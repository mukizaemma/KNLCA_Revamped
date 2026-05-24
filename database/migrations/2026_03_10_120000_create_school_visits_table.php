<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_name');
            $table->string('visitor_email');
            $table->string('visitor_phone')->nullable();
            $table->string('reason');
            $table->dateTime('visit_datetime');
            $table->text('what_to_see')->nullable();
            $table->boolean('has_student')->default(false);
            $table->string('student_name')->nullable();
            $table->string('student_grade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_visits');
    }
};

