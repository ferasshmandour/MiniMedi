<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthService
{
    /**
     * Register a new patient
     */
    public function register(array $data): JsonResponse
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient',
        ]);

        // Create patient profile
        $user->patient()->create([
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'blood_type' => $data['blood_type'] ?? null,
            'allergies' => $data['allergies'] ?? null,
            'medical_history' => $data['medical_history'] ?? null,
        ]);

        $token = $user->createToken('patient-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Patient registered successfully',
            'data' => [
                'user' => $user,
                'patient' => $user->patient,
                'token' => $token
            ]
        ], 201);
    }

    /**
     * Login user
     */
    public function login(array $credentials): JsonResponse
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken($user->role . '-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'role' => $user->role,
                'token' => $token
            ]
        ]);
    }

    /**
     * Logout user
     */
    public function logout($user): JsonResponse
    {
        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get user profile
     */
    public function profile($user): JsonResponse
    {
        $profileData = [
            'user' => $user,
            'role' => $user->role,
        ];

        // Include role-specific profile
        if ($user->isDoctor() && $user->doctor) {
            $profileData['doctor'] = $user->doctor;
        } elseif ($user->isPatient() && $user->patient) {
            $profileData['patient'] = $user->patient;
        }

        return response()->json([
            'success' => true,
            'data' => $profileData
        ]);
    }
}
