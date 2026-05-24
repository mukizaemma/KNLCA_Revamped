@section('title', 'Home Slides')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Home Slides</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search title or caption..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Slide
                </button>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th style="width: 100px;">Image</th>
                        <th>Title</th>
                        <th class="text-center" style="width: 80px;">Order</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $s)
                        <tr>
                            <td>
                                @if($s->image_path)
                                    <img src="{{ asset($s->image_path) }}" alt="" class="rounded border" style="height: 50px; width: auto; max-width: 120px; object-fit: cover;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $s->title ?: '—' }}</td>
                            <td class="text-center">{{ $s->sort_order ?? '—' }}</td>
                            <td class="text-center">
                                @if($s->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $s->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $s->id }})" onclick="return confirm('Delete this slide?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No slides found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $sliders->links() }}</div>
    </div>

    {{-- Form Modal --}}
    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Slide' : 'New Slide' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="slider-form">
                            <div class="mb-3">
                                <label class="form-label">Slide Image</label>
                                <input type="file" class="form-control" wire:model="image" accept="image/*">
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 120px;">
                                @elseif($image_path)
                                    <img src="{{ asset($image_path) }}" alt="Current" class="img-fluid rounded mt-2" style="max-height: 120px;">
                                @endif
                                @if(!$editingId)
                                    <small class="text-muted d-block">Required for new slide.</small>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" wire:model.defer="title">
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Caption</label>
                                <textarea class="form-control summernote" wire:model.defer="caption" rows="3"></textarea>
                                @error('caption') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Button Text</label>
                                    <input type="text" class="form-control" wire:model.defer="button_text" placeholder="e.g. Learn More">
                                    @error('button_text') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Button URL</label>
                                    <input type="url" class="form-control" wire:model.defer="button_url" placeholder="https://">
                                    @error('button_url') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" wire:model.defer="sort_order" min="0" style="max-width: 120px;">
                                @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" wire:model.defer="is_active">
                                <label class="form-check-label">Active</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeFormModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="slider-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
