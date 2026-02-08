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

        // Prepare medical note data
        $noteData = [
            'appointment_id' => $data['appointment_id'],
            'doctor_id' => Auth::id(),
        ];

        // Add translatable fields (spatie/laravel-translatable handles JSON conversion)
        if (isset($data['diagnosis'])) {
            $noteData['diagnosis_translatable'] = $data['diagnosis'];
        }
        if (isset($data['prescription'])) {
            $noteData['prescription_translatable'] = $data['prescription'];
        }
        if (isset($data['treatment_plan'])) {
            $noteData['treatment_plan_translatable'] = $data['treatment_plan'];
        }
        if (isset($data['symptoms'])) {
            $noteData['symptoms_translatable'] = $data['symptoms'];
        }
        if (isset($data['vital_signs'])) {
            $noteData['vital_signs_translatable'] = $data['vital_signs'];
        }

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
