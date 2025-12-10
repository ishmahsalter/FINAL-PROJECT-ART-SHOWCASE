<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Challenge;
use App\Models\User;
use App\Models\Collection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    // Cache duration in minutes
    protected $cacheDuration = 10;
    
    public function index()
    {
        // Cache frequently accessed data to improve performance
        $data = Cache::remember('homepage_data', $this->cacheDuration, function () {
            return [
                'artworks' => Artwork::with(['user:id,name,display_name,profile_image', 'category:id,name', 'likes:id', 'comments:id'])
                    ->withCount(['likes', 'comments'])
                    ->latest()
                    ->take(20)
                    ->get(),
                
                'challenges' => Challenge::active()
                    ->with(['curator:id,name,display_name,profile_image', 'submissions:id'])
                    ->latest()
                    ->take(10)
                    ->get(),
                
                'featuredArtworks' => Artwork::with(['user:id,name,display_name,profile_image', 'category:id,name'])
                    ->where('is_featured', true)
                    ->latest()
                    ->take(8)
                    ->get(),
                
                'popularArtworks' => Artwork::with(['user:id,name,display_name,profile_image', 'category:id,name'])
                    ->where('views_count', '>', 0)
                    ->orderBy('views_count', 'desc')
                    ->take(8)
                    ->get(),
                
                'latestArtworks' => Artwork::with(['user:id,name,display_name,profile_image', 'category:id,name'])
                    ->latest()
                    ->take(8)
                    ->get(),
            ];
        });
        
        return view('home.public', $data);
    }
    
    public function artworks(Request $request)
    {
        $query = Artwork::with(['user:id,name,display_name,profile_image', 'category:id,name,slug'])
            ->withCount(['likes', 'comments']);
            
        if ($request->filled('category')) {
            $query->whereHas('category', function (Builder $q) use ($request) {
                $q->where('id', $request->category)
                  ->orWhere('slug', $request->category);
            });
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function (Builder $userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('display_name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'popular':
                    $query->orderBy('views_count', 'desc');
                    break;
                case 'trending':
                    $query->withCount('likes')->orderBy('likes_count', 'desc');
                    break;
                case 'latest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
        
        $artworks = $query->paginate(20)->withQueryString();
        $categories = Category::all();
        $creatorsCount = User::where('role', 'member')->count();
        
        return view('artworks.index', compact('artworks', 'categories', 'creatorsCount'));
    }
    
    public function showArtwork(Artwork $artwork)
    {
        // Increment views safely
        if (auth()->id() !== $artwork->user_id) {
            $artwork->increment('views_count');
        }
        
        $artwork->load([
            'user:id,name,display_name,profile_image,bio',
            'category:id,name,slug',
            'comments.user:id,name,display_name,profile_image',
            'likes:id,user_id',
        ]);
        
        // Get related artworks
        $relatedArtworks = Artwork::where('category_id', $artwork->category_id)
            ->where('id', '!=', $artwork->id)
            ->with(['user:id,name,display_name,profile_image', 'category:id,name'])
            ->latest()
            ->take(6)
            ->get();
        
        return view('artworks.show', compact('artwork', 'relatedArtworks'));
    }
    
    public function profile($username)
    {
        // Search by name, display_name, or id
        $user = User::where('name', $username)
            ->orWhere('display_name', $username)
            ->orWhere('id', $username)
            ->with(['artworks' => function ($query) {
                $query->where('status', 'published')
                      ->with('category:id,name')
                      ->latest();
            }, 'followers:id,name,display_name,profile_image', 'following:id,name,display_name,profile_image'])
            ->withCount(['artworks' => function($query) {
                $query->where('status', 'published');
            }, 'followers', 'following'])
            ->firstOrFail();
            
        return view('profile.show', compact('user'));
    }
    
    public function challenges()
    {
        $challenges = Challenge::public()
            ->with(['curator:id,name,display_name,profile_image', 'submissions:id'])
            ->latest()
            ->paginate(12);
            
        return view('challenges.index', compact('challenges'));
    }
    
    // METODE BARU untuk public challenge show
    public function showChallenge($slug)
    {
        // Cari challenge berdasarkan slug
        $challenge = Challenge::where('slug', $slug)->firstOrFail();
        
        // Cek apakah challenge visible ke public
        if (!$challenge->is_approved || $challenge->is_draft || $challenge->isCancelled() || $challenge->trashed()) {
            abort(404, 'Challenge tidak ditemukan atau tidak tersedia untuk publik.');
        }
        
        // Load relationships
        $challenge->load([
            'curator:id,name,display_name,profile_image,bio',
            'submissions' => function ($query) {
                $query->whereIn('status', ['approved', 'winner'])
                      ->with(['artwork' => function ($q) {
                          $q->where('status', 'published')
                            ->with('user:id,name,display_name,profile_image', 'category:id,name');
                      }]);
            },
            'winners.submission.artwork.user',
            'winners.submission.artwork'
        ]);
        
        // Filter hanya submissions yang memiliki artwork yang valid
        $challenge->submissions = $challenge->submissions->filter(function ($submission) {
            return $submission->artwork !== null;
        });
        
        // Get related challenges
        $relatedChallenges = Challenge::where('id', '!=', $challenge->id)
            ->where(function($query) use ($challenge) {
                $query->where('theme', $challenge->theme)
                      ->orWhere('status', $challenge->status);
            })
            ->orWhere('curator_id', $challenge->curator_id)
            ->with('curator:id,name,display_name,profile_image')
            ->latest()
            ->take(3)
            ->get();
        
        // Cek apakah user sudah submit
        $userHasSubmitted = false;
        if (auth()->check()) {
            $userHasSubmitted = $challenge->hasUserSubmitted(auth()->id());
        }
        
        return view('challenges.show-public', compact('challenge', 'relatedChallenges', 'userHasSubmitted'));
    }
    
    // METODE LAMA (untuk curator) - tetap dipertahankan untuk compatibility
    public function challengeShow(Challenge $challenge)
    {
        // Load relationships sesuai arahan
        $challenge->load([
            'curator:id,name,display_name,profile_image,bio',
            'submissions.artwork.user:id,name,display_name,profile_image',
            'submissions.artwork.category:id,name'
        ]);
        
        // Get related challenges sesuai arahan
        $relatedChallenges = Challenge::where('id', '!=', $challenge->id)
            ->where(function($query) use ($challenge) {
                $query->where('theme', $challenge->theme)
                      ->orWhere('category_id', $challenge->category_id);
            })
            ->orWhere('curator_id', $challenge->curator_id)
            ->with('curator:id,name,display_name,profile_image')
            ->latest()
            ->take(3)
            ->get();
        
        return view('challenges.show', compact('challenge', 'relatedChallenges'));
    }
    
    public function exploreCreators()
    {
        $creators = User::where('role', 'member')
            ->where('status', 'active')
            ->withCount(['artworks' => function($query) {
                $query->where('status', 'published');
            }, 'followers'])
            ->orderBy('followers_count', 'desc')
            ->paginate(20);
            
        return view('explore.creators', compact('creators'));
    }
    
    public function exploreTrending()
    {
        // Get trending artworks from last 7 days
        $artworks = Artwork::with(['user:id,name,display_name,profile_image', 'category:id,name'])
            ->withCount(['likes', 'comments'])
            ->where('status', 'published')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByRaw('(likes_count * 2 + comments_count + views_count) DESC')
            ->paginate(20);
            
        return view('explore.trending', compact('artworks'));
    }
    
    public function exploreCollections()
    {
        $collections = Collection::with(['user:id,name,display_name', 'artworks:id,title,image_path'])
            ->withCount(['artworks' => function($query) {
                $query->where('status', 'published');
            }])
            ->where('is_public', true)
            ->orderBy('artworks_count', 'desc')
            ->paginate(20);
            
        return view('explore.collections', compact('collections'));
    }
    
    public function activeChallenges()
    {
        $challenges = Challenge::active()
            ->with(['curator:id,name,display_name,profile_image', 'submissions:id'])
            ->latest()
            ->paginate(12);
            
        return view('challenges.active', compact('challenges'));
    }
    
    public function pastChallenges()
    {
        $challenges = Challenge::completed()
            ->with(['curator:id,name,display_name,profile_image', 'submissions:id', 'winners:id'])
            ->latest()
            ->paginate(12);
            
        return view('challenges.past', compact('challenges'));
    }
    
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
            'type' => 'sometimes|in:all,artworks,creators,challenges,collections'
        ]);
        
        $query = $request->get('q');
        $type = $request->get('type', 'all');
        
        $results = [];
        
        if ($type === 'all' || $type === 'artworks') {
            $results['artworks'] = Artwork::with(['user:id,name,display_name,profile_image', 'category:id,name'])
                ->where('status', 'published')
                ->where(function (Builder $q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhereHas('tags', function (Builder $tagQuery) use ($query) {
                          $tagQuery->where('name', 'like', '%' . $query . '%');
                      });
                })
                ->take(10)
                ->get();
        }
        
        if ($type === 'all' || $type === 'creators') {
            $results['creators'] = User::where('role', 'member')
                ->where('status', 'active')
                ->where(function (Builder $q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('display_name', 'like', '%' . $query . '%')
                      ->orWhere('bio', 'like', '%' . $query . '%');
                })
                ->take(10)
                ->get();
        }
        
        if ($type === 'all' || $type === 'challenges') {
            $results['challenges'] = Challenge::public()
                ->with('curator:id,name,display_name,profile_image')
                ->where(function(Builder $q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhere('theme', 'like', '%' . $query . '%');
                })
                ->take(10)
                ->get();
        }
        
        if ($type === 'all' || $type === 'collections') {
            $results['collections'] = Collection::with('user:id,name,display_name')
                ->where('is_public', true)
                ->where(function(Builder $q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%');
                })
                ->take(10)
                ->get();
        }
        
        return view('search.index', compact('query', 'type', 'results'));
    }
    
    // New method: Recent Activity Feed
    public function activityFeed()
    {
        $activities = Cache::remember('activity_feed', $this->cacheDuration, function () {
            $artworks = Artwork::with('user:id,name,display_name,profile_image')
                ->where('status', 'published')
                ->latest()
                ->take(15)
                ->get();
            
            $challenges = Challenge::active()
                ->with('curator:id,name,display_name,profile_image')
                ->latest()
                ->take(10)
                ->get();
            
            return $artworks->merge($challenges)->sortByDesc('created_at')->take(20);
        });
        
        return view('home.activity', compact('activities'));
    }
    
    // New method: Statistics Dashboard
    public function statistics()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $stats = Cache::remember('site_statistics', 60, function () {
            return [
                'totalArtworks' => Artwork::where('status', 'published')->count(),
                'totalUsers' => User::where('status', 'active')->count(),
                'totalChallenges' => Challenge::count(),
                'activeChallenges' => Challenge::active()->count(),
                'popularCategories' => Category::withCount(['artworks' => function($query) {
                    $query->where('status', 'published');
                }])
                ->orderBy('artworks_count', 'desc')
                ->take(5)
                ->get()
            ];
        });
        
        return view('admin.statistics', compact('stats'));
    }
}