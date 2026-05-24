<?php

namespace App\Livewire\Frontend\Departments;

use App\Models\ClinicalDepartment;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.frontend')]
    public $department;

    public function mount($department)
    {
        $this->department = is_numeric($department)
            ? ClinicalDepartment::where('is_active', true)->findOrFail($department)
            : ClinicalDepartment::where('is_active', true)->where('slug', $department)->firstOrFail();
    }

    public function render()
    {
        $department = $this->department;
        $gallery = $department->gallery ? (is_string($department->gallery) ? json_decode($department->gallery, true) : $department->gallery) : [];
        if (!is_array($gallery)) {
            $gallery = [];
        }

        return view('livewire.frontend.departments.show', [
            'department' => $department,
            'gallery' => $gallery,
        ]);
    }
}
