<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\AppointmentStoreRequest;
use App\Http\Requests\Web\AppointmentUpdateStatusRequest;
use App\Services\WebAppointmentService;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(WebAppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Admin: View all appointments
     */
    public function adminIndex()
    {
        $appointments = $this->appointmentService->getAllAppointments();
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Doctor: View assigned appointments
     */
    public function doctorIndex()
    {
        $appointments = $this->appointmentService->getDoctorAppointments();
        return view('doctor.appointments.index', compact('appointments'));
    }

    /**
     * Patient: View own appointments
     */
    public function patientIndex()
    {
        $appointments = $this->appointmentService->getPatientAppointments();
        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show appointment details
     */
    public function show($id)
    {
        $appointment = \App\Models\Appointment::with(['patient', 'doctor', 'medicalNote'])->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Patient: Book appointment form
     */
    public function create()
    {
        $doctors = $this->appointmentService->getDoctorsForBooking();
        return view('patient.book-appointment', compact('doctors'));
    }

    /**
     * Patient: Store new appointment
     */
    public function store(AppointmentStoreRequest $request)
    {
        return $this->appointmentService->store($request->validated());
    }

    /**
     * Update appointment status (Admin)
     */
    public function updateStatus(AppointmentUpdateStatusRequest $request, $id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        return $this->appointmentService->updateStatus($appointment, $request->validated());
    }

    /**
     * Cancel appointment (Patient)
     */
    public function cancel($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        return $this->appointmentService->cancel($appointment);
    }
}
