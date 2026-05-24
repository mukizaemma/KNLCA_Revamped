<?php

namespace App\Livewire\Frontend;

use App\Mail\StudentRegistrationSubmitted;
use App\Models\PageHeader;
use App\Models\StudentRegistration;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session as SessionState;
use Livewire\Component;
use Livewire\WithFileUploads;

class Appointment extends Component
{
    use WithFileUploads;

    private const DRAFT_PREFIX = 'registration_draft.';

    #[SessionState(key: 'registration_draft.step')]
    public int $step = 1;

    #[SessionState(key: 'registration_draft.student_first_name')]
    public string $student_first_name = '';

    #[SessionState(key: 'registration_draft.student_last_name')]
    public string $student_last_name = '';

    #[SessionState(key: 'registration_draft.academic_level')]
    public string $academic_level = '';

    #[SessionState(key: 'registration_draft.date_of_birth')]
    public string $date_of_birth = '';

    /** @var 'mother'|'father'|'guardian' */
    #[SessionState(key: 'registration_draft.contact_relationship')]
    public string $contact_relationship = 'mother';

    #[SessionState(key: 'registration_draft.contact_full_name')]
    public string $contact_full_name = '';

    #[SessionState(key: 'registration_draft.contact_email')]
    public string $contact_email = '';

    #[SessionState(key: 'registration_draft.contact_phone')]
    public string $contact_phone = '';

    public string $submission_channel = '';

    #[SessionState(key: 'registration_draft.previous_school_name')]
    public string $previous_school_name = '';

    public $previous_school_report;

    #[SessionState(key: 'registration_draft.previous_school_report_filename')]
    public string $previous_school_report_filename = '';

    #[SessionState(key: 'registration_draft.from_other_school')]
    public bool $from_other_school = false;

    public bool $submitted = false;

    public function updatedPreviousSchoolReport(): void
    {
        $this->previous_school_report_filename = $this->previous_school_report
            ? $this->previous_school_report->getClientOriginalName()
            : '';
    }

    public function updatedFromOtherSchool(mixed $value): void
    {
        $this->from_other_school = filter_var($value, FILTER_VALIDATE_BOOLEAN) || $value === 1 || $value === '1';
    }

    /** @return array<int, string> */
    public function getStepsProperty(): array
    {
        return [
            1 => 'Student details',
            2 => 'Previous school',
            3 => 'Contact details',
            4 => 'Review & submit',
        ];
    }

