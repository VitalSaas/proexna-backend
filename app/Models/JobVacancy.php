<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobVacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'employment_type',
        'salary_range',
        'short_description',
        'description',
        'requirements',
        'benefits',
        'posted_at',
        'closes_at',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'posted_at' => 'date',
        'closes_at' => 'date',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (JobVacancy $vacancy) {
            if (empty($vacancy->slug)) {
                $vacancy->slug = static::generateUniqueSlug($vacancy->title);
            }
        });
    }

    protected static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'vacante';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('closes_at')->orWhereDate('closes_at', '>=', now()->toDateString());
            });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('posted_at')->orderBy('title');
    }

    public static function getEmploymentTypes(): array
    {
        return [
            'tiempo_completo' => 'Tiempo Completo',
            'medio_tiempo' => 'Medio Tiempo',
            'temporal' => 'Temporal',
            'por_proyecto' => 'Por Proyecto',
            'freelance' => 'Freelance',
            'practicas' => 'Prácticas',
        ];
    }

    public function getEmploymentTypeLabelAttribute(): ?string
    {
        if (!$this->employment_type) {
            return null;
        }
        return self::getEmploymentTypes()[$this->employment_type] ?? $this->employment_type;
    }
}
