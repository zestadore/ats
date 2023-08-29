<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;

    public function __construct($invoice=null)
    {
        $this->invoice=$invoice;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'View Your Invoice',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.invoice_mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
