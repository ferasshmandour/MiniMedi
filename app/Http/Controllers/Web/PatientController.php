<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\PatientStoreRequest;
use App\Services\PatientService;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * List all patients (Admin)
     */
    public function index()
    {
        $patients = $this->patientService->getAllPatients();
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show create patient form (Admin)
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store new patient (Admin)
     */
    public function store(PatientStoreRequest $request)
    {
        return $this->patientService->store($request->validated());
    }

    /**
     * Show patient details (Admin)
     */
    public function show($id)
    {
        $patient = \App\Models\User::where('role', 'patient')->with('patient')->findOrFail($id);
        return view('admin.patients.show', compact('patient'));
    }
}
