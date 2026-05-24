<?php

namespace App\Livewire\Frontend;

use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Careers extends Component
{
    public function render()
    {
        $header = PageHeader::where('page_key', 'careers')->first();

        return view('livewire.frontend.careers', [
            'header' => $header,
        ]);
    }
}
