<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = 'all';
    public bool $showFormModal = false;

    public ?int $editingId = null;
    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public ?string $biography = null;
    public string $role = 'clinical_staff';
    public ?string $password = null;

    protected function allowedRolesForCurrentUser(): array
    {
        $userRole = auth()->user()->role ?? null;

        if ($userRole === 'super_admin') {
            return ['super_admin', 'website_admin', 'management_staff', 'clinical_staff', 'guest'];
        }

        // website_admin can only manage staff members
        if ($userRole === 'website_admin') {
            return ['management_staff', 'clinical_staff'];
        }

        return [];
    }

    protected function rules(): array
    {
        $allowedRoles = $this->allowedRolesForCurrentUser();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->editingId),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'biography' => ['nullable', 'string'],
            'role' => ['required', Rule::in($allowedRoles)],
            'password' => [$this->editingId ? 'nullable' : 'required', 'string', 'min:6'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->authorizeAccess();
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

    public function edit(int $userId): void
    {
        $this->authorizeAccess();

        $user = $this->findManagedUserOrFail($userId);

        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->biography = $user->biography ?? '';
        $this->role = $user->role;
        $this->password = null;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $this->authorizeAccess();

        $data = $this->validate();

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'biography' => $data['biography'] ?? null,
            'role' => $data['role'],
        ];

        if (!empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        if ($this->editingId) {
            $user = $this->findManagedUserOrFail($this->editingId);
            $user->update($payload);
            session()->flash('success', 'User updated successfully.');
        } else {
            User::create($payload);
            session()->flash('success', 'User created successfully.');
        }

        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $userId): void
    {
        $this->authorizeAccess();

        $user = $this->findManagedUserOrFail($userId);

        // Prevent user from deleting themselves
        if (auth()->id() === $user->id) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function findManagedUserOrFail(int $userId): User
    {
        $allowedRoles = $this->allowedRolesForCurrentUser();

        return User::where('id', $userId)
            ->whereIn('role', $allowedRoles)
            ->firstOrFail();
    }

    protected function authorizeAccess(): void
    {
        if (empty($this->allowedRolesForCurrentUser())) {
            abort(403, 'Unauthorized access.');
        }
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->biography = '';
        $this->role = auth()->user()->role === 'website_admin' ? 'clinical_staff' : 'guest';
        $this->password = '';
    }

    public function getUsersProperty()
    {
        $allowedRoles = $this->allowedRolesForCurrentUser();

        $query = User::query()
            ->whereIn('role', $allowedRoles)
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            });

        if ($this->roleFilter !== 'all') {
            $query->where('role', $this->roleFilter);
        }

        return $query->orderBy('name')->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.users.index', [
            'users' => $this->users,
            'allowedRoles' => $this->allowedRolesForCurrentUser(),
        ]);
    }
}

