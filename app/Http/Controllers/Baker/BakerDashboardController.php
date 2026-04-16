<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Http\Middleware\BakerProfileComplete;
use App\Models\BakerOrder;
use App\Models\CakeRequest;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class BakerDashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $baker = $user->baker;

        // ── Profile completeness ──────────────────────────────────────────
        $missingFields    = BakerProfileComplete::getMissingFields($user);
        $profileIncomplete = !empty($missingFields);

        // ── Stats ─────────────────────────────────────────────────────────
        $openRequestsCount  = CakeRequest::where('status', 'open')->count();
        $myActiveBidsCount  = Bid::where('baker_id', $user->id)
                                 ->where('status', 'PENDING')->count();
        $activeOrdersCount  = BakerOrder::where('baker_id', $user->id)
                                        ->whereNotIn('status', ['completed', 'cancelled'])->count();

        $completedThisMonth = BakerOrder::where('baker_id', $user->id)
                                        ->where('status', 'completed')
                                        ->whereMonth('updated_at', now()->month)
                                        ->count();

     $monthEarnings = 0;

        // ── Open requests ─────────────────────────────────────────────────
        $openRequests = CakeRequest::where('status', 'open')
                                   ->with('bids')
                                   ->latest()
                                   ->take(5)
                                   ->get();

        // ── Recent bids ───────────────────────────────────────────────────
        $recentBids = Bid::where('baker_id', $user->id)
                         ->with('cakeRequest')
                         ->latest()
                         ->take(5)
                         ->get();

        // ── Earnings chart (last 6 months) ────────────────────────────────
        $earningsChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
       $total = 0;
            $earningsChart[] = [
                'label' => $month->format('M'),
                'total' => $total,
            ];
        }

        return view('baker.dashboard', compact(
            'openRequestsCount', 'myActiveBidsCount', 'activeOrdersCount',
            'completedThisMonth', 'monthEarnings',
            'openRequests', 'recentBids', 'earningsChart',
            'missingFields', 'profileIncomplete'
        ));
    }
}