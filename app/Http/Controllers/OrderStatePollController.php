<?php

namespace App\Http\Controllers;

use App\Models\BakerOrder;
use App\Models\CakeRequest;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderStatePollController extends Controller
{
    /**
     * Baker-side polling
     * GET /baker/orders/{order}/state-poll
     */
    public function bakerPoll(BakerOrder $order)
    {
        $user  = Auth::user();
        $baker = \App\Models\Baker::where('user_id', $user->id)->first();

        $authorized = ($order->baker_id === $user->id)
                   || ($baker && $order->baker_id === $baker->id);

        abort_if(!$authorized, 403);

        $order->refresh();

        // Use the relationship properly
        $cakeRequest = CakeRequest::find($order->cake_request_id);

        $down  = Payment::where('cake_request_id', $cakeRequest->id)
                        ->where('payment_type', 'downpayment')
                        ->first();
        $final = Payment::where('cake_request_id', $cakeRequest->id)
                        ->where('payment_type', 'final')
                        ->first();

        return response()->json([
    'order_status'   => $order->status,
    'request_status' => $cakeRequest->status,
    'down_status'    => $down?->status,
    'down_escrow'    => $down?->escrow_status,
    'final_status'   => $final?->status,
    'final_escrow'   => $final?->escrow_status,
    'has_cake_photo' => (bool) $order->cake_final_photo,
    'agreed_price'   => $order->agreed_price,
    'baker_payout'   => $order->baker_payout,
]);
    }

    /**
     * Customer-side polling
     * GET /customer/cake-requests/{cakeRequest}/state-poll
     */
    public function customerPoll(CakeRequest $cakeRequest)
    {
        $user = Auth::user();
        abort_if($cakeRequest->user_id !== $user->id, 403);

        $cakeRequest->refresh();
        $bakerOrder = BakerOrder::where('cake_request_id', $cakeRequest->id)
                        ->latest()
                        ->first();

        $down  = Payment::where('cake_request_id', $cakeRequest->id)
                        ->where('payment_type', 'downpayment')
                        ->first();
        $final = Payment::where('cake_request_id', $cakeRequest->id)
                        ->where('payment_type', 'final')
                        ->first();

       return response()->json([
    'request_status'     => $cakeRequest->status,
    'baker_order_status' => $bakerOrder?->status,
    'bids_count'         => $cakeRequest->bids()->count(),
    'last_bid_id'        => $cakeRequest->bids()->max('id') ?? 0,
    'down_status'        => $down?->status,
    'down_escrow'        => $down?->escrow_status,
    'final_status'       => $final?->status,
    'final_escrow'       => $final?->escrow_status,
    'has_cake_photo'     => (bool) $bakerOrder?->cake_final_photo,
    'baker_order_id'     => $bakerOrder?->id,
    'agreed_price'       => $bakerOrder?->agreed_price,
]);
    }
}