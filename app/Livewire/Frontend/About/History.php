<?php

namespace App\Livewire\Frontend\About;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class History extends Component
{
    use LoadsPageHeader;

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.frontend.about.history', [
            'header' => $this->pageHeader('about_history'),
            'settings' => WebsiteSetting::first(),
        ]);
    }
}
