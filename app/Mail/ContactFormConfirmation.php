<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $first_name,
        public string $email,
        public string $message,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We Received Your Message - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
