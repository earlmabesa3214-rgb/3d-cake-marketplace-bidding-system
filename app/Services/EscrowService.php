<?php

namespace App\Services;

use App\Models\BakerOrder;
use App\Models\EscrowHold;
use App\Models\Wallet;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class EscrowService
{
    const PLATFORM_FEE_RATE = 0.05; // 5%

    /**
     * Single full-payment hold. Applies to both delivery and pickup orders.
     * Delivery fee (if any) is charged in full alongside the cake price.
     */
    public function holdFullPayment(BakerOrder $order): EscrowHold
    {
        $amount         = round($order->agreed_price, 2) + (float) ($order->delivery_fee ?? 0);
        $customerWallet = Wallet::forUser($order->cakeRequest->user_id);
        $bakerWallet    = Wallet::forUser($order->baker_id);
        $fee            = round($amount * self::PLATFORM_FEE_RATE, 2);
        $bakerPayout    = $amount - $fee;

        if (!$customerWallet->hasEnough($amount)) {
            throw new \Exception('insufficient_balance');
        }

        return DB::transaction(function () use ($order, $amount, $customerWallet, $bakerWallet, $fee, $bakerPayout) {

            $customerWallet->holdForEscrow(
                $amount,
                $order->id,
                "Payment for Order #{$order->id}"
            );

            $hold = EscrowHold::create([
                'customer_wallet_id'  => $customerWallet->id,
                'baker_wallet_id'     => $bakerWallet->id,
                'order_id'            => $order->id,
                'payment_type'        => 'full',
                'amount'              => $amount,
                'platform_fee_rate'   => self::PLATFORM_FEE_RATE,
                'platform_fee_amount' => $fee,
                'baker_payout_amount' => $bakerPayout,
                'status'              => 'held',
                'held_at'             => now(),
            ]);

            Payment::updateOrCreate(
                ['cake_request_id' => $order->cake_request_id, 'payment_type' => 'full'],
                [
                    'bid_id'         => $order->bid_id,
                    'customer_id'    => $order->cakeRequest->user_id,
                    'payment_method' => 'wallet',
                    'status'         => 'confirmed',
                    'escrow_status'  => 'held',
                    'agreed_price'   => $order->agreed_price,
                    'amount'         => $amount,
                    'paid_at'        => now(),
                    'confirmed_at'   => now(),
                    'held_at'        => now(),
                ]
            );

            $order->update(['status' => 'PREPARING']);
            $order->cakeRequest->update(['status' => 'IN_PROGRESS']);

            try {
                $order->baker->notify(
                    new \App\Notifications\OrderStatusChangedNotification($order, 'paid')
                );
            } catch (\Exception $e) {
                // Notification failed — don't block the transaction
            }

            return $hold;
        });
    }

    /**
     * Customer clicks "Cake Received" (delivery) or baker clicks "Confirm Handover" (pickup).
     * Releases the escrow hold to the baker wallet and completes the order.
     */
    public function releaseToBaker(BakerOrder $order): void
    {
        DB::transaction(function () use ($order) {

            $holds = EscrowHold::where('order_id', $order->id)
                ->where('status', 'held')
                ->get();

            $totalBakerPayout = 0;

            foreach ($holds as $hold) {
                $bakerWallet = Wallet::forUser($order->baker_id);

                $bakerWallet->credit(
                    $hold->baker_payout_amount,
                    'escrow_release',
                    "Payment release for Order #{$order->id}",
                    $order->id
                );

                $hold->update([
                    'status'      => 'released',
                    'released_at' => now(),
                ]);

                Payment::where('cake_request_id', $order->cake_request_id)
                    ->where('payment_type', $hold->payment_type)
                    ->update([
                        'escrow_status' => 'released',
                        'released_at'   => now(),
                    ]);

                $totalBakerPayout += $hold->baker_payout_amount;
            }

            $order->update([
                'status'             => 'COMPLETED',
                'payout_status'      => 'RELEASED',
                'baker_payout'       => $totalBakerPayout,
                'platform_fee'       => $order->agreed_price - $totalBakerPayout,
                'payout_released_at' => now(),
                'completed_at'       => now(),
            ]);

            $order->cakeRequest->update(['status' => 'COMPLETED']);

            try {
                $order->baker->notify(
                    new \App\Notifications\OrderStatusChangedNotification($order, 'completed')
                );
            } catch (\Exception $e) {
                // Notification failed — don't block the transaction
            }
        });
    }

    /**
     * Cancellation: forfeit the full payment to the baker if already paid (no refund).
     * Kept payment_type-agnostic so it still works cleanly against a single 'full' hold.
     */
    public function handleCancellation(BakerOrder $order, string $cancelledBy = 'customer'): void
    {
        DB::transaction(function () use ($order, $cancelledBy) {

            $holds = EscrowHold::where('order_id', $order->id)
                ->where('status', 'held')
                ->get();

            foreach ($holds as $hold) {
                if ($cancelledBy === 'customer') {
                    // No refund — forfeit full payment to baker
                    $bakerWallet = Wallet::forUser($order->baker_id);
                    $bakerWallet->credit(
                        $hold->baker_payout_amount,
                        'escrow_release',
                        "Forfeited payment — Order #{$order->id} cancelled by customer",
                        $order->id
                    );
                    $hold->update(['status' => 'forfeited', 'released_at' => now()]);
                } else {
                    // Refund to customer (admin cancel or pre-payment cancel)
                    $customerWallet = Wallet::forUser($order->cakeRequest->user_id);
                    $customerWallet->credit(
                        $hold->amount,
                        'escrow_refund',
                        "Refund for cancelled Order #{$order->id}",
                        $order->id
                    );
                    $hold->update(['status' => 'refunded', 'refunded_at' => now()]);
                }
            }
        });
    }
}