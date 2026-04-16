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

        $downpayment  = Payment::where('cake_request_id', $order->cake_request_id)->where('payment_type', 'downpayment')->first();
        $finalPayment = Payment::where('cake_request_id', $order->cake_request_id)->where('payment_type', 'final')->first();
        $isPickup     = $order->cakeRequest->isPickup();
        $downEscrow   = $downpayment?->escrow_status;
        $finalEscrow  = $finalPayment?->escrow_status;

        return view('baker.orders.show', compact(
            'order', 'downpayment', 'finalPayment',
            'isPickup', 'downEscrow', 'finalEscrow'
        ));
    }

    public function advance(Request $request, BakerOrder $order)
    {
        abort_if($order->baker_id !== Auth::id(), 403);
        abort_if($order->status === 'CANCELLED', 422, 'This order has been cancelled.');

        $isPickup = $order->cakeRequest->isPickup();

      $next = [
    'PREPARING'             => 'READY',
    'READY'                 => 'WAITING_FINAL_PAYMENT',
    'WAITING_FINAL_PAYMENT' => 'DELIVERED',
];

        if (!isset($next[$order->status])) {
            return back()->with('error', 'Cannot advance order from current status.');
        }

        $newStatus = $next[$order->status];

        DB::transaction(function () use ($order, $newStatus, $request) {
            $updateData = ['status' => $newStatus];

   if ($newStatus === 'READY' && $request->hasFile('cake_final_photo')) {
    $updateData['cake_final_photo'] = $request->file('cake_final_photo')
        ->store('cake-final-photos', 'public');
}

        $order->update($updateData);

if ($newStatus === 'READY') {
    $order->cakeRequest->update(['status' => 'WAITING_FINAL_PAYMENT']);
} else {
    $order->cakeRequest->update(['status' => 'IN_PROGRESS']);
}
        });

        $order->cakeRequest->user->notify(
            new \App\Notifications\OrderStatusChangedNotification($order, $newStatus)
        );

        return back()->with('success', '📦 Cake marked as ready! Customer has been notified to confirm and pay.');
    }

/**
     * Baker confirms final payment (pickup cash or delivery wallet release).
     */
    public function confirmFinalPayment(Request $request, BakerOrder $order)
    {
        abort_if($order->baker_id !== Auth::id(), 403);
        abort_if($order->status !== 'WAITING_FINAL_PAYMENT', 422, 'Order is not awaiting final payment.');

        $isPickup = $order->cakeRequest->isPickup();

        DB::transaction(function () use ($order, $isPickup) {
            if ($isPickup) {
                // Cash pickup — no wallet, just complete directly
                $order->update(['status' => 'COMPLETED', 'completed_at' => now()]);
                $order->cakeRequest->update(['status' => 'COMPLETED']);

                // Release downpayment escrow to baker
                try {
                    $this->escrow->releaseToBaker($order);
                } catch (\Exception $e) {
                    // Already released or no escrow, continue
                }
            } else {
                // Delivery — baker confirms they delivered, release escrow
                $order->update(['status' => 'COMPLETED', 'completed_at' => now()]);
                $order->cakeRequest->update(['status' => 'COMPLETED']);

                try {
                    $this->escrow->releaseToBaker($order);
                } catch (\Exception $e) {
                    // Already released, continue
                }
            }
        });

        $order->cakeRequest->user->notify(
            new \App\Notifications\OrderStatusChangedNotification($order, 'COMPLETED')
        );

        return redirect()
            ->route('baker.orders.show', $order->id)
            ->with('success', $isPickup ? '💵 Cash confirmed! Order completed.' : '🎉 Order completed! Funds released to your wallet.');
    }

    /**
     * Baker marks "Ready for Pickup" — customer sees cake photo and pays final via wallet.
     */
    public function markReadyForPickup(Request $request, BakerOrder $order)
    {
        abort_if($order->baker_id !== Auth::id(), 403);
        abort_if($order->status !== 'PREPARING', 422);

        $request->validate([
            'cake_final_photo' => 'required|image|max:5120',
        ]);

        $path = $request->file('cake_final_photo')->store('cake-final-photos', 'public');

        $order->update([
            'status'          => 'READY',
            'cake_final_photo' => $path,
        ]);
        $order->cakeRequest->update(['status' => 'IN_PROGRESS']);

        $order->cakeRequest->user->notify(
            new \App\Notifications\OrderStatusChangedNotification($order, 'READY')
        );

        return back()->with('success', '🏪 Customer notified — they will confirm and pay via wallet.');
    }
}