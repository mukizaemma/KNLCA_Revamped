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

    /** Plain-text teaser for listing cards. */
    public function shortDescription(int $limit = 100): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($this->description ?? ''))) ?? '');

        return $text === '' ? '' : \Illuminate\Support\Str::limit($text, $limit);
    }
}

