<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()
            ->with(['artwork.user', 'artwork.category', 'artwork.likes'])
            ->latest()
            ->paginate(12);
            
        return view('member.favorites.index', compact('favorites'));
    }
    
    public function store($artworkId)
    {
        $existing = Favorite::where('user_id', Auth::id())
            ->where('artwork_id', $artworkId)
            ->first();
            
        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'artwork_id' => $artworkId,
            ]);
            $status = 'added';
        }
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'count' => Auth::user()->favorites()->count()
            ]);
        }
        
        return redirect()->back()->with('success', 'Favorite updated!');
    }
}