<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_first_name',
        'student_last_name',
        'academic_level',
        'date_of_birth',
        'primary_contact',
        'submission_channel',
        'father_full_name',
        'father_email',
        'father_phone',
        'mother_full_name',
        'mother_email',
        'mother_phone',
        'guardian_full_name',
        'guardian_email',
        'guardian_phone',
        'previous_school_name',
        'previous_school_report_path',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function getStudentFullNameAttribute(): string
    {
        return trim($this->student_first_name . ' ' . $this->student_last_name);
    }
}
