<?php

namespace VitalSaaS\VitalCMSMinimal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CmsHeroSection extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'hero_image',
        'image_position',
        'gradient_position',
        'gradient_settings',
        'image_effects',
        'content_position',
        'content_width',
        'background_image',
        'background_video',
        'background_type',
        'background_settings',
        'buttons',
        'layout',
        'height',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'gradient_settings' => 'array',
        'image_effects' => 'array',
        'background_settings' => 'array',
        'buttons' => 'array',
        'is_active' => 'boolean',
        'height' => 'integer',
        'sort_order' => 'integer',
        'content_width' => 'integer',
    ];

    /**
     * Get the table name with prefix.
     */
    public function getTable(): string
    {
        return config('vitalcms.table_prefix', 'cms_') . 'hero_sections';
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Scope to get only active hero sections.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get background image URL.
     */
    public function getBackgroundImageUrlAttribute(): ?string
    {
        if (!$this->background_image) {
            return null;
        }

        return asset('storage/' . config('vitalcms.hero_sections.image_upload_path', 'hero-sections') . '/' . $this->background_image);
    }

    /**
     * Get hero image URL.
     */
    public function getHeroImageUrlAttribute(): ?string
    {
        if (!$this->hero_image) {
            return null;
        }

        return asset('storage/' . config('vitalcms.hero_sections.image_upload_path', 'hero-sections') . '/' . $this->hero_image);
    }

    /**
     * Get gradient CSS for the specified position.
     */
    public function getGradientCssAttribute(): ?string
    {
        if ($this->gradient_position === 'none' || !$this->gradient_settings) {
            return null;
        }

        $settings = $this->gradient_settings;
        $direction = $this->getGradientDirection();

        $colors = [];
        if (isset($settings['start_color'])) {
            $colors[] = $settings['start_color'] . ($settings['start_opacity'] ?? 100) . '%';
        }
        if (isset($settings['end_color'])) {
            $colors[] = $settings['end_color'] . ($settings['end_opacity'] ?? 0) . '%';
        }

        if (empty($colors)) {
            return null;
        }

        return "linear-gradient({$direction}, " . implode(', ', $colors) . ")";
    }

    /**
     * Get gradient direction based on position.
     */
    private function getGradientDirection(): string
    {
        return match ($this->gradient_position) {
            'top' => 'to bottom',
            'bottom' => 'to top',
            'left' => 'to right',
            'right' => 'to left',
            'center' => 'radial',
            default => 'to bottom'
        };
    }

    /**
     * Check if hero has image (either background or hero image).
     */
    public function getHasImageAttribute(): bool
    {
        return !empty($this->hero_image) || !empty($this->background_image);
    }

    /**
     * Get the first button (primary CTA).
     */
    public function getPrimaryButtonAttribute(): ?array
    {
        $buttons = $this->buttons ?? [];
        return $buttons[0] ?? null;
    }

    /**
     * Get the second button (secondary CTA).
     */
    public function getSecondaryButtonAttribute(): ?array
    {
        $buttons = $this->buttons ?? [];
        return $buttons[1] ?? null;
    }
}