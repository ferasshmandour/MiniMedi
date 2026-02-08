<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Appointment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'reason',
        'notes',
        // Translatable fields
        'reason_translatable',
        'notes_translatable',
    ];

    protected $translatable = [
        'reason',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Get the patient for this appointment
     */
    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the doctor for this appointment
     */
    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the medical note for this appointment
     */
    public function medicalNote(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MedicalNote::class);
    }

    /**
     * Scope a query to only include pending appointments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed appointments
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include completed appointments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled appointments
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Get formatted appointment date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->appointment_date->format('Y-m-d H:i');
    }

    /**
     * Check if appointment can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Check if appointment can be completed
     */
    public function canBeCompleted(): bool
    {
        return in_array($this->status, ['confirmed']);
    }

    /**
     * Register media collections for Spatie Media Library
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('appointment_files')
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp',
                ]);
            })
            ->maxFileSize(10 * 1024 * 1024); // 10MB max
    }
}
