<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class WebAppointmentService
{
    /**
     * Admin: View all appointments
     */
    public function getAllAppointments()
    {
        return Appointment::with(['patient', 'doctor'])->latest()->get();
    }

    /**
     * Doctor: View assigned appointments
     */
    public function getDoctorAppointments()
    {
        return Auth::user()->appointmentsAsDoctor()->with(['patient', 'doctor'])->latest()->get();
    }

    /**
     * Patient: View own appointments
     */
    public function getPatientAppointments()
    {
        return Auth::user()->appointmentsAsPatient()->with(['patient', 'doctor'])->latest()->get();
    }

    /**
     * Get all doctors for booking
     */
    public function getDoctorsForBooking()
    {
        return User::where('role', 'doctor')->with('doctor')->get();
    }

    /**
     * Store new appointment
     */
    public function store(array $data): RedirectResponse
    {
        $doctor = User::where('id', $data['doctor_id'])
            ->where('role', 'doctor')
            ->firstOrFail();

        $appointment = Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'reason' => $data['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments.index')->with('success', 'Appointment booked successfully!');
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Appointment $appointment, array $data): RedirectResponse
    {
        $appointment->update(['status' => $data['status']]);
        return back()->with('success', 'Appointment status updated!');
    }

    /**
     * Cancel appointment
     */
    public function cancel(Appointment $appointment): RedirectResponse
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$appointment->canBeCancelled()) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Appointment cancelled successfully!');
    }
}
