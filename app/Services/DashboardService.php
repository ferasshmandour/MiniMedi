<?php

namespace App\Services;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    /**
     * Get dashboard data based on user role
     */
    public function getDashboardData()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return [
                'role' => 'admin',
                'stats' => [
                    'total_patients' => User::where('role', 'patient')->count(),
                    'total_doctors' => User::where('role', 'doctor')->count(),
                    'total_appointments' => Appointment::count(),
                    'pending_appointments' => Appointment::where('status', 'pending')->count(),
                ],
                'recent_appointments' => Appointment::with(['patient', 'doctor'])->latest()->take(10)->get(),
                'recent_patients' => User::where('role', 'patient')->with('patient')->latest()->take(10)->get(),
            ];
        }

        if ($user->isDoctor()) {
            return [
                'role' => 'doctor',
                'stats' => [
                    'today_appointments' => $user->appointmentsAsDoctor()
                        ->whereDate('appointment_date', today())
                        ->count(),
                    'pending_appointments' => $user->appointmentsAsDoctor()
                        ->where('status', 'pending')
                        ->count(),
                    'completed_appointments' => $user->appointmentsAsDoctor()
                        ->where('status', 'completed')
                        ->count(),
                ],
                'today_appointments' => $user->appointmentsAsDoctor()
                    ->whereDate('appointment_date', today())
                    ->with(['patient', 'doctor'])
                    ->orderBy('appointment_date')
                    ->get(),
            ];
        }

        if ($user->isPatient()) {
            return [
                'role' => 'patient',
                'stats' => [
                    'upcoming_appointments' => $user->appointmentsAsPatient()
                        ->where('status', 'pending')
                        ->whereDate('appointment_date', '>=', today())
                        ->count(),
                    'completed_appointments' => $user->appointmentsAsPatient()
                        ->where('status', 'completed')
                        ->count(),
                ],
                'upcoming_appointments' => $user->appointmentsAsPatient()
                    ->where('status', 'pending')
                    ->whereDate('appointment_date', '>=', today())
                    ->with(['patient', 'doctor'])
                    ->orderBy('appointment_date')
                    ->get(),
            ];
        }

        return [];
    }

    /**
     * Get patients for dashboard (admin view only)
     */
    public function getPatientsForDashboard()
    {
        return User::where('role', 'patient')->with('patient')->latest()->get();
    }

    /**
     * Get patient details for dashboard
     */
    public function getPatientDetailsForDashboard(User $patient)
    {
        return $patient->load([
            'patient',
            'appointmentsAsPatient' => function ($query) {
                $query->with(['doctor'])->latest();
            }
        ]);
    }
}
