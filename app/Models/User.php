<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const SUPER_ADMIN_EMAIL = 'admin@iremetech.com';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'biography',
        'session_version',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'session_version' => 'integer',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin'
            && strcasecmp((string) $this->email, self::SUPER_ADMIN_EMAIL) === 0;
    }

    public function isWebsiteAdmin(): bool
    {
        return $this->role === 'website_admin' || $this->isSuperAdmin();
    }

    public function bumpSessionVersion(): void
    {
        $this->forceFill([
            'session_version' => ((int) $this->session_version) + 1,
        ])->save();
    }
}
