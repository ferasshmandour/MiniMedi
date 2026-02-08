<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppointmentService
{
    /**
     * Book a new appointment (Patient only)
     */
    public function store(array $data, $user): JsonResponse
    {
        // Only patients can book appointments
        if (!$user->isPatient()) {
            return response()->json([
                'success' => false,
                'message' => 'Only patients can book appointments'
            ], 403);
        }

        // Verify the doctor exists and is actually a doctor
        $doctor = User::where('id', $data['doctor_id'])
            ->where('role', 'doctor')
            ->first();

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid doctor selected'
            ], 422);
        }

        // Prepare appointment data
        $appointmentData = [
            'patient_id' => $user->id,
            'doctor_id' => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'status' => 'pending',
        ];

        // Add translatable fields (spatie/laravel-translatable handles JSON conversion)
        if (isset($data['reason'])) {
            $appointmentData['reason_translatable'] = $data['reason'];
        }

        $appointment = Appointment::create($appointmentData);

        // Load relationships for response
        $appointment->load(['patient', 'doctor']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully',
            'data' => $appointment
        ], 201);
    }

    /**
     * View own appointments (Patient) or assigned appointments (Doctor)
     */
    public function index($user): JsonResponse
    {
        $query = Appointment::with(['patient', 'doctor']);

        if ($user->isPatient()) {
            // Patients see only their own appointments
            $query->where('patient_id', $user->id);
        } elseif ($user->isDoctor()) {
            // Doctors see only their assigned appointments
            $query->where('doctor_id', $user->id);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $appointments,
            'count' => $appointments->count()
        ]);
    }

    /**
     * View a specific appointment
     */
    public function show($user, $id): JsonResponse
    {
        try {
            $appointment = Appointment::with(['patient', 'doctor', 'medicalNote'])
                ->findOrFail($id);

            // Check authorization
            if ($user->isPatient() && $appointment->patient_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to view this appointment'
                ], 403);
            }

            if ($user->isDoctor() && $appointment->doctor_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to view this appointment'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => $appointment
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found'
            ], 404);
        }
    }

    /**
     * Cancel own appointment (Patient)
     */
    public function cancel($user, $id): JsonResponse
    {
        if (!$user->isPatient()) {
            return response()->json([
                'success' => false,
                'message' => 'Only patients can cancel appointments'
            ], 403);
        }

        try {
            $appointment = Appointment::where('patient_id', $user->id)
                ->findOrFail($id);

            if (!$appointment->canBeCancelled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment cannot be cancelled'
                ], 400);
            }

            $appointment->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Appointment cancelled successfully',
                'data' => $appointment
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found'
            ], 404);
        }
    }
}
