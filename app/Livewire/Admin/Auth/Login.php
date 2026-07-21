<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;

#[Layout('layouts.admin-auth')]
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

        $user = Auth::user();
        
        // Only real super admin or website_admin may use admin login
        if (! $user->isSuperAdmin() && $user->role !== 'website_admin') {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => __('You do not have permission to access the admin panel.'),
            ]);
        }

        session()->regenerate();
        session(['user_session_version' => (int) $user->session_version]);

        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
