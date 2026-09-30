<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            $minutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
            $name    = $notifiable->first_name ?? null;

            return (new MailMessage)
                ->subject('Reset your BakeSphere password')
                ->greeting($name ? "Hello, {$name}." : 'Hello.')
                ->line('We received a request to reset the password for your BakeSphere account.')
                ->action('Reset password', $url)
                ->line("This link expires in {$minutes} minutes.")
                ->line('If you did not request this, you can safely ignore this email. Your password will stay the same.')
                ->salutation("With care,\nThe BakeSphere team");
        });
    }
}