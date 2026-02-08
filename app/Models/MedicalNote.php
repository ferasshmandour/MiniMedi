<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class MedicalNote extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'diagnosis',
        'prescription',
        'treatment_plan',
        'symptoms',
        'vital_signs',
        // Translatable fields
        'diagnosis_translatable',
        'prescription_translatable',
        'treatment_plan_translatable',
        'symptoms_translatable',
        'vital_signs_translatable',
    ];

    protected $translatable = [
        'diagnosis',
        'prescription',
        'treatment_plan',
        'symptoms',
        'vital_signs',
    ];

    /**
     * Get the appointment for this medical note
     */
    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the doctor who created this note
     */
    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get formatted created date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('Y-m-d H:i');
    }

    /**
     * Register media collections for Spatie Media Library
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('lab_results')
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, [
                    'application/pdf',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp',
                ]);
            })
            ->maxFileSize(10 * 1024 * 1024); // 10MB max

        $this->addMediaCollection('prescriptions')
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp',
                ]);
            })
            ->withResponsiveImages()
            ->maxFileSize(10 * 1024 * 1024); // 10MB max
    }
}
