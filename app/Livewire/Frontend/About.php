<?php

namespace App\Livewire\Frontend;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\LeadershipTeamMember;
use App\Models\WebsiteSetting;
use App\Support\SiteContent;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class About extends Component
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

    public string $submission_channel = '';

    public bool $inquirySubmitted = false;

    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();

        $valueCards = [];
        if ($settings?->about_value_cards) {
            $valueCards = is_array($settings->about_value_cards)
                ? $settings->about_value_cards
                : json_decode($settings->about_value_cards, true);
            $valueCards = is_array($valueCards)
                ? array_values(array_filter($valueCards, fn ($c) => ! empty($c['name'] ?? null)))
                : [];
        }

        if (empty($valueCards)) {
            $fromContent = SiteContent::get($settings, 'about.core_value_cards', []);
            $valueCards = is_array($fromContent)
                ? array_values(array_filter($fromContent, fn ($c) => ! empty($c['name'] ?? null)))
                : [];
        }

        $affiliateSchools = [];
        if ($settings?->affiliate_schools) {
            $affiliateSchools = is_string($settings->affiliate_schools)
                ? json_decode($settings->affiliate_schools, true)
                : $settings->affiliate_schools;
            $affiliateSchools = is_array($affiliateSchools)
                ? array_values(array_filter($affiliateSchools, fn ($s) => ! empty($s['name'] ?? null)))
                : [];
        }

        return view('livewire.frontend.about.overview', [
            'header' => $this->pageHeader('about'),
            'settings' => $settings,
            'valueCards' => $valueCards,
            'affiliateSchools' => $affiliateSchools,
            'staff' => LeadershipTeamMember::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function submitInquiry(string $channel): void
    {
        $this->submission_channel = $channel;

        $rules = [
            'inquiry_first_name' => ['required', 'string', 'max:100'],
            'inquiry_last_name' => ['required', 'string', 'max:100'],
            'inquiry_email' => ['required', 'email', 'max:255'],
            'inquiry_phone' => ['required', 'string', 'max:50'],
            'inquiry_type' => ['required', 'in:general,visit_school,admission,partnership'],
            'inquiry_message' => ['required', 'string', 'min:10'],
            'submission_channel' => ['required', 'in:whatsapp,email'],
        ];

        if ($this->inquiry_type === 'visit_school') {
            $rules['visit_date'] = ['required', 'date', 'after_or_equal:today'];
            $rules['visit_time'] = ['required', 'date_format:H:i'];
        }

        $this->validate($rules, [
            'inquiry_type.required' => 'Please select the reason for your message.',
            'visit_date.required' => 'Please choose a preferred visit date.',
            'visit_time.required' => 'Please choose a preferred visit time.',
            'submission_channel.required' => 'Please choose WhatsApp or Email to submit your message.',
        ]);

        if ($this->submission_channel === 'whatsapp'
            && strlen(preg_replace('/[^0-9]/', '', $this->inquiry_phone)) < 9) {
            $this->addError('submission_channel', 'Please enter a valid WhatsApp phone number.');

            return;
        }

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
            'submission_channel' => $this->submission_channel,
        ]);

        $settings = WebsiteSetting::first();

        if ($this->submission_channel === 'email') {
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
                'inquiry_type', 'visit_date', 'visit_time', 'inquiry_message', 'submission_channel',
            ]);
            $this->inquirySubmitted = true;

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Message sent',
                'text' => 'Thank you. We will respond to you soon.',
            ]);

            return;
        }

        $waNumber = preg_replace('/[^0-9]/', '', $settings->phone_whatsapp ?? $settings->phone_reception ?? '');
        if (! $waNumber) {
            $this->addError('submission_channel', 'WhatsApp is temporarily unavailable. Please choose Email or contact the school.');

            return;
        }

        $school = $settings?->company_name ?? config('app.name');
        $visitExtra = '';
        if ($this->inquiry_type === 'visit_school') {
            $visitExtra = "Preferred visit: {$this->visit_date} at {$this->visit_time}\n";
        }

        $waMessage = "Hello {$school},\n\n"
            ."I am sending an enquiry via your website.\n\n"
            ."Name: {$this->inquiry_first_name} {$this->inquiry_last_name}\n"
            ."Email: {$this->inquiry_email}\n"
            ."Phone: {$this->inquiry_phone}\n"
            ."Reason: {$subject}\n"
            .$visitExtra
            ."\nMessage:\n{$this->inquiry_message}\n";

        $waUrl = 'https://wa.me/'.$waNumber.'?text='.rawurlencode($waMessage);

        $this->reset([
            'inquiry_first_name', 'inquiry_last_name', 'inquiry_email', 'inquiry_phone',
            'inquiry_type', 'visit_date', 'visit_time', 'inquiry_message', 'submission_channel',
        ]);

        $this->redirect($waUrl, navigate: false);
    }
}
