<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image_path',
        'published_at',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function galleryImages(): HasMany
    {
        return $this->hasMany(SchoolActivityImage::class)->orderBy('sort_order');
    }
}
