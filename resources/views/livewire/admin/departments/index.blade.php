@section('title', 'Programs / Curriculum')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Programs / Curriculum</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search programs..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Program
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
                        <th style="width: 90px;">Cover Image</th>
                        <th>Program Name</th>
                        <th style="min-width: 180px;">Short Description</th>
                        <th class="text-center" style="width: 100px;">Images</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                        @php
                            $galleryPaths = $dept->gallery ? (array) json_decode($dept->gallery, true) : [];
                            $galleryCount = count($galleryPaths);
                            $shortDesc = $dept->description ? \Illuminate\Support\Str::limit(strip_tags($dept->description), 80) : '—';
                        @endphp
                        <tr>
                            <td>
                                @if($dept->cover_image)
                                    <img src="{{ asset($dept->cover_image) }}" alt="" class="rounded border" style="height: 50px; width: 70px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>{{ $dept->name }}</td>
                            <td class="small text-muted">{{ $shortDesc }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $galleryCount }}</span>
                            </td>
                            <td class="text-center">
                                @if($dept->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-info me-1" wire:click="openGalleryModal({{ $dept->id }})">
                                    <i class="fa fa-images"></i> Gallery
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $dept->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $dept->id }})" onclick="return confirm('Delete this department?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No programs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $departments->links() }}</div>
    </div>

    {{-- Form Modal (Add/Edit Department) --}}
    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Program' : 'New Program' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="department-form">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" wire:model.defer="name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control summernote" wire:model.defer="description" rows="4"></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cover Image</label>
                                <input type="file" class="form-control" wire:model="cover_image" accept="image/*">
                                @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
                                @if($cover_image)
                                    <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 100px;">
                                @elseif($cover_image_path)
                                    <img src="{{ asset($cover_image_path) }}" alt="Current" class="img-fluid rounded mt-2" style="max-height: 100px;">
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
                        <button type="submit" class="btn btn-primary" form="department-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Gallery Modal --}}
    @if($showGalleryModal && $galleryDepartmentId)
        @php $galleryDept = \App\Models\ClinicalDepartment::find($galleryDepartmentId); @endphp
        @if($galleryDept)
            <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-images me-2"></i>Gallery — {{ $galleryDept->name }}</h5>
                            <button type="button" class="btn-close" wire:click="closeGalleryModal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Add multiple images</label>
                                <input type="file" class="form-control" wire:model="gallery_images" accept="image/*" multiple>
                                <small class="text-muted d-block mt-1">Select one or more images at once (use Ctrl/Cmd+Click or Shift+Click to select multiple files).</small>
                                @error('gallery_images') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                @error('gallery_images.*') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                @php $n = is_array($gallery_images) ? count($gallery_images) : ($gallery_images ? 1 : 0); @endphp
                                @if($n > 0)
                                    <small class="text-primary d-block mt-1">{{ $n }} image(s) selected — click the button below to upload.</small>
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary mb-3" wire:click="addGalleryImages" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="addGalleryImages">Upload selected image(s)</span>
                                <span wire:loading wire:target="addGalleryImages">Uploading...</span>
                            </button>

                            <hr>
                            <h6 class="mb-2">Current gallery</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($galleryPaths as $gIndex => $gPath)
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset($gPath) }}" alt="Gallery" class="rounded border" style="height: 70px; width: auto;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" wire:click="removeGalleryImage({{ $galleryDepartmentId }}, {{ $gIndex }})" onclick="return confirm('Remove this image?')">&times;</button>
                                    </div>
                                @endforeach
                                @if(empty($galleryPaths))
                                    <span class="text-muted small">No gallery images yet. Add some above.</span>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeGalleryModal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
