<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.auth')]
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => 'guest',
        ]);

        Auth::login($user);

        session()->regenerate();
        session(['user_session_version' => (int) $user->session_version]);

        // Guests stay on public pages
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
