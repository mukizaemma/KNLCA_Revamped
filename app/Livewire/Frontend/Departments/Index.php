<?php

namespace App\Livewire\Frontend\Departments;

use App\Models\ClinicalDepartment;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $header = PageHeader::where('page_key', 'departments')->first();
        $departments = ClinicalDepartment::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.frontend.departments.index', [
            'header' => $header,
            'departments' => $departments,
        ]);
    }
}
