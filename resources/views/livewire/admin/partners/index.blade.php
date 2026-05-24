@section('title', 'Partners')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Partners</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search partners..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Partner
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
                        <th style="width: 80px;">Logo</th>
                        <th>Name</th>
                        <th>Website</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $p)
                        <tr>
                            <td>
                                @if($p->logo_path)
                                    <img src="{{ asset($p->logo_path) }}" alt="" class="rounded" style="height: 40px; width: auto;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $p->name }}</td>
                            <td>
                                @if($p->website_url)
                                    <a href="{{ $p->website_url }}" target="_blank" rel="noopener noreferrer" class="text-truncate d-inline-block" style="max-width: 180px;">{{ $p->website_url }}</a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $p->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $p->id }})" onclick="return confirm('Delete this partner?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No partners found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $partners->links() }}</div>
    </div>

    {{-- Form Modal --}}
    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Partner' : 'New Partner' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="partner-form">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" wire:model.defer="name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Logo</label>
                                <input type="file" class="form-control" wire:model="logo" accept="image/*">
                                @error('logo') <small class="text-danger">{{ $message }}</small> @enderror
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 80px;">
                                @elseif($logo_path)
                                    <img src="{{ asset($logo_path) }}" alt="Current" class="img-fluid rounded mt-2" style="max-height: 80px;">
                                @endif
                                @if(!$editingId)
                                    <small class="text-muted d-block">Required for new partner.</small>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Website URL</label>
                                <input type="url" class="form-control" wire:model.defer="website_url" placeholder="https://">
                                @error('website_url') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control summernote" wire:model.defer="description" rows="3"></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" wire:model.defer="contact_person">
                                    @error('contact_person') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" wire:model.defer="contact_email">
                                    @error('contact_email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control" wire:model.defer="contact_phone">
                                    @error('contact_phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Display order</label>
                                <input type="number" min="0" class="form-control" wire:model.defer="sort_order" placeholder="Lower numbers appear first">
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
                        <button type="submit" class="btn btn-primary" form="partner-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
