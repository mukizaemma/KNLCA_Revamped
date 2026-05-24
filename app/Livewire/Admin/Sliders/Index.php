<?php

namespace App\Livewire\Admin\Sliders;

use App\Models\HomeSlider;
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
    public bool $showFormModal = false;
    public $image;
    public ?string $image_path = null;
    public ?string $title = null;
    public ?string $caption = null;
    public ?string $button_text = null;
    public ?string $button_url = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    protected function rules(): array
    {
        $imageRule = $this->editingId ? ['nullable', 'image', 'max:4096'] : ['required', 'image', 'max:4096'];
        return [
            'image' => $imageRule,
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'url', 'max:255'],
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

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    public function edit(int $id): void
    {
        $s = HomeSlider::findOrFail($id);
        $this->editingId = $s->id;
        $this->image_path = $s->image_path;
        $this->image = null;
        $this->title = $s->title ?? '';
        $this->caption = $s->caption ?? '';
        $this->button_text = $s->button_text ?? '';
        $this->button_url = $s->button_url ?? '';
        $this->is_active = $s->is_active;
        $this->sort_order = $s->sort_order;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();
        $payload = [
            'title' => $data['title'] ?: null,
            'caption' => $data['caption'] ?: null,
            'button_text' => $data['button_text'] ?: null,
            'button_url' => $data['button_url'] ?: null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];
        if ($this->image) {
            $path = $this->image->store('sliders', 'public');
            $payload['image_path'] = 'storage/' . $path;
        }
        if ($this->editingId) {
            $model = HomeSlider::findOrFail($this->editingId);
            $model->update($payload);
            $this->image_path = $model->image_path;
            session()->flash('success', 'Slide updated successfully.');
        } else {
            if (empty($payload['image_path']) && !$this->image) {
                session()->flash('error', 'Image is required when creating a slide.');
                return;
            }
            if ($this->image) {
                $path = $this->image->store('sliders', 'public');
                $payload['image_path'] = 'storage/' . $path;
            }
            HomeSlider::create($payload);
            session()->flash('success', 'Slide created successfully.');
        }
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        HomeSlider::findOrFail($id)->delete();
        session()->flash('success', 'Slide deleted successfully.');
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function resetForm(): void
    {
        $this->image = null;
        $this->image_path = null;
        $this->title = null;
        $this->caption = null;
        $this->button_text = null;
        $this->button_url = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getSlidersProperty()
    {
        return HomeSlider::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('caption', 'like', '%' . $this->search . '%'))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.sliders.index', ['sliders' => $this->sliders]);
    }
}
