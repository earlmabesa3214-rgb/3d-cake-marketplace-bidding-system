<?php

namespace App\Notifications;

use App\Models\BakerOrder;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentRejectedNotification extends Notification
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
        $reason   = $this->payment->rejection_reason_label;

        return (new MailMessage)
            ->subject("⚠️ Payment Proof Rejected — Order #$orderNum")
            ->greeting("Hello {$notifiable->first_name},")
            ->line("Your payment proof for Order **#$orderNum** was rejected by your baker.")
            ->line("**Reason:** $reason")
            ->when($this->payment->rejection_note, fn ($m) =>
                $m->line("**Baker's note:** {$this->payment->rejection_note}")
            )
            ->line('Please upload a valid payment receipt to continue.')
            ->action('Upload New Proof', route('customer.cake-requests.show', $this->order->cake_request_id))
            ->line('⚠️ **Warning:** A second rejection will automatically cancel your order.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'payment_rejected',
            'order_id'   => $this->order->id,
            'reason'     => $this->payment->rejection_reason,
            'note'       => $this->payment->rejection_note,
            'message'    => 'Your payment proof was rejected. Please re-upload a valid receipt.',
        ];
    }
}