<?php

namespace App\Livewire\Admin;

use App\Models\ClinicalDepartment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        // For the school website dashboard we surface simple content stats.
        $programCount = ClinicalDepartment::count();
        $serviceCount = \App\Models\ClinicalService::count();
        $staffCount = \App\Models\LeadershipTeamMember::count();
        $contactMessageCount = \App\Models\ContactMessage::count();

        return view('livewire.admin.dashboard', [
            'programCount' => $programCount,
            'serviceCount' => $serviceCount,
            'staffCount' => $staffCount,
            'contactMessageCount' => $contactMessageCount,
        ]);
    }
}
