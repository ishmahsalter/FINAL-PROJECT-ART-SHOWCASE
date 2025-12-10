<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggle($userId)
    {
        $userToFollow = User::findOrFail($userId);
        
        // Can't follow yourself
        if ($userToFollow->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot follow yourself!'
            ], 400);
        }
        
        // Check if already following
        $existing = Follow::where('follower_id', Auth::id())
            ->where('following_id', $userToFollow->id)
            ->first();
            
        if ($existing) {
            // Unfollow
            $existing->delete();
            $following = false;
        } else {
            // Follow
            Follow::create([
                'follower_id' => Auth::id(),
                'following_id' => $userToFollow->id,
            ]);
            $following = true;
        }
        
        // Update counts
        $userToFollow->refresh();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'following' => $following,
                'followers_count' => $userToFollow->followers()->count(),
                'following_count' => $userToFollow->following()->count(),
            ]);
        }
        
        return redirect()->back()->with('success', 
            $following ? 'You are now following ' . $userToFollow->name : 
                        'You unfollowed ' . $userToFollow->name
        );
    }
    
    public function feed()
    {
        $followingIds = Auth::user()->following()->pluck('following_id');
        
        $artworks = \App\Models\Artwork::whereIn('user_id', $followingIds)
            ->with(['user', 'category', 'likes', 'comments'])
            ->latest()
            ->paginate(12);
            
        return view('member.following.feed', compact('artworks'));
    }
    
    public function followers()
    {
        $user = Auth::user();
        
        $followers = $user->followers()
            ->withCount(['artworks', 'followers'])
            ->paginate(20);
        
        // Hitung followers baru bulan ini
        $newFollowersCount = $user->followers()
            ->where('follows.created_at', '>=', now()->subMonth())
            ->count();
        
        // Hitung mutual follows
        $mutualFollowersCount = $user->followers()
            ->whereIn('id', $user->following()->pluck('following_id'))
            ->count();
        
        // ⭐⭐ GANTI INI ⭐⭐
        return view('member.followers.index', compact('followers', 'newFollowersCount', 'mutualFollowersCount'));
    }
    
    public function following()
    {
        $user = Auth::user();
        
        $following = $user->following()
            ->withCount(['artworks', 'followers'])
            ->paginate(20);
        
        // Hitung yang aktif minggu ini (punya artwork baru)
        $activeFollowingCount = $user->following()
            ->whereHas('artworks', function($query) {
                $query->where('created_at', '>=', now()->subWeek());
            })
            ->count();
        
        // Hitung mutual follows
        $mutualFollowingCount = $user->following()
            ->whereIn('id', $user->followers()->pluck('follower_id'))
            ->count();
        
        // ⭐⭐ GANTI INI ⭐⭐
        return view('member.following.index', compact('following', 'activeFollowingCount', 'mutualFollowingCount'));
    }
}