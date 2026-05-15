<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prospect extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'source',
        'status',
        'interest',
        'budget_range',
        'tentative_service_date',
        'score',
        'chatbot_conversation_id',
        'chatbot_payload',
        'assigned_to',
        'next_follow_up_at',
        'converted_at',
        'lost_reason',
        'notes',
    ];

    protected $casts = [
        'chatbot_payload' => 'array',
        'score' => 'integer',
        'tentative_service_date' => 'datetime',
        'next_follow_up_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public static function getStatuses(): array
    {
        return [
            'new' => 'Nuevo',
            'contacted' => 'Contactado',
            'qualified' => 'Calificado',
            'proposal' => 'Propuesta',
            'negotiation' => 'Negociación',
            'won' => 'Ganado',
            'lost' => 'Perdido',
            'archived' => 'Archivado',
        ];
    }

    public static function getSources(): array
    {
        return [
            'web' => 'Sitio Web',
            'chatbot' => 'Chatbot',
            'contact_form' => 'Formulario de Contacto',
            'referral' => 'Referido',
            'social' => 'Redes Sociales',
            'phone' => 'Teléfono',
            'email' => 'Email',
            'other' => 'Otro',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function getSourceLabelAttribute(): string
    {
        return self::getSources()[$this->source] ?? $this->source;
    }

    public function scopeOpen($query)
    {
        return $query->whereNotIn('status', ['won', 'lost', 'archived']);
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }
}
