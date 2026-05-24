<?php

namespace App\Livewire\Frontend\About;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Inquire extends Component
{
    use LoadsPageHeader;

    public string $inquiry_first_name = '';
    public string $inquiry_last_name = '';
    public string $inquiry_email = '';
    public string $inquiry_phone = '';
    public string $inquiry_type = '';
    public string $visit_date = '';
    public string $visit_time = '';
    public string $inquiry_message = '';

    public bool $inquirySubmitted = false;

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.frontend.about.inquire', [
            'header' => $this->pageHeader('about_inquire', 'contact'),
        ]);
    }

    public function submitInquiry(): void
    {
        $rules = [
            'inquiry_first_name' => ['required', 'string', 'max:100'],
            'inquiry_last_name' => ['required', 'string', 'max:100'],
            'inquiry_email' => ['required', 'email', 'max:255'],
            'inquiry_phone' => ['required', 'string', 'max:50'],
            'inquiry_type' => ['required', 'in:general,visit_school,admission,partnership'],
            'inquiry_message' => ['required', 'string', 'min:10'],
        ];

        if ($this->inquiry_type === 'visit_school') {
            $rules['visit_date'] = ['required', 'date', 'after_or_equal:today'];
            $rules['visit_time'] = ['required', 'date_format:H:i'];
        }

        $this->validate($rules, [
            'inquiry_type.required' => 'Please select the reason for your message.',
            'visit_date.required' => 'Please choose a preferred visit date.',
            'visit_time.required' => 'Please choose a preferred visit time.',
        ]);

        $typeLabels = [
            'general' => 'General enquiry',
            'visit_school' => 'Schedule a school visit',
            'admission' => 'Admissions enquiry',
            'partnership' => 'Partnership',
        ];

        $subject = $typeLabels[$this->inquiry_type] ?? 'About page enquiry';

        ContactMessage::create([
            'first_name' => $this->inquiry_first_name,
            'last_name' => $this->inquiry_last_name,
            'email' => $this->inquiry_email,
            'phone' => $this->inquiry_phone,
            'subject' => $subject,
            'inquiry_type' => $this->inquiry_type,
            'visit_date' => $this->inquiry_type === 'visit_school' ? $this->visit_date : null,
            'visit_time' => $this->inquiry_type === 'visit_school' ? $this->visit_time : null,
            'message' => $this->inquiry_message,
        ]);

        $settings = WebsiteSetting::first();
        if ($settings?->email) {
            Mail::to($settings->email)->send(new ContactFormSubmitted(
                first_name: $this->inquiry_first_name,
                last_name: $this->inquiry_last_name,
                email: $this->inquiry_email,
                phone: $this->inquiry_phone,
                subject: $subject,
                message: $this->inquiry_message,
            ));
        }

        $this->reset([
            'inquiry_first_name', 'inquiry_last_name', 'inquiry_email', 'inquiry_phone',
            'inquiry_type', 'visit_date', 'visit_time', 'inquiry_message',
        ]);
        $this->inquirySubmitted = true;

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Message sent',
            'text' => 'Thank you. We will respond to you soon.',
        ]);
    }
}
