<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinical_department_id',
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

    public function department()
    {
        return $this->belongsTo(ClinicalDepartment::class, 'clinical_department_id');
    }
}
