<?php

namespace App\Livewire\Frontend\SchoolActivities;

use App\Models\SchoolActivity;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Show extends Component
{
    public $activity;

    public function mount($activity)
    {
        $query = SchoolActivity::where('is_active', true)->with('galleryImages');
        $this->activity = is_numeric($activity)
            ? $query->findOrFail($activity)
            : $query->where('slug', $activity)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.school-activities.show', [
            'activity' => $this->activity,
        ]);
    }
}
