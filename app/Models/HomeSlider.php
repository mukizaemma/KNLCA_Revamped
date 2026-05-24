<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'title',
        'caption',
        'button_text',
        'button_url',
        'is_active',
        'sort_order',
    ];
}

