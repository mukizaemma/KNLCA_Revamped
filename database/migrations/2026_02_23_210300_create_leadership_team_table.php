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
        Schema::create('leadership_team', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('position');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('biography')->nullable();
            $table->string('profile_image')->nullable();
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
        Schema::dropIfExists('leadership_team');
    }
};

