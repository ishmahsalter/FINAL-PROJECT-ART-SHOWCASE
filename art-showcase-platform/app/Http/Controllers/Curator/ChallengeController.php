<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = auth()->user()
            ->challenges()
            ->withCount('submissions')
            ->latest()
            ->paginate(12);

        return view('curator.challenges.index', compact('challenges'));
    }

    public function create()
    {
        return view('curator.challenges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'required|string',
            'prize' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('challenges', 'public');
        }

        Challenge::create([
            'curator_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'rules' => $request->rules,
            'prize' => $request->prize,
            'banner_image' => $bannerPath,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge created successfully!');
    }

    public function edit($id)
    {
        $challenge = Challenge::where('curator_id', auth()->id())->findOrFail($id);
        return view('curator.challenges.edit', compact('challenge'));
    }

    public function update(Request $request, $id)
    {
        $challenge = Challenge::where('curator_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'required|string',
            'prize' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $challenge->update([
            'title' => $request->title,
            'description' => $request->description,
            'rules' => $request->rules,
            'prize' => $request->prize,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge updated successfully!');
    }

    public function destroy($id)
    {
        $challenge = Challenge::where('curator_id', auth()->id())->findOrFail($id);
        
        if ($challenge->banner_image) {
            Storage::disk('public')->delete($challenge->banner_image);
        }

        $challenge->delete();

        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge deleted successfully!');
    }

    public function submissions($id)
    {
        $challenge = Challenge::where('curator_id', auth()->id())->findOrFail($id);
        
        $submissions = $challenge->submissions()
            ->with(['artwork.user', 'user'])
            ->latest()
            ->get();

        return view('curator.challenges.submissions', compact('challenge', 'submissions'));
    }

    public function selectWinner(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        
        $request->validate([
            'winner_rank' => 'required|integer|in:1,2,3',
        ]);

        $submission->update([
            'winner_rank' => $request->winner_rank,
        ]);

        return back()->with('success', 'Winner selected!');
    }
}