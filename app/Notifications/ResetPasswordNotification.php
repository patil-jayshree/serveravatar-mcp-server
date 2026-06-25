<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     */
    public string $token;

    /**
     * The callback that should be used to generate the reset password URL.
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message of the notification.
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $resetUrl = $this->resetUrl($notifiable);

        return $this->buildMailMessage($notifiable, $resetUrl);
    }

    /**
     * Get the reset password notification mail message for the given notifiable.
     */
    protected function buildMailMessage(object $notifiable, string $url): MailMessage
    {
        return (new MailMessage)
            ->subject('Reset Your ServerAvatar MCP Password')
            ->markdown('emails.reset-password', [
                'url' => $url,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);
    }

    /**
     * Get the reset URL for the given notifiable.
     */
    protected function resetUrl(object $notifiable): string
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }

    /**
     * Set a callback that should be used to create the reset password URL.
     */
    public static function createUrlUsing(callable $callback): void
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used to build the mail message.
     """
    public static function toMailUsing(callable $callback): void
    {
        static::$toMailCallback = $callback;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
