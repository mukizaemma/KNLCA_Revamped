<?php

namespace App\Livewire\Frontend\LeadershipTeam;

use App\Models\LeadershipTeamMember;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $header = PageHeader::where('page_key', 'leadership')->first();
        $members = LeadershipTeamMember::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.frontend.leadership-team.index', [
            'header' => $header,
            'members' => $members,
        ]);
    }
}
