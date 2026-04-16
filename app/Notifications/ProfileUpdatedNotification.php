<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ProfileUpdatedNotification extends Notification
{
    public function __construct(public string $message) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'icon'    => '✏️',
            'type'    => 'info',
            'title'   => 'Profile Updated',
            'message' => $this->message,
            'url'     => route('baker.profile.index'),
        ];
    }
}