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
            // Google Maps iframe src or full embed code (kept simple as string)
            $table->longText('map_embed_url')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            if (Schema::hasColumn('website_settings', 'map_embed_url')) {
                $table->dropColumn('map_embed_url');
            }
        });
    }
};

