<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is doctor
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    /**
     * Check if user is patient
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Get the doctor's profile (if user is a doctor)
     */
    public function doctor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Get the patient's profile (if user is a patient)
     */
    public function patient(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Get appointments where user is a patient
     */
    public function appointmentsAsPatient(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /**
     * Get appointments where user is a doctor
     */
    public function appointmentsAsDoctor(): \Illuminate\Database\Eloquent\Relations\HasMany
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
     * Get the user's profile based on role
     */
    public function getProfileAttribute()
    {
        if ($this->isDoctor()) {
            return $this->doctor;
        }
        if ($this->isPatient()) {
            return $this->patient;
        }
        return null;
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->singleFile()
            ->acceptsFile(function ($file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
            });

        $this->addMediaCollection('documents')
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
            ->performOnCollection('profile_photo');

        $this->addMediaConversion('preview')
            ->width(400)
            ->height(400)
            ->performOnCollection('profile_photo');
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->hasMedia('profile_photo')) {
            return $this->getMedia('profile_photo')->first()->getUrl('preview');
        }
        return null;
    }

    /**
     * Get profile photo thumbnail URL
     */
    public function getProfilePhotoThumbnailUrlAttribute()
    {
        if ($this->hasMedia('profile_photo')) {
            return $this->getMedia('profile_photo')->first()->getUrl('thumbnail');
        }
        return null;
    }

    /**
     * Get all documents
     */
    public function getDocumentsAttribute()
    {
        return $this->getMedia('documents');
    }
}
