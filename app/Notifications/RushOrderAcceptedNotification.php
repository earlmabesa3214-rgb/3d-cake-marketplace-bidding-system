<?php
namespace App\Notifications;

use App\Models\Baker;
use App\Models\CakeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RushOrderAcceptedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public CakeRequest $cakeRequest,
        public Baker $baker,
        public float $agreedPrice
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title'   => '⚡ Baker found for your rush order!',
            'message' => $this->baker->user->first_name . ' accepted your rush order. Pay your downpayment to begin.',
            'url'     => route('customer.cake-requests.show', $this->cakeRequest->id),
            'price'   => $this->agreedPrice,
        ];
    }
}