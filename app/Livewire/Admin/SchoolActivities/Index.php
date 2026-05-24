<?php

namespace App\Livewire\Admin\SchoolActivities;

use App\Models\SchoolActivity;
use App\Models\SchoolActivityImage;
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
    public string $title = '';
    public ?string $excerpt = null;
    public ?string $content = null;
    public $image;
    public ?string $image_path = null;
    public ?string $published_at = null;
    public bool $is_active = true;
    public ?int $sort_order = null;
    public bool $showFormModal = false;

    /** @var \Illuminate\Http\UploadedFile[] */
    public array $galleryFiles = [];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'published_at' => ['nullable', 'date'],
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
        $a = SchoolActivity::findOrFail($id);
        $this->editingId = $a->id;
        $this->title = $a->title;
        $this->excerpt = $a->excerpt ?? '';
        $this->content = $a->content ?? '';
        $this->image_path = $a->image_path;
        $this->image = null;
        $this->published_at = $a->published_at ? $a->published_at->format('Y-m-d\TH:i') : null;
        $this->is_active = $a->is_active;
        $this->sort_order = $a->sort_order;
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
        $slug = $this->uniqueSlug(Str::slug($data['title']), $this->editingId);
        $payload = [
            'title' => $data['title'],
            'slug' => $slug,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
            'published_at' => !empty($data['published_at']) ? \Carbon\Carbon::parse($data['published_at']) : null,
        ];

        if ($this->image) {
            $path = $this->image->store('school-activities', 'public');
            $payload['image_path'] = 'storage/' . $path;
        }

        if ($this->editingId) {
            $model = SchoolActivity::findOrFail($this->editingId);
            if (!isset($payload['image_path'])) {
                $payload['image_path'] = $model->image_path;
            }
            $model->update($payload);
            session()->flash('success', 'School activity updated successfully.');
        } else {
            SchoolActivity::create($payload);
            session()->flash('success', 'School activity created successfully.');
        }

        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        SchoolActivity::findOrFail($id)->delete();
        session()->flash('success', 'School activity deleted successfully.');
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    public function addGalleryImages(): void
    {
        if (! $this->editingId) {
            return;
        }
        $this->validate([
            'galleryFiles' => ['required', 'array', 'max:10'],
            'galleryFiles.*' => ['image', 'max:4096'],
        ]);
        $activity = SchoolActivity::findOrFail($this->editingId);
        $maxOrder = $activity->galleryImages()->max('sort_order') ?? 0;
        foreach ($this->galleryFiles as $file) {
            $path = $file->store('school-activity-gallery', 'public');
            $activity->galleryImages()->create([
                'image_path' => 'storage/' . $path,
                'sort_order' => ++$maxOrder,
            ]);
        }
        $this->galleryFiles = [];
        $this->resetValidation();
        session()->flash('success', 'Gallery images added.');
    }

    public function removeGalleryImage(int $id): void
    {
        $img = SchoolActivityImage::where('school_activity_id', $this->editingId)->findOrFail($id);
        $img->delete();
        session()->flash('success', 'Image removed from gallery.');
    }

    protected function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug = $base;
        $q = SchoolActivity::where('slug', $slug);
        if ($excludeId) {
            $q->where('id', '!=', $excludeId);
        }
        $n = 0;
        while ($q->exists()) {
            $n++;
            $slug = $base . '-' . $n;
            $q = SchoolActivity::where('slug', $slug);
            if ($excludeId) {
                $q->where('id', '!=', $excludeId);
            }
        }
        return $slug;
    }

    protected function resetForm(): void
    {
        $this->title = '';
        $this->excerpt = null;
        $this->content = null;
        $this->image = null;
        $this->image_path = null;
        $this->published_at = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getActivitiesProperty()
    {
        return SchoolActivity::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('slug', 'like', '%' . $this->search . '%'))
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10);
    }

    public function render()
    {
        $editActivity = $this->editingId
            ? SchoolActivity::with('galleryImages')->find($this->editingId)
            : null;

        return view('livewire.admin.school-activities.index', [
            'activities' => $this->activities,
            'editActivity' => $editActivity,
        ]);
    }
}
