<?php

namespace App\Livewire\Frontend\Doctors;

use App\Models\Doctor;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $header = PageHeader::where('page_key', 'departments')->first(); // reuse or add 'doctors' in admin later
        $doctors = Doctor::where('is_active', true)->with('department')->orderBy('sort_order')->get();

        return view('livewire.frontend.doctors.index', [
            'header' => $header,
            'doctors' => $doctors,
        ]);
    }
}
