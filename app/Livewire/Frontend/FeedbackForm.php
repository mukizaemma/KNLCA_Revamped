<?php

namespace App\Livewire\Frontend;

use App\Models\ClinicalDepartment;
use App\Models\CustomerFeedback;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class FeedbackForm extends Component
{
    #[Layout('layouts.frontend')]
    public string $full_name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public ?int $rating_out_of_10 = null;
    public string $rating_category = 'overall';
    public bool $wants_response = false;
    public string $preferred_contact_method = 'none';

    protected function rules(): array
    {
        return [
            'full_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'min:10'],
            'rating_out_of_10' => ['nullable', 'integer', 'min:1', 'max:10'],
            'rating_category' => ['nullable', 'string', 'in:overall,department,service,restaurant,facility,staff,other'],
            'wants_response' => ['boolean'],
            'preferred_contact_method' => ['nullable', 'string', 'in:none,email,phone,either'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        CustomerFeedback::create([
            'full_name' => $this->full_name ?: null,
            'email' => $this->email ?: null,
            'phone' => $this->phone ?: null,
            'message' => $this->message,
            'rating_out_of_10' => $this->rating_out_of_10,
            'rating_category' => $this->rating_category,
            'wants_response' => $this->wants_response,
            'preferred_contact_method' => $this->wants_response ? $this->preferred_contact_method : 'none',
            'feedback_date' => now(),
        ]);

        session()->flash('feedback_success', 'Thank you. Your feedback has been submitted.');
        $this->reset('full_name', 'email', 'phone', 'message', 'rating_out_of_10', 'wants_response', 'preferred_contact_method');
    }

    public function render()
    {
        $header = PageHeader::where('page_key', 'feedback')->first();
        return view('livewire.frontend.feedback-form', ['header' => $header]);
    }
}
