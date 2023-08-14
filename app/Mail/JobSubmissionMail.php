<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $submission;

    public function __construct($submission=null)
    {
        $this->submission=$submission;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Job Submission',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.job_submission',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
