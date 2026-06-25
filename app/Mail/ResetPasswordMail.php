<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $token;
    public string $email;
    public string $name;
    public string $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $email, string $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
        $this->resetUrl = config('app.url') . '/reset-password/' . $token . '?email=' . urlencode($email);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your ServerAvatar MCP Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reset-password',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'url' => $this->resetUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
