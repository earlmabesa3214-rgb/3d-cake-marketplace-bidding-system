<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BakerOrder;
use App\Models\Wallet;
use App\Services\EscrowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function __construct(private EscrowService $escrow) {}

    /**
     * Customer pays the full agreed price from wallet before the baker starts.
     * Applies to both delivery and pickup orders.
     */
    public function payFull(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'WAITING_FOR_PAYMENT', 422, 'Order is not awaiting payment.');

        $wallet = Wallet::forUser(Auth::id());

        if (!$wallet->hasEnough($order->agreed_price)) {
            return redirect()
                ->route('customer.wallet.index')
                ->with('error', "Insufficient balance. You need ₱{$order->agreed_price}. Please top up your wallet first.");
        }

        try {
            $this->escrow->holdFullPayment($order); // ⚠ needs to exist in EscrowService
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('customer.cake-requests.show', $order->cake_request_id)
            ->with('success', ' Payment confirmed! Your baker will now begin preparing your cake.');
    }
    /**
     * Customer approves the finished cake and greenlights the baker to
     * begin delivery. Delivery flow only — pickup orders skip this since
     * the baker confirms handover in person.
     */
    public function approveDelivery(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== Auth::id(), 403);
        abort_if($order->cakeRequest->isPickup(), 422, 'Pickup orders do not need delivery approval.');
        abort_if($order->status !== 'READY', 422, 'Order is not ready for delivery approval yet.');

        $order->update(['status' => 'OUT_FOR_DELIVERY', 'approved_for_delivery_at' => now()]);

        $order->baker->notify(
            new \App\Notifications\OrderStatusChangedNotification($order, 'OUT_FOR_DELIVERY')
        );

        return redirect()
            ->route('customer.cake-requests.show', $order->cake_request_id)
            ->with('success', '🚚 Baker notified — your cake is being delivered!');
    }

    /**
     * Customer clicks "Cake Received" — releases escrow to baker.
     * Delivery flow only (pickup is confirmed by the baker instead).
     */
    public function confirmReceived(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'DELIVERED', 422, 'Order has not been marked as delivered yet.');
        abort_if($order->cakeRequest->isPickup(), 422, 'Pickup orders are confirmed by the baker.');

        try {
            $this->escrow->releaseToBaker($order);
        } catch (\Exception $e) {
            return back()->with('error', 'Error completing order: ' . $e->getMessage());
        }

        $order->update(['status' => 'COMPLETED', 'completed_at' => now()]);
        $order->cakeRequest->update(['status' => 'COMPLETED']);

        return redirect()
            ->route('customer.cake-requests.show', $order->cake_request_id)
            ->with('success', '🎉 Order complete! Thank you for your purchase.');
    }
}