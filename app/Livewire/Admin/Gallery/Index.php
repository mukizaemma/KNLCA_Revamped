<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\MediaGalleryItem;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $typeFilter = '';
    public ?int $editingId = null;
    public bool $showFormModal = false;
    public string $type = 'image';
    public $image;
    public ?string $image_path = null;
    public ?string $video_url = null;
    public ?string $title = null;
    public ?string $caption = null;
    public bool $is_featured = false;
    public bool $is_active = true;
    public ?int $sort_order = null;

    protected function rules(): array
    {
        $rules = [
            'type' => ['required', 'in:image,video'],
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
        if ($this->type === 'image') {
            $rules['image'] = $this->editingId ? ['nullable', 'image', 'max:4096'] : ['required', 'image', 'max:4096'];
        } else {
            $rules['video_url'] = ['nullable', 'url', 'max:500'];
        }
        return $rules;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = true;
    }

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    public function edit(int $id): void
    {
        $g = MediaGalleryItem::findOrFail($id);
        $this->editingId = $g->id;
        $this->type = $g->type;
        $this->image_path = $g->image_path;
        $this->image = null;
        $this->video_url = $g->video_url ?? '';
        $this->title = $g->title ?? '';
        $this->caption = $g->caption ?? '';
        $this->is_featured = $g->is_featured;
        $this->is_active = $g->is_active;
        $this->sort_order = $g->sort_order;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();
        $payload = [
            'type' => $data['type'],
            'title' => $data['title'] ?: null,
            'caption' => $data['caption'] ?: null,
            'is_featured' => $data['is_featured'],
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];
        if ($this->type === 'image' && $this->image) {
            $path = $this->image->store('gallery', 'public');
            $payload['image_path'] = 'storage/' . $path;
            $payload['video_url'] = null;
        } elseif ($this->type === 'video') {
            $payload['video_url'] = $data['video_url'] ?: null;
            if (!$this->editingId || $this->image) {
                $payload['image_path'] = null;
            }
        }
        if ($this->editingId) {
            $model = MediaGalleryItem::findOrFail($this->editingId);
            $model->update($payload);
            $this->image_path = $model->image_path;
            session()->flash('success', 'Gallery item updated successfully.');
        } else {
            if ($this->type === 'image' && empty($payload['image_path'])) {
                session()->flash('error', 'Image is required for image type.');
                return;
            }
            MediaGalleryItem::create($payload);
            session()->flash('success', 'Gallery item created successfully.');
        }
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        MediaGalleryItem::findOrFail($id)->delete();
        session()->flash('success', 'Gallery item deleted successfully.');
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function resetForm(): void
    {
        $this->type = 'image';
        $this->image = null;
        $this->image_path = null;
        $this->video_url = null;
        $this->title = null;
        $this->caption = null;
        $this->is_featured = false;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getItemsProperty()
    {
        return MediaGalleryItem::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('caption', 'like', '%' . $this->search . '%'))
            ->when($this->typeFilter !== '', fn($q) => $q->where('type', $this->typeFilter))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.gallery.index', ['items' => $this->items]);
    }
}
