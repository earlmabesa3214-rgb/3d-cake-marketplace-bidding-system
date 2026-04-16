<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CakeRequestStatusNotification extends Notification
{
    public function __construct(
        public string $message,
        public int    $cakeRequestId,
        public string $status
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message'         => $this->message,
            'cake_request_id' => $this->cakeRequestId,
            'status'          => $this->status,
        ];
    }
}