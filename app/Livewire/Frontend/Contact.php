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

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $settings = WebsiteSetting::first();
        $adminEmail = $settings?->email;

        // Store in database
        ContactMessage::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone ?: null,
            'email' => $this->email,
            'subject' => $this->subject ?: null,
            'message' => $this->message,
        ]);

        // Send to admin
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

        // Send copy to user
        Mail::to($this->email)->send(new ContactFormConfirmation(
            first_name: $this->first_name,
            email: $this->email,
            message: $this->message,
        ));

        session()->flash('contact_success', 'Thank you! Your message has been sent. We will get back to you soon.');
        $this->reset('first_name', 'last_name', 'phone', 'email', 'subject', 'message');

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Message sent',
            'text' => 'Thank you for contacting us. We will get back to you soon.',
        ]);
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
