@section('title', 'Facilities')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Facilities</h4>
            <div class="d-flex flex-wrap gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search..." wire:model.debounce.300ms="search" style="min-width: 220px;">
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Facility
                </button>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th style="width: 90px;">Image</th>
                        <th>Name</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $f)
                        <tr>
                            <td>
                                @if($f->image_path)
                                    <img
                                        src="{{ asset($f->image_path) }}"
                                        alt="{{ $f->name }}"
                                        class="rounded border"
                                        style="height: 50px; width: 70px; object-fit: cover;"
                                        onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('span'),{className:'text-muted small',textContent:'Missing file'}));"
                                    >
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>{{ $f->name }}</td>
                            <td class="text-center">
                                @if($f->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $f->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $f->id }})" onclick="return confirm('Delete this facility?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No facilities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $facilities->links() }}</div>
    </div>

    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Facility' : 'New Facility' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="facility-form">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" wire:model.defer="name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control summernote" wire:model.defer="description" rows="4"></textarea>
                                <small class="text-muted">List pages show a short preview; the full description appears on the facility page.</small>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image @if(!$editingId)<span class="text-danger">*</span>@endif</label>
                                <input type="file" class="form-control" wire:model="image" accept="image/*">
                                <div wire:loading wire:target="image" class="small text-primary mt-1">Uploading image…</div>
                                @error('image') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 100px;">
                                @elseif($image_path)
                                    <img src="{{ asset($image_path) }}" alt="Current" class="img-fluid rounded mt-2" style="max-height: 100px;">
                                @endif
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
                        <button type="submit" class="btn btn-primary" form="facility-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
