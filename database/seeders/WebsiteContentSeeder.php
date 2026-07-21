<?php

namespace Database\Seeders;

use App\Models\PageHeader;
use App\Models\WebsiteSetting;
use App\Support\SiteContent;
use Illuminate\Database\Seeder;

class WebsiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = SiteContent::defaults();

        $coreValueCards = [
            ['name' => 'Integrity', 'description' => 'We are committed to honesty and strong moral principles in every aspect of school life.'],
            ['name' => 'Learning', 'description' => 'We foster a culture of continuous learning for both students and staff.'],
            ['name' => 'Community', 'description' => 'Families, staff, and students work together to build a caring school community.'],
            ['name' => 'Excellence', 'description' => 'We encourage every learner to reach their full potential in academics and character.'],
        ];

        $defaults['about']['core_value_cards'] = $coreValueCards;

        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([
            'company_name' => 'New Life Christian Academy Kigali',
        ]);

        $existingSections = is_array($settings->page_sections)
            ? $settings->page_sections
            : (is_string($settings->page_sections) ? (json_decode($settings->page_sections, true) ?: []) : []);

        $settings->page_sections = SiteContent::merge($defaults, $existingSections);

        if (empty($settings->about_value_cards)) {
            $settings->about_value_cards = $coreValueCards;
        }

        if (empty($settings->about_values_subheading)) {
            $settings->about_values_subheading = 'Growing hearts and minds through ACE';
        }

        if (empty($settings->company_name)) {
            $settings->company_name = 'New Life Christian Academy Kigali';
        }

        $settings->save();

        $headers = [
            'about' => ['title' => 'About us', 'caption' => 'Know our story, values, and community'],
            'about_mission' => ['title' => 'Mission & vision', 'caption' => 'What drives us forward'],
            'about_values' => ['title' => 'Core values', 'caption' => 'Principles that shape our school'],
            'about_staff' => ['title' => 'Our staff', 'caption' => 'Educators who nurture every child'],
            'about_history' => ['title' => 'Our history', 'caption' => 'How we grew into who we are'],
            'about_schools' => ['title' => 'Our schools', 'caption' => 'The New Life family of campuses'],
            'about_inquire' => ['title' => 'Get in touch', 'caption' => 'We are glad to hear from you'],
            'departments' => ['title' => 'Academics', 'caption' => 'ACE-aligned nursery and primary programs'],
            'admissions' => ['title' => 'Admissions', 'caption' => 'Begin your child\'s journey with us'],
            'register' => ['title' => 'Register', 'caption' => 'Start online registration'],
            'visit_school' => ['title' => 'Visit our school', 'caption' => 'Schedule a campus visit'],
            'facilities' => ['title' => 'Facilities', 'caption' => 'Spaces designed for learning and play'],
            'leadership' => ['title' => 'Our staff', 'caption' => 'Meet our team'],
            'school_activities' => ['title' => 'School activities', 'caption' => 'Life beyond the classroom'],
            'careers' => ['title' => 'Careers', 'caption' => 'Join our mission'],
            'gallery' => ['title' => 'Gallery', 'caption' => 'Moments from campus life'],
            'contact' => ['title' => 'Contact us', 'caption' => 'Reach the school office'],
            'feedback' => ['title' => 'Feedback', 'caption' => 'Help us serve families better'],
        ];

        foreach ($headers as $key => $data) {
            PageHeader::updateOrCreate(
                ['page_key' => $key],
                [
                    'title' => $data['title'],
                    'caption' => $data['caption'],
                ]
            );
        }

        $this->command?->info('Website page content, core values, and page headers seeded.');
    }
}
