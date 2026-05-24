<?php

namespace App\Livewire\Frontend\SchoolActivities;

use App\Models\PageHeader;
use App\Models\SchoolActivity;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Index extends Component
{
    public function render()
    {
        $header = PageHeader::where('page_key', 'school_activities')->first();
        $activities = SchoolActivity::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->paginate(9);

        return view('livewire.frontend.school-activities.index', [
            'header' => $header,
            'activities' => $activities,
        ]);
    }
}
