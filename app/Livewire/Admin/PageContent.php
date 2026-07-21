<?php

namespace App\Livewire\Admin;

use App\Models\PageHeader;
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

    /** @var array<int, array{key: string, label: string, title: string, caption: string, image_path: ?string}> */
    public array $headers = [];

    protected array $headerPages = [
        ['key' => 'about', 'label' => 'About · Overview'],
        ['key' => 'about_mission', 'label' => 'About · Mission & Vision'],
        ['key' => 'about_values', 'label' => 'About · Core Values'],
        ['key' => 'about_staff', 'label' => 'About · Staff'],
        ['key' => 'about_history', 'label' => 'About · History'],
        ['key' => 'about_schools', 'label' => 'About · Our Schools'],
        ['key' => 'about_inquire', 'label' => 'About · Contact'],
        ['key' => 'departments', 'label' => 'Academics'],
        ['key' => 'admissions', 'label' => 'Admissions'],
        ['key' => 'register', 'label' => 'Register / Enrollment'],
        ['key' => 'visit_school', 'label' => 'Visit School'],
        ['key' => 'facilities', 'label' => 'Facilities'],
        ['key' => 'leadership', 'label' => 'Staff'],
        ['key' => 'school_activities', 'label' => 'School Activities'],
        ['key' => 'careers', 'label' => 'Careers'],
        ['key' => 'gallery', 'label' => 'Gallery'],
        ['key' => 'contact', 'label' => 'Contacts'],
        ['key' => 'feedback', 'label' => 'Feedback'],
    ];

    public function mount(): void
    {
        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([]);
        $this->sections = SiteContent::for($settings);

        if (empty($this->sections['about']['core_value_cards']) && ! empty($settings->about_value_cards)) {
            $cards = is_array($settings->about_value_cards)
                ? $settings->about_value_cards
                : (json_decode((string) $settings->about_value_cards, true) ?: []);
            $this->sections['about']['core_value_cards'] = is_array($cards) ? array_values($cards) : [];
        }

        $this->loadHeaders();
    }

    public function setTab(string $tab): void
    {
        $allowed = ['global', 'home', 'about', 'headers', 'facilities', 'contact', 'departments', 'activities', 'gallery', 'careers', 'leadership', 'feedback', 'registration'];
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

    public function addExploreCard(): void
    {
        $this->sections['home']['explore_cards'][] = [
            'key' => 'custom',
            'title' => '',
            'description' => '',
            'url' => '/',
        ];
    }

    public function removeExploreCard(int $index): void
    {
        $cards = $this->sections['home']['explore_cards'] ?? [];
        array_splice($cards, $index, 1);
        $this->sections['home']['explore_cards'] = array_values($cards);
    }

    public function addCoreValueCard(): void
    {
        $this->sections['about']['core_value_cards'][] = ['name' => '', 'description' => ''];
    }

    public function removeCoreValueCard(int $index): void
    {
        $cards = $this->sections['about']['core_value_cards'] ?? [];
        array_splice($cards, $index, 1);
        $this->sections['about']['core_value_cards'] = array_values($cards);
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

        $coreCards = array_values(array_filter(
            $this->sections['about']['core_value_cards'] ?? [],
            fn ($c) => ! empty($c['name']) || ! empty($c['description'])
        ));
        $this->sections['about']['core_value_cards'] = $coreCards;

        $settings->update([
            'page_sections' => $this->sections,
            'about_value_cards' => $coreCards,
        ]);

        $this->saveHeaders();

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

    protected function loadHeaders(): void
    {
        $existing = PageHeader::all()->keyBy('page_key');
        $this->headers = [];

        foreach ($this->headerPages as $page) {
            $row = $existing->get($page['key']);
            $this->headers[] = [
                'key' => $page['key'],
                'label' => $page['label'],
                'title' => $row?->title ?? '',
                'caption' => $row?->caption ?? '',
                'image_path' => $row?->image_path,
            ];
        }
    }

    protected function saveHeaders(): void
    {
        foreach ($this->headers as $header) {
            PageHeader::updateOrCreate(
                ['page_key' => $header['key']],
                [
                    'title' => $header['title'] ?: null,
                    'caption' => $header['caption'] ?: null,
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.page-content');
    }
}
