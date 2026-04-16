<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\BakerOrder;
use App\Models\BakerWallet;
use App\Models\WithdrawalRequest;
use App\Models\PlatformAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EscrowController extends Controller
{
    /**
     * List all pending payment proofs for admin review.
     */
    public function index()
    {
        $pendingPayments = Payment::where('status', 'pending')
            ->where('escrow_status', 'pending')
            ->with(['cakeRequest.user', 'cakeRequest.bakerOrder.baker'])
            ->latest()
            ->get();

        $heldPayments = Payment::where('escrow_status', 'held')
            ->with(['cakeRequest.user', 'cakeRequest.bakerOrder.baker'])
            ->latest()
            ->get();

        $pendingWithdrawals = WithdrawalRequest::where('status', 'pending')
            ->with('baker')
            ->latest()
            ->get();

        $platformAccounts = PlatformAccount::all();

        return view('admin.escrow.index', compact(
            'pendingPayments', 'heldPayments',
            'pendingWithdrawals', 'platformAccounts'
        ));
    }

    /**
     * Admin confirms payment received in platform account
     * → marks as held in escrow
     * → advances baker order to PREPARING (if downpayment)
     */
    public function confirmPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'platform_reference' => 'required|string|max:100',
        ]);

        abort_if($payment->escrow_status !== 'pending', 422, 'Payment is not in pending state.');

        DB::transaction(function () use ($payment, $request) {
            $payment->markAsHeld($request->platform_reference);

            $order = BakerOrder::where('cake_request_id', $payment->cake_request_id)->first();
            if (!$order) return;

            if ($payment->payment_type === 'downpayment' && $order->status === 'WAITING_FOR_PAYMENT') {
                $order->update(['status' => 'PREPARING']);
                $order->cakeRequest->update(['status' => 'IN_PROGRESS']);

                // Notify baker
                $order->baker->notify(
                    new \App\Notifications\OrderStatusChangedNotification($order, 'paid')
                );
                // Notify customer
                $order->cakeRequest->user->notify(
                    new \App\Notifications\OrderStatusChangedNotification($order, 'paid')
                );
            }

            if ($payment->payment_type === 'final' && $order->status === 'WAITING_FINAL_PAYMENT') {
                // Notify baker that final payment is confirmed, they can deliver
                $order->baker->notify(
                    new \App\Notifications\OrderStatusChangedNotification($order, 'paid')
                );
            }
        });

        return back()->with('success', 'Payment confirmed and held in escrow. Baker has been notified.');
    }

    /**
     * Admin rejects a payment proof.
     */
    public function rejectPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|in:' . implode(',', array_keys(Payment::REJECTION_REASONS)),
            'rejection_note'   => 'nullable|string|max:500',
        ]);

        $newCount = $payment->rejection_count + 1;

        $payment->update([
            'status'                => 'rejected',
            'escrow_status'         => 'pending',
            'rejection_reason'      => $request->rejection_reason,
            'rejection_note'        => $request->rejection_note,
            'rejected_at'           => now(),
            'rejection_count'       => $newCount,
            'reupload_requested_at' => $newCount < 2 ? now() : null,
        ]);

        $order = BakerOrder::where('cake_request_id', $payment->cake_request_id)->first();

        if ($newCount >= 2 && $order) {
            $order->update([
                'status'        => 'CANCELLED',
                'cancelled_at'  => now(),
                'cancel_reason' => 'Repeated invalid payment proofs.',
            ]);
            $order->cakeRequest->update(['status' => 'CANCELLED']);
            $order->cakeRequest->user->notify(
                new \App\Notifications\OrderCancelledDueToFraudNotification($order, $payment)
            );
        } else {
            $order?->cakeRequest->user->notify(
                new \App\Notifications\PaymentRejectedNotification($order, $payment)
            );
        }

        return back()->with('success', 'Payment rejected. Customer notified.');
    }

    /**
     * Admin approves baker withdrawal request.
     */
    public function approveWithdrawal(Request $request, WithdrawalRequest $withdrawal)
    {
        abort_if($withdrawal->status !== 'pending', 422);

        DB::transaction(function () use ($withdrawal, $request) {
            $wallet = BakerWallet::forBaker($withdrawal->baker_id);
            $wallet->debit($withdrawal->amount);

            $withdrawal->update([
                'status'       => 'approved',
                'processed_at' => now(),
                'admin_note'   => $request->admin_note,
                'processed_by' => auth()->id(),
            ]);
        });

        return back()->with('success', "Withdrawal of ₱{$withdrawal->amount} approved. Send to {$withdrawal->account_number}.");
    }

    /**
     * Admin rejects baker withdrawal request.
     */
    public function rejectWithdrawal(Request $request, WithdrawalRequest $withdrawal)
    {
        abort_if($withdrawal->status !== 'pending', 422);

        $withdrawal->update([
            'status'       => 'rejected',
            'processed_at' => now(),
            'admin_note'   => $request->admin_note,
            'processed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Withdrawal request rejected.');
    }

    /**
     * Manage platform accounts (GCash/Maya).
     */
    public function updatePlatformAccount(Request $request, PlatformAccount $account)
    {
        $request->validate([
            'account_name'   => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'qr_code'        => 'nullable|image|max:2048',
        ]);

        $data = [
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
        ];

        if ($request->hasFile('qr_code')) {
            $data['qr_code_path'] = $request->file('qr_code')->store('platform-qr', 'public');
        }

        $account->update($data);

        return back()->with('success', 'Platform account updated.');
    }
}