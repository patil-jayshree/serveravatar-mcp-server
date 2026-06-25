<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;

class ResetPasswordMail extends Notifiable
{
    use Queueable;

    protected string $token;
    protected string $email;

    /**
     * Create a new message instance.
     */
    public function __construct(string $email, string $token)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        $resetUrl = url(config('app.url') . '/reset-password/' . $this->token . '?email=' . urlencode($this->email));

        return $this
            ->subject('Reset Your ServerAvatar MCP Password')
            ->markdown('emails.reset-password', [
                'url' => $resetUrl,
                'email' => $this->email,
            ]);
    }

    /**
     * Get the notifications for the mail.
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
        $resetUrl = url(config('app.url') . '/reset-password/' . $this->token . '?email=' . urlencode($this->notifiable->email));

        return (new MailMessage)
            ->subject('Reset Your ServerAvatar MCP Password')
            ->markdown('emails.reset-password', [
                'url' => $resetUrl,
                'email' => $this->notifiable->email,
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
            'email' => $this->email,
        ];
    }
}
