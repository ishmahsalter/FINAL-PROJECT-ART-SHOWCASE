<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // TOTAL CHALLENGES
        $totalChallenges = Challenge::where('curator_id', $userId)->count();
        
        // ACTIVE CHALLENGES (sedang berlangsung)
        $activeChallengesCount = Challenge::where('curator_id', $userId)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->count();
            
        // UPCOMING CHALLENGES (belum dimulai)
        $upcomingChallengesCount = Challenge::where('curator_id', $userId)
            ->where('start_date', '>', Carbon::now())
            ->count();
            
        // ENDED CHALLENGES (sudah selesai)
        $endedChallengesCount = Challenge::where('curator_id', $userId)
            ->where('end_date', '<', Carbon::now())
            ->count();
            
        // CHALLENGES WITHOUT WINNERS (sudah selesai tapi belum ada pemenang)
        $endedChallengesWithoutWinners = Challenge::where('curator_id', $userId)
            ->where('end_date', '<', Carbon::now())
            ->whereDoesntHave('winners')
            ->count();
        
        // SUBMISSION STATS
        $totalSubmissions = Submission::whereHas('challenge', function($query) use ($userId) {
                $query->where('curator_id', $userId);
            })->count();
            
        $pendingSubmissions = Submission::whereHas('challenge', function($query) use ($userId) {
                $query->where('curator_id', $userId);
            })
            ->where('status', 'pending')
            ->count();
        
        // RECENT PENDING SUBMISSIONS (limit 5)
        $recentPendingSubmissions = Submission::whereHas('challenge', function($query) use ($userId) {
                $query->where('curator_id', $userId);
            })
            ->where('status', 'pending')
            ->with(['user', 'challenge'])
            ->latest()
            ->take(5)
            ->get();
        
        // RECENT CHALLENGES (limit 5)
        $recentChallenges = Challenge::where('curator_id', $userId)
            ->withCount(['submissions'])
            ->with(['winners'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('curator.dashboard', compact(
            'totalChallenges',
            'activeChallengesCount',
            'upcomingChallengesCount',
            'endedChallengesCount',
            'endedChallengesWithoutWinners',
            'totalSubmissions',
            'pendingSubmissions',
            'recentPendingSubmissions',
            'recentChallenges'
        ));
    }
    
    public function stats()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        $stats = [
            'total_challenges' => Challenge::where('curator_id', $userId)->count(),
            'active_challenges' => Challenge::where('curator_id', $userId)
                ->where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->count(),
            'total_submissions' => Submission::whereHas('challenge', function($query) use ($userId) {
                    $query->where('curator_id', $userId);
                })->count(),
            'pending_reviews' => Submission::whereHas('challenge', function($query) use ($userId) {
                    $query->where('curator_id', $userId);
                })
                ->where('status', 'pending')
                ->count(),
        ];
        
        return response()->json($stats);
    }
    
    public function analytics()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // Challenges per month
        $challengesPerMonth = Challenge::where('curator_id', $userId)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');
        
        // Submissions per challenge
        $popularChallenges = Challenge::where('curator_id', $userId)
            ->withCount('submissions')
            ->orderBy('submissions_count', 'desc')
            ->take(5)
            ->get();
        
        // Submission status distribution
        $submissionStats = Submission::whereHas('challenge', function($query) use ($userId) {
                $query->where('curator_id', $userId);
            })
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        return view('curator.analytics', compact(
            'challengesPerMonth',
            'popularChallenges',
            'submissionStats'
        ));
    }
    
    public function submissionReports()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        $submissions = Submission::whereHas('challenge', function($query) use ($userId) {
                $query->where('curator_id', $userId);
            })
            ->with(['user', 'challenge', 'artwork'])
            ->latest()
            ->paginate(20);
        
        return view('curator.submission-reports', compact('submissions'));
    }
    
    public function users()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // Users who participated in curator's challenges
        $participants = Submission::whereHas('challenge', function($query) use ($userId) {
                $query->where('curator_id', $userId);
            })
            ->with('user')
            ->select('user_id')
            ->distinct()
            ->paginate(20);
        
        return view('curator.users', compact('participants'));
    }
    
    public function artworks()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // Artworks submitted to curator's challenges
        $artworks = Submission::whereHas('challenge', function($query) use ($userId) {
                $query->where('curator_id', $userId);
            })
            ->with(['artwork.user', 'artwork.category', 'challenge'])
            ->latest()
            ->paginate(20);
        
        return view('curator.artworks', compact('artworks'));
    }
}