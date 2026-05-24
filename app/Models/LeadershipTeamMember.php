<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipTeamMember extends Model
{
    use HasFactory;

    protected $table = 'leadership_team';

    protected $fillable = [
        'full_name',
        'position',
        'phone',
        'email',
        'biography',
        'profile_image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
