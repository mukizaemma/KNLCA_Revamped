<?php

namespace App\Livewire\Frontend;

use App\Mail\SchoolVisitConfirmation;
use App\Mail\SchoolVisitRequested;
use App\Models\PageHeader;
use App\Models\SchoolVisit;
use App\Models\WebsiteSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class VisitSchool extends Component
{
    public string $visitor_name = '';
    public string $visitor_email = '';
    public string $visitor_phone = '';
    public string $reason = '';
    public string $visit_date = '';
    public string $visit_time = '';
    public string $what_to_see = '';
    public bool $has_student = false;
    public string $student_name = '';
    public string $student_grade = '';

    public bool $submitted = false;

    protected function rules(): array
    {
        return [
            'visitor_name' => ['required', 'string', 'max:180'],
            'visitor_email' => ['required', 'email', 'max:255'],
            'visitor_phone' => ['nullable', 'string', 'max:50'],
            'reason' => ['required', 'string', 'max:255'],
            'visit_date' => ['required', 'date'],
            'visit_time' => ['required', 'date_format:H:i'],
            'what_to_see' => ['nullable', 'string', 'max:1000'],
            'has_student' => ['boolean'],
            'student_name' => ['nullable', 'string', 'max:180'],
            'student_grade' => ['nullable', 'string', 'max:120'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $visitDateTime = $this->visit_date . ' ' . $this->visit_time . ':00';
        $visitDateTimeForDisplay = Carbon::parse($visitDateTime)->format('d M Y H:i');

        $visit = SchoolVisit::create([
            'visitor_name' => $this->visitor_name,
            'visitor_email' => $this->visitor_email,
            'visitor_phone' => $this->visitor_phone ?: null,
            'reason' => $this->reason,
            'visit_datetime' => $visitDateTime,
            'what_to_see' => $this->what_to_see ?: null,
            'has_student' => $this->has_student,
            'student_name' => $this->has_student ? ($this->student_name ?: null) : null,
            'student_grade' => $this->has_student ? ($this->student_grade ?: null) : null,
        ]);

        $settings = WebsiteSetting::first();
        $adminEmail = $settings?->email;

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new SchoolVisitRequested(
                visitor_name: $visit->visitor_name,
                visitor_email: $visit->visitor_email,
                visitor_phone: $visit->visitor_phone,
                reason: $visit->reason,
                visit_datetime: $visitDateTimeForDisplay,
                what_to_see: $visit->what_to_see,
                has_student: $visit->has_student,
                student_name: $visit->student_name,
                student_grade: $visit->student_grade,
            ));
        }

        Mail::to($visit->visitor_email)->send(new SchoolVisitConfirmation(
            visitor_name: $visit->visitor_name,
            visitor_email: $visit->visitor_email,
            visit_datetime: $visitDateTimeForDisplay,
        ));

        $this->reset([
            'visitor_name',
            'visitor_email',
            'visitor_phone',
            'reason',
            'visit_date',
            'visit_time',
            'what_to_see',
            'has_student',
            'student_name',
            'student_grade',
        ]);
        $this->submitted = true;

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Thank you for your request',
            'text' => 'We have received your school visit request and will contact you with a confirmation.',
        ]);
    }

    #[Layout('layouts.frontend')]
    public function render()
    {
        $header = PageHeader::where('page_key', 'visit_school')->first()
            ?? PageHeader::where('page_key', 'facilities')->first();

        return view('livewire.frontend.visit-school', [
            'header' => $header,
        ]);
    }
}

