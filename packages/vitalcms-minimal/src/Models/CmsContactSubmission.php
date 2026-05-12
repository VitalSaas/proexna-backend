<?php

namespace VitalSaaS\VitalCMSMinimal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class CmsContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'service_interest',
        'ip_address',
        'user_agent',
        'status',
        'read_at',
        'replied_at',
        'notes',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Get the table name with prefix.
     */
    public function getTable(): string
    {
        return config('vitalcms.table_prefix', 'cms_') . 'contact_submissions';
    }

    /**
     * Scope to get only new submissions.
     */
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    /**
     * Scope to get unread submissions.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope to get read submissions.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope to get submissions from today.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope to get submissions from this week.
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    /**
     * Mark submission as read.
     */
    public function markAsRead(): void
    {
        $this->update([
            'status' => self::STATUS_READ,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark submission as replied.
     */
    public function markAsReplied(): void
    {
        $this->update([
            'status' => self::STATUS_REPLIED,
            'replied_at' => now(),
        ]);
    }

    /**
     * Check if submission is new.
     */
    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    /**
     * Check if submission is read.
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if submission has been replied to.
     */
    public function isReplied(): bool
    {
        return !is_null($this->replied_at);
    }

    /**
     * Get time ago format.
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_NEW => 'success',
            self::STATUS_READ => 'warning',
            self::STATUS_REPLIED => 'primary',
            self::STATUS_ARCHIVED => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get available statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW => 'Nuevo',
            self::STATUS_READ => 'Leído',
            self::STATUS_REPLIED => 'Respondido',
            self::STATUS_ARCHIVED => 'Archivado',
        ];
    }

    /**
     * Get service interests.
     */
    public static function getServiceInterests(): array
    {
        return [
            'diseño' => 'Diseño de Jardines',
            'mantenimiento' => 'Mantenimiento',
            'paisajismo' => 'Paisajismo',
            'instalacion' => 'Instalación de Sistemas',
            'consulta' => 'Consultoría',
            'otro' => 'Otro',
        ];
    }
}