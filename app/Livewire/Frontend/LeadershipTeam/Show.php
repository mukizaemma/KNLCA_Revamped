<?php

namespace App\Livewire\Frontend\LeadershipTeam;

use App\Models\LeadershipTeamMember;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.frontend')]
    public $member;

    public function mount($member, $slug = null)
    {
        $this->member = LeadershipTeamMember::where('is_active', true)->findOrFail($member);
    }

    public function render()
    {
        return view('livewire.frontend.leadership-team.show', [
            'member' => $this->member,
        ]);
    }
}
