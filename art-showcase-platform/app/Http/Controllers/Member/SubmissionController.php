<?php

namespace App\Http\Controllers\Member;  // ⭐ NAMESPACE INI YANG BENAR

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display user's submissions
     */
    public function index()
    {
        // Ambil submissions user dengan eager loading
        $submissions = Submission::where('user_id', Auth::id())
            ->with(['challenge', 'artwork'])
            ->latest()
            ->paginate(10);

        // Ambil challenges aktif untuk form
        $activeChallenges = Challenge::where('status', 'active')
            ->where('end_date', '>', now())
            ->where('is_approved', true)
            ->where('is_draft', false)
            ->latest()
            ->get();

        return view('member.submissions.index', compact('submissions', 'activeChallenges'));
    }

    /**
     * Store a new submission
     */
    public function store(Request $request)
    {
        $request->validate([
            'challenge_id' => 'required|exists:challenges,id',
            'artwork_id' => 'required|exists:artworks,id',
            'description' => 'nullable|string|max:500',
        ]);

        // Cek jika challenge aktif
        $challenge = Challenge::where('id', $request->challenge_id)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->where('is_approved', true)
            ->where('is_draft', false)
            ->first();

        if (!$challenge) {
            return back()
                ->with('error', 'This challenge is not active or has expired.')
                ->withInput();
        }

        // Cek jika sudah submit ke challenge ini
        $existing = Submission::where('user_id', Auth::id())
            ->where('challenge_id', $request->challenge_id)
            ->exists();

        if ($existing) {
            return back()
                ->with('error', 'You have already submitted to this challenge.')
                ->withInput();
        }

        // Cek jika artwork milik user
        $artwork = Auth::user()->artworks()->find($request->artwork_id);
        if (!$artwork) {
            return back()
                ->with('error', 'You do not own this artwork or it does not exist.')
                ->withInput();
        }

        // Buat submission
        Submission::create([
            'user_id' => Auth::id(),
            'challenge_id' => $request->challenge_id,
            'artwork_id' => $request->artwork_id,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        // Update count di challenge
        $challenge->increment('submissions_count');

        return redirect()->route('member.submissions.index')
            ->with('success', '🎉 Submission created successfully! It is now pending review.');
    }

    /**
     * Delete a submission
     */
    public function destroy(Submission $submission)
    {
        // Authorization
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa delete jika status pending
        if ($submission->status !== 'pending') {
            return back()->with('error', 'Cannot delete submission that has been reviewed.');
        }

        // Decrement count di challenge
        $submission->challenge()->decrement('submissions_count');

        $submission->delete();

        return back()->with('success', '🗑️ Submission deleted successfully!');
    }
}