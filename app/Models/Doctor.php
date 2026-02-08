<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Doctor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'user_id',
        'specialization',
        'license_number',
        'department',
        'phone',
        'available_from',
        'available_to',
        'bio',
        // Translatable fields
        'specialization_translatable',
        'department_translatable',
        'bio_translatable',
    ];

    protected $translatable = [
        'specialization',
        'department',
        'bio',
    ];

    /**
     * Get the user that owns the doctor profile
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get appointments for this doctor
     */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Get medical notes created by this doctor
     */
    public function medicalNotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MedicalNote::class, 'doctor_id');
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
     * Register media collections for doctor
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('doctor_photo')
            ->singleFile()
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
            });

        $this->addMediaCollection('certifications')
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
            ->performOnCollection('doctor_photo');

        $this->addMediaConversion('preview')
            ->width(400)
            ->height(400)
            ->performOnCollection('doctor_photo');
    }

    /**
     * Get doctor photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->hasMedia('doctor_photo')) {
            return $this->getMedia('doctor_photo')->first()->getUrl('preview');
        }
        return null;
    }

    /**
     * Get all certifications
     */
    public function getCertificationsAttribute()
    {
        return $this->getMedia('certifications');
    }
}
