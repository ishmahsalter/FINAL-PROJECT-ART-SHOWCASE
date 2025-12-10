<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Artwork;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Report an artwork.
     */
    public function reportArtwork(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        $artwork = Artwork::findOrFail($id);
        
        // Check if user already reported this artwork
        $existingReport = Report::where('reporter_id', Auth::id())
            ->where('reportable_type', 'App\Models\Artwork')
            ->where('reportable_id', $artwork->id)
            ->first();
        
        if ($existingReport) {
            return redirect()->back()
                ->with('error', 'You have already reported this artwork.');
        }
        
        // Create report
        Report::create([
            'reporter_id' => Auth::id(),
            'reportable_type' => 'App\Models\Artwork',
            'reportable_id' => $artwork->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);
        
        // Increment report count on artwork
        $artwork->increment('report_count');
        
        return redirect()->back()
            ->with('success', 'Thank you for your report. Our team will review it shortly.');
    }

    /**
     * Report a comment.
     */
    public function reportComment(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        $comment = Comment::findOrFail($id);
        
        // Check if user already reported this comment
        $existingReport = Report::where('reporter_id', Auth::id())
            ->where('reportable_type', 'App\Models\Comment')
            ->where('reportable_id', $comment->id)
            ->first();
        
        if ($existingReport) {
            return redirect()->back()
                ->with('error', 'You have already reported this comment.');
        }
        
        // Create report
        Report::create([
            'reporter_id' => Auth::id(),
            'reportable_type' => 'App\Models\Comment',
            'reportable_id' => $comment->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);
        
        return redirect()->back()
            ->with('success', 'Thank you for your report. Our team will review it shortly.');
    }
}