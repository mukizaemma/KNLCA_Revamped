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
        
        // Check if user has admin role
        if (!in_array($user->role, ['super_admin', 'website_admin'])) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => __('You do not have permission to access the admin panel.'),
            ]);
        }

        session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
