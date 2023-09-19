<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    
    public function __construct($user)
    {
        $this->user=$user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Verification Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.verification_email',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
