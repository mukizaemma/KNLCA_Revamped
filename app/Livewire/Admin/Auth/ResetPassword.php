<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-auth')]
class ResetPassword extends Component
{
    public string $token;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function mount(string $token, string $email = ''): void
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function resetPassword(): void
    {
        $this->validate();

        $status = Password::broker()->reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            $this->redirectRoute('admin.login');
        } else {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.reset-password');
    }
}

