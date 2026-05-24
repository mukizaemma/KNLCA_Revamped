<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinical_department_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'gallery',
        'is_active',
        'sort_order',
    ];

    public function department()
    {
        return $this->belongsTo(ClinicalDepartment::class, 'clinical_department_id');
    }
}

