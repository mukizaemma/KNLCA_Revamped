<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'image_path',
        'video_url',
        'title',
        'caption',
        'is_featured',
        'is_active',
        'sort_order',
    ];
}

