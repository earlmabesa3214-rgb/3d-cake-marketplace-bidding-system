<?php

namespace App\Notifications;

use App\Models\Baker;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BakerApproved extends Notification
{


    public function __construct(public Baker $baker) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
     return (new MailMessage)
        ->subject('🎉 Your BakeSphere Baker Application is Approved!')
        ->view('emails.baker-approved', [
            'bakerName' => $this->baker->user->first_name ?? $this->baker->name,
            'shopName'  => $this->baker->shop_name,
            'loginUrl'  => route('login'),
        ]);
}
    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => 'baker_approved',
            'title'   => 'Application Approved!',
            'message' => 'Your baker application for ' . $this->baker->shop_name . ' has been approved. You can now start bidding on orders.',
        ];
    }
}