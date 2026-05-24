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
        Schema::create('media_gallery_items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('title')->nullable();
            $table->longText('caption')->nullable();
            $table->boolean('is_featured')->default(false);
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
        Schema::dropIfExists('media_gallery_items');
    }
};

