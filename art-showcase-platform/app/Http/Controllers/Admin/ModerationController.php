<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['reporter', 'reportable']);

        // Filter by status
        $status = $request->get('status', 'pending');
        if ($status) {
            $query->where('status', $status);
        }

        $reports = $query->latest()->paginate(20);

        return view('admin.moderation.index', compact('reports'));
    }

    public function dismiss(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $report->update([
            'status' => 'dismissed',
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Report dismissed!');
    }

    public function resolve($id)
    {
        $report = Report::findOrFail($id);

        // Delete the reported content
        $reportable = $report->reportable;
        if ($reportable) {
            $reportable->delete();
        }

        $report->update([
            'status' => 'resolved',
        ]);

        return back()->with('success', 'Report resolved and content removed!');
    }
}