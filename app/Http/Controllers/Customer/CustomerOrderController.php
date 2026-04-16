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
     * Customer confirms cake looks good + pays final payment from wallet.
     * Delivery flow only.
     */
    public function confirmCakeAndPay(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== Auth::id(), 403);
abort_if(!in_array($order->status, ['WAITING_FINAL_PAYMENT', 'READY']), 422, 'Order is not ready yet.');

        abort_if($order->cakeRequest->isPickup(), 422, 'Use pickup flow instead.');

        $totalAmount = $order->agreed_price;
        $finalAmount = round($totalAmount * 0.5, 2);
        $wallet      = Wallet::forUser(Auth::id());

        if (!$wallet->hasEnough($finalAmount)) {
            return redirect()
                ->route('customer.wallet.index')
                ->with('error', "Insufficient balance. You need ₱{$finalAmount} more. Please top up your wallet first.");
        }
try {
    $this->escrow->holdFinalPayment($order);
} catch (\Exception $e) {
    return back()->with('error', 'Payment failed: ' . $e->getMessage());
}

// Advance baker order to WAITING_FINAL_PAYMENT so baker can confirm delivery
$order->update(['status' => 'WAITING_FINAL_PAYMENT']);
$order->cakeRequest->update(['status' => 'WAITING_FINAL_PAYMENT']);

// Notify baker
$order->baker->notify(
    new \App\Notifications\OrderStatusChangedNotification($order, 'WAITING_FINAL_PAYMENT')
);

return redirect()
    ->route('customer.cake-requests.show', $order->cake_request_id)
    ->with('success', '✅ Final payment confirmed! Your baker will now prepare your cake for delivery. Click "Cake Received" once you get it.');
    }

    /**
     * Customer clicks "Cake Received" — releases escrow to baker.
     * Delivery flow.
     */
    public function confirmReceived(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'WAITING_FINAL_PAYMENT', 422);
        abort_if($order->cakeRequest->isPickup(), 422);

        try {
   $this->escrow->releaseToBaker($order);
        } catch (\Exception $e) {
            return back()->with('error', 'Error completing order: ' . $e->getMessage());
        }

        return redirect()
            ->route('customer.cake-requests.show', $order->cake_request_id)
            ->with('success', '🎉 Order complete! Thank you for your purchase.');
    }

    /**
     * Pickup: customer pays final 50% from wallet + confirms pickup done.
     */
    public function confirmPickup(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'READY', 422);
        abort_if(!$order->cakeRequest->isPickup(), 422);

        $finalAmount = round($order->agreed_price * 0.5, 2);
        $wallet      = Wallet::forUser(Auth::id());

        if (!$wallet->hasEnough($finalAmount)) {
            return redirect()
                ->route('customer.wallet.index')
                ->with('error', "Insufficient balance. You need ₱{$finalAmount}. Please top up your wallet.");
        }

        try {
            $this->escrow->processPickupCompletion($order);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('customer.cake-requests.show', $order->cake_request_id)
            ->with('success', '🎉 Pickup complete! Order finished. Baker has been paid.');
    }
    public function payDownpayment(Request $request, BakerOrder $order)
{
    abort_if($order->cakeRequest->user_id !== Auth::id(), 403);
    abort_if($order->status !== 'WAITING_FOR_PAYMENT', 422, 'Order is not awaiting payment.');

    try {
        $this->escrow->holdDownpayment($order);
    } catch (\Exception $e) {
        $msg = $e->getMessage() === 'insufficient_balance'
            ? 'Insufficient wallet balance. Please top up first.'
            : 'Payment failed: ' . $e->getMessage();
        return back()->with('error', $msg);
    }

    return redirect()
        ->route('customer.cake-requests.show', $order->cake_request_id)
        ->with('success', '✅ Downpayment paid! Your baker will now begin preparing your cake.');
}
}