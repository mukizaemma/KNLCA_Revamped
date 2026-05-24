<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->longText('biography')->nullable()->after('phone');
        });

        // Expand role enum to support clinical and management staff
        DB::statement(
            "ALTER TABLE users MODIFY COLUMN role ENUM(
                'super_admin',
                'website_admin',
                'clinical_staff',
                'management_staff',
                'guest'
            ) NOT NULL DEFAULT 'guest'"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Shrink enum back to original values
        DB::statement(
            "ALTER TABLE users MODIFY COLUMN role ENUM(
                'super_admin',
                'website_admin',
                'guest'
            ) NOT NULL DEFAULT 'guest'"
        );

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'biography']);
        });
    }
};

