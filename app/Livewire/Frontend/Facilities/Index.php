<?php

namespace App\Livewire\Frontend\Facilities;

use App\Models\Facility;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Index extends Component
{
    public function render()
    {
        $header = PageHeader::where('page_key', 'facilities')->first();
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('livewire.frontend.facilities.index', [
            'header' => $header,
            'facilities' => $facilities,
        ]);
    }
}
