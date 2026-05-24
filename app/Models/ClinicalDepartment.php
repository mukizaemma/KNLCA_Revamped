<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'gallery',
        'is_active',
        'sort_order',
    ];

    public function services()
    {
        return $this->hasMany(ClinicalService::class, 'clinical_department_id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'clinical_department_id');
    }
}

