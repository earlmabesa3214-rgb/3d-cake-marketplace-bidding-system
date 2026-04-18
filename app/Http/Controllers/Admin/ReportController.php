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
$reports = Report::with(['reporter', 'reported', 'bakerOrder'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('role'),   fn($q) => $q->where('reporter_role', $request->role))
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }
public function show(Report $report)
{
    $report->load(['reporter', 'reported', 'bakerOrder']);
    return view('admin.reports.show', compact('report'));
}

public function update(Request $request, Report $report)
{
    $request->validate([
        'status'     => ['required', 'in:pending,reviewed,resolved,dismissed'],
        'admin_note' => ['nullable', 'string', 'max:1000'],
    ]);

    $report->update([
        'status'      => $request->status,
        'admin_note'  => $request->admin_note,
        'reviewed_at' => now(),
    ]);

    return back()->with('success', 'Report updated.');
}
}