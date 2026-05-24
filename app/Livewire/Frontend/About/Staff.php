<?php

namespace App\Livewire\Frontend\About;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Models\LeadershipTeamMember;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Staff extends Component
{
    use LoadsPageHeader;

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.frontend.about.staff', [
            'header' => $this->pageHeader('about_staff', 'leadership'),
            'staff' => LeadershipTeamMember::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
