<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('inquiry_type', 40)->nullable()->after('subject');
            $table->date('visit_date')->nullable()->after('inquiry_type');
            $table->time('visit_time')->nullable()->after('visit_date');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['inquiry_type', 'visit_date', 'visit_time']);
        });
    }
};
