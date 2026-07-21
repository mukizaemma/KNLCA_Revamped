<?php

namespace App\Support;

use App\Models\WebsiteSetting;

class SiteContent
{
    public static function defaults(): array
    {
        return [
            'global' => [
                'meta_description' => 'ACE curriculum nursery & primary school in Rwanda. Mastery-based learning, character development, and a caring community for your child.',
                'topbar_tagline' => 'Raising generations of Christian leaders',
                'footer_menu_heading' => 'Our School',
                'developer_credit' => 'Developed by <a href="https://iremetech.com" target="_blank" rel="noopener noreferrer">Ireme Technologies</a>',
            ],
            'home' => [
                'hero_primary_text' => 'Learn about us',
                'hero_primary_url' => '/about#inquire',
                'hero_secondary_text' => 'Register your child',
                'hero_secondary_url' => '/appointment',
                'overview_label' => 'School overview',
                'overview_fallback' => 'A warm, safe, and inspiring ACE school where nursery and primary children discover their potential—with dedicated teachers and a vibrant community in Rwanda.',
                'overview_link_text' => 'More About Our School',
                'curriculum_label' => 'Curriculum overview',
                'curriculum_title' => 'Accredited ACE Curriculum',
                'curriculum_intro' => 'We combine mastery-based ACE learning with caring, Christ-centred teaching—helping every child grow in knowledge, character, and confidence here in Rwanda.',
                'curriculum_subtitle' => 'Helping Children Grow in Knowledge, Character & Faith',
                'curriculum_pillars' => [
                    ['title' => 'Mastery Learning', 'description' => 'Building strong academic skills through mastery-based learning—children progress at their own pace until concepts are truly understood.'],
                    ['title' => 'Godly Perspective', 'description' => 'Teaching students to see the world from a biblical viewpoint—building integrity, respect, and servant hearts.'],
                    ['title' => 'Critical Thinking', 'description' => 'Encouraging problem-solving and independent thinking so every learner grows confident and curious.'],
                ],
                'curriculum_link_text' => 'Learn more',
                'programs_label' => 'Programs',
                'programs_title' => 'Nursery & Primary Programs',
                'programs_subtitle' => 'Explore our ACE-aligned levels—from playful early years through confident primary graduates.',
                'programs_link_text' => 'View all programs',
                'programs_card_fallback' => 'ACE-aligned learning for this level.',
                'why_choose_label' => 'Our values',
                'why_choose_title' => 'Our Core Values',
                'why_choose_empty' => 'Edit core value cards in Admin → Page Content → About to highlight what makes your school special for parents.',
                'explore_label' => 'Discover more',
                'explore_title' => 'Explore Our School',
                'explore_subtitle' => 'Take a closer look at academics, campus life, and the activities that shape every day at NLCA.',
                'explore_link_text' => 'Learn more',
                'explore_cards' => [
                    ['key' => 'academics', 'title' => 'Academics', 'description' => 'Learn about our ACE-based educational programs.', 'url' => '/departments'],
                    ['key' => 'facilities', 'title' => 'Facilities', 'description' => 'Discover our modern and welcoming campus.', 'url' => '/facilities'],
                    ['key' => 'activities', 'title' => 'School Activities', 'description' => 'See the fun and enriching activities we offer.', 'url' => '/school-activities'],
                ],
                'news_label' => 'Campus life',
                'news_title' => 'Life at NLCA-K',
                'news_link_text' => 'View full gallery',
                'news_empty' => 'Photos will appear here once added in Admin → Gallery.',
                'show_cta' => '1',
            ],
            'about' => [
                'overview_label' => 'School overview',
                'overview_fallback' => 'We are a Christ-centred nursery and primary school in Rwanda, offering the Accelerated Christian Education (ACE) curriculum in a safe, caring environment.',
                'mission_vision_title' => 'Our mission & vision',
                'core_values_title' => 'Our core values',
                'core_value_cards' => [
                    ['name' => 'Integrity', 'description' => 'We are committed to honesty and strong moral principles in every aspect of school life.'],
                    ['name' => 'Learning', 'description' => 'We foster a culture of continuous learning for both students and staff.'],
                    ['name' => 'Community', 'description' => 'Families, staff, and students work together to build a caring school community.'],
                    ['name' => 'Excellence', 'description' => 'We encourage every learner to reach their full potential in academics and character.'],
                ],
                'history_title' => 'Our history',
                'history_intro' => 'How New Life Christian Academy Kigali grew into the ACE nursery and primary school we are today.',
                'history_body' => '<p>Share your school story here—founding, milestones, and the community that shaped your campus. Edit this in Admin → Page Content → About.</p>',
                'staff_label' => 'Our team',
                'staff_title' => 'Our staff',
                'staff_subtitle' => 'Educators and leaders who nurture every child on their ACE learning journey.',
                'staff_empty' => 'Staff profiles will appear here once added in Admin → Leadership.',
                'affiliate_label' => 'New Life family',
                'affiliate_title' => 'Quick Links',
                'affiliate_subtitle' => 'Other New Life Christian Academy campuses and affiliate schools.',
                'affiliate_empty' => 'Add affiliate schools in Admin → Settings when you are ready to list other campuses.',
                'inquire_label' => 'Contact us',
                'inquire_title' => 'Send us a message',
                'inquire_subtitle' => 'General questions, admissions, partnerships—or schedule a visit to our campus.',
                'enroll_cta_title' => 'Ready to enrol?',
                'enroll_cta_text' => 'Start your child’s registration online.',
                'enroll_primary_btn' => 'Register your child',
                'enroll_secondary_btn' => 'Admissions info',
            ],
            'facilities' => [
                'section_label' => 'Our campus',
                'section_title' => 'Spaces for learning & play',
                'section_intro' => 'Safe, bright classrooms, playgrounds, and resources that support ACE mastery learning from nursery through primary.',
                'empty' => 'Facilities will be listed here. Add them in the admin panel.',
                'cta_title' => 'See our campus in person',
                'cta_text' => 'Parents and partners are welcome to schedule a guided tour.',
                'cta_btn' => 'Schedule a visit',
            ],
            'contact' => [
                'form_label' => 'Contact',
                'form_title' => 'Get in touch',
                'form_subtitle' => 'Questions about ACE programs, visits, or enrollment? We’re happy to help.',
                'submission_help' => 'Choose WhatsApp to open a pre-filled message, or Email to send your enquiry to the school.',
                'whatsapp_help' => 'Opens WhatsApp with your message—use a phone number that has WhatsApp.',
                'email_help' => 'Saves your enquiry and emails the school (and a copy to you when possible).',
            ],
            'departments' => [
                'section_label' => 'ACE curriculum',
                'section_title' => 'Nursery & Primary Programs',
                'section_subtitle' => 'Mastery-based learning paths from early years through primary—each level builds confidence, character, and academic strength.',
                'card_fallback' => 'ACE-aligned learning with caring teachers in a safe, engaging environment.',
            ],
            'activities' => [
                'section_label' => 'School life',
                'section_title' => 'News, events & activities',
                'section_intro' => 'Sports, clubs, celebrations, and community moments that make our nursery and primary school vibrant.',
                'empty' => 'No activities yet. Check back soon.',
            ],
            'gallery' => [
                'section_label' => 'Gallery',
                'section_title' => 'Life at our school',
                'section_subtitle' => 'Classrooms, play, celebrations, and everyday joy across nursery and primary.',
                'empty' => 'No gallery items yet.',
            ],
            'careers' => [
                'section_label' => 'Join our team',
                'section_title' => 'Careers at our ACE school',
                'section_intro' => 'We welcome passionate educators and staff who share our mission—nurturing nursery and primary learners through excellence, character, and faith.',
                'body' => '<p>Open positions and application details can be shared here. For now, reach out to learn about teaching and support roles at our school in Rwanda.</p>',
                'cta_title' => 'Interested in joining our team?',
                'cta_btn' => 'Contact us',
            ],
            'leadership' => [
                'section_label' => 'Our team',
                'section_title' => 'Educators & Leaders',
                'section_subtitle' => 'Dedicated staff guiding every child through their ACE learning journey.',
            ],
            'feedback' => [
                'section_label' => 'Your voice matters',
                'section_title' => 'Share your feedback',
                'section_subtitle' => 'Parents, partners, and community members—we welcome your suggestions to help our ACE school grow.',
            ],
            'registration' => [
                'intro' => 'This form is the first step to registering at {school_name}.',
                'academic_levels' => ['Nursery', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'],
                'success_title' => 'Application received',
                'success_message' => 'Thank you for registering. We will be in touch regarding the next steps.',
                'fallback_sidebar' => 'Registration is now open. Complete the form to start the admission process for your child.',
                'submission_help' => 'Choose one option. We save your application in our system, then continue via WhatsApp or email using the contact details for your selected primary contact.',
                'whatsapp_help' => 'Opens WhatsApp with a summary—you must have WhatsApp on the phone number entered above.',
                'email_help' => 'Sends confirmation to the school and to your primary contact email.',
            ],
        ];
    }

    public static function merge(array $defaults, ?array $stored): array
    {
        if (empty($stored)) {
            return $defaults;
        }

        return array_replace_recursive($defaults, $stored);
    }

    public static function for(?WebsiteSetting $settings): array
    {
        $stored = $settings?->page_sections;
        if (is_string($stored)) {
            $stored = json_decode($stored, true);
        }

        return self::merge(self::defaults(), is_array($stored) ? $stored : []);
    }

    public static function get(?WebsiteSetting $settings, string $path, mixed $default = null): mixed
    {
        $data = self::for($settings);

        foreach (explode('.', $path) as $segment) {
            if (! is_array($data) || ! array_key_exists($segment, $data)) {
                return $default;
            }
            $data = $data[$segment];
        }

        return $data;
    }

    public static function replacePlaceholders(string $text, ?WebsiteSetting $settings): string
    {
        $school = $settings?->company_name ?? config('app.name');

        return str_replace('{school_name}', $school, $text);
    }

    public static function hasRichTextContent(?string $html): bool
    {
        if ($html === null || trim($html) === '') {
            return false;
        }

        $text = html_entity_decode(strip_tags(str_replace(
            ['<br>', '<br/>', '<br />', '&nbsp;'],
            ' ',
            $html
        )));

        return trim(preg_replace('/\s+/u', ' ', $text)) !== '';
    }
}
