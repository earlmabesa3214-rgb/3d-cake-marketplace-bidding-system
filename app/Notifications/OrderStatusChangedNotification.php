<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    public function __construct(public $order, public string $status) {}

    public function via($notifiable): array { return ['database']; }

    public function toArray($notifiable): array
    {
        $messages = [
            'pending_payment' => ['icon' => '💳', 'type' => 'payment', 'msg' => 'Customer is ready to pay for order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . '.'],
            'paid'            => ['icon' => '✅', 'type' => 'success', 'msg' => 'Payment confirmed for order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . '. Start baking!'],
            'baking'          => ['icon' => '🎂', 'type' => 'order',   'msg' => 'Order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ' is now marked as baking.'],
            'ready'           => ['icon' => '📦', 'type' => 'order',   'msg' => 'Order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ' is ready for delivery.'],
            'delivered'       => ['icon' => '🚚', 'type' => 'success', 'msg' => 'Order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ' has been delivered.'],
            'completed'       => ['icon' => '⭐', 'type' => 'success', 'msg' => 'Order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ' is completed! Check your earnings.'],
            'cancelled'       => ['icon' => '❌', 'type' => 'error',   'msg' => 'Order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ' was cancelled.'],
        ];

        $info = $messages[$this->status] ?? ['icon' => '📋', 'type' => 'order', 'msg' => 'Order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ' status updated to ' . $this->status . '.'];

        return [
            'icon'    => $info['icon'],
            'type'    => $info['type'],
            'title'   => 'Order Update',
            'message' => $info['msg'],
            'url'     => route('baker.orders.show', $this->order->id),
        ];
    }
}