    #[Layout('layouts.frontend')]
    public function render()
    {
        $header = PageHeader::where('page_key', 'register')->first()
            ?? PageHeader::where('page_key', 'admissions')->first();

        return view('livewire.frontend.appointment', [
            'header' => $header,
            'settings' => WebsiteSetting::first(),
            'steps' => $this->steps,
        ]);
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step));

        if ($this->step < 4) {
            $this->step++;
            $this->dispatch('registration-step-changed');
        }
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
            $this->dispatch('registration-step-changed');
        }
    }

    public function goToStep(int $step): void
    {
        if ($step < 1 || $step > 4 || $step >= $this->step) {
            return;
        }

        $this->step = $step;
        $this->dispatch('registration-step-changed');
    }

    public function submit(string $channel): void
    {
        $this->submission_channel = $channel;

        $this->validate(array_merge(
            $this->rulesForStep(1),
            $this->rulesForStep(2),
            $this->rulesForStep(3),
            ['submission_channel' => 'required|in:whatsapp,email'],
        ), [
            'submission_channel.required' => 'Please choose how you would like to submit this registration (WhatsApp or Email).',
        ]);

        $this->validateContactForChannel();

        $reportPath = null;
        if ($this->previous_school_report) {
            $stored = $this->previous_school_report->store('previous-reports', 'public');
            $reportPath = 'storage/' . $stored;
        }

        $registration = StudentRegistration::create(array_merge(
            [
                'student_first_name' => $this->student_first_name,
                'student_last_name' => $this->student_last_name,
                'academic_level' => $this->academic_level,
                'date_of_birth' => $this->date_of_birth ?: null,
                'primary_contact' => $this->contact_relationship,
                'submission_channel' => $this->submission_channel,
                'previous_school_name' => $this->from_other_school ? ($this->previous_school_name ?: null) : null,
                'previous_school_report_path' => $this->from_other_school ? $reportPath : null,
            ],
            $this->contactAttributesForStorage(),
        ));

        if ($this->submission_channel === 'email') {
            $settings = WebsiteSetting::first();
            if ($settings?->email) {
                Mail::to($settings->email)->send(new StudentRegistrationSubmitted($registration));
            }
            if ($this->contact_email) {
                Mail::to($this->contact_email)->send(new StudentRegistrationSubmitted($registration));
            }

            $this->submitted = true;
            $this->resetForm();

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Registration received',
                'text' => 'We have saved your application and sent a confirmation by email.',
            ]);

            return;
        }

        $settings = WebsiteSetting::first();
        $waNumber = preg_replace('/[^0-9]/', '', $settings->phone_whatsapp ?? $settings->phone_reception ?? '');
        if (! $waNumber) {
            $this->addError('submission_channel', 'WhatsApp registration is temporarily unavailable. Please choose Email or contact the school.');

            return;
        }

        $message = $this->buildWhatsAppMessage($registration);
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($message);

        $this->resetForm();

        $this->redirect($waUrl, navigate: false);
    }

    /** @return array<string, mixed> */
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'student_first_name' => 'required|string|max:120',
                'student_last_name' => 'required|string|max:120',
                'academic_level' => 'required|string|max:60',
                'date_of_birth' => 'nullable|date',
            ],
            2 => [
                'from_other_school' => 'boolean',
                'previous_school_name' => [
                    Rule::requiredIf($this->from_other_school),
                    'nullable',
                    'string',
                    'max:255',
                ],
                'previous_school_report' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            ],
            3 => [
                'contact_relationship' => 'required|in:mother,father,guardian',
                'contact_full_name' => 'required|string|max:180',
                'contact_email' => 'required|email|max:120',
                'contact_phone' => 'required|string|max:30',
            ],
            default => [],
        };
    }

    /** @return array<string, string|null> */
    protected function contactAttributesForStorage(): array
    {
        $prefix = match ($this->contact_relationship) {
            'father' => 'father',
            'mother' => 'mother',
            'guardian' => 'guardian',
            default => 'guardian',
        };

        return [
            'father_full_name' => $prefix === 'father' ? $this->contact_full_name : null,
            'father_email' => $prefix === 'father' ? $this->contact_email : null,
            'father_phone' => $prefix === 'father' ? $this->contact_phone : null,
            'mother_full_name' => $prefix === 'mother' ? $this->contact_full_name : null,
            'mother_email' => $prefix === 'mother' ? $this->contact_email : null,
            'mother_phone' => $prefix === 'mother' ? $this->contact_phone : null,
            'guardian_full_name' => $prefix === 'guardian' ? $this->contact_full_name : null,
            'guardian_email' => $prefix === 'guardian' ? $this->contact_email : null,
            'guardian_phone' => $prefix === 'guardian' ? $this->contact_phone : null,
        ];
    }

    protected function validateContactForChannel(): void
    {
        if ($this->submission_channel === 'whatsapp') {
            if (strlen(preg_replace('/[^0-9]/', '', $this->contact_phone)) < 9) {
                $this->addError('submission_channel', 'Please enter a valid WhatsApp phone number for your contact.');
            }
        }

        if ($this->submission_channel === 'email') {
            if (! filter_var($this->contact_email, FILTER_VALIDATE_EMAIL)) {
                $this->addError('submission_channel', 'Please enter a valid email address for your contact.');
            }
        }
    }

    public function contactRelationshipLabel(): string
    {
        return match ($this->contact_relationship) {
            'father' => 'Father',
            'mother' => 'Mother',
            'guardian' => 'Guardian',
            default => ucfirst($this->contact_relationship),
        };
    }

    protected function buildWhatsAppMessage(StudentRegistration $registration): string
    {
        $school = WebsiteSetting::first()?->company_name ?? 'New Life Christian Academy';

        return "Hello {$school},\n\n"
            . "I am submitting a student registration via your website.\n\n"
            . "Student: {$registration->student_full_name}\n"
            . "Level: {$registration->academic_level}\n"
            . "Contact: {$this->contactRelationshipLabel()} — {$this->contact_full_name}\n\n"
            . "Please confirm receipt of this application. Thank you.";
    }

    protected function resetForm(): void
    {
        $this->clearDraftSession();

        $this->reset([
            'step',
            'student_first_name', 'student_last_name', 'academic_level', 'date_of_birth',
            'contact_relationship', 'contact_full_name', 'contact_email', 'contact_phone',
            'submission_channel',
            'previous_school_name', 'previous_school_report', 'previous_school_report_filename', 'from_other_school',
        ]);

        $this->step = 1;
        $this->contact_relationship = 'mother';
        $this->from_other_school = false;
    }

    protected function clearDraftSession(): void
    {
        Session::forget([
            self::DRAFT_PREFIX . 'step',
            self::DRAFT_PREFIX . 'student_first_name',
            self::DRAFT_PREFIX . 'student_last_name',
            self::DRAFT_PREFIX . 'academic_level',
            self::DRAFT_PREFIX . 'date_of_birth',
            self::DRAFT_PREFIX . 'contact_relationship',
            self::DRAFT_PREFIX . 'contact_full_name',
            self::DRAFT_PREFIX . 'contact_email',
            self::DRAFT_PREFIX . 'contact_phone',
            self::DRAFT_PREFIX . 'previous_school_name',
            self::DRAFT_PREFIX . 'previous_school_report_filename',
            self::DRAFT_PREFIX . 'from_other_school',
        ]);
    }
}
