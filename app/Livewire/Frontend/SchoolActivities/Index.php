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
        $activities = SchoolActivity::query()
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->orderBy('sort_order')
            ->paginate(9);

        return view('livewire.frontend.school-activities.index', [
            'header' => $header,
            'activities' => $activities,
        ]);
    }
}
