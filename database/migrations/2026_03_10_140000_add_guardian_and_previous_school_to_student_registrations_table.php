<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->string('guardian_full_name')->nullable()->after('mother_phone');
            $table->string('guardian_email')->nullable()->after('guardian_full_name');
            $table->string('guardian_phone')->nullable()->after('guardian_email');
            $table->string('previous_school_name')->nullable()->after('guardian_phone');
            $table->string('previous_school_report_path')->nullable()->after('previous_school_name');
        });
    }

    public function down(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'guardian_full_name',
                'guardian_email',
                'guardian_phone',
                'previous_school_name',
                'previous_school_report_path',
            ]);
        });
    }
};

