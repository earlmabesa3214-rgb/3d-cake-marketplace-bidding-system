<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\CakeRequest;
use App\Models\BakerOrder;
use App\Models\Baker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RushOrderController extends Controller
{
    public function accept(CakeRequest $cakeRequest)
    {
        // Only RUSH_MATCHING orders can be accepted this way
        if ($cakeRequest->status !== 'RUSH_MATCHING') {
            return back()->with('error', 'This rush order is no longer available.');
        }

        // Baker must have rush mode ON and be available
        $baker = Baker::where('user_id', Auth::id())->firstOrFail();
        if (!$baker->accepts_rush_orders || !$baker->is_available) {
            return back()->with('error', 'Enable rush mode and set yourself as available to accept rush orders.');
        }

        // Auto-price: use cake config total + baker's rush fee
        $config    = is_array($cakeRequest->cake_configuration)
            ? $cakeRequest->cake_configuration
            : (json_decode($cakeRequest->cake_configuration, true) ?? []);

        $basePrice = (float) ($config['total'] ?? $cakeRequest->budget_min ?? 0);
        $rushFee   = (float) ($baker->rush_fee ?? 0);
        $agreed    = $basePrice + $rushFee;

        // Clamp to customer's budget max if exceeded
        if ($agreed > $cakeRequest->budget_max) {
            $agreed = (float) $cakeRequest->budget_max;
        }

     // Prevent duplicate bids
        if ($cakeRequest->bids()->where('baker_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already submitted a bid for this rush order.');
        }

        \App\Models\Bid::create([
            'baker_id'        => Auth::id(),
            'cake_request_id' => $cakeRequest->id,
            'amount'          => $agreed,
            'estimated_days'  => 1,
            'message'         => '⚡ Rush bid — includes ₱' . number_format($rushFee, 2) . ' rush fee',
            'status'          => 'PENDING',
        ]);

        // Notify customer a baker has responded
        $cakeRequest->user?->notify(
            new \App\Notifications\RushOrderAvailableNotification($cakeRequest, 0)
        );

        return redirect()->route('baker.requests.index')
            ->with('success', '⚡ Rush bid submitted! The customer will choose within 60 seconds.');
    }
}