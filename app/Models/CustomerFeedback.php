<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    use HasFactory;

    protected $table = 'customer_feedback';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'message',
        'recommendations',
        'rating_out_of_10',
        'rating_category',
        'clinical_department_id',
        'clinical_service_id',
        'rated_target_label',
        'wants_response',
        'preferred_contact_method',
        'feedback_date',
        'is_approved',
        'is_featured',
        'approved_at',
    ];

    protected $casts = [
        'wants_response' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'feedback_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(ClinicalDepartment::class, 'clinical_department_id');
    }

    public function service()
    {
        return $this->belongsTo(ClinicalService::class, 'clinical_service_id');
    }
}

