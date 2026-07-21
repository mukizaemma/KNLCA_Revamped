<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_messages', 'submission_channel')) {
                $table->string('submission_channel', 20)->nullable()->after('inquiry_type');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'session_version')) {
                $table->unsignedInteger('session_version')->default(0)->after('remember_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (Schema::hasColumn('contact_messages', 'submission_channel')) {
                $table->dropColumn('submission_channel');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'session_version')) {
                $table->dropColumn('session_version');
            }
        });
    }
};
