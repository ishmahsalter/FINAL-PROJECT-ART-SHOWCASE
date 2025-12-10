<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Submission;
use App\Models\Winner;
use App\Models\Artwork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ChallengeController extends Controller
{
    public function index()
    {
        \Log::info('Curator ChallengeController@index accessed', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role ?? 'guest',
            'request_url' => request()->fullUrl(),
            'request_method' => request()->method(),
        ]);
        
        $user = Auth::user();
        
        $query = Challenge::where('curator_id', Auth::id())
            ->withCount(['submissions', 'winners'])
            ->orderBy('created_at', 'desc');
        
        // Apply filters
        if (request('filter')) {
            $now = Carbon::now();
            
            switch (request('filter')) {
                case 'active':
                    $query->where('start_date', '<=', $now)
                          ->where('end_date', '>=', $now);
                    break;
                    
                case 'upcoming':
                    $query->where('start_date', '>', $now);
                    break;
                    
                case 'ended':
                    $query->where('end_date', '<', $now);
                    break;
                    
                case 'without-winners':
                    $query->where('end_date', '<', $now)
                          ->whereDoesntHave('winners');
                    break;
            }
        }
        
        $challenges = $query->paginate(12);
        
        // Hitung challenges tanpa pemenang untuk stats
        $endedChallengesWithoutWinners = Challenge::where('curator_id', Auth::id())
            ->where('end_date', '<', Carbon::now())
            ->whereDoesntHave('winners')
            ->count();
        
        \Log::info('Curator ChallengeController@index data prepared', [
            'total_challenges' => $challenges->total(),
            'filter' => request('filter'),
            'ended_without_winners_count' => $endedChallengesWithoutWinners,
        ]);
        
        return view('curator.challenges.index', compact(
            'challenges',
            'endedChallengesWithoutWinners'
        ));
    }
    
    public function create()
    {
        \Log::info('Curator ChallengeController@create accessed', [
            'user_id' => Auth::id(),
        ]);
        
        return view('curator.challenges.create');
    }
    
    public function store(Request $request)
    {
        \Log::info('Curator ChallengeController@store attempt', [
            'user_id' => Auth::id(),
            'data' => $request->except(['banner_image', '_token']),
        ]);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'required|string',
            'prize' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);
        
        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('challenges/banners', 'public');
            $validated['banner_image'] = $path;
            \Log::info('Banner image uploaded', ['path' => $path]);
        }
        
        $validated['curator_id'] = Auth::id();
        $validated['status'] = 'active';
        $validated['slug'] = Str::slug($validated['title']);
        
        $challenge = Challenge::create($validated);
        
        \Log::info('Challenge created successfully', [
            'challenge_id' => $challenge->id,
            'title' => $challenge->title,
            'slug' => $challenge->slug,
        ]);
        
        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge created successfully!');
    }
    
    public function show($challenge)
    {
        \Log::info('Curator ChallengeController@show accessed', [
            'challenge_param' => $challenge,
            'type' => gettype($challenge),
            'user_id' => Auth::id(),
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $challenge->load([
            'submissions.user', 
            'submissions.artwork', 
            'winners.submission.artwork.user',
            'winners.user'
        ]);
        
        \Log::info('Challenge data loaded for show', [
            'submissions_count' => $challenge->submissions->count(),
            'winners_count' => $challenge->winners->count(),
        ]);
        
        return view('curator.challenges.show', compact('challenge'));
    }
    
    public function edit($challenge)
    {
        \Log::info('Curator ChallengeController@edit accessed', [
            'challenge_param' => $challenge,
            'user_id' => Auth::id(),
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('curator.challenges.edit', compact('challenge'));
    }
    
    public function update(Request $request, $challenge)
    {
        \Log::info('Curator ChallengeController@update attempt', [
            'challenge_param' => $challenge,
            'user_id' => Auth::id(),
            'data' => $request->except(['banner_image', '_token', '_method']),
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'required|string',
            'prize' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);
        
        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner if exists
            if ($challenge->banner_image) {
                Storage::disk('public')->delete($challenge->banner_image);
                \Log::info('Old banner deleted', ['path' => $challenge->banner_image]);
            }
            
            $path = $request->file('banner_image')->store('challenges/banners', 'public');
            $validated['banner_image'] = $path;
            \Log::info('New banner uploaded', ['path' => $path]);
        }
        
        // Update slug if title changed
        if ($challenge->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
            \Log::info('Slug updated due to title change', [
                'old_title' => $challenge->title,
                'new_title' => $validated['title'],
                'new_slug' => $validated['slug'],
            ]);
        }
        
        $challenge->update($validated);
        
        \Log::info('Challenge updated successfully', [
            'challenge_id' => $challenge->id,
            'title' => $challenge->title,
        ]);
        
        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge updated successfully!');
    }
    
    public function destroy($challenge)
    {
        \Log::info('Curator ChallengeController@destroy attempt', [
            'challenge_param' => $challenge,
            'user_id' => Auth::id(),
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete banner image if exists
        if ($challenge->banner_image) {
            Storage::disk('public')->delete($challenge->banner_image);
            \Log::info('Banner image deleted', ['path' => $challenge->banner_image]);
        }
        
        $challenge->delete();
        
        \Log::info('Challenge deleted successfully', ['challenge_id' => $challenge->id]);
        
        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge deleted successfully!');
    }
    
    public function submissions($challenge)
    {
        \Log::info('Curator ChallengeController@submissions accessed', [
            'challenge_param' => $challenge,
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role ?? 'guest',
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $submissions = $challenge->submissions()
            ->with(['user', 'artwork.category', 'artwork.likes'])
            ->latest()
            ->paginate(20);
        
        \Log::info('Submissions loaded', [
            'total_submissions' => $submissions->total(),
            'challenge_title' => $challenge->title,
        ]);
        
        return view('curator.challenges.submissions', compact('challenge', 'submissions'));
    }
    
    public function selectWinners($challenge)
    {
        \Log::info('=== CURATOR selectWinners Method Called ===', [
            'challenge_param' => $challenge,
            'type' => gettype($challenge),
            'user_id' => Auth::id(),
            'full_url' => request()->fullUrl(),
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
            \Log::info('Challenge found by ID', ['challenge_id' => $challenge->id]);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
            \Log::info('Challenge found by slug', ['challenge_id' => $challenge->id]);
        }
        
        \Log::info('Challenge resolved:', [
            'challenge_id' => $challenge->id,
            'title' => $challenge->title,
            'curator_id' => $challenge->curator_id,
            'current_user_id' => Auth::id(),
            'end_date' => $challenge->end_date,
            'now' => now(),
        ]);
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if challenge has ended
        if ($challenge->end_date > now()) {
            \Log::warning('Attempt to select winners for active challenge', [
                'challenge_id' => $challenge->id,
                'end_date' => $challenge->end_date,
                'status' => 'active',
            ]);
            
            return redirect()->route('curator.challenges.submissions', $challenge->id)
                ->with('error', 'Challenge is still active. You can select winners after it ends.');
        }
        
        $submissions = $challenge->submissions()
            ->with(['user', 'artwork.category', 'artwork.likes'])
            ->where('status', 'approved')
            ->paginate(12);
        
        \Log::info('Select winners page loaded', [
            'eligible_submissions' => $submissions->total(),
            'challenge_status' => $challenge->status,
        ]);
        
        return view('curator.challenges.select-winners', compact('challenge', 'submissions'));
    }
    
    public function storeWinners(Request $request, $challenge)
    {
        \Log::info('Curator ChallengeController@storeWinners attempt', [
            'challenge_param' => $challenge,
            'user_id' => Auth::id(),
            'winners_data' => $request->winners ?? [],
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'winners' => 'required|array|min:1|max:3',
            'winners.*.rank' => 'required|integer|min:1|max:3',
        ]);
        
        // Delete existing winners
        $challenge->winners()->delete();
        \Log::info('Existing winners deleted', ['challenge_id' => $challenge->id]);
        
        // Store new winners
        foreach ($request->winners as $submissionId => $data) {
            Winner::create([
                'challenge_id' => $challenge->id,
                'submission_id' => $submissionId,
                'rank' => $data['rank'],
            ]);
            
            // Update submission as winner
            Submission::find($submissionId)->update(['is_winner' => true]);
            
            \Log::info('Winner selected', [
                'submission_id' => $submissionId,
                'rank' => $data['rank'],
            ]);
        }
        
        \Log::info('Winners stored successfully', [
            'challenge_id' => $challenge->id,
            'total_winners' => count($request->winners),
        ]);
        
        return redirect()->route('curator.challenges.index')
            ->with('success', 'Winners selected successfully!');
    }
    
    public function selectWinner(Request $request, $challenge, $submission)
    {
        \Log::info('Curator ChallengeController@selectWinner attempt', [
            'challenge_param' => $challenge,
            'submission_param' => $submission,
            'user_id' => Auth::id(),
            'rank' => $request->rank,
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Resolve submission
        if (is_numeric($submission)) {
            $submission = Submission::findOrFail($submission);
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'rank' => 'required|integer|min:1|max:3',
        ]);
        
        // Check if rank is already taken
        $existingWinner = Winner::where('challenge_id', $challenge->id)
            ->where('rank', $request->rank)
            ->first();
        
        if ($existingWinner) {
            \Log::warning('Rank already taken', [
                'rank' => $request->rank,
                'existing_winner_id' => $existingWinner->id,
            ]);
            
            return back()->with('error', 'This rank is already assigned to another submission.');
        }
        
        // Create winner entry
        Winner::create([
            'challenge_id' => $challenge->id,
            'submission_id' => $submission->id,
            'rank' => $request->rank,
        ]);
        
        // Update submission
        $submission->update(['is_winner' => true]);
        
        \Log::info('Winner selected successfully', [
            'submission_id' => $submission->id,
            'rank' => $request->rank,
        ]);
        
        return back()->with('success', 'Winner selected successfully!');
    }
    
    public function close($challenge)
    {
        \Log::info('Curator ChallengeController@close attempt', [
            'challenge_param' => $challenge,
            'user_id' => Auth::id(),
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $challenge->update(['status' => 'closed']);
        
        \Log::info('Challenge closed', ['challenge_id' => $challenge->id]);
        
        return back()->with('success', 'Challenge closed successfully!');
    }
    
    public function reopen($challenge)
    {
        \Log::info('Curator ChallengeController@reopen attempt', [
            'challenge_param' => $challenge,
            'user_id' => Auth::id(),
        ]);
        
        // Resolve challenge
        if (is_numeric($challenge)) {
            $challenge = Challenge::findOrFail($challenge);
        } elseif (is_string($challenge)) {
            $challenge = Challenge::where('slug', $challenge)->firstOrFail();
        }
        
        // Authorization: Check if curator owns this challenge
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $challenge->update(['status' => 'active']);
        
        \Log::info('Challenge reopened', ['challenge_id' => $challenge->id]);
        
        return back()->with('success', 'Challenge reopened successfully!');
    }
}