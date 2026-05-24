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
        Schema::create('clinical_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_department_id')
                ->constrained('clinical_departments')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            // JSON-encoded array of image paths for gallery
            $table->longText('gallery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_services');
    }
};

