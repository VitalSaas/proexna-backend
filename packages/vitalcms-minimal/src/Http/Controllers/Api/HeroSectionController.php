<?php

namespace VitalSaaS\VitalCMSMinimal\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use VitalSaaS\VitalCMSMinimal\Models\CmsHeroSection;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of active hero sections.
     */
    public function index(Request $request): JsonResponse
    {
        $cacheKey = config('vitalcms.hero_sections.cache_key', 'vitalcms:hero_sections');
        $cacheTtl = config('vitalcms.cache.ttl', 3600);

        $heroSections = Cache::remember($cacheKey, $cacheTtl, function () {
            return CmsHeroSection::active()
                ->ordered()
                ->get()
                ->map(function ($heroSection) {
                    return $this->transformHeroSection($heroSection);
                });
        });

        return response()->json([
            'success' => true,
            'data' => $heroSections,
            'meta' => [
                'count' => $heroSections->count(),
                'cache_ttl' => $cacheTtl,
            ]
        ]);
    }

    /**
     * Display the specified hero section.
     */
    public function show(CmsHeroSection $heroSection): JsonResponse
    {
        if (!$heroSection->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Hero section not found or inactive',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->transformHeroSection($heroSection),
        ]);
    }

    /**
     * Transform hero section data for API response.
     */
    private function transformHeroSection(CmsHeroSection $heroSection): array
    {
        return [
            'id' => $heroSection->id,
            'title' => $heroSection->title,
            'slug' => $heroSection->slug,
            'subtitle' => $heroSection->subtitle,
            'description' => $heroSection->description,

            // Imagen principal mejorada
            'image' => [
                'url' => $heroSection->hero_image_url,
                'position' => $heroSection->image_position,
                'effects' => $heroSection->image_effects ?? [],
            ],

            // Configuración de gradiente mejorada
            'gradient' => [
                'position' => $heroSection->gradient_position,
                'settings' => $heroSection->gradient_settings ?? [],
                'css' => $heroSection->gradient_css,
            ],

            // Configuración de contenido
            'content' => [
                'position' => $heroSection->content_position,
                'width' => $heroSection->content_width,
            ],

            // Background (legacy, mantenido para compatibilidad)
            'background' => [
                'type' => $heroSection->background_type,
                'image' => $heroSection->background_image_url,
                'video' => $heroSection->background_video,
                'settings' => $heroSection->background_settings ?? [],
            ],

            'buttons' => $this->transformButtons($heroSection->buttons ?? []),
            'layout' => $heroSection->layout, // Legacy
            'height' => $heroSection->height,
            'sort_order' => $heroSection->sort_order,
            'primary_button' => $heroSection->primary_button,
            'secondary_button' => $heroSection->secondary_button,
            'has_image' => $heroSection->has_image,

            // Frontend-friendly data mejorada
            'backgroundImage' => $this->generateBackgroundStyle($heroSection),
            'imageUrl' => $heroSection->hero_image_url ?? $heroSection->background_image_url,
            'gradientOverlay' => $heroSection->gradient_css,
            'contentAlignment' => $this->mapContentPosition($heroSection->content_position),
            'buttonText' => $heroSection->primary_button['text'] ?? 'Contactar',
            'buttonSecondaryText' => $heroSection->secondary_button['text'] ?? 'Más info',

            // CSS classes helpers para el frontend
            'cssClasses' => $this->generateCssClasses($heroSection),
            'styles' => $this->generateInlineStyles($heroSection),
        ];
    }

    /**
     * Transform buttons for frontend consumption.
     */
    private function transformButtons(array $buttons): array
    {
        return array_map(function ($button) {
            return [
                'text' => $button['text'] ?? '',
                'url' => $button['url'] ?? '#',
                'type' => $button['type'] ?? 'primary',
                'action' => $button['action'] ?? 'link',
                // Frontend helpers
                'onClick' => $this->generateButtonAction($button),
            ];
        }, $buttons);
    }

    /**
     * Generate JavaScript action for button.
     */
    private function generateButtonAction(array $button): string
    {
        $url = $button['url'] ?? '#';
        $action = $button['action'] ?? 'link';

        return match ($action) {
            'call' => "window.open('{$url}', '_self')",
            'whatsapp' => "window.open('{$url}', '_blank')",
            'email' => "window.open('mailto:{$url}', '_self')",
            'scroll' => "document.querySelector('{$url}')?.scrollIntoView({behavior: 'smooth'})",
            default => "window.location.href = '{$url}'",
        };
    }

    /**
     * Generate background style based on hero section configuration.
     */
    private function generateBackgroundStyle(CmsHeroSection $heroSection): string
    {
        // Prioridad: hero_image > background_image > gradient > color
        if ($heroSection->hero_image_url) {
            return $heroSection->hero_image_url;
        }

        if ($heroSection->background_image_url) {
            return $heroSection->background_image_url;
        }

        if ($heroSection->gradient_css) {
            return $heroSection->gradient_css;
        }

        // Fallback
        return $heroSection->background_settings['gradient'] ??
               'linear-gradient(135deg, #22c55e 0%, #16a34a 100%)';
    }

    /**
     * Map content position to CSS alignment classes.
     */
    private function mapContentPosition(string $position): array
    {
        return match ($position) {
            'left' => ['justify' => 'start', 'align' => 'center'],
            'right' => ['justify' => 'end', 'align' => 'center'],
            'center' => ['justify' => 'center', 'align' => 'center'],
            'top-left' => ['justify' => 'start', 'align' => 'start'],
            'top-right' => ['justify' => 'end', 'align' => 'start'],
            'bottom-left' => ['justify' => 'start', 'align' => 'end'],
            'bottom-right' => ['justify' => 'end', 'align' => 'end'],
            default => ['justify' => 'center', 'align' => 'center'],
        };
    }

    /**
     * Generate CSS classes for hero section layout.
     */
    private function generateCssClasses(CmsHeroSection $heroSection): array
    {
        $classes = ['hero-section'];

        // Layout classes
        $classes[] = 'layout-' . $heroSection->layout;
        $classes[] = 'image-position-' . $heroSection->image_position;
        $classes[] = 'content-position-' . $heroSection->content_position;

        if ($heroSection->gradient_position !== 'none') {
            $classes[] = 'has-gradient';
            $classes[] = 'gradient-' . $heroSection->gradient_position;
        }

        if ($heroSection->has_image) {
            $classes[] = 'has-image';
        }

        return $classes;
    }

    /**
     * Generate inline styles for hero section.
     */
    private function generateInlineStyles(CmsHeroSection $heroSection): array
    {
        $styles = [];

        // Height
        if ($heroSection->height) {
            $styles['height'] = $heroSection->height . 'px';
        }

        // Background image
        if ($heroSection->hero_image_url && $heroSection->image_position === 'background') {
            $styles['backgroundImage'] = "url('{$heroSection->hero_image_url}')";
            $styles['backgroundSize'] = 'cover';
            $styles['backgroundPosition'] = 'center';
            $styles['backgroundRepeat'] = 'no-repeat';
        }

        // Gradient overlay
        if ($heroSection->gradient_css && $heroSection->hero_image_url) {
            $styles['backgroundImage'] = "{$heroSection->gradient_css}, url('{$heroSection->hero_image_url}')";
        } elseif ($heroSection->gradient_css) {
            $styles['backgroundImage'] = $heroSection->gradient_css;
        }

        // Image effects
        if ($heroSection->image_effects) {
            $filters = [];
            foreach ($heroSection->image_effects as $effect => $value) {
                $filters[] = "{$effect}({$value})";
            }
            if (!empty($filters)) {
                $styles['filter'] = implode(' ', $filters);
            }
        }

        return $styles;
    }
}