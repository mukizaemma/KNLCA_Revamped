<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;

#[Layout('layouts.auth')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('The provided credentials do not match our records.'),
            ]);
        }

        session()->regenerate();
        session(['user_session_version' => (int) Auth::user()->session_version]);

        $user = Auth::user();
        
        // Redirect based on user role
        if ($user->isSuperAdmin() || $user->role === 'website_admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
