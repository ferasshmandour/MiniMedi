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

        // Prepare translatable data
        $doctorData = [
            'license_number' => $data['license_number'],
            'phone' => $data['phone'] ?? null,
        ];

        // Add translatable fields (spatie/laravel-translatable handles JSON conversion)
        if (isset($data['specialization'])) {
            $doctorData['specialization_translatable'] = $data['specialization'];
        }
        if (isset($data['department'])) {
            $doctorData['department_translatable'] = $data['department'];
        }
        if (isset($data['bio'])) {
            $doctorData['bio_translatable'] = $data['bio'];
        }

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
