<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'reason',
        'visit_datetime',
        'what_to_see',
        'has_student',
        'student_name',
        'student_grade',
    ];
}

