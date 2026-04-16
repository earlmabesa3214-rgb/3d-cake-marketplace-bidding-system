<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashInRequest;
use App\Models\Wallet;
use App\Models\WalletWithdrawal;
use App\Models\EscrowHold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletAdminController extends Controller
{
    public function index()
    {
        $pendingCashIns   = CashInRequest::where('status', 'pending')->with('user')->latest()->get();
        $pendingWithdrawals = WalletWithdrawal::where('status', 'pending')->with('user')->latest()->get();
        $heldEscrows      = EscrowHold::where('status', 'held')->with('order.cakeRequest.user', 'order.baker')->latest()->get();

        $totalHeld        = $heldEscrows->sum('amount');
        $totalPendingIn   = $pendingCashIns->sum('amount');
        $totalPendingOut  = $pendingWithdrawals->sum('amount');

        return view('admin.wallet.index', compact(
            'pendingCashIns', 'pendingWithdrawals', 'heldEscrows',
            'totalHeld', 'totalPendingIn', 'totalPendingOut'
        ));
    }

    public function approveCashIn(Request $request, CashInRequest $cashIn)
    {
        abort_if($cashIn->status !== 'pending', 422);

        DB::transaction(function () use ($cashIn) {
            $wallet = Wallet::forUser($cashIn->user_id);
            $wallet->credit($cashIn->amount, 'cashin', "GCash cash-in ₱{$cashIn->amount}");

            $cashIn->update([
                'status'      => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);
        });

        // Auto-trigger any pending escrow holds for this user
        $this->triggerPendingEscrows($cashIn->user_id);

        return back()->with('success', "₱{$cashIn->amount} credited to {$cashIn->user->first_name}'s wallet.");
    }

    public function rejectCashIn(Request $request, CashInRequest $cashIn)
    {
        $request->validate(['reason' => 'required|string|max:255']);
        $cashIn->update(['status' => 'rejected', 'reject_reason' => $request->reason]);
        return back()->with('success', 'Cash-in request rejected.');
    }

public function approveWithdrawal(Request $request, WalletWithdrawal $withdrawal)
{
    abort_if($withdrawal->status !== 'pending', 422);

    $request->validate([
        'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
    ]);

    $receiptPath = $request->file('receipt')->store('withdrawal-receipts', 'public');

    DB::transaction(function () use ($withdrawal, $request, $receiptPath) {
        $wallet = Wallet::forUser($withdrawal->user_id);
        $wallet->debit($withdrawal->amount, "Withdrawal to {$withdrawal->payment_method} {$withdrawal->account_number}");

        $withdrawal->update([
            'status'       => 'approved',
            'processed_at' => now(),
            'processed_by' => auth()->id(),
            'admin_note'   => $request->admin_note,
            'receipt_path' => $receiptPath,
        ]);
    });

    return back()->with('success', "Withdrawal of ₱{$withdrawal->amount} approved.");
}

    public function rejectWithdrawal(Request $request, WalletWithdrawal $withdrawal)
    {
        $withdrawal->update([
            'status'       => 'rejected',
            'processed_at' => now(),
            'processed_by' => auth()->id(),
            'admin_note'   => $request->admin_note,
        ]);
        return back()->with('success', 'Withdrawal rejected.');
    }

    /**
     * After cash-in approved, auto-trigger any orders waiting for payment.
     */
    private function triggerPendingEscrows(int $userId): void
    {
        $pendingOrders = \App\Models\BakerOrder::whereHas('cakeRequest', fn($q) => $q->where('user_id', $userId))
            ->where('status', 'WAITING_FOR_PAYMENT')
            ->get();

        $escrow = app(\App\Services\EscrowService::class);

        foreach ($pendingOrders as $order) {
            try {
                $escrow->holdDownpayment($order);
            } catch (\Exception $e) {
                // Still not enough balance, skip
            }
        }
    }
}