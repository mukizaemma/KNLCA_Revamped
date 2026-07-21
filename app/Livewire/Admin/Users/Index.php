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
    public string $role = 'website_admin';
    public ?string $password = null;

    protected function allowedRolesForCurrentUser(): array
    {
        if (! auth()->user()?->isSuperAdmin()) {
            return [];
        }

        // Super admin may create website admins and guests — never another super_admin.
        return ['website_admin', 'management_staff', 'clinical_staff', 'guest'];
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
                function ($attribute, $value, $fail) {
                    if (strcasecmp((string) $value, User::SUPER_ADMIN_EMAIL) === 0 && $this->editingId !== auth()->id()) {
                        $fail('This email is reserved for the system super admin.');
                    }
                },
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
        $this->role = $user->role === 'super_admin' ? 'website_admin' : $user->role;
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

        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        if ($this->editingId) {
            $user = $this->findManagedUserOrFail($this->editingId);

            if ($user->isSuperAdmin()) {
                session()->flash('error', 'The system super admin account cannot be edited here.');

                return;
            }

            $user->update($payload);

            if (! empty($data['password'])) {
                $user->bumpSessionVersion();
            }

            session()->flash('success', 'User updated successfully.');
        } else {
            User::create($payload);
            session()->flash('success', 'User created successfully.');
        }

        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function forceLogout(int $userId): void
    {
        $this->authorizeAccess();

        $user = $this->findManagedUserOrFail($userId);

        if ($user->isSuperAdmin() || auth()->id() === $user->id) {
            session()->flash('error', 'You cannot force-logout this account.');

            return;
        }

        $user->bumpSessionVersion();
        session()->flash('success', 'User will be signed out on their next request.');
    }

    public function delete(int $userId): void
    {
        $this->authorizeAccess();

        $user = $this->findManagedUserOrFail($userId);

        if (auth()->id() === $user->id || $user->isSuperAdmin()) {
            session()->flash('error', 'You cannot delete this account.');

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
        return User::where('id', $userId)
            ->where(function ($q) {
                $q->where('email', '!=', User::SUPER_ADMIN_EMAIL)
                    ->orWhere('id', auth()->id());
            })
            ->firstOrFail();
    }

    protected function authorizeAccess(): void
    {
        if (! auth()->user()?->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->biography = '';
        $this->role = 'website_admin';
        $this->password = '';
    }

    public function getUsersProperty()
    {
        $query = User::query()
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            });

        if ($this->roleFilter !== 'all') {
            $query->where('role', $this->roleFilter);
        }

        return $query->orderByRaw('CASE WHEN email = ? THEN 0 ELSE 1 END', [User::SUPER_ADMIN_EMAIL])
            ->orderBy('name')
            ->paginate(10);
    }

    public function render()
    {
        $this->authorizeAccess();

        return view('livewire.admin.users.index', [
            'users' => $this->users,
            'allowedRoles' => $this->allowedRolesForCurrentUser(),
        ]);
    }
}
