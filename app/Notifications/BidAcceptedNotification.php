<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;

class BidAcceptedNotification extends Notification
{
    public function __construct(public $bid, public $cakeRequest) {}

    public function via($notifiable): array { return ['database']; }

    public function toArray($notifiable): array
    {
        return [
            'icon'    => '🎉',
            'type'    => 'success',
            'title'   => 'Bid Accepted!',
            'message' => "Your bid of ₱" . number_format($this->bid->amount, 0) . " was accepted for request #" . str_pad($this->cakeRequest->id, 4, '0', STR_PAD_LEFT) . ".",
            'url'     => route('baker.orders.index'),
        ];
    }
}