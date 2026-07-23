<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Plain-text teaser for listing cards. */
    public function shortDescription(int $limit = 150): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($this->description ?? ''))) ?? '');

        return $text === '' ? '' : \Illuminate\Support\Str::limit($text, $limit);
    }
}
