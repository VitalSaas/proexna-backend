<?php

namespace VitalSaaS\VitalCMSMinimal\Database\Seeders;

use Illuminate\Database\Seeder;
use VitalSaaS\VitalCMSMinimal\Models\CmsHeroSection;
use VitalSaaS\VitalCMSMinimal\Models\CmsService;

class VitalCMSMinimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedHeroSections();
        $this->seedServices();
    }

    /**
     * Seed Hero Sections from current frontend hardcoded data.
     */
    private function seedHeroSections(): void
    {
        $heroSections = [
            [
                'title' => 'PROEXNA - Profesionalismo en la naturaleza',
                'subtitle' => 'Profesionalismo en la naturaleza',
                'description' => 'Especialistas en jardinería profesional. Ofrecemos servicios integrales desde mantenimientos generales hasta tratamientos especializados por invasión de hongos.',
                'background_type' => 'gradient',
                'background_settings' => [
                    'gradient' => 'linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%)',
                    'overlay' => 'rgba(0, 0, 0, 0.2)'
                ],
                'buttons' => [
                    [
                        'text' => '951 308 4924',
                        'url' => 'tel:+529513084924',
                        'type' => 'primary',
                        'action' => 'call'
                    ],
                    [
                        'text' => 'WhatsApp',
                        'url' => 'https://wa.me/+529513084924?text=' . urlencode('¡Hola PROEXNA! 🌱 Me interesa conocer más sobre sus servicios profesionales de jardinería.'),
                        'type' => 'secondary',
                        'action' => 'whatsapp'
                    ]
                ],
                'layout' => 'centered',
                'height' => 600,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Tratamiento especializado contra invasión de hongos',
                'subtitle' => 'contra invasión de hongos',
                'description' => 'Servicio profesional de intervención para áreas verdes afectadas. Diagnóstico, tratamiento específico y restauración completa del área verde.',
                'background_type' => 'gradient',
                'background_settings' => [
                    'gradient' => 'linear-gradient(135deg, #dc2626 0%, #991b1b 50%, #7f1d1d 100%)',
                    'overlay' => 'rgba(0, 0, 0, 0.2)'
                ],
                'buttons' => [
                    [
                        'text' => 'Solicitar Diagnóstico',
                        'url' => '#contacto',
                        'type' => 'primary',
                        'action' => 'scroll'
                    ],
                    [
                        'text' => 'Más Información',
                        'url' => '#servicios',
                        'type' => 'secondary',
                        'action' => 'scroll'
                    ]
                ],
                'layout' => 'centered',
                'height' => 600,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Servicios completos de jardinería profesional',
                'subtitle' => 'de jardinería profesional',
                'description' => 'Instalación de sistemas de riego, banqueo de árboles, poda correctiva, fertilización, fumigación y todo lo que abarca el ámbito natural.',
                'background_type' => 'gradient',
                'background_settings' => [
                    'gradient' => 'linear-gradient(135deg, #84cc16 0%, #22c55e 50%, #16a34a 100%)',
                    'overlay' => 'rgba(0, 0, 0, 0.2)'
                ],
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
                'layout' => 'centered',
                'height' => 600,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'PROEXNA cerca de ti',
                'subtitle' => 'cerca de ti',
                'description' => 'Construcción, remodelación, diseño de jardines ornamentales y desérticos. Sembrado de árboles y palmas adultas. Experiencia y profesionalismo garantizados.',
                'background_type' => 'gradient',
                'background_settings' => [
                    'gradient' => 'linear-gradient(135deg, #15803d 0%, #166534 50%, #14532d 100%)',
                    'overlay' => 'rgba(0, 0, 0, 0.2)'
                ],
                'buttons' => [
                    [
                        'text' => 'Llamar Ahora',
                        'url' => 'tel:+529513084924',
                        'type' => 'primary',
                        'action' => 'call'
                    ],
                    [
                        'text' => 'Ver Galería',
                        'url' => '#galeria',
                        'type' => 'secondary',
                        'action' => 'scroll'
                    ]
                ],
                'layout' => 'centered',
                'height' => 600,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($heroSections as $heroData) {
            CmsHeroSection::create($heroData);
        }

        $this->command->info('✅ Hero sections seeded successfully!');
    }

    /**
     * Seed Services from current frontend hardcoded data.
     */
    private function seedServices(): void
    {
        $services = [
            // Servicio Especializado Destacado
            [
                'title' => 'Tratamiento y Restauración de Área Verde por Invasión de Hongos',
                'short_description' => 'Servicio especializado de intervención para áreas verdes afectadas por hongos.',
                'description' => 'Diagnóstico profesional, tratamiento específico y restauración completa del área. Especialistas en problemas de invasión de hongos con técnicas avanzadas de recuperación.',
                'price' => 'Consultar',
                'price_description' => 'Según diagnóstico',
                'icon' => '🍄',
                'category' => 'especializado',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],

            // Servicios Principales (3)
            [
                'title' => 'Diseño y Construcción',
                'short_description' => 'Diseño de jardines ornamentales y desérticos. Construcción y remodelación de jardines con enfoque profesional.',
                'description' => 'Servicios completos de diseño personalizado, construcción y remodelación de jardines ornamentales y desérticos. Incluye planificación, diseño 3D y ejecución profesional.',
                'price' => 'Desde $5,000',
                'price_description' => 'por proyecto',
                'icon' => '🌿',
                'category' => 'diseño',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 2,
                'meta_data' => [
                    'features' => [
                        'Jardines ornamentales',
                        'Jardines desérticos',
                        'Construcción y remodelación',
                        'Diseño personalizado'
                    ]
                ]
            ],
            [
                'title' => 'Mantenimiento Integral',
                'short_description' => 'Mantenimientos generales, fertilización, abonado y cuidado especializado de áreas verdes.',
                'description' => 'Servicio completo de mantenimiento para conservar sus áreas verdes en perfecto estado. Incluye cuidados preventivos y correctivos profesionales.',
                'price' => 'Desde $800',
                'price_description' => 'mensual',
                'icon' => '🌱',
                'category' => 'mantenimiento',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 3,
                'meta_data' => [
                    'features' => [
                        'Mantenimientos generales',
                        'Fertilización y abonado',
                        'Poda correctiva',
                        'Control de plagas'
                    ]
                ]
            ],
            [
                'title' => 'Instalación y Sistemas',
                'short_description' => 'Instalación de sistemas de riego, sembrado de árboles adultos y palmas, banqueo y reubicación.',
                'description' => 'Servicios especializados en instalación de infraestructura verde. Sistemas de riego automatizados y manejo profesional de árboles y palmas.',
                'price' => 'Desde $2,500',
                'price_description' => 'por sistema',
                'icon' => '🏡',
                'category' => 'instalacion',
                'featured' => true,
                'is_active' => true,
                'sort_order' => 4,
                'meta_data' => [
                    'features' => [
                        'Sistemas de riego',
                        'Sembrado de árboles adultos',
                        'Banqueo de árboles y palmas',
                        'Reubicación profesional'
                    ]
                ]
            ],

            // Servicios Específicos de la Lista Completa (10)
            [
                'title' => 'Mantenimientos Generales',
                'short_description' => 'Mantenimiento integral de áreas verdes y jardines.',
                'description' => 'Servicio completo de mantenimiento que incluye poda, limpieza, riego y cuidados básicos para mantener sus espacios verdes saludables.',
                'price' => 'Desde $600',
                'price_description' => 'por servicio',
                'icon' => '📌',
                'category' => 'mantenimiento',
                'featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Instalación de Sistema de Riegos',
                'short_description' => 'Diseño e instalación de sistemas de riego automatizados.',
                'description' => 'Sistemas de riego por aspersión, goteo y automatizados. Diseño personalizado según las necesidades de cada área verde.',
                'price' => 'Desde $3,000',
                'price_description' => 'por sistema',
                'icon' => '💧',
                'category' => 'instalacion',
                'featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Banqueo y Reubicación de Árboles y Palmas',
                'short_description' => 'Traslado profesional de árboles y palmas adultas.',
                'description' => 'Servicio especializado en el traslado seguro de árboles y palmas. Técnicas profesionales que garantizan la supervivencia de las plantas.',
                'price' => 'Desde $1,500',
                'price_description' => 'por árbol',
                'icon' => '🌴',
                'category' => 'instalacion',
                'featured' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'title' => 'Fumigación para Control de Plagas',
                'short_description' => 'Control profesional de plagas en jardines y áreas verdes.',
                'description' => 'Fumigación especializada usando productos certificados. Control eficaz de insectos, hongos y otras plagas que afectan las plantas.',
                'price' => 'Desde $800',
                'price_description' => 'por aplicación',
                'icon' => '🐛',
                'category' => 'mantenimiento',
                'featured' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'title' => 'Poda Correctiva y Derribado de Árboles',
                'short_description' => 'Poda profesional y derribado seguro de árboles.',
                'description' => 'Servicios de poda correctiva, formativa y derribado controlado. Técnicas certificadas que preservan la salud de los árboles.',
                'price' => 'Desde $500',
                'price_description' => 'por árbol',
                'icon' => '✂️',
                'category' => 'mantenimiento',
                'featured' => false,
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'title' => 'Fertilización y Abonado de Áreas Verdes',
                'short_description' => 'Nutrición especializada para plantas y césped.',
                'description' => 'Programas de fertilización personalizada según el tipo de plantas. Abonos orgánicos e inorgánicos para un crecimiento saludable.',
                'price' => 'Desde $400',
                'price_description' => 'por aplicación',
                'icon' => '🌾',
                'category' => 'mantenimiento',
                'featured' => false,
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'title' => 'Sembrado de Árboles y Palmas Adultas',
                'short_description' => 'Plantación profesional de árboles y palmas de gran tamaño.',
                'description' => 'Plantación especializada de ejemplares adultos. Preparación del suelo, técnicas de plantación y cuidados post-plantación.',
                'price' => 'Desde $1,200',
                'price_description' => 'por árbol',
                'icon' => '🌳',
                'category' => 'instalacion',
                'featured' => false,
                'is_active' => true,
                'sort_order' => 11,
            ]
        ];

        foreach ($services as $serviceData) {
            CmsService::create($serviceData);
        }

        $this->command->info('✅ Services seeded successfully!');
    }
}