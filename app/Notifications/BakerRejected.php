<?php

namespace App\Notifications;

use App\Models\Baker;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BakerRejected extends Notification
{
    
    public function __construct(
        public Baker $baker,
        public string $reason = ''
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Update on Your BakeSphere Baker Application')
            ->greeting('Hello, ' . $this->baker->name . '.')
            ->line('Thank you for applying to become a baker on BakeSphere.')
            ->line('After reviewing your application for **' . $this->baker->shop_name . '**, we were unable to approve it at this time.');

        if (!empty($this->reason)) {
            $mail->line('**Reason:** ' . $this->reason);
        }
 
     return (new MailMessage)
        ->subject('Update on Your BakeSphere Baker Application')
        ->view('emails.baker-rejected', [
            'bakerName'  => $this->baker->user->first_name ?? $this->baker->name,
            'shopName'   => $this->baker->shop_name,
            'reason'     => $this->reason,
            'supportUrl' => url('/'),
        ]);
}

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => 'baker_rejected',
            'title'   => 'Application Not Approved',
            'message' => 'Your baker application for ' . $this->baker->shop_name . ' was not approved. Please contact support for more information.',
        ];
    }
}