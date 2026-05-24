<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-auth')]
class ForgotPassword extends Component
{
    public string $email = '';

    protected $rules = [
        'email' => ['required', 'email'],
    ];

    public function sendResetLink(): void
    {
        $this->validate();

        $status = Password::broker()->sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.forgot-password');
    }
}

