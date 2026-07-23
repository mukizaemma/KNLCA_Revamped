<?php

namespace App\Livewire\Admin\Facilities;

use App\Models\Facility;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public ?int $editingId = null;
    public string $name = '';
    public ?string $description = null;
    public $image;
    public ?string $image_path = null;
    public bool $is_active = true;
    public ?int $sort_order = null;
    public bool $showFormModal = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => [$this->editingId ? 'nullable' : 'required', 'image', 'max:4096'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function updatingSearch(): void
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
        $f = Facility::findOrFail($id);
        $this->editingId = $f->id;
        $this->name = $f->name;
        $this->description = $f->description ?? '';
        $this->image_path = $f->image_path;
        $this->image = null;
        $this->is_active = $f->is_active;
        $this->sort_order = $f->sort_order;
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
        $slug = $this->uniqueSlug(Str::slug($data['name']), $this->editingId);
        $payload = [
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];

        if ($this->image) {
            $path = $this->image->store('facilities', 'public');
            $payload['image_path'] = 'storage/' . $path;
        }

        if ($this->editingId) {
            $model = Facility::findOrFail($this->editingId);
            if (!isset($payload['image_path'])) {
                $payload['image_path'] = $model->image_path;
            }
            $model->update($payload);
            session()->flash('success', 'Facility updated successfully.');
        } else {
            Facility::create($payload);
            session()->flash('success', 'Facility created successfully.');
        }

        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        Facility::findOrFail($id)->delete();
        session()->flash('success', 'Facility deleted successfully.');
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug = $base;
        $q = Facility::where('slug', $slug);
        if ($excludeId) {
            $q->where('id', '!=', $excludeId);
        }
        $n = 0;
        while ($q->exists()) {
            $n++;
            $slug = $base . '-' . $n;
            $q = Facility::where('slug', $slug);
            if ($excludeId) {
                $q->where('id', '!=', $excludeId);
            }
        }
        return $slug;
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->description = null;
        $this->image = null;
        $this->image_path = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getFacilitiesProperty()
    {
        return Facility::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('slug', 'like', '%' . $this->search . '%'))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.facilities.index', [
            'facilities' => $this->facilities,
        ]);
    }
}
