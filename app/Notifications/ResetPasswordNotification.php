<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct($token, $otp)
    {
        $this->token = $token;
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // $frontendUrl = config('app.frontend_url', 'http://localhost:5173');

        return (new MailMessage)
            ->subject('Reset Password Request')
            ->line("Your OTP is: {$this->otp}")
            ->line("Or you can reset your password using the following link:")
            ->action('Reset Password', url(config('app.frontend_url') . '/reset-password?token=' . $this->token))
            ->line('This OTP will expire in 10 minutes.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
