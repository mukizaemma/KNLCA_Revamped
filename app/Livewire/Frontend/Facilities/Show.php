<?php

namespace App\Livewire\Frontend\Facilities;

use App\Models\Facility;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.frontend')]
    public $facility;

    public function mount($facility): void
    {
        $this->facility = is_numeric($facility)
            ? Facility::where('is_active', true)->findOrFail($facility)
            : Facility::where('is_active', true)->where('slug', $facility)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.facilities.show', [
            'facility' => $this->facility,
        ]);
    }
}
