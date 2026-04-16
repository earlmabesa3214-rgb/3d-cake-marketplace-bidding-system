<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * List all user reports.
     * Route: GET /admin/reports
     */
    public function index(Request $request)
    {
        $query = Report::with(['reporter', 'reported', 'bakerOrder']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('role')) {
            $query->where('reporter_role', $request->role);
        }

        $reports = $query->latest()->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show a single report.
     * Route: GET /admin/reports/{report}
     */
    public function show(Report $report)
    {
        $report->load(['reporter', 'reported', 'bakerOrder.cakeRequest']);

        return view('admin.reports.show', compact('report'));
    }

    /**
     * Update report status and admin note.
     * Route: PATCH /admin/reports/{report}
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status'     => ['required', 'in:pending,reviewed,resolved,dismissed'],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        // Set reviewed_at timestamp when moving out of pending
        if ($report->status === 'pending' && $validated['status'] !== 'pending') {
            $validated['reviewed_at'] = now();
        }

        $report->update($validated);

        return back()->with('success', 'Report updated successfully.');
    }
}