<?php
namespace App\Notifications;

use App\Models\CakeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RushOrderAvailableNotification extends Notification
{
    use Queueable;

    public function __construct(
        public CakeRequest $cakeRequest,
        public float $distanceKm
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title'   => '⚡ Rush order ' . $this->distanceKm . 'km away!',
            'message' => 'A customer needs a cake urgently. First baker to accept gets the order.',
            'url'     => route('baker.requests.show', $this->cakeRequest->id),
        ];
    }
}