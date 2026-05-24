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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();

            $table->string('company_name')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('home_background_image_path')->nullable();
            $table->longText('home_background_text')->nullable();

            $table->longText('about_description')->nullable();

            $table->string('email')->nullable();
            $table->string('phone_reception')->nullable();
            $table->string('phone_urgency')->nullable();
            $table->string('phone_whatsapp')->nullable();
            $table->string('phone_billing')->nullable();
            $table->string('phone_restaurant')->nullable();

            $table->string('address')->nullable();

            $table->longText('mission')->nullable();
            $table->longText('vision')->nullable();
            $table->longText('core_values')->nullable(); // Can store HTML or JSON list

            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('x_url')->nullable();
            $table->string('threads_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};

