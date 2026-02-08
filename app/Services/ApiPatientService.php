<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class ApiPatientService
{
    /**
     * Get patient by ID for API
     */
    public function getPatient($user): JsonResponse
    {
        $patient = $user->patient;

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'patient' => $patient
            ]
        ]);
    }

    /**
     * Get all patients (admin only)
     */
    public function getAllPatients(): JsonResponse
    {
        $patients = User::where('role', 'patient')->with('patient')->get();

        return response()->json([
            'success' => true,
            'data' => $patients,
            'count' => $patients->count()
        ]);
    }
}
