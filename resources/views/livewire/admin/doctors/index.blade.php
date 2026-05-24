@section('title', 'Doctors')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Doctors</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search name, position, email, phone..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <select class="form-select form-select-sm" wire:model="departmentFilter" style="min-width: 160px;">
                    <option value="">All Departments</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Doctor
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
                        <th style="width: 70px;">Photo</th>
                        <th>Full Name</th>
                        <th style="width: 160px;">Department</th>
                        <th style="width: 140px;">Position</th>
                        <th style="width: 120px;">Phone</th>
                        <th style="width: 160px;">Email</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doc)
                        <tr>
                            <td>
                                @if($doc->profile_image)
                                    <img src="{{ asset($doc->profile_image) }}" alt="" class="rounded-circle border" style="height: 44px; width: 44px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center text-muted" style="height: 44px; width: 44px;">
                                        <i class="fa fa-user"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $doc->full_name }}</td>
                            <td>{{ $doc->department->name ?? '—' }}</td>
                            <td>{{ $doc->position }}</td>
                            <td class="small">{{ $doc->phone ?: '—' }}</td>
                            <td class="small">{{ $doc->email ?: '—' }}</td>
                            <td class="text-center">
                                @if($doc->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $doc->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $doc->id }})" onclick="return confirm('Remove this doctor?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No doctors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $doctors->links() }}</div>
    </div>

    {{-- Form Modal (Add/Edit Doctor) --}}
    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Doctor' : 'New Doctor' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="doctor-form">
                            <div class="mb-3">
                                <label class="form-label">Profile Image</label>
                                <input type="file" class="form-control" wire:model="profile_image" accept="image/*">
                                @error('profile_image') <small class="text-danger">{{ $message }}</small> @enderror
                                @if($profile_image)
                                    <img src="{{ $profile_image->temporaryUrl() }}" alt="Preview" class="rounded-circle mt-2 border" style="height: 80px; width: 80px; object-fit: cover;">
                                @elseif($profile_image_path)
                                    <img src="{{ asset($profile_image_path) }}" alt="Current" class="rounded-circle mt-2 border" style="height: 80px; width: 80px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model.defer="full_name">
                                    @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department <span class="text-danger">*</span></label>
                                    <select class="form-select" wire:model.defer="clinical_department_id">
                                        <option value="">-- Select department --</option>
                                        @foreach($departments as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('clinical_department_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model.defer="position" placeholder="e.g. Senior Consultant, Resident">
                                @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" wire:model.defer="phone">
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" wire:model.defer="email">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Biography</label>
                                <textarea class="form-control summernote" wire:model.defer="biography" rows="4"></textarea>
                                @error('biography') <small class="text-danger">{{ $message }}</small> @enderror
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
                        <button type="submit" class="btn btn-primary" form="doctor-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
