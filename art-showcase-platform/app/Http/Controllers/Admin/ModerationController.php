<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Artwork;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    /**
     * Display moderation queue.
     */
    public function index()
    {
        // Get all reports with polymorphic relationships
        $reports = Report::with(['reporter', 'reportable'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.moderation.index', compact('reports'));
    }

    /**
     * Show detailed report view.
     */
    public function show($id)
    {
        $report = Report::with(['reporter', 'reportable'])
            ->findOrFail($id);
            
        // Load additional relationships based on reportable type
        if ($report->reportable_type === 'App\Models\Artwork') {
            $report->reportable->load(['user', 'category']);
        } elseif ($report->reportable_type === 'App\Models\Comment') {
            $report->reportable->load(['user', 'artwork']);
        }
            
        return view('admin.moderation.show', compact('report'));
    }

    /**
     * Dismiss a report (reject the report).
     */
    public function dismiss($id)
    {
        $report = Report::findOrFail($id);
        
        $report->update([
            'status' => 'dismissed',
            'admin_note' => 'Report dismissed by admin',
        ]);
        
        return redirect()->route('admin.moderation.index')
            ->with('success', 'Report dismissed successfully.');
    }

    /**
     * Resolve a report (take action on reported content).
     */
    public function resolve($id)
    {
        $report = Report::with('reportable')->findOrFail($id);
        
        // Handle based on reportable type
        if ($report->reportable_type === 'App\Models\Artwork') {
            $artwork = $report->reportable;
            $artworkTitle = $artwork->title;
            $artistId = $artwork->user_id;
            
            // Delete the artwork
            $artwork->delete();
            
            $action = 'artwork_removed';
            $message = 'Artwork removed successfully.';
            
        } elseif ($report->reportable_type === 'App\Models\Comment') {
            $comment = $report->reportable;
            $commentContent = $comment->content;
            $commenterId = $comment->user_id;
            
            // Delete the comment
            $comment->delete();
            
            $action = 'comment_removed';
            $message = 'Comment removed successfully.';
        } else {
            return redirect()->back()
                ->with('error', 'Unknown content type.');
        }
        
        // Update report status
        $report->update([
            'status' => 'resolved',
            'admin_note' => "Content removed: " . ($action === 'artwork_removed' ? 'Artwork' : 'Comment'),
        ]);
        
        return redirect()->route('admin.moderation.index')
            ->with('success', $message);
    }
    
    /**
     * Temporary suspension (ban user).
     */
    public function suspendUser($reportId)
    {
        $report = Report::with('reportable')->findOrFail($reportId);
        
        // Get user based on reportable type
        if ($report->reportable_type === 'App\Models\Artwork') {
            $user = $report->reportable->user;
        } elseif ($report->reportable_type === 'App\Models\Comment') {
            $user = $report->reportable->user;
        } else {
            return redirect()->back()
                ->with('error', 'Cannot identify user.');
        }
        
        // Check if user exists
        if (!$user) {
            return redirect()->back()
                ->with('error', 'User not found.');
        }
        
        // Update user status
        $user->update([
            'status' => 'suspended',
            'suspended_until' => now()->addDays(7),
        ]);
        
        // Update report
        $report->update([
            'status' => 'resolved',
            'admin_note' => 'User suspended for 7 days.',
        ]);
        
        return redirect()->route('admin.moderation.index')
            ->with('success', 'User suspended for 7 days.');
    }
    
    /**
     * Add admin note to report.
     */
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);
        
        $report = Report::findOrFail($id);
        $report->update([
            'admin_note' => $request->admin_note,
        ]);
        
        return redirect()->back()
            ->with('success', 'Note added successfully.');
    }
}