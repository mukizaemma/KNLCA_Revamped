<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('student_first_name');
            $table->string('student_last_name');
            $table->string('academic_level')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('primary_contact')->nullable(); // mother|father
            $table->string('father_full_name')->nullable();
            $table->string('father_email')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_full_name')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};
