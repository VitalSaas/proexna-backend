<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Áreas Verdes Escolares - Colegio Carmel',
                'slug' => 'areas-verdes-escolares-colegio-carmel',
                'short_description' => 'Mantenimiento integral de patios, canchas y áreas didácticas con enfoque seguro para niños y libre de químicos agresivos.',
                'description' => 'Diseñamos un programa de mantenimiento orientado al entorno escolar: poda preventiva de árboles cercanos a zonas de juego, control biológico de plagas (sin pesticidas residuales), reemplazo de pasto en zonas de alto tráfico y siembra de especies nativas de bajo mantenimiento. El plan se ejecuta en periodos vacacionales para no interrumpir actividades académicas.',
                'client' => 'Colegio Carmel',
                'location' => 'Oaxaca de Juárez, Oax.',
                'category' => 'mantenimiento',
                'completed_at' => '2025-08-15',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Paisajismo Hotel Boutique Quinta Real',
                'slug' => 'paisajismo-hotel-boutique-quinta-real',
                'short_description' => 'Rediseño de patios coloniales y jardines interiores con especies nativas, iluminación cálida y guía de cuidados para el equipo del hotel.',
                'description' => 'Proyecto de paisajismo integral en un hotel boutique del centro histórico. Se respetó la arquitectura original recuperando macetones tradicionales con bugambilias, palmas y agaves, integrando un sistema de riego por goteo oculto y luminarias dirigidas para resaltar texturas durante la noche. Entregamos al hotel un manual operativo para que su equipo conserve el diseño.',
                'client' => 'Hotel Quinta Real Oaxaca',
                'location' => 'Centro Histórico, Oaxaca',
                'category' => 'paisajismo',
                'completed_at' => '2025-11-20',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Jardines Hotel Casa Oaxaca',
                'slug' => 'jardines-hotel-casa-oaxaca',
                'short_description' => 'Diseño y siembra de jardines temáticos en hotel de lujo, con énfasis en flora endémica y rincones contemplativos para huéspedes.',
                'description' => 'Diseño paisajístico de las áreas exteriores del hotel: jardines temáticos con especies endémicas del Valle de Oaxaca, ruta sensorial con plantas aromáticas, y rincones contemplativos con vegetación de sombra. Incluyó la instalación de un huerto orgánico que abastece parcialmente al restaurante del hotel.',
                'client' => 'Hotel Casa Oaxaca',
                'location' => 'San Felipe del Agua, Oaxaca',
                'category' => 'diseno',
                'completed_at' => '2026-02-10',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Mantenimiento Residencial Lomas del Creston',
                'slug' => 'mantenimiento-residencial-lomas-del-creston',
                'short_description' => 'Programa mensual de mantenimiento para fraccionamiento residencial: áreas comunes, accesos, camellones y jardines de casa club.',
                'description' => 'Servicio mensual contratado por la administración del fraccionamiento. Atendemos áreas comunes, accesos vehiculares, camellones, alberca exterior y jardines de la casa club. El plan incluye podas técnicas trimestrales, fertilización estacional, control fitosanitario integrado y reportes documentados para la mesa directiva.',
                'client' => 'Administración Lomas del Creston',
                'location' => 'Oaxaca de Juárez, Oax.',
                'category' => 'residencial',
                'completed_at' => '2026-04-30',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Rehabilitación de Áreas Verdes - Santa María del Tule',
                'slug' => 'rehabilitacion-areas-verdes-santa-maria-del-tule',
                'short_description' => 'Recuperación de jardines municipales en el entorno del Árbol del Tule: poda sanitaria, reposición de pasto y manejo de drenaje.',
                'description' => 'Trabajo coordinado con el municipio para rehabilitar las áreas verdes que rodean al Árbol del Tule y las plazas adyacentes. Se realizaron podas sanitarias supervisadas, reposición de pasto en zonas erosionadas, mejoramiento de suelo con composta y reparación del sistema de drenaje pluvial. Todas las intervenciones respetaron los protocolos de conservación del ahuehuete.',
                'client' => 'H. Ayuntamiento de Santa María del Tule',
                'location' => 'Santa María del Tule, Oax.',
                'category' => 'mantenimiento',
                'completed_at' => '2025-10-05',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Parques y Jardines Municipales - San Agustín Etla',
                'slug' => 'parques-jardines-municipales-san-agustin-etla',
                'short_description' => 'Paisajismo de plaza principal y parques comunitarios con especies nativas, bancas integradas y zonas de sombra natural.',
                'description' => 'Proyecto integral con el municipio de San Agustín Etla para renovar la plaza principal y dos parques comunitarios. Se sembraron jacarandas, fresnos y especies nativas de bajo consumo hídrico, se crearon zonas de sombra natural alrededor de bancas existentes y se capacitó al personal municipal en cuidados básicos para asegurar la permanencia del diseño.',
                'client' => 'H. Ayuntamiento de San Agustín Etla',
                'location' => 'San Agustín Etla, Oax.',
                'category' => 'paisajismo',
                'completed_at' => '2026-01-25',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($projects as $data) {
            Project::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
