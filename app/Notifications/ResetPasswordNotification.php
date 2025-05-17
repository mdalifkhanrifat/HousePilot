<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
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
        // $resetUrl = "{$frontendUrl}/reset-password?token={$this->token}&email={$notifiable->email}";
        // return (new MailMessage)
        //     ->subject('Reset Your HousePilot Password')
        //     ->line('We received a request to reset your password.')
        //     ->line("🔐 **Your OTP is: {$this->otp}** (valid for 10 minutes)")
        //     ->action('Reset Password via Link', $resetUrl)
        //     ->line('You can reset your password using either the OTP or the link above.')
        //     ->line('If you did not request this, you can safely ignore this email.');

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
