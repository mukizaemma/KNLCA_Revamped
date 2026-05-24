<?php

namespace App\Livewire\Frontend\About;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MissionVision extends Component
{
    use LoadsPageHeader;

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.frontend.about.mission-vision', [
            'header' => $this->pageHeader('about_mission'),
            'settings' => WebsiteSetting::first(),
        ]);
    }
}
