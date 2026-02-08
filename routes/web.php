<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Dashboard Routes
|--------------------------------------------------------------------------
|
| These routes are for the web dashboard (Admin & Doctor interfaces)
| They require session-based authentication
|
*/

// Public routes (login page)
Route::get('/login', [\App\Http\Controllers\Web\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\Web\AuthController::class, 'login']);

// Dashboard home - Shows patients list for admin
Route::get('/dashboard', [\App\Http\Controllers\Web\DashboardController::class, 'index'])->name('dashboard');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Logout (support both GET and POST for convenience)
    Route::post('/logout', [\App\Http\Controllers\Web\AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [\App\Http\Controllers\Web\AuthController::class, 'logout'])->name('logout.get');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\Web\ProfileController::class, 'show'])->name('profile');

    // Profile Media Uploads
    Route::post('/profile/photo/upload', [\App\Http\Controllers\Web\ProfileController::class, 'uploadProfilePhoto'])->name('profile.photo.upload');
    Route::post('/profile/document/upload', [\App\Http\Controllers\Web\ProfileController::class, 'uploadDocument'])->name('profile.document.upload');
    Route::delete('/profile/document/{mediaId}/delete', [\App\Http\Controllers\Web\ProfileController::class, 'deleteDocument'])->name('profile.document.delete');

    // Doctor-specific media uploads
    Route::post('/profile/doctor/photo/upload', [\App\Http\Controllers\Web\ProfileController::class, 'uploadDoctorPhoto'])->name('profile.doctor.photo.upload');
    Route::post('/profile/certification/upload', [\App\Http\Controllers\Web\ProfileController::class, 'uploadCertification'])->name('profile.certification.upload');
    Route::delete('/profile/certification/{mediaId}/delete', [\App\Http\Controllers\Web\ProfileController::class, 'deleteCertification'])->name('profile.certification.delete');

    // Patient-specific media uploads
    Route::post('/profile/patient/photo/upload', [\App\Http\Controllers\Web\ProfileController::class, 'uploadPatientPhoto'])->name('profile.patient.photo.upload');
    Route::post('/profile/medical-record/upload', [\App\Http\Controllers\Web\ProfileController::class, 'uploadMedicalRecord'])->name('profile.medical-record.upload');
    Route::delete('/profile/medical-record/{mediaId}/delete', [\App\Http\Controllers\Web\ProfileController::class, 'deleteMedicalRecord'])->name('profile.medical-record.delete');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard - View all patients
        Route::get('/dashboard', [\App\Http\Controllers\Web\DashboardController::class, 'index'])->name('dashboard');

        // Doctors management
        Route::get('/doctors', [\App\Http\Controllers\Web\DoctorController::class, 'index'])->name('doctors.index');
        Route::get('/doctors/create', [\App\Http\Controllers\Web\DoctorController::class, 'create'])->name('doctors.create');
        Route::post('/doctors', [\App\Http\Controllers\Web\DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/doctors/{doctor}', [\App\Http\Controllers\Web\DoctorController::class, 'show'])->name('doctors.show');

        // Patients management - View and details only
        Route::get('/patients', [\App\Http\Controllers\Web\PatientController::class, 'index'])->name('patients.index');
        Route::get('/patients/create', [\App\Http\Controllers\Web\PatientController::class, 'create'])->name('patients.create');
        Route::post('/patients', [\App\Http\Controllers\Web\PatientController::class, 'store'])->name('patients.store');
        Route::get('/patients/{patient}', [\App\Http\Controllers\Web\PatientController::class, 'show'])->name('patients.show');

        // All appointments
        Route::get('/appointments', [\App\Http\Controllers\Web\AppointmentController::class, 'adminIndex'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [\App\Http\Controllers\Web\AppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\Web\AppointmentController::class, 'updateStatus'])->name('appointments.update-status');

        // Roles & Permissions
        Route::get('/roles', [\App\Http\Controllers\Web\RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [\App\Http\Controllers\Web\RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [\App\Http\Controllers\Web\RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}', [\App\Http\Controllers\Web\RoleController::class, 'show'])->name('roles.show');
        Route::delete('/roles/{role}', [\App\Http\Controllers\Web\RoleController::class, 'destroy'])->name('roles.destroy');

        // Permissions management
        Route::get('/permissions', [\App\Http\Controllers\Web\PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [\App\Http\Controllers\Web\PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [\App\Http\Controllers\Web\PermissionController::class, 'store'])->name('permissions.store');
        Route::delete('/permissions/{permission}', [\App\Http\Controllers\Web\PermissionController::class, 'destroy'])->name('permissions.destroy');

        // Assign role to doctor
        Route::post('/doctors/{doctor}/assign-role', [\App\Http\Controllers\Web\DoctorController::class, 'assignRole'])->name('doctors.assign-role');
        Route::post('/doctors/{doctor}/unassign-role', [\App\Http\Controllers\Web\DoctorController::class, 'unassignRole'])->name('doctors.unassign-role');
        Route::get('/doctors/roles/manage', [\App\Http\Controllers\Web\DoctorController::class, 'manageRoles'])->name('doctors.roles.manage');
    });

    // Doctor Routes
    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        // Doctor's appointments
        Route::get('/appointments', [\App\Http\Controllers\Web\AppointmentController::class, 'doctorIndex'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [\App\Http\Controllers\Web\AppointmentController::class, 'show'])->name('appointments.show');

        // Medical notes
        Route::get('/medical-notes', [\App\Http\Controllers\Web\MedicalNoteController::class, 'index'])->name('medical-notes.index');
        Route::get('/medical-notes/create/{appointment}', [\App\Http\Controllers\Web\MedicalNoteController::class, 'create'])->name('medical-notes.create');
        Route::post('/medical-notes', [\App\Http\Controllers\Web\MedicalNoteController::class, 'store'])->name('medical-notes.store');
        Route::get('/medical-notes/{note}', [\App\Http\Controllers\Web\MedicalNoteController::class, 'show'])->name('medical-notes.show');
    });

    // Note: Patient routes are only in API (api.php) - Patients do not have web dashboard access
});

// Root URL - redirect to dashboard or login
Route::get('/', function () {
    if (auth()->user()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Language switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language');

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'message' => 'MiniMedi API is running']);
})->name('health');
