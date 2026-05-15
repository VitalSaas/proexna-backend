<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_vacancy_id',
        'name',
        'email',
        'phone',
        'city',
        'position_interest',
        'message',
        'resume_path',
        'status',
        'internal_notes',
        'contacted_at',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    public static function getStatuses(): array
    {
        return [
            'nuevo' => 'Nuevo',
            'contactado' => 'Contactado',
            'entrevista' => 'En Entrevista',
            'contratado' => 'Contratado',
            'descartado' => 'Descartado',
            'archivado' => 'Archivado',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function getResumeUrlAttribute(): ?string
    {
        if (!$this->resume_path) {
            return null;
        }
        return asset('storage/' . ltrim($this->resume_path, '/'));
    }

    public function getIsOpenApplicationAttribute(): bool
    {
        return is_null($this->job_vacancy_id);
    }
}
