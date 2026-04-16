<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\BakerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Show the report form.
     * Route: GET /report/order/{bakerOrder}
     */
    public function create(BakerOrder $bakerOrder)
    {
        $user = Auth::user();

        // Determine reporter role
        $isBaker    = $bakerOrder->baker_id === $user->id;
        $isCustomer = $bakerOrder->cakeRequest->user_id === $user->id;

        if (!$isBaker && !$isCustomer) {
            abort(403, 'You are not part of this order.');
        }

        // Prevent duplicate reports for same order by same user
        $existing = Report::where('reporter_id', $user->id)
            ->where('baker_order_id', $bakerOrder->id)
            ->first();

        $reporterRole = $isBaker ? 'baker' : 'customer';
        $reportedUser = $isBaker ? $bakerOrder->cakeRequest->user : $bakerOrder->baker;

        return view('reports.create', compact(
            'bakerOrder',
            'reporterRole',
            'reportedUser',
            'existing'
        ));
    }

    /**
     * Store the report.
     * Route: POST /report/order/{bakerOrder}
     */
    public function store(Request $request, BakerOrder $bakerOrder)
    {
        $user = Auth::user();

        $isBaker    = $bakerOrder->baker_id === $user->id;
        $isCustomer = $bakerOrder->cakeRequest->user_id === $user->id;

        if (!$isBaker && !$isCustomer) {
            abort(403);
        }

        // Prevent duplicate
        $existing = Report::where('reporter_id', $user->id)
            ->where('baker_order_id', $bakerOrder->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already submitted a report for this order.');
        }

        $request->validate([
            'category'    => ['required', 'in:' . implode(',', array_keys(Report::CATEGORIES))],
            'description' => ['required', 'string', 'min:2', 'max:2000'],
            'screenshot'  => ['nullable', 'image', 'max:4096'],
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('reports/screenshots', 'public');
        }

        $reporterRole = $isBaker ? 'baker' : 'customer';
        $reportedId   = $isBaker ? $bakerOrder->cakeRequest->user_id : $bakerOrder->baker_id;

        Report::create([
            'reporter_id'    => $user->id,
            'reported_id'    => $reportedId,
            'baker_order_id' => $bakerOrder->id,
            'reporter_role'  => $reporterRole,
            'category'       => $request->category,
            'description'    => $request->description,
            'screenshot_path'=> $screenshotPath,
            'status'         => 'pending',
        ]);

        $redirectRoute = $isBaker
            ? route('baker.orders.show', $bakerOrder->id)
            : route('customer.cake-requests.show', $bakerOrder->cake_request_id);

        return redirect($redirectRoute)
            ->with('success', 'Your report has been submitted. Our admin team will review it shortly.');
    }

    /**
     * List reports filed by the current user.
     * Route: GET /reports/my
     */
    public function myReports()
    {
        $reports = Report::with(['reported', 'bakerOrder'])
            ->where('reporter_id', Auth::id())
            ->latest()
            ->get();

        return view('reports.my-reports', compact('reports'));
    }
}