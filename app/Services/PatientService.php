<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class PatientService
{
    /**
     * List all patients
     */
    public function getAllPatients()
    {
        return User::where('role', 'patient')->with('patient')->get();
    }

    /**
     * Store new patient
     */
    public function store(array $data): RedirectResponse
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient',
        ]);

        // Prepare patient data
        $patientData = [
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'blood_type' => $data['blood_type'] ?? null,
        ];

        // Add translatable fields (spatie/laravel-translatable handles JSON conversion)
        if (isset($data['allergies'])) {
            $patientData['allergies_translatable'] = $data['allergies'];
        }
        if (isset($data['medical_history'])) {
            $patientData['medical_history_translatable'] = $data['medical_history'];
        }

        $user->patient()->create($patientData);

        return redirect()->route('admin.patients.index')->with('success', 'Patient created successfully!');
    }

    /**
     * Get patient by ID
     */
    public function getPatient(User $patient)
    {
        return $patient->load('patient');
    }
}
