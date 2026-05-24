<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'logo_path',
        // Home / hero
        'home_background_image_path',
        'home_background_text',
        // Home CTA
        'cta_background_image_path',
        'cta_title',
        'cta_description',
        // About page
        'about_description',
        'about_heading',
        'about_values_subheading',
        'about_value_cards',
        'affiliate_schools',
        // Contacts
        'email',
        'phone_reception',
        'phone_urgency',
        'phone_whatsapp',
        'phone_billing',
        'phone_restaurant',
        'address',
        'map_embed_url',
        // Mission / vision / values
        'mission',
        'vision',
        'core_values',
        // Socials
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'x_url',
        'threads_url',
        // Gallery override
        'gallery_external_url',
        // Typography
        'site_font_family',
        'site_font_css_url',
        // Registration banner
        'registration_academic_year',
        'registration_message',
        'page_sections',
    ];

    protected $casts = [
        'about_value_cards' => 'array',
        'affiliate_schools' => 'array',
        'page_sections' => 'array',
    ];
}

