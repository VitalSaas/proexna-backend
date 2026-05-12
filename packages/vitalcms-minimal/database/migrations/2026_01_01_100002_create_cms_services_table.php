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
        $tableName = config('vitalcms.table_prefix', 'cms_') . 'services';

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable(); // For service cards
            $table->string('price')->nullable(); // "Desde $500", "$200/mes", etc.
            $table->string('price_description')->nullable(); // "por proyecto", "mensual", etc.
            $table->string('icon')->nullable(); // Emoji or icon class
            $table->string('image')->nullable(); // Service image
            $table->string('category')->nullable(); // diseño, mantenimiento, etc.
            $table->boolean('featured')->default(false); // Featured in homepage
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('meta_data')->nullable(); // SEO, extra data
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['is_active', 'featured', 'sort_order']);
            $table->index(['category', 'is_active']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = config('vitalcms.table_prefix', 'cms_') . 'services';
        Schema::dropIfExists($tableName);
    }
};