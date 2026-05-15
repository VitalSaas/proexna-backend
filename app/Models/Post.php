<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'author_name',
        'user_id',
        'status',
        'published_at',
        'views_count',
        'meta_data',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'meta_data' => 'array',
        'views_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
        });
    }

    protected static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'articulo';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('created_at');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->featured_image) {
            return null;
        }
        return asset('storage/' . ltrim($this->featured_image, '/'));
    }

    public function getDisplayAuthorAttribute(): string
    {
        if ($this->author_name) {
            return $this->author_name;
        }
        if ($this->author && $this->author->name) {
            return $this->author->name;
        }
        return 'PROEXNA';
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags((string) $this->content));
        return max(1, (int) ceil($words / 200));
    }

    public static function getStatuses(): array
    {
        return [
            'draft' => 'Borrador',
            'published' => 'Publicado',
            'archived' => 'Archivado',
        ];
    }

    public static function getCategories(): array
    {
        return [
            'consejos' => 'Consejos de Jardinería',
            'mantenimiento' => 'Mantenimiento',
            'diseno' => 'Diseño de Jardines',
            'plantas' => 'Plantas y Especies',
            'paisajismo' => 'Paisajismo',
            'sustentabilidad' => 'Sustentabilidad',
            'noticias' => 'Noticias',
        ];
    }
}
