<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\CashInRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WalletController extends Controller
{
    public function index()
    {
        $wallet       = Wallet::forUser(Auth::id());
        $transactions = $wallet->transactions()->latest()->take(20)->get();
        $pendingCashin = CashInRequest::where('user_id', Auth::id())
            ->where('status', 'pending')->first();

        return view('customer.wallet.index', compact('wallet', 'transactions', 'pendingCashin'));
    }

    public function cashIn(Request $request)
    {
        $request->validate([
            'amount'           => 'required|numeric|min:50|max:50000',
            'gcash_reference'  => 'required|string|max:20',
            'proof'            => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Check no pending request
        $existing = CashInRequest::where('user_id', Auth::id())
            ->where('status', 'pending')->first();
        if ($existing) {
            return back()->with('error', 'You already have a pending cash-in request.');
        }

        $proofPath = $request->file('proof')->store('cashin-proofs', 'public');

        CashInRequest::create([
            'user_id'         => Auth::id(),
            'amount'          => $request->amount,
            'gcash_reference' => $request->gcash_reference,
            'proof_path'      => $proofPath,
            'method'          => 'gcash',
            'status'          => 'pending',
        ]);

        return back()->with('success', '✅ Cash-in request submitted! Your wallet will be credited within minutes after admin verification.');
    }
}