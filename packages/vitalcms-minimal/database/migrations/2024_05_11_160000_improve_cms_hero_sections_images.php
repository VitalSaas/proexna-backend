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
        Schema::table('cms_hero_sections', function (Blueprint $table) {
            // Campos para imagen principal (separada del background)
            $table->string('hero_image')->nullable()->after('description');
            $table->enum('image_position', ['left', 'right', 'center', 'background', 'none'])
                  ->default('background')
                  ->after('hero_image');

            // Configuración de gradientes
            $table->enum('gradient_position', ['top', 'bottom', 'left', 'right', 'center', 'none'])
                  ->default('none')
                  ->after('image_position');
            $table->json('gradient_settings')->nullable()->after('gradient_position');

            // Configuración de overlay/filtros
            $table->json('image_effects')->nullable()->after('gradient_settings');

            // Configuración de contenido
            $table->enum('content_position', ['left', 'right', 'center', 'top-left', 'top-right', 'bottom-left', 'bottom-right'])
                  ->default('center')
                  ->after('image_effects');
            $table->integer('content_width')->default(50)->after('content_position'); // Porcentaje del ancho
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_hero_sections', function (Blueprint $table) {
            $table->dropColumn([
                'hero_image',
                'image_position',
                'gradient_position',
                'gradient_settings',
                'image_effects',
                'content_position',
                'content_width'
            ]);
        });
    }
};