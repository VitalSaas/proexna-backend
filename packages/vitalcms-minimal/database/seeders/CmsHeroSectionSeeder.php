<?php

namespace VitalSaaS\VitalCMSMinimal\Database\Seeders;

use Illuminate\Database\Seeder;
use VitalSaaS\VitalCMSMinimal\Models\CmsHeroSection;

class CmsHeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar registros existentes
        CmsHeroSection::truncate();

        // Hero Section 1 - Principal
        CmsHeroSection::create([
            'title' => 'Profesionalismo en la Naturaleza',
            'subtitle' => 'Expertos en Jardinería y Paisajismo',
            'description' => 'Transformamos tus espacios exteriores en oasis de tranquilidad y belleza natural. Con más de 10 años de experiencia, ofrecemos servicios integrales de diseño, instalación y mantenimiento de jardines.',
            'background_type' => 'gradient',
            'background_settings' => [
                'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'overlay' => 'rgba(0,0,0,0.3)'
            ],
            'layout' => 'centered',
            'height' => 600,
            'buttons' => [
                [
                    'text' => 'Ver Servicios',
                    'url' => '#servicios',
                    'type' => 'primary',
                    'action' => 'scroll'
                ],
                [
                    'text' => 'Contactar',
                    'url' => '#contacto',
                    'type' => 'secondary',
                    'action' => 'scroll'
                ]
            ],
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Hero Section 2 - Diseño de Jardines
        CmsHeroSection::create([
            'title' => 'Diseños que Inspiran',
            'subtitle' => 'Jardines Únicos y Personalizados',
            'description' => 'Creamos espacios verdes únicos que reflejan tu personalidad y se adaptan perfectamente a tu estilo de vida. Desde jardines minimalistas hasta exuberantes paisajes tropicales.',
            'background_type' => 'image',
            'background_image' => 'hero-sections/jardin-diseno.jpg',
            'background_settings' => [
                'overlay' => 'rgba(0,0,0,0.4)',
                'position' => 'center center'
            ],
            'layout' => 'left',
            'height' => 500,
            'buttons' => [
                [
                    'text' => 'Diseño de Jardines',
                    'url' => '/servicios/diseno-jardines',
                    'type' => 'primary',
                    'action' => 'link'
                ]
            ],
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Hero Section 3 - Mantenimiento
        CmsHeroSection::create([
            'title' => 'Mantenimiento Profesional',
            'subtitle' => 'Tu Jardín Siempre Perfecto',
            'description' => 'Servicios de mantenimiento integral para mantener tu jardín en perfectas condiciones durante todo el año. Poda, riego, fertilización y control de plagas.',
            'background_type' => 'video',
            'background_video' => 'https://example.com/mantenimiento-jardin.mp4',
            'background_settings' => [
                'overlay' => 'rgba(34, 139, 34, 0.3)',
                'autoplay' => true,
                'loop' => true,
                'muted' => true
            ],
            'layout' => 'right',
            'height' => 450,
            'buttons' => [
                [
                    'text' => 'Mantenimiento',
                    'url' => '/servicios/mantenimiento',
                    'type' => 'primary',
                    'action' => 'link'
                ],
                [
                    'text' => 'Cotizar',
                    'url' => 'https://wa.me/529513084924?text=Hola, me interesa el servicio de mantenimiento',
                    'type' => 'outline',
                    'action' => 'whatsapp'
                ]
            ],
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Hero Section 4 - Contacto
        CmsHeroSection::create([
            'title' => '¿Tienes un Proyecto en Mente?',
            'subtitle' => 'Hablemos de Tu Jardín Ideal',
            'description' => 'Estamos listos para hacer realidad tu proyecto. Contáctanos para una consulta gratuita y descubre cómo podemos transformar tu espacio exterior.',
            'background_type' => 'color',
            'background_settings' => [
                'color' => '#2d5a27',
                'pattern' => 'subtle-dots'
            ],
            'layout' => 'centered',
            'height' => 400,
            'buttons' => [
                [
                    'text' => 'WhatsApp',
                    'url' => 'https://wa.me/529513084924',
                    'type' => 'primary',
                    'action' => 'whatsapp'
                ],
                [
                    'text' => 'Llamar',
                    'url' => 'tel:+529513084924',
                    'type' => 'secondary',
                    'action' => 'call'
                ],
                [
                    'text' => 'Email',
                    'url' => 'mailto:info@proexna.com',
                    'type' => 'outline',
                    'action' => 'email'
                ]
            ],
            'is_active' => true,
            'sort_order' => 4
        ]);
    }
}