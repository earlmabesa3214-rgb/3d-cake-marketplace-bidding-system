<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    public function __construct(public string $status) {}

    public function via($notifiable): array { return ['database']; }

    public function toArray($notifiable): array
    {
        if ($this->status === 'approved') {
            return [
                'icon'    => '✅',
                'type'    => 'success',
                'title'   => 'Application Approved!',
                'message' => 'Congratulations! Your baker application has been approved. You can now start bidding on cake requests.',
                'url'     => route('baker.dashboard'),
            ];
        }

        return [
            'icon'    => '❌',
            'type'    => 'error',
            'title'   => 'Application Rejected',
            'message' => 'Unfortunately, your baker application was not approved. Please contact support for more information.',
            'url'     => route('login'),
        ];
    }
}