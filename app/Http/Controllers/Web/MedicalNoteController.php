<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\MedicalNoteStoreRequest;
use App\Services\MedicalNoteService;

class MedicalNoteController extends Controller
{
    protected $medicalNoteService;

    public function __construct(MedicalNoteService $medicalNoteService)
    {
        $this->medicalNoteService = $medicalNoteService;
    }

    /**
     * List all medical notes (Doctor)
     */
    public function index()
    {
        $notes = $this->medicalNoteService->getDoctorNotes();
        return view('doctor.medical-notes.index', compact('notes'));
    }

    /**
     * Show create medical note form
     */
    public function create($appointmentId)
    {
        $appointment = \App\Models\Appointment::with(['patient'])->findOrFail($appointmentId);
        return view('doctor.medical-notes.create', compact('appointment'));
    }

    /**
     * Store new medical note
     */
    public function store(MedicalNoteStoreRequest $request)
    {
        return $this->medicalNoteService->store($request->validated());
    }

    /**
     * Show medical note details
     */
    public function show($id)
    {
        $note = \App\Models\MedicalNote::with(['appointment', 'appointment.patient'])->findOrFail($id);
        return view('doctor.medical-notes.show', compact('note'));
    }
}
