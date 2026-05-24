<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolActivityImage extends Model
{
    protected $fillable = [
        'school_activity_id',
        'image_path',
        'caption',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function schoolActivity(): BelongsTo
    {
        return $this->belongsTo(SchoolActivity::class);
    }
}
