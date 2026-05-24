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
        Schema::create('admission_page', function (Blueprint $table) {
            $table->id();
            $table->string('process_heading')->default('Admission Process');
            $table->longText('admission_process')->nullable(); // HTML or plain text for numbered steps
            $table->string('first_admission_heading')->default('First Admission');
            $table->longText('first_admission_intro')->nullable();
            $table->json('first_admission_documents')->nullable(); // array of document strings
            $table->string('transfer_heading')->default('Transfer from another school');
            $table->longText('transfer_intro')->nullable();
            $table->json('transfer_documents')->nullable(); // array of document strings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_page');
    }
};
