<?php

namespace App\Livewire\Admin\Departments;

use App\Models\ClinicalDepartment;
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
    public string $slug = '';
    public ?string $description = null;
    public $cover_image;
    public ?string $cover_image_path = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    /** Gallery: multiple new images (for modal upload) */
    public array $gallery_images = [];
    /** Department id for which we're managing gallery (modal) */
    public ?int $galleryDepartmentId = null;
    /** Show form modal */
    public bool $showFormModal = false;
    /** Show gallery modal */
    public bool $showGalleryModal = false;

    protected function rules(): array
    {
        $slugRule = $this->editingId
            ? ['required', 'string', 'max:255', 'unique:clinical_departments,slug,' . $this->editingId]
            : ['required', 'string', 'max:255', 'unique:clinical_departments,slug'];
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => $slugRule,
            'description' => ['nullable', 'string'],
            'cover_image' => [$this->editingId ? 'nullable' : 'nullable', 'image', 'max:4096'],
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
        $this->galleryDepartmentId = null;
        $this->showFormModal = true;
        $this->showGalleryModal = false;
    }

    public function edit(int $id): void
    {
        $dept = ClinicalDepartment::findOrFail($id);
        $this->editingId = $dept->id;
        $this->name = $dept->name;
        $this->slug = $dept->slug;
        $this->description = $dept->description ?? '';
        $this->cover_image_path = $dept->cover_image;
        $this->cover_image = null;
        $this->is_active = $dept->is_active;
        $this->sort_order = $dept->sort_order;
        $this->galleryDepartmentId = null;
        $this->showFormModal = true;
        $this->showGalleryModal = false;
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
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];

        if ($this->cover_image) {
            $path = $this->cover_image->store('departments', 'public');
            $payload['cover_image'] = 'storage/' . $path;
        }

        if ($this->editingId) {
            $model = ClinicalDepartment::findOrFail($this->editingId);
            $model->update($payload);
            session()->flash('success', 'Department updated successfully.');
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Department updated',
                'text' => 'The program has been updated successfully.',
            ]);
        } else {
            $payload['gallery'] = json_encode([]);
            ClinicalDepartment::create($payload);
            session()->flash('success', 'Department created successfully.');
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Department created',
                'text' => 'A new program has been created successfully.',
            ]);
        }

        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        ClinicalDepartment::findOrFail($id)->delete();
        session()->flash('success', 'Department deleted successfully.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Department deleted',
            'text' => 'The program has been removed.',
        ]);
        $this->showFormModal = false;
        $this->showGalleryModal = false;
        $this->galleryDepartmentId = null;
        $this->resetForm();
        $this->editingId = null;
    }

    public function updatedName($value): void
    {
        if (!$this->editingId) {
            $this->slug = Str::slug($value);
        }
    }

    /** Gallery: open modal for a department */
    public function openGalleryModal(int $departmentId): void
    {
        $this->galleryDepartmentId = $departmentId;
        $this->gallery_images = [];
        $this->showGalleryModal = true;
    }

    public function closeGalleryModal(): void
    {
        $this->showGalleryModal = false;
        $this->galleryDepartmentId = null;
        $this->gallery_images = [];
    }

    /** Gallery CRD: add multiple images to department gallery */
    public function addGalleryImages(): void
    {
        // Normalize to array (Livewire may bind single file as one object when only one selected)
        $files = is_array($this->gallery_images) ? $this->gallery_images : array_filter([$this->gallery_images]);
        $this->gallery_images = $files;

        $this->validate([
            'gallery_images' => ['required', 'array', 'min:1'],
            'gallery_images.*' => ['required', 'image', 'max:4096'],
        ]);

        $dept = ClinicalDepartment::findOrFail($this->galleryDepartmentId);
        $paths = $dept->gallery ? (array) json_decode($dept->gallery, true) : [];
        $added = 0;
        foreach ($this->gallery_images as $file) {
            if (is_object($file) && method_exists($file, 'store')) {
                $path = $file->store('departments/gallery', 'public');
                $paths[] = 'storage/' . $path;
                $added++;
            }
        }
        $dept->update(['gallery' => json_encode($paths)]);
        $this->gallery_images = [];
        session()->flash('success', $added . ' gallery image(s) added.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Gallery updated',
            'text' => $added . ' image(s) added to this program.',
        ]);
    }

    /** Gallery CRD: remove image from department gallery */
    public function removeGalleryImage(int $departmentId, int $index): void
    {
        $dept = ClinicalDepartment::findOrFail($departmentId);
        $paths = $dept->gallery ? (array) json_decode($dept->gallery, true) : [];
        $paths = array_values(array_filter($paths, fn($_, $i) => (int) $i !== $index, ARRAY_FILTER_USE_BOTH));
        $dept->update(['gallery' => json_encode($paths)]);
        session()->flash('success', 'Gallery image removed.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Image removed',
            'text' => 'The image was removed from the gallery.',
        ]);
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->slug = '';
        $this->description = null;
        $this->cover_image = null;
        $this->cover_image_path = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getDepartmentsProperty()
    {
        return ClinicalDepartment::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('slug', 'like', '%' . $this->search . '%'))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);
    }

    public function getGalleryPathsProperty(): array
    {
        if (!$this->galleryDepartmentId) {
            return [];
        }
        $dept = ClinicalDepartment::find($this->galleryDepartmentId);
        if (!$dept || !$dept->gallery) {
            return [];
        }
        $decoded = json_decode($dept->gallery, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function render()
    {
        return view('livewire.admin.departments.index', [
            'departments' => $this->departments,
            'galleryPaths' => $this->galleryPaths,
        ]);
    }
}
