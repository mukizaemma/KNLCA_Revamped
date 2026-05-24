<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admission_page', function (Blueprint $table) {
            $table->string('intro_label')->nullable()->after('id');
            $table->string('intro_title')->nullable()->after('intro_label');
            $table->text('intro_subtitle')->nullable()->after('intro_title');
            $table->string('featured_badge')->nullable()->after('intro_subtitle');
            $table->string('cta_title')->nullable()->after('transfer_documents');
            $table->text('cta_text')->nullable()->after('cta_title');
            $table->string('cta_primary_btn')->nullable()->after('cta_text');
            $table->string('cta_secondary_btn')->nullable()->after('cta_primary_btn');
        });
    }

    public function down(): void
    {
        Schema::table('admission_page', function (Blueprint $table) {
            $table->dropColumn([
                'intro_label', 'intro_title', 'intro_subtitle', 'featured_badge',
                'cta_title', 'cta_text', 'cta_primary_btn', 'cta_secondary_btn',
            ]);
        });
    }
};
