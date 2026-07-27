<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ChangeEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $newEmail,
        public string $token
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your New Email Address',
        );
    }

    public function content(): Content
    {
        $appUrl = rtrim(config('app.url'), '/');
        $confirmUrl = $appUrl . '/email/change/' . $this->token;

        return new Content(
            markdown: 'emails.change-email',
            with: [
                'user' => $this->user,
                'newEmail' => $this->newEmail,
                'confirmUrl' => $confirmUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
