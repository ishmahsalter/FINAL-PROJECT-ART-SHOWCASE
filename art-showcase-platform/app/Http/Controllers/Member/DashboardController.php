<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Collection;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Follow;
use App\Models\Submission;
use App\Models\Challenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cache key for user-specific dashboard
        $cacheKey = 'member_dashboard_' . $user->id;
        
        // Cache for 5 minutes
        $dashboardData = Cache::remember($cacheKey, 300, function () use ($user) {
            
            // Stats untuk Quick Stats
            $artworksCount = $user->artworks()->count();
            $favoritesCount = Favorite::where('user_id', $user->id)->count();
            $followersCount = $user->followers()->count();
            $followingCount = $user->following()->count();
            
            // Published artworks count
            $publishedArtworksCount = $user->artworks()
                ->where('status', 'published')
                ->count();
            
            // Submissions count
            $submissionsCount = Submission::where('user_id', $user->id)->count();
            
            // Recent artworks (user bisa lihat semua status miliknya)
            $recentArtworks = $user->artworks()
                ->with(['category:id,name', 'likes:id'])
                ->select(['id', 'title', 'image_path', 'category_id', 'status', 'views_count', 'created_at'])
                ->latest()
                ->take(6)
                ->get();
                
            // Following feed (hanya yang published)
            $followingIds = $user->following()->pluck('following_id');
            $followingFeed = Artwork::whereIn('user_id', $followingIds)
                ->where('status', 'published')
                ->with([
                    'user:id,name,display_name,profile_image',
                    'category:id,name',
                    'likes:id,user_id',
                    'comments:id,user_id,artwork_id,created_at'
                ])
                ->select(['id', 'title', 'image_path', 'user_id', 'category_id', 'views_count', 'created_at'])
                ->latest()
                ->take(6)
                ->get();
                
            // Collections
            $collections = $user->collections()
                ->withCount(['artworks' => function($query) {
                    $query->where('status', 'published');
                }])
                ->with(['artworks' => function($query) {
                    $query->where('status', 'published')
                        ->select(['id', 'title', 'image_path'])
                        ->latest()
                        ->take(3);
                }])
                ->latest()
                ->take(6)
                ->get();
                
            // Suggested artists
            $suggestedArtists = User::where('role', 'member')
                ->where('status', 'active')
                ->where('id', '!=', $user->id)
                ->whereNotIn('id', $user->following()->pluck('following_id'))
                ->withCount([
                    'artworks' => function($query) {
                        $query->where('status', 'published');
                    },
                    'followers',
                    'following'
                ])
                ->having('artworks_count', '>', 0)
                ->orderBy('followers_count', 'desc')
                ->take(4)
                ->get();
                
            // Active challenges
            $activeChallenges = Challenge::where('status', 'active')
                ->where(function($query) {
                    $query->where('end_date', '>', now())
                          ->orWhereNull('end_date');
                })
                ->with([
                    'curator:id,name,display_name,profile_image',
                    'submissions' => function($query) use ($user) {
                        $query->where('user_id', $user->id)
                              ->select(['id', 'artwork_id', 'status', 'created_at']);
                    }
                ])
                ->withCount(['submissions'])
                ->latest()
                ->take(4)
                ->get();
            
            // Quick stats array
            $quickStats = [
                'artworks' => $artworksCount,
                'published_artworks' => $publishedArtworksCount,
                'favorites' => $favoritesCount,
                'followers' => $followersCount,
                'following' => $followingCount,
                'submissions' => $submissionsCount,
            ];
            
            // Performance metrics
            $performanceData = [
                'total_views' => $user->artworks()->sum('views_count'),
                'total_likes' => $user->artworks()->withCount('likes')->get()->sum('likes_count'),
                'total_comments' => $user->artworks()->withCount('comments')->get()->sum('comments_count'),
                'avg_views_per_artwork' => $artworksCount > 0 ? round($user->artworks()->avg('views_count'), 1) : 0,
            ];
            
            return compact(
                'artworksCount',
                'favoritesCount',
                'followersCount',
                'followingCount',
                'submissionsCount',
                'publishedArtworksCount',
                'recentArtworks',
                'followingFeed',
                'collections',
                'suggestedArtists',
                'activeChallenges',
                'quickStats',
                'performanceData'
            );
        });
        
        return view('member.dashboard', $dashboardData);
    }
}