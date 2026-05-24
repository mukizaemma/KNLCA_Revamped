<?php

namespace App\Livewire\Admin;

use App\Models\WebsiteSetting;
use App\Support\SiteContent;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class PageContent extends Component
{
    public string $activeTab = 'global';

    /** @var array<string, mixed> */
    public array $sections = [];

    public function mount(): void
    {
        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([]);
        $this->sections = SiteContent::for($settings);
    }

    public function setTab(string $tab): void
    {
        $allowed = ['global', 'home', 'about', 'facilities', 'contact', 'departments', 'activities', 'gallery', 'careers', 'leadership', 'feedback', 'registration'];
        if (in_array($tab, $allowed, true)) {
            $this->activeTab = $tab;
        }
    }

    public function addCurriculumPillar(): void
    {
        $this->sections['home']['curriculum_pillars'][] = ['title' => '', 'description' => ''];
    }

    public function removeCurriculumPillar(int $index): void
    {
        $pillars = $this->sections['home']['curriculum_pillars'] ?? [];
        array_splice($pillars, $index, 1);
        $this->sections['home']['curriculum_pillars'] = array_values($pillars);
    }

    public function addAcademicLevel(): void
    {
        $this->sections['registration']['academic_levels'][] = '';
    }

    public function removeAcademicLevel(int $index): void
    {
        $levels = $this->sections['registration']['academic_levels'] ?? [];
        array_splice($levels, $index, 1);
        $this->sections['registration']['academic_levels'] = array_values($levels);
    }

    public function save(): void
    {
        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([]);

        $settings->update([
            'page_sections' => $this->sections,
        ]);

        session()->flash('message', 'Page content updated successfully.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Saved',
            'text' => 'Website page content has been updated.',
        ]);
    }

    public function resetToDefaults(): void
    {
        $this->sections = SiteContent::defaults();
    }

    public function render()
    {
        return view('livewire.admin.page-content');
    }
}
