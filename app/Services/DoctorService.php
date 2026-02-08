<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class DoctorService
{
    /**
     * List all doctors
     */
    public function getAllDoctors()
    {
        return User::where('role', 'doctor')->with('doctor', 'roles')->get();
    }

    /**
     * Store new doctor
     */
    public function store(array $data): RedirectResponse
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'doctor',
        ]);

        // Handle translatable fields - they come as arrays from the form
        $specialization = $data['specialization'] ?? ['en' => '', 'ar' => ''];
        $department = $data['department'] ?? ['en' => '', 'ar' => ''];
        $bio = $data['bio'] ?? ['en' => '', 'ar' => ''];

        // Prepare data - use spatie/laravel-translatable format
        $doctorData = [
            'license_number' => $data['license_number'],
            'phone' => $data['phone'] ?? null,
            'available_from' => $data['available_from'] ?? '09:00:00',
            'available_to' => $data['available_to'] ?? '17:00:00',
            // These will be automatically cast to JSON by the HasTranslations trait
            'specialization' => $specialization,
            'department' => $department,
            'bio' => $bio,
        ];

        $user->doctor()->create($doctorData);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully!');
    }

    /**
     * Get doctor by ID
     */
    public function getDoctor(User $doctor)
    {
        return $doctor->load('doctor');
    }
}
