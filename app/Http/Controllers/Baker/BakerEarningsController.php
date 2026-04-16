<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\BakerOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class BakerEarningsController extends Controller
{
    public function index()
    {
        $bakerId = Auth::id();

        // Earnings grouped by month for the last 6 months
        $monthly = BakerOrder::where('baker_id', $bakerId)
            ->where('status', 'COMPLETED')
            ->where('completed_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->selectRaw("YEAR(completed_at) as year, MONTH(completed_at) as month, SUM(agreed_price) as total, COUNT(*) as count")
            ->groupByRaw('YEAR(completed_at), MONTH(completed_at)')
            ->orderByRaw('YEAR(completed_at), MONTH(completed_at)')
            ->get();

        $thisMonth = BakerOrder::where('baker_id', $bakerId)
            ->where('status', 'COMPLETED')
            ->whereMonth('completed_at', Carbon::now()->month)
            ->whereYear('completed_at', Carbon::now()->year)
            ->sum('agreed_price');

 $wallet  = \App\Models\BakerWallet::forBaker($bakerId);
        $allTime = $wallet->total_earned;

        $completedCount = BakerOrder::where('baker_id', $bakerId)
            ->where('status', 'COMPLETED')
            ->count();

        // ADD THIS ↓
        $transactions = BakerOrder::where('baker_id', $bakerId)
            ->where('status', 'COMPLETED')
            ->with('cakeRequest.user')
            ->latest('completed_at')
            ->get();

    return view('baker.earnings', compact(
            'monthly', 'thisMonth', 'allTime', 'completedCount', 'transactions', 'wallet'
        ));
    }
}