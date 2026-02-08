<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\MedicalNote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalNoteService
{
    /**
     * List all medical notes for doctor
     */
    public function getDoctorNotes()
    {
        return MedicalNote::where('doctor_id', Auth::id())
            ->with(['appointment', 'appointment.patient'])
            ->latest()
            ->get();
    }

    /**
     * Store new medical note
     */
    public function store(array $data): \Illuminate\Http\RedirectResponse
    {
        $appointment = Appointment::findOrFail($data['appointment_id']);

        // Verify doctor owns this appointment
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Handle translatable fields - they come as arrays from the form
        $diagnosis = $data['diagnosis'] ?? ['en' => '', 'ar' => ''];
        $prescription = $data['prescription'] ?? ['en' => '', 'ar' => ''];
        $treatment_plan = $data['treatment_plan'] ?? ['en' => '', 'ar' => ''];
        $symptoms = $data['symptoms'] ?? ['en' => '', 'ar' => ''];
        $vital_signs = $data['vital_signs'] ?? null;

        // Prepare medical note data - use spatie/laravel-translatable format
        $noteData = [
            'appointment_id' => $data['appointment_id'],
            'doctor_id' => Auth::id(),
            // These will be automatically cast to JSON by the HasTranslations trait
            'diagnosis' => $diagnosis,
            'prescription' => $prescription,
            'treatment_plan' => $treatment_plan,
            'symptoms' => $symptoms,
            'vital_signs' => $vital_signs,
        ];

        MedicalNote::create($noteData);

        $appointment->update(['status' => 'completed']);

        return redirect()->route('doctor.medical-notes.index')->with('success', 'Medical note added successfully!');
    }

    /**
     * Show medical note details
     */
    public function show(MedicalNote $note)
    {
        // Verify doctor owns this note
        if ($note->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return $note->load(['appointment', 'appointment.patient']);
    }
}
