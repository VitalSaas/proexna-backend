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
        $tableName = config('vitalcms.table_prefix', 'cms_') . 'hero_sections';

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_video')->nullable();
            $table->enum('background_type', ['image', 'video', 'gradient', 'color'])->default('image');
            $table->json('background_settings')->nullable(); // overlay, position, etc.
            $table->json('buttons')->nullable(); // CTAs configurables
            $table->enum('layout', ['centered', 'left', 'right', 'split'])->default('centered');
            $table->integer('height')->default(500); // Altura en px
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['is_active', 'sort_order']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = config('vitalcms.table_prefix', 'cms_') . 'hero_sections';
        Schema::dropIfExists($tableName);
    }
};