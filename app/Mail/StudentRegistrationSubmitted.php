<?php

namespace App\Mail;

use App\Models\StudentRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentRegistrationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public StudentRegistration $registration
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New student registration – ' . $this->registration->student_full_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student-registration-submitted',
        );
    }
}
