<?php

namespace App\Livewire\Frontend;

use App\Models\Facility;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Facilities extends Component
{
    public function render()
    {
        $header = PageHeader::where('page_key', 'facilities')->first();
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('livewire.frontend.facilities', [
            'header' => $header,
            'facilities' => $facilities,
        ]);
    }
}
