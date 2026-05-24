<?php

namespace App\Livewire\Admin\Services;

use App\Models\ClinicalDepartment;
use App\Models\ClinicalService;
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
    public string $departmentFilter = '';
    public ?int $editingId = null;
    public ?int $clinical_department_id = null;
    public string $title = '';
    public string $slug = '';
    public ?string $description = null;
    public $cover_image;
    public ?string $cover_image_path = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    public array $gallery_images = [];
    public ?int $galleryServiceId = null;
    public bool $showFormModal = false;
    public bool $showGalleryModal = false;

    protected function rules(): array
    {
        $slugRule = $this->editingId
            ? ['required', 'string', 'max:255', 'unique:clinical_services,slug,' . $this->editingId]
            : ['required', 'string', 'max:255', 'unique:clinical_services,slug'];
        return [
            'clinical_department_id' => ['required', 'exists:clinical_departments,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => $slugRule,
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
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
        $this->galleryServiceId = null;
        $this->showFormModal = true;
        $this->showGalleryModal = false;
    }

    public function edit(int $id): void
    {
        $srv = ClinicalService::findOrFail($id);
        $this->editingId = $srv->id;
        $this->clinical_department_id = $srv->clinical_department_id;
        $this->title = $srv->title;
        $this->slug = $srv->slug;
        $this->description = $srv->description ?? '';
        $this->cover_image_path = $srv->cover_image;
        $this->cover_image = null;
        $this->is_active = $srv->is_active;
        $this->sort_order = $srv->sort_order;
        $this->galleryServiceId = null;
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
            'clinical_department_id' => $data['clinical_department_id'],
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];
        if ($this->cover_image) {
            $path = $this->cover_image->store('services', 'public');
            $payload['cover_image'] = 'storage/' . $path;
        }
        if ($this->editingId) {
            ClinicalService::findOrFail($this->editingId)->update($payload);
            session()->flash('success', 'Service updated successfully.');
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Service updated',
                'text' => 'The service has been updated successfully.',
            ]);
        } else {
            $payload['gallery'] = json_encode([]);
            ClinicalService::create($payload);
            session()->flash('success', 'Service created successfully.');
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Service created',
                'text' => 'A new service has been created successfully.',
            ]);
        }
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        ClinicalService::findOrFail($id)->delete();
        session()->flash('success', 'Service deleted successfully.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Service deleted',
            'text' => 'The service has been removed.',
        ]);
        $this->showFormModal = false;
        $this->showGalleryModal = false;
        $this->galleryServiceId = null;
        $this->resetForm();
        $this->editingId = null;
    }

    public function updatedTitle($value): void
    {
        if (!$this->editingId) {
            $this->slug = Str::slug($value);
        }
    }

    public function openGalleryModal(int $serviceId): void
    {
        $this->galleryServiceId = $serviceId;
        $this->gallery_images = [];
        $this->showGalleryModal = true;
    }

    public function closeGalleryModal(): void
    {
        $this->showGalleryModal = false;
        $this->galleryServiceId = null;
        $this->gallery_images = [];
    }

    public function addGalleryImages(): void
    {
        // Normalize to array (Livewire may bind single file as one object when only one selected)
        $files = is_array($this->gallery_images) ? $this->gallery_images : array_filter([$this->gallery_images]);
        $this->gallery_images = $files;

        $this->validate([
            'gallery_images' => ['required', 'array', 'min:1'],
            'gallery_images.*' => ['required', 'image', 'max:4096'],
        ]);

        $srv = ClinicalService::findOrFail($this->galleryServiceId);
        $paths = $srv->gallery ? (array) json_decode($srv->gallery, true) : [];
        $added = 0;
        foreach ($this->gallery_images as $file) {
            if (is_object($file) && method_exists($file, 'store')) {
                $path = $file->store('services/gallery', 'public');
                $paths[] = 'storage/' . $path;
                $added++;
            }
        }
        $srv->update(['gallery' => json_encode($paths)]);
        $this->gallery_images = [];
        session()->flash('success', $added . ' gallery image(s) added.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Gallery updated',
            'text' => $added . ' image(s) added to this service.',
        ]);
    }

    public function removeGalleryImage(int $serviceId, int $index): void
    {
        $srv = ClinicalService::findOrFail($serviceId);
        $paths = $srv->gallery ? (array) json_decode($srv->gallery, true) : [];
        $paths = array_values(array_filter($paths, fn($_, $i) => (int) $i !== $index, ARRAY_FILTER_USE_BOTH));
        $srv->update(['gallery' => json_encode($paths)]);
        session()->flash('success', 'Gallery image removed.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Image removed',
            'text' => 'The image was removed from the gallery.',
        ]);
    }

    protected function resetForm(): void
    {
        $this->clinical_department_id = $this->clinical_department_id ?: ClinicalDepartment::query()->min('id');
        $this->title = '';
        $this->slug = '';
        $this->description = null;
        $this->cover_image = null;
        $this->cover_image_path = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getServicesProperty()
    {
        return ClinicalService::query()
            ->with('department')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('slug', 'like', '%' . $this->search . '%'))
            ->when($this->departmentFilter, fn($q) => $q->where('clinical_department_id', $this->departmentFilter))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10);
    }

    public function getGalleryPathsProperty(): array
    {
        if (!$this->galleryServiceId) return [];
        $srv = ClinicalService::find($this->galleryServiceId);
        if (!$srv || !$srv->gallery) return [];
        $decoded = json_decode($srv->gallery, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function render()
    {
        return view('livewire.admin.services.index', [
            'services' => $this->services,
            'departments' => ClinicalDepartment::orderBy('sort_order')->orderBy('name')->get(),
            'galleryPaths' => $this->galleryPaths,
        ]);
    }
}
