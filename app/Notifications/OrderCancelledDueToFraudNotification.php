<?php

namespace App\Notifications;

use App\Models\BakerOrder;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderCancelledDueToFraudNotification extends Notification
{
    use Queueable;

    public function __construct(
        public BakerOrder $order,
        public Payment    $payment,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $orderNum = str_pad($this->order->id, 4, '0', STR_PAD_LEFT);

        return (new MailMessage)
            ->subject("🚫 Order #$orderNum Cancelled — Repeated Payment Rejection")
            ->greeting("Hello {$notifiable->first_name},")
            ->line("Your Order **#$orderNum** has been **automatically cancelled**.")
            ->line('Your payment proof was rejected twice by your baker due to suspicious or invalid receipts.')
            ->line('If you believe this is an error, please contact support.')
            ->action('Contact Support', url('/support'))
            ->line('We apologize for any inconvenience.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'     => 'order_cancelled_fraud',
            'order_id' => $this->order->id,
            'message'  => 'Your order was cancelled due to repeated invalid payment proofs.',
        ];
    }
}