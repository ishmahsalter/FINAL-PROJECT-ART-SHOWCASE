<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Artwork::with(['user', 'category', 'likes']);

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('display_name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Sort
        $sort = $request->get('sort', 'recent');
        if ($sort === 'popular') {
            $query->withCount('likes')->orderBy('likes_count', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $artworks = $query->paginate(12);
        $categories = Category::all();
        $challenges = Challenge::active()->with('curator')->get();

        return view('home', compact('artworks', 'categories', 'challenges'));
    }

    public function show($id)
    {
        $artwork = Artwork::with(['user', 'category', 'likes', 'comments.user'])
            ->withCount('likes')
            ->findOrFail($id);

        // Increment view count
        $artwork->incrementViewCount();

        return view('artworks.show', compact('artwork'));
    }

    public function profile($username)
    {
        $user = \App\Models\User::where('display_name', $username)
            ->orWhere('name', $username)
            ->firstOrFail();

        $artworks = $user->artworks()
            ->with(['category', 'likes'])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('profile.show', compact('user', 'artworks'));
    }

    public function challenges()
    {
        $activeChallenges = Challenge::active()->with('curator')->get();
        $endedChallenges = Challenge::ended()->with('curator')->latest()->get();

        return view('challenges.index', compact('activeChallenges', 'endedChallenges'));
    }

    public function challengeShow($id)
    {
        $challenge = Challenge::with(['curator', 'submissions.artwork.user'])
            ->findOrFail($id);

        $winners = $challenge->winners()->with('artwork.user')->get();

        return view('challenges.show', compact('challenge', 'winners'));
    }
}