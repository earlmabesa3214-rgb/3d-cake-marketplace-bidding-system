<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification
{
    public function __construct(public $order) {}

    public function via($notifiable): array { return ['database']; }

    public function toArray($notifiable): array
    {
        return [
            'icon'    => '💰',
            'type'    => 'payment',
            'title'   => 'Payment Proof Submitted',
            'message' => "Customer submitted payment proof for order #" . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ". Please review and confirm.",
            'url'     => route('baker.orders.show', $this->order->id),
        ];
    }
}