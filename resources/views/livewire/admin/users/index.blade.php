@section('title', 'Users & Staff Management')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Users & Staff</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search name, email, phone..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <select class="form-select form-select-sm" wire:model="roleFilter" style="min-width: 140px;">
                    <option value="all">All Roles</option>
                    @foreach($allowedRoles as $allowedRole)
                        <option value="{{ $allowedRole }}">{{ ucfirst(str_replace('_', ' ', $allowedRole)) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New User
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center" style="width: 120px;">Role</th>
                        <th class="text-center" style="width: 100px;">Created</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?: '—' }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                            </td>
                            <td class="text-center">{{ $user->created_at?->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $user->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $user->id }})" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $users->links() }}</div>
    </div>

    {{-- Form Modal --}}
    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit User' : 'New User' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="user-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" wire:model.defer="name">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" wire:model.defer="email">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" wire:model.defer="phone" style="max-width: 240px;">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select" wire:model.defer="role" style="max-width: 240px;">
                                    @foreach($allowedRoles as $allowedRole)
                                        <option value="{{ $allowedRole }}">{{ ucfirst(str_replace('_', ' ', $allowedRole)) }}</option>
                                    @endforeach
                                </select>
                                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Biography <small class="text-muted">(optional)</small></label>
                                <textarea class="form-control summernote" wire:model.defer="biography" rows="3"></textarea>
                                @error('biography') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Password
                                    @if($editingId)
                                        <small class="text-muted">(leave blank to keep current)</small>
                                    @endif
                                </label>
                                <input type="password" class="form-control" wire:model.defer="password" style="max-width: 280px;">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeFormModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="user-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
