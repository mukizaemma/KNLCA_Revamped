<?php

namespace App\Livewire\Frontend;

use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\PageHeader;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
    #[Layout('layouts.frontend')]

    public string $first_name = '';
    public string $last_name = '';
    public string $phone = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';
    public string $submission_channel = '';

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
            'submission_channel' => ['required', 'in:whatsapp,email'],
        ];
    }

    public function submit(string $channel): void
    {
        $this->submission_channel = $channel;

        $this->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
            'submission_channel' => ['required', 'in:whatsapp,email'],
        ], [
            'submission_channel.required' => 'Please choose WhatsApp or Email to submit your message.',
        ]);

        if ($this->submission_channel === 'whatsapp') {
            if (strlen(preg_replace('/[^0-9]/', '', $this->phone)) < 9) {
                $this->addError('submission_channel', 'Please enter a valid WhatsApp phone number.');

                return;
            }
        }

        ContactMessage::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone ?: null,
            'email' => $this->email,
            'subject' => $this->subject ?: null,
            'message' => $this->message,
            'submission_channel' => $this->submission_channel,
        ]);

        $settings = WebsiteSetting::first();

        if ($this->submission_channel === 'email') {
            $adminEmail = $settings?->email;

            if ($adminEmail) {
                Mail::to($adminEmail)->send(new ContactFormSubmitted(
                    first_name: $this->first_name,
                    last_name: $this->last_name,
                    email: $this->email,
                    phone: $this->phone ?: null,
                    subject: $this->subject ?: null,
                    message: $this->message,
                ));
            }

            Mail::to($this->email)->send(new ContactFormConfirmation(
                first_name: $this->first_name,
                email: $this->email,
                message: $this->message,
            ));

            session()->flash('contact_success', 'Thank you! Your message has been sent. We will get back to you soon.');
            $this->reset('first_name', 'last_name', 'phone', 'email', 'subject', 'message', 'submission_channel');

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Message sent',
                'text' => 'Thank you for contacting us. We will get back to you soon.',
            ]);

            return;
        }

        $waNumber = preg_replace('/[^0-9]/', '', $settings->phone_whatsapp ?? $settings->phone_reception ?? '');
        if (! $waNumber) {
            $this->addError('submission_channel', 'WhatsApp is temporarily unavailable. Please choose Email or contact the school.');

            return;
        }

        $school = $settings?->company_name ?? config('app.name');
        $waMessage = "Hello {$school},\n\n"
            ."I am sending an enquiry via your website.\n\n"
            ."Name: {$this->first_name} {$this->last_name}\n"
            ."Email: {$this->email}\n"
            .'Phone: '.($this->phone ?: '—')."\n"
            .'Subject: '.($this->subject ?: 'General enquiry')."\n\n"
            ."Message:\n{$this->message}\n";

        $waUrl = 'https://wa.me/'.$waNumber.'?text='.rawurlencode($waMessage);

        $this->reset('first_name', 'last_name', 'phone', 'email', 'subject', 'message', 'submission_channel');
        $this->redirect($waUrl, navigate: false);
    }

    public function render()
    {
        $header = PageHeader::where('page_key', 'contact')->first();
        $settings = WebsiteSetting::first();

        return view('livewire.frontend.contact', [
            'header' => $header,
            'settings' => $settings,
        ]);
    }
}
