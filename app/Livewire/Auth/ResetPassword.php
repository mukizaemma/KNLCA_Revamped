<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class ResetPassword extends Component
{
    public string $token = '';
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

    public function mount(string $token, ?string $email = null): void
    {
        $this->token = $token;
        $this->email = $email ?? request()->query('email', '');
    }

    public function resetPassword(): void
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill(['password' => $password])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            $this->redirectRoute('login', navigate: true);
        } else {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
