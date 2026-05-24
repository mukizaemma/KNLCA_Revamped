<?php

namespace App\Livewire\Frontend;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class About extends Component
{
    use LoadsPageHeader;

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.frontend.about.overview', [
            'header' => $this->pageHeader('about'),
            'settings' => WebsiteSetting::first(),
        ]);
    }
}
