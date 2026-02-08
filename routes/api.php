<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/auth/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
});

// Protected routes - Patient API only
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    // Auth endpoints
    Route::get('/auth/profile', [\App\Http\Controllers\Api\AuthController::class, 'profile']);
    Route::post('/auth/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    // Patient Profile
    Route::get('/patient', [\App\Http\Controllers\Api\PatientController::class, 'profile']);
    Route::get('/patient/profile', [\App\Http\Controllers\Api\PatientController::class, 'profile']);

    // Patient Media Uploads
    Route::post('/patient/profile-photo', [\App\Http\Controllers\Api\PatientController::class, 'uploadProfilePhoto']);
    Route::post('/patient/document', [\App\Http\Controllers\Api\PatientController::class, 'uploadDocument']);
    Route::delete('/patient/document/{mediaId}', [\App\Http\Controllers\Api\PatientController::class, 'deleteDocument']);
    Route::post('/patient/medical-record', [\App\Http\Controllers\Api\PatientController::class, 'uploadMedicalRecord']);
    Route::delete('/patient/medical-record/{mediaId}', [\App\Http\Controllers\Api\PatientController::class, 'deleteMedicalRecord']);

    // Patient Appointments
    Route::get('/appointments', [\App\Http\Controllers\Api\AppointmentController::class, 'index']);
    Route::post('/appointments', [\App\Http\Controllers\Api\AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [\App\Http\Controllers\Api\AppointmentController::class, 'show']);
    Route::post('/appointments/{id}/cancel', [\App\Http\Controllers\Api\AppointmentController::class, 'cancel']);
});
