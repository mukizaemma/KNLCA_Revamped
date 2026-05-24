<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolVisitRequested extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $visitor_name,
        public string $visitor_email,
        public ?string $visitor_phone,
        public string $reason,
        public string $visit_datetime,
        public ?string $what_to_see,
        public bool $has_student,
        public ?string $student_name,
        public ?string $student_grade,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New School Visit Request - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.school-visit-requested',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

