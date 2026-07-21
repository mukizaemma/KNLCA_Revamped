<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $casts = [
        'visit_date' => 'date',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'subject',
        'inquiry_type',
        'visit_date',
        'visit_time',
        'message',
        'submission_channel',
    ];
}
