<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Patient extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'date_of_birth',
        'blood_type',
        'allergies',
        'medical_history',
        // Translatable fields
        'allergies_translatable',
        'medical_history_translatable',
    ];

    protected $translatable = [
        'allergies',
        'medical_history',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the patient profile
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get appointments for this patient
     */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /**
     * Get medical notes for this patient (through appointments)
     */
    public function medicalNotes(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(MedicalNote::class, Appointment::class, 'patient_id', 'appointment_id');
    }

    /**
     * Get the user's name through the relationship
     */
    public function getNameAttribute(): string
    {
        return $this->user->name ?? 'Unknown';
    }

    /**
     * Get the user's email through the relationship
     */
    public function getEmailAttribute(): string
    {
        return $this->user->email ?? 'Unknown';
    }

    /**
     * Calculate age from date of birth
     */
    public function getAgeAttribute(): int
    {
        if (!$this->date_of_birth) {
            return 0;
        }
        return now()->diffInYears($this->date_of_birth);
    }

    /**
     * Register media collections for patient
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('patient_photo')
            ->singleFile()
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
            });

        $this->addMediaCollection('medical_records')
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'image/jpeg',
                    'image/png',
                    'image/jpg',
                ]);
            });
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(150)
            ->height(150)
            ->crop(150, 150)
            ->performOnCollection('patient_photo');

        $this->addMediaConversion('preview')
            ->width(400)
            ->height(400)
            ->performOnCollection('patient_photo');
    }

    /**
     * Get patient photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->hasMedia('patient_photo')) {
            return $this->getMedia('patient_photo')->first()->getUrl('preview');
        }
        return null;
    }

    /**
     * Get all medical records
     */
    public function getMedicalRecordsAttribute()
    {
        return $this->getMedia('medical_records');
    }
}
