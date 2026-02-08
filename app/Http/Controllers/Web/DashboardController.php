<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the dashboard based on user role
     */
    public function index(Request $request)
    {
        $data = $this->dashboardService->getDashboardData();
        return view('dashboard.index', compact('data'));
    }

    /**
     * View all patients (Admin only)
     */
    public function patients()
    {
        $patients = $this->dashboardService->getPatientsForDashboard();
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * View patient details (Admin only)
     */
    public function patientDetails($id)
    {
        $patient = \App\Models\User::where('role', 'patient')->with('patient')->findOrFail($id);
        $patientDetails = $this->dashboardService->getPatientDetailsForDashboard($patient);
        return view('admin.patients.show', compact('patient', 'patientDetails'));
    }
}
