<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Notification for sending OTP and password reset link via email.
 */
class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    protected $token;

    /**
     * The One Time Password (OTP).
     *
     * @var string
     */
    protected $otp;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     * @param  string  $otp
     * @return void
     */
    public function __construct($token, $otp)
    {
        $this->token = $token;
        $this->otp = $otp;

        // Set the queue connection (you can change it to 'redis' or others if needed)
        $this->connection = 'database';
    }

    /**
     * Get the notification's delivery channels.
     *
     * This tells Laravel to send the notification via mail.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * This builds the actual email content that the user will receive.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        // return (new MailMessage)
        //     ->subject('Reset Password Request')
        //     ->line("Your OTP is: {$this->otp}")
        //     ->line("Or you can reset your password using the following link:")
        //     ->action('Reset Password', url(config('app.frontend_url') . '/reset-password?token=' . $this->token))
        //     ->line('This OTP will expire in 10 minutes.');

        return (new MailMessage)
        ->view('emails.reset-password', [
            'otp' => $this->otp,
            'token' => $this->token,
            'notifiable' => $notifiable,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * This can be used if you want to store notifications in the database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
