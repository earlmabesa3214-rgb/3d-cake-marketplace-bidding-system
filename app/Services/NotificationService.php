<?php

namespace App\Services;

use App\Models\BakerOrder;
use App\Models\Bid;
use App\Models\CakeRequest;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    // ─── CUSTOMER NOTIFICATIONS ──────────────────────────────────────────────

    /**
     * A baker placed a bid on the customer's request.
     */
    public static function bakerBidPlaced(CakeRequest $cakeRequest, Bid $bid): void
    {
        $customer = $cakeRequest->user;
        $baker    = $bid->baker;

        $customer->notify(new \App\Notifications\GenericNotification([
            'title'   => '🎂 New Bid Received!',
            'message' => "{$baker->first_name} {$baker->last_name} placed a bid of ₱" . number_format($bid->price, 2) . " on your cake request.",
            'icon'    => '🎂',
            'type'    => 'bid',
            'url'     => route('customer.cake-requests.show', $cakeRequest->id),
        ]));
    }

    /**
     * Baker's bid was accepted by the customer — notify the baker.
     */
    public static function bidAccepted(BakerOrder $order): void
    {
        $baker    = $order->baker;
        $customer = $order->cakeRequest->user;

        $baker->notify(new \App\Notifications\GenericNotification([
            'title'   => '🎉 Your Bid Was Accepted!',
            'message' => "{$customer->first_name} {$customer->last_name} accepted your bid of ₱" . number_format($order->agreed_price, 2) . ". Head to Active Orders to get started.",
            'icon'    => '🎉',
            'type'    => 'bid',
            'url'     => route('baker.orders.show', $order->id),
        ]));
    }

    /**
     * Customer submitted downpayment proof — notify baker.
     */
    public static function downpaymentSubmitted(BakerOrder $order): void
    {
        $baker    = $order->baker;
        $customer = $order->cakeRequest->user;

        $baker->notify(new \App\Notifications\GenericNotification([
            'title'   => '💰 Downpayment Proof Submitted',
            'message' => "{$customer->first_name} {$customer->last_name} submitted proof of downpayment for Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ". Please review and confirm.",
            'icon'    => '💰',
            'type'    => 'payment',
            'url'     => route('baker.orders.show', $order->id),
        ]));
    }

    /**
     * Customer submitted final payment proof — notify baker.
     */
    public static function finalPaymentSubmitted(BakerOrder $order): void
    {
        $baker    = $order->baker;
        $customer = $order->cakeRequest->user;

        $baker->notify(new \App\Notifications\GenericNotification([
            'title'   => '💳 Final Payment Proof Submitted',
            'message' => "{$customer->first_name} {$customer->last_name} submitted final payment proof for Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ". Please confirm to complete the order.",
            'icon'    => '💳',
            'type'    => 'payment',
            'url'     => route('baker.orders.show', $order->id),
        ]));
    }

    /**
     * Baker confirmed downpayment — notify customer.
     */
    public static function downpaymentConfirmed(BakerOrder $order): void
    {
        $customer = $order->cakeRequest->user;

        $customer->notify(new \App\Notifications\GenericNotification([
            'title'   => '✅ Downpayment Confirmed!',
            'message' => "Your downpayment for Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . " has been confirmed. Your baker will start working on your cake!",
            'icon'    => '✅',
            'type'    => 'payment',
            'url'     => route('customer.cake-requests.show', $order->cakeRequest->id),
        ]));
    }

    /**
     * Baker confirmed final payment — notify customer.
     */
    public static function finalPaymentConfirmed(BakerOrder $order): void
    {
        $customer = $order->cakeRequest->user;

        $customer->notify(new \App\Notifications\GenericNotification([
            'title'   => '🎊 Payment Confirmed — Order Complete!',
            'message' => "Your final payment for Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . " has been confirmed. Enjoy your cake!",
            'icon'    => '🎊',
            'type'    => 'success',
            'url'     => route('customer.cake-requests.show', $order->cakeRequest->id),
        ]));
    }

    /**
     * Payment was rejected — notify customer.
     */
    public static function paymentRejected(BakerOrder $order, string $reason = ''): void
    {
        $customer = $order->cakeRequest->user;

        $customer->notify(new \App\Notifications\GenericNotification([
            'title'   => '❌ Payment Proof Rejected',
            'message' => "Your payment proof for Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . " was rejected." . ($reason ? " Reason: {$reason}" : " Please re-upload a valid proof."),
            'icon'    => '❌',
            'type'    => 'error',
            'url'     => route('customer.cake-requests.show', $order->cakeRequest->id),
        ]));
    }

    /**
     * Order status advanced (e.g. IN_PROGRESS, OUT_FOR_DELIVERY) — notify customer.
     */
    public static function orderStatusUpdated(BakerOrder $order, string $newStatus): void
    {
        $customer = $order->cakeRequest->user;

        $statusLabels = [
            'IN_PROGRESS'      => ['label' => 'Your baker has started baking!',          'icon' => '👨‍🍳'],
            'READY'            => ['label' => 'Your cake is ready for pickup/delivery!',  'icon' => '📦'],
            'OUT_FOR_DELIVERY' => ['label' => 'Your cake is on its way!',                'icon' => '🚗'],
            'COMPLETED'        => ['label' => 'Your order has been completed!',           'icon' => '🎉'],
            'CANCELLED'        => ['label' => 'Your order has been cancelled.',           'icon' => '❌'],
        ];

        $info = $statusLabels[$newStatus] ?? ['label' => "Order status updated to {$newStatus}.", 'icon' => '📋'];

        $customer->notify(new \App\Notifications\GenericNotification([
            'title'   => $info['icon'] . ' Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' Update',
            'message' => $info['label'],
            'icon'    => $info['icon'],
            'type'    => $newStatus === 'CANCELLED' ? 'error' : 'order',
            'url'     => route('customer.cake-requests.show', $order->cakeRequest->id),
        ]));
    }

    /**
     * Customer confirmed delivery — notify baker.
     */
    public static function deliveryConfirmed(BakerOrder $order): void
    {
        $baker    = $order->baker;
        $customer = $order->cakeRequest->user;

        $baker->notify(new \App\Notifications\GenericNotification([
            'title'   => '🎉 Delivery Confirmed!',
            'message' => "{$customer->first_name} {$customer->last_name} confirmed delivery of Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ". Great work!",
            'icon'    => '🎉',
            'type'    => 'success',
            'url'     => route('baker.orders.show', $order->id),
        ]));
    }

    /**
     * Customer left a review — notify baker.
     */
    public static function reviewReceived(BakerOrder $order, int $rating): void
    {
        $baker    = $order->baker;
        $customer = $order->cakeRequest->user;
        $stars    = str_repeat('⭐', $rating);

        $baker->notify(new \App\Notifications\GenericNotification([
            'title'   => '⭐ New Review Received!',
            'message' => "{$customer->first_name} {$customer->last_name} gave you {$stars} for Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ".",
            'icon'    => '⭐',
            'type'    => 'success',
            'url'     => route('baker.orders.show', $order->id),
        ]));
    }

    /**
     * A report was submitted against a user — notify admin (optional: notify the reported user).
     */
    public static function reportSubmitted(User $reportedUser, BakerOrder $order): void
    {
        // Notify the reported user
        $reportedUser->notify(new \App\Notifications\GenericNotification([
            'title'   => '⚠️ A Report Was Filed',
            'message' => "A report has been submitted regarding Order #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ". Our admin team will review it shortly.",
            'icon'    => '⚠️',
            'type'    => 'warning',
            'url'     => null,
        ]));
    }
}