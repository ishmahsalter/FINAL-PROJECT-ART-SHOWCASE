<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    public function updateStatus(Request $request, Submission $submission)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);
        
        // Check if curator owns the challenge
        if ($submission->challenge->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $submission->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => 'Submission status updated',
            'submission' => $submission
        ]);
    }
    
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'submission_ids' => 'required|array',
            'submission_ids.*' => 'exists:submissions,id',
            'status' => 'required|in:approved,rejected,pending'
        ]);
        
        $updated = Submission::whereIn('id', $request->submission_ids)
            ->whereHas('challenge', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => "Updated {$updated} submissions",
            'updated_count' => $updated
        ]);
    }
    
    public function markAsWinner(Submission $submission)
    {
        // Check if curator owns the challenge
        if ($submission->challenge->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        // Check if challenge is ended
        if ($submission->challenge->end_date > now()) {
            return response()->json([
                'success' => false,
                'message' => 'Challenge is still active'
            ], 400);
        }
        
        // Mark as winner (temporary, rank will be set in select-winners page)
        $submission->update(['is_winner' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Submission marked as winner'
        ]);
    }
    
    public function remove(Submission $submission)
    {
        // Check if curator owns the challenge
        if ($submission->challenge->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $submission->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Submission removed from challenge'
        ]);
    }
}