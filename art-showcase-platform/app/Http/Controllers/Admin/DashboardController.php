<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Submission;
use App\Models\Artwork;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $pendingCurators = User::where('role', 'curator')
                               ->where('status', 'pending')
                               ->count();
        $totalArtworks = Artwork::count();
        $totalChallenges = Challenge::count();
        
        $recentUsers = User::latest()->take(8)->get();
        $recentChallenges = Challenge::latest()->take(5)->get();
        $recentSubmissions = Submission::with(['user', 'challenge'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingCurators', 
            'totalArtworks',
            'totalChallenges',
            'recentUsers',
            'recentChallenges',
            'recentSubmissions'
        ));
    }
    
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }
    
    public function challenges()
    {
        $challenges = Challenge::with('curator')->latest()->paginate(15);
        return view('admin.challenges.index', compact('challenges'));
    }
}