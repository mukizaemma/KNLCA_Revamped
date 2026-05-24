<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolVisitConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $visitor_name,
        public string $visitor_email,
        public string $visit_datetime,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your School Visit Request - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.school-visit-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

