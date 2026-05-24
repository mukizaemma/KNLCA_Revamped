<?php

namespace App\Livewire\Admin\Doctors;

use App\Models\ClinicalDepartment;
use App\Models\Doctor;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $departmentFilter = '';
    public ?int $editingId = null;
    public bool $showFormModal = false;

    public ?int $clinical_department_id = null;
    public string $full_name = '';
    public string $position = '';
    public ?string $phone = null;
    public ?string $email = null;
    public ?string $biography = null;
    public $profile_image;
    public ?string $profile_image_path = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    protected function rules(): array
    {
        return [
            'clinical_department_id' => ['required', 'exists:clinical_departments,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'biography' => ['nullable', 'string'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingDepartmentFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = true;
    }

    public function edit(int $id): void
    {
        $doctor = Doctor::findOrFail($id);
        $this->editingId = $doctor->id;
        $this->clinical_department_id = $doctor->clinical_department_id;
        $this->full_name = $doctor->full_name;
        $this->position = $doctor->position;
        $this->phone = $doctor->phone ?? '';
        $this->email = $doctor->email ?? '';
        $this->biography = $doctor->biography ?? '';
        $this->profile_image_path = $doctor->profile_image;
        $this->profile_image = null;
        $this->is_active = $doctor->is_active;
        $this->sort_order = $doctor->sort_order;
        $this->showFormModal = true;
    }

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    public function save(): void
    {
        $data = $this->validate();
        $payload = [
            'clinical_department_id' => $data['clinical_department_id'],
            'full_name' => $data['full_name'],
            'position' => $data['position'],
            'phone' => $data['phone'] ?: null,
            'email' => $data['email'] ?: null,
            'biography' => $data['biography'] ?: null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];

        if ($this->profile_image) {
            $path = $this->profile_image->store('doctors', 'public');
            $payload['profile_image'] = 'storage/' . $path;
        }

        if ($this->editingId) {
            Doctor::findOrFail($this->editingId)->update($payload);
            session()->flash('success', 'Doctor updated successfully.');
        } else {
            Doctor::create($payload);
            session()->flash('success', 'Doctor added successfully.');
        }

        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        Doctor::findOrFail($id)->delete();
        session()->flash('success', 'Doctor removed successfully.');
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function resetForm(): void
    {
        $this->clinical_department_id = $this->clinical_department_id ?: ClinicalDepartment::query()->min('id');
        $this->full_name = '';
        $this->position = '';
        $this->phone = null;
        $this->email = null;
        $this->biography = null;
        $this->profile_image = null;
        $this->profile_image_path = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getDoctorsProperty()
    {
        return Doctor::query()
            ->with('department')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            }))
            ->when($this->departmentFilter !== '', fn($q) => $q->where('clinical_department_id', $this->departmentFilter))
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.doctors.index', [
            'doctors' => $this->doctors,
            'departments' => ClinicalDepartment::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
