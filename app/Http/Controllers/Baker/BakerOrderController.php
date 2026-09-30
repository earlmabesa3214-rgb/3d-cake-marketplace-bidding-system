<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\BakerOrder;
use App\Models\Payment;
use App\Models\Baker;
use App\Services\EscrowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BakerOrderController extends Controller
{
    public function __construct(private EscrowService $escrow) {}

    public function index()
    {
        $orders = BakerOrder::with(['cakeRequest.user', 'bid'])
            ->where('baker_id', Auth::id())
            ->latest()->get();

        return view('baker.orders.index', compact('orders'));
    }

    public function show(BakerOrder $order)
    {
        abort_if($order->baker_id !== Auth::id(), 403);

        if ($order->cakeRequest->status === 'CANCELLED' && $order->status !== 'CANCELLED') {
            $order->update(['status' => 'CANCELLED', 'cancelled_at' => now(), 'cancel_reason' => 'Cancelled by customer.']);
            $order->refresh();
        }

        $order->load(['cakeRequest.user', 'baker', 'messages']);

        $payment  = Payment::where('cake_request_id', $order->cake_request_id)->where('payment_type', 'full')->first();
        $isPickup = $order->cakeRequest->isPickup();
        $escrow   = $payment?->escrow_status;

        return view('baker.orders.show', compact('order', 'payment', 'isPickup', 'escrow'));
    }

   
public function advance(Request $request, BakerOrder $order)
{
    abort_if($order->baker_id !== Auth::id(), 403);
    abort_if($order->status === 'CANCELLED', 422, 'This order has been cancelled.');

    // Pickup orders: the "Confirm Pickup" button posts here while status is READY
    if ($order->status === 'READY' && $order->cakeRequest->isPickup()) {
        return $this->confirmHandover($request, $order);
    }

    // Double-click or stale page: go back instead of throwing a 422
    if ($order->status !== 'PREPARING') {
        return redirect()->route('baker.orders.show', $order->id)
            ->with('error', 'This order has already moved to the next step.');
    }

    $request->validate(['cake_final_photo' => 'required|image|max:5120']);

    DB::transaction(function () use ($order, $request) {
        $order->update([
            'status'           => 'READY',
            'cake_final_photo' => $request->file('cake_final_photo')->store('cake-final-photos', 'public'),
        ]);
        $order->cakeRequest->update(['status' => 'IN_PROGRESS']);
    });

    $order->cakeRequest->user->notify(
        new \App\Notifications\OrderStatusChangedNotification($order, 'READY')
    );

    return back()->with('success', 'Cake marked as ready! Customer has been notified.');
}

public function confirmHandover(Request $request, BakerOrder $order)
{
    abort_if($order->baker_id !== Auth::id(), 403);
    abort_if($order->status === 'CANCELLED', 422, 'This order has been cancelled.');
    abort_if(! $order->cakeRequest->isPickup(), 422, 'Only pickup orders are confirmed via handover.');

    if ($order->status !== 'READY') {
        return redirect()->route('baker.orders.show', $order->id)
            ->with('error', 'This order is not ready for handover.');
    }

    try {
        $this->escrow->releaseToBaker($order);
    } catch (\Exception $e) {
        return back()->with('error', 'Error completing order: ' . $e->getMessage());
    }

    $order->update(['status' => 'COMPLETED', 'completed_at' => now()]);
    $order->cakeRequest->update(['status' => 'COMPLETED']);

    $order->cakeRequest->user->notify(
        new \App\Notifications\OrderStatusChangedNotification($order, 'COMPLETED')
    );

    return redirect()
        ->route('baker.orders.show', $order->id)
        ->with('success', 'Pickup confirmed! Funds released to your wallet.');
}

    /**
     * Delivery only: baker marks the cake as delivered, once the customer
     * has approved (status OUT_FOR_DELIVERY). Does NOT release escrow —
     * that still happens when the customer confirms receipt.
     */
    public function markDelivered(Request $request, BakerOrder $order)
    {
        abort_if($order->baker_id !== Auth::id(), 403);
        abort_if($order->cakeRequest->isPickup(), 422, 'Pickup orders are confirmed via handover instead.');
        abort_if($order->status !== 'OUT_FOR_DELIVERY', 422, 'Customer has not yet approved delivery.');

        $order->update(['status' => 'DELIVERED', 'delivered_at' => now()]);

        $order->cakeRequest->user->notify(
            new \App\Notifications\OrderStatusChangedNotification($order, 'DELIVERED')
        );

        return back()->with('success', '🚚 Marked as delivered! Customer has been notified to confirm receipt.');
    }
}