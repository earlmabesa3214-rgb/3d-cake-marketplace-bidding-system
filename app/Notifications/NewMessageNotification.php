<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    public function __construct(public $message, public $order) {}

    public function via($notifiable): array { return ['database']; }

    public function toArray($notifiable): array
    {
        return [
            'icon'    => '💬',
            'type'    => 'info',
            'title'   => 'New Message',
            'message' => 'You have a new message on order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . '.',
            'url'     => route('baker.orders.show', $this->order->id),
        ];
    }
}