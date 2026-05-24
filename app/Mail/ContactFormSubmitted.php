<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public ?string $phone,
        public ?string $subject,
        public string $message,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Form Submission - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-submitted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
