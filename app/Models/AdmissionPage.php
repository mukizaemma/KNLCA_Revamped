<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionPage extends Model
{
    protected $table = 'admission_page';

    protected $fillable = [
        'intro_label',
        'intro_title',
        'intro_subtitle',
        'featured_badge',
        'process_heading',
        'admission_process',
        'first_admission_heading',
        'first_admission_intro',
        'first_admission_documents',
        'transfer_heading',
        'transfer_intro',
        'transfer_documents',
        'cta_title',
        'cta_text',
        'cta_primary_btn',
        'cta_secondary_btn',
    ];

    protected $casts = [
        'first_admission_documents' => 'array',
        'transfer_documents' => 'array',
    ];

    /**
     * Get the single admission page content (singleton row).
     */
    public static function content(): self
    {
        $row = self::first();
        if ($row) {
            return $row;
        }
        return self::create([
            'intro_label' => 'Join us',
            'intro_title' => 'Admissions for Nursery & Primary',
            'intro_subtitle' => 'ACE curriculum enrollment—clear steps for new families and transfers.',
            'featured_badge' => 'Most common',
            'process_heading' => 'Admission Process',
            'admission_process' => "1. Attend Admission Tour, Open House\n2. Submit Application & Letter of recommendation or transfer if a child is from an ACE school or Home school\n3. Student Assessment & Parent Interview\n4. Receipt of results of Application (Accepted, Denied, Waitlist)\n5. If accepted, New Family Conference, 25% deposit, & Reserve student's spot.",
            'first_admission_heading' => 'First Admission',
            'first_admission_intro' => 'A parent/guardian must complete an application form for admission of his/her child to the school. The following documents must accompany the application:',
            'transfer_heading' => 'Transfer from another school',
            'transfer_intro' => 'A parent/guardian must complete an application form for admission of his/her child to the school. The following documents must accompany the application:',
            'first_admission_documents' => [
                'A certified copy of the learner\'s original birth certificate/identity document.',
                'Proof of residence.',
                'Learner card to be completed.',
                'The necessary documents must be submitted to the school before the end of the term of admission.',
            ],
            'transfer_documents' => [
                'A certified copy of the learner\'s original birth certificate/identity document.',
                'Proof of residence.',
                'Learner card to be completed.',
                'The necessary documents must be submitted to the school before the end of the term of admission.',
            ],
            'cta_title' => 'Start your application',
            'cta_text' => 'Register online or visit us to meet our team and tour the campus.',
            'cta_primary_btn' => 'Register your child',
            'cta_secondary_btn' => 'Schedule a school visit',
        ]);
    }
}
