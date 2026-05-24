<?php

namespace App\Livewire\Admin;

use App\Models\AdmissionPage as AdmissionPageModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class AdmissionPage extends Component
{
    public string $process_heading = '';
    public string $intro_label = '';
    public string $intro_title = '';
    public string $intro_subtitle = '';
    public string $featured_badge = '';
    public string $admission_process = '';
    public string $first_admission_heading = '';
    public string $first_admission_intro = '';
    /** @var array<int, string> */
    public array $first_admission_documents = [];
    public string $transfer_heading = '';
    public string $transfer_intro = '';
    /** @var array<int, string> */
    public array $transfer_documents = [];
    public string $cta_title = '';
    public string $cta_text = '';
    public string $cta_primary_btn = '';
    public string $cta_secondary_btn = '';

    public function mount(): void
    {
        $content = AdmissionPageModel::content();
        $this->process_heading = $content->process_heading ?? 'Admission Process';
        $this->intro_label = $content->intro_label ?? 'Join us';
        $this->intro_title = $content->intro_title ?? 'Admissions for Nursery & Primary';
        $this->intro_subtitle = $content->intro_subtitle ?? '';
        $this->featured_badge = $content->featured_badge ?? 'Most common';
        $this->admission_process = $content->admission_process ?? '';
        $this->first_admission_heading = $content->first_admission_heading ?? 'First Admission';
        $this->first_admission_intro = $content->first_admission_intro ?? '';
        $this->first_admission_documents = $content->first_admission_documents ?? [];
        $this->transfer_heading = $content->transfer_heading ?? 'Transfer from another school';
        $this->transfer_intro = $content->transfer_intro ?? '';
        $this->transfer_documents = $content->transfer_documents ?? [];
        $this->cta_title = $content->cta_title ?? 'Start your application';
        $this->cta_text = $content->cta_text ?? '';
        $this->cta_primary_btn = $content->cta_primary_btn ?? 'Register your child';
        $this->cta_secondary_btn = $content->cta_secondary_btn ?? 'Schedule a school visit';
    }

    public function addFirstAdmissionDocument(): void
    {
        $this->first_admission_documents[] = '';
    }

    public function removeFirstAdmissionDocument(int $index): void
    {
        $arr = $this->first_admission_documents;
        array_splice($arr, $index, 1);
        $this->first_admission_documents = array_values($arr);
    }

    public function addTransferDocument(): void
    {
        $this->transfer_documents[] = '';
    }

    public function removeTransferDocument(int $index): void
    {
        $arr = $this->transfer_documents;
        array_splice($arr, $index, 1);
        $this->transfer_documents = array_values($arr);
    }

    public function save(): void
    {
        $content = AdmissionPageModel::content();
        $content->update([
            'intro_label' => $this->intro_label,
            'intro_title' => $this->intro_title,
            'intro_subtitle' => $this->intro_subtitle,
            'featured_badge' => $this->featured_badge,
            'process_heading' => $this->process_heading,
            'admission_process' => $this->admission_process,
            'first_admission_heading' => $this->first_admission_heading,
            'first_admission_intro' => $this->first_admission_intro,
            'first_admission_documents' => array_values(array_filter($this->first_admission_documents)),
            'transfer_heading' => $this->transfer_heading,
            'transfer_intro' => $this->transfer_intro,
            'transfer_documents' => array_values(array_filter($this->transfer_documents)),
            'cta_title' => $this->cta_title,
            'cta_text' => $this->cta_text,
            'cta_primary_btn' => $this->cta_primary_btn,
            'cta_secondary_btn' => $this->cta_secondary_btn,
        ]);
        session()->flash('message', 'Admissions page content updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.admission-page');
    }
}
