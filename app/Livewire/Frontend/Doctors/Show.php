<?php

namespace App\Livewire\Frontend\Doctors;

use App\Models\Doctor;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.frontend')]
    public $doctor;

    public function mount($doctor, $slug = null)
    {
        $this->doctor = Doctor::where('is_active', true)->findOrFail($doctor);
    }

    public function render()
    {
        return view('livewire.frontend.doctors.show', [
            'doctor' => $this->doctor,
        ]);
    }
}
