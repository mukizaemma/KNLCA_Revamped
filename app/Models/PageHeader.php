<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'title',
        'caption',
        'image_path',
    ];
}

