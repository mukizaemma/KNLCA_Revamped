@section('title', 'School Activities')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">School Activities (Articles)</h4>
            <div class="d-flex flex-wrap gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search..." wire:model.debounce.300ms="search" style="min-width: 220px;">
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Activity
                </button>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <p class="text-muted small mb-3">
            Active activities appear on the public <a href="{{ route('school-activities') }}" target="_blank">School Activities</a> page.
            Set <strong>Published At</strong> (or leave the default) and keep <strong>Active</strong> on.
        </p>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th style="width: 90px;">Image</th>
                        <th>Title</th>
                        <th style="width: 120px;">Published</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $a)
                        <tr>
                            <td>
                                @if($a->image_path)
                                    <img src="{{ asset($a->image_path) }}" alt="" class="rounded border" style="height: 50px; width: 70px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>{{ $a->title }}</td>
                            <td class="small">{{ $a->published_at?->format('M j, Y') ?: '—' }}</td>
                            <td class="text-center">
                                @if($a->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $a->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $a->id }})" onclick="return confirm('Delete this activity?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No school activities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $activities->links() }}</div>
    </div>

    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Activity' : 'New Activity' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="activity-form">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" wire:model.defer="title">
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control summernote" wire:model.defer="content" rows="8" data-summernote-height="280"></textarea>
                                <small class="text-muted">Public list pages show a short preview; the full description appears on the activity page.</small>
                                @error('content') <small class="text-danger d-block">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Featured Image</label>
                                <input type="file" class="form-control" wire:model="image" accept="image/*">
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 100px;">
                                @elseif($image_path)
                                    <img src="{{ asset($image_path) }}" alt="Current" class="img-fluid rounded mt-2" style="max-height: 100px;">
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Published At</label>
                                    <input type="datetime-local" class="form-control" wire:model.defer="published_at">
                                    <small class="text-muted">Leave blank to publish immediately. Future dates stay hidden until then.</small>
                                    @error('published_at') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" class="form-control" wire:model.defer="sort_order" min="0">
                                    @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" wire:model.defer="is_active">
                                <label class="form-check-label">Active</label>
                            </div>

                            @if($editingId && $editActivity)
                                <hr class="my-4">
                                <h6 class="mb-2"><i class="fa fa-images me-1"></i> Event gallery</h6>
                                <p class="small text-muted mb-2">Add photos for this activity. They will appear on the public activity page.</p>
                                @if($editActivity->galleryImages->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        @foreach($editActivity->galleryImages as $gimg)
                                            <div class="position-relative border rounded overflow-hidden" style="width: 80px; height: 80px;">
                                                <img src="{{ asset($gimg->image_path) }}" alt="" class="w-100 h-100" style="object-fit: cover;">
                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" wire:click="removeGalleryImage({{ $gimg->id }})" title="Remove">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="d-flex flex-wrap align-items-end gap-2">
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control form-control-sm" wire:model="galleryFiles" multiple accept="image/*">
                                        @error('galleryFiles') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                        @error('galleryFiles.*') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addGalleryImages" wire:loading.attr="disabled">
                                        <i class="fa fa-plus me-1"></i> Add to gallery
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeFormModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="activity-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
