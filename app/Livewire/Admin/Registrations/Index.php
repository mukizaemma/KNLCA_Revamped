<?php

namespace App\Livewire\Admin\Registrations;

use App\Models\StudentRegistration;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = StudentRegistration::query()
            ->orderByDesc('created_at');

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('student_first_name', 'like', $term)
                    ->orWhere('student_last_name', 'like', $term)
                    ->orWhere('academic_level', 'like', $term)
                    ->orWhere('father_full_name', 'like', $term)
                    ->orWhere('father_email', 'like', $term)
                    ->orWhere('father_phone', 'like', $term)
                    ->orWhere('mother_full_name', 'like', $term)
                    ->orWhere('mother_email', 'like', $term)
                    ->orWhere('mother_phone', 'like', $term);
            });
        }

        $registrations = $query->paginate(15);

        return view('livewire.admin.registrations.index', [
            'registrations' => $registrations,
        ]);
    }
}
