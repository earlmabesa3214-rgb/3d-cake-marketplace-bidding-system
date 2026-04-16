<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletWithdrawal;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BakerWalletController extends Controller
{
    public function index()
    {
        $wallet       = Wallet::forUser(Auth::id());
        $transactions = $wallet->transactions()->latest()->take(30)->get();
        $withdrawals  = WalletWithdrawal::where('user_id', Auth::id())->latest()->get();
$pending           = $withdrawals->where('status', 'pending')->first();
$pendingWithdrawal = $pending;

        return view('baker.wallet.index', compact('wallet', 'transactions', 'withdrawals', 'pending', 'pendingWithdrawal'));
    }

    public function requestWithdrawal(Request $request)
    {
        $wallet = Wallet::forUser(Auth::id());

        $request->validate([
            'amount'         => "required|numeric|min:100|max:{$wallet->balance}",
            'payment_method' => 'required|in:gcash,maya',
            'account_name'   => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
        ]);

        if (WalletWithdrawal::where('user_id', Auth::id())->where('status', 'pending')->exists()) {
            return back()->with('error', 'You already have a pending withdrawal request.');
        }

        WalletWithdrawal::create([
            'user_id'        => Auth::id(),
            'wallet_id'      => $wallet->id,
            'amount'         => $request->amount,
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
            'requested_at'   => now(),
        ]);

        return back()->with('success', 'Withdrawal request submitted! Admin will process within 1-2 business days.');
    }
}