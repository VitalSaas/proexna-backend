<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'client',
        'location',
        'category',
        'completed_at',
        'image',
        'gallery',
        'featured',
        'is_active',
        'sort_order',
        'meta_data',
    ];

    protected $casts = [
        'completed_at' => 'date',
        'gallery' => 'array',
        'meta_data' => 'array',
        'featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = static::generateUniqueSlug($project->title);
            }
        });
    }

    protected static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'proyecto';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('completed_at')->orderBy('title');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery) || !is_array($this->gallery)) {
            return [];
        }
        return array_map(fn ($path) => asset('storage/' . ltrim($path, '/')), $this->gallery);
    }

    public static function getCategories(): array
    {
        return [
            'diseno' => 'Diseño de Jardines',
            'mantenimiento' => 'Mantenimiento',
            'paisajismo' => 'Paisajismo',
            'instalacion' => 'Instalación',
            'tratamiento' => 'Tratamiento',
            'residencial' => 'Residencial',
            'comercial' => 'Comercial',
        ];
    }
}
