<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('registration_academic_year', 60)->nullable()->after('gallery_external_url');
            $table->text('registration_message')->nullable()->after('registration_academic_year');
        });
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['registration_academic_year', 'registration_message']);
        });
    }
};

