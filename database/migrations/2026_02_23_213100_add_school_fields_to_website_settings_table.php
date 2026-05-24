<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            // Extra hero/CTA + about fields used by the School settings screen
            if (! Schema::hasColumn('website_settings', 'cta_background_image_path')) {
                $table->string('cta_background_image_path')->nullable()->after('home_background_text');
            }

            if (! Schema::hasColumn('website_settings', 'cta_title')) {
                $table->string('cta_title')->nullable()->after('cta_background_image_path');
            }

            if (! Schema::hasColumn('website_settings', 'cta_description')) {
                $table->longText('cta_description')->nullable()->after('cta_title');
            }

            if (! Schema::hasColumn('website_settings', 'about_heading')) {
                $table->string('about_heading')->nullable()->after('about_description');
            }

            if (! Schema::hasColumn('website_settings', 'about_values_subheading')) {
                $table->string('about_values_subheading')->nullable()->after('about_heading');
            }

            if (! Schema::hasColumn('website_settings', 'about_value_cards')) {
                $table->longText('about_value_cards')->nullable()->after('about_values_subheading');
            }

            if (! Schema::hasColumn('website_settings', 'gallery_external_url')) {
                $table->string('gallery_external_url', 500)->nullable()->after('threads_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            if (Schema::hasColumn('website_settings', 'cta_background_image_path')) {
                $table->dropColumn('cta_background_image_path');
            }
            if (Schema::hasColumn('website_settings', 'cta_title')) {
                $table->dropColumn('cta_title');
            }
            if (Schema::hasColumn('website_settings', 'cta_description')) {
                $table->dropColumn('cta_description');
            }
            if (Schema::hasColumn('website_settings', 'about_heading')) {
                $table->dropColumn('about_heading');
            }
            if (Schema::hasColumn('website_settings', 'about_values_subheading')) {
                $table->dropColumn('about_values_subheading');
            }
            if (Schema::hasColumn('website_settings', 'about_value_cards')) {
                $table->dropColumn('about_value_cards');
            }
            if (Schema::hasColumn('website_settings', 'gallery_external_url')) {
                $table->dropColumn('gallery_external_url');
            }
        });
    }
};

