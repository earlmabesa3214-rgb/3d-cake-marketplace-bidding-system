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
        ->when($request->filled('role'),     fn($q) => $q->where('reporter_role', $request->role))
->when($request->filled('category'), fn($q) => $q->where('category', $request->category))
            ->latest()
            ->paginate(20);

       $categories = Report::CATEGORIES;
        return view('admin.reports.index', compact('reports', 'categories'));
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

/**
 * Hold or release the baker's payment for this order.
 * Route: POST /admin/reports/{report}/hold-payment
 */
public function holdPayment(Request $request, Report $report)
{
    $hold = (bool) $request->input('hold', true);

    $report->update(['payment_held' => $hold]);

    // If a bakerOrder exists, freeze the agreed payout so it can't auto-release
    if ($report->bakerOrder) {
        $report->bakerOrder->update([
            'payout_frozen' => $hold,
        ]);
    }

    $msg = $hold
        ? 'Payment has been placed on hold. Baker cannot receive funds until released.'
        : 'Payment hold has been lifted.';

    return back()->with('success', $msg);
}

/**
 * Approve a refund — moves downpayment back to customer wallet.
 * Route: POST /admin/reports/{report}/refund/approve
 */
public function approveRefund(Request $request, Report $report)
{
    $request->validate([
        'refund_amount' => ['required', 'numeric', 'min:1'],
        'refund_note'   => ['nullable', 'string', 'max:500'],
    ]);

    $bakerOrder = $report->bakerOrder;

    if (!$bakerOrder) {
        return back()->with('error', 'No baker order linked to this report.');
    }

    $amount = (float) $request->refund_amount;

    // Credit customer wallet
    $customerUserId = $bakerOrder->cakeRequest->user_id ?? null;
    if ($customerUserId) {
        $wallet = \App\Models\Wallet::forUser($customerUserId);
      $wallet->credit(
    $amount,
    'refund',
    'Refund approved by admin — Order #' . str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT),
    $bakerOrder->id
);
    }

    // Debit baker wallet if payment was already released (edge case)
    // Only debit baker if their wallet actually received it
    $downpayment = \App\Models\Payment::where('cake_request_id', $bakerOrder->cake_request_id)
        ->where('payment_type', 'downpayment')
        ->where('status', 'paid')
        ->first();

    if ($downpayment && $bakerOrder->payout_frozen) {
        // Payment was held — no need to debit baker, just void the hold
        $bakerOrder->update(['payout_frozen' => false, 'status' => 'CANCELLED']);
    }

    $report->update([
        'refund_status'        => 'approved',
        'refund_amount'        => $amount,
        'refund_note'          => $request->refund_note,
        'payment_held'         => false,
        'refund_processed_at'  => now(),
        'status'               => 'resolved',
        'reviewed_at'          => now(),
    ]);

    return back()->with('success', "Refund of ₱{$amount} approved and credited to customer's wallet.");
}

/**
 * Reject the refund request.
 * Route: POST /admin/reports/{report}/refund/reject
 */
public function rejectRefund(Request $request, Report $report)
{
    $request->validate([
        'refund_note' => ['required', 'string', 'max:500'],
    ]);

    // Release payment hold so baker can eventually be paid
    $report->update([
        'refund_status'       => 'rejected',
        'refund_note'         => $request->refund_note,
        'payment_held'        => false,
        'refund_processed_at' => now(),
        'status'              => 'resolved',
        'reviewed_at'         => now(),
    ]);

    if ($report->bakerOrder) {
        $report->bakerOrder->update(['payout_frozen' => false]);
    }

    return back()->with('success', 'Refund request rejected. Payment hold released.');
}
}