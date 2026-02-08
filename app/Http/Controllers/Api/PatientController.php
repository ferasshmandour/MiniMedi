<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiPatientService;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientService;
    protected $mediaService;

    public function __construct(ApiPatientService $patientService, MediaService $mediaService)
    {
        $this->patientService = $patientService;
        $this->mediaService = $mediaService;
    }

    /**
     * Get current patient's profile
     */
    public function profile(): JsonResponse
    {
        return $this->patientService->getPatient(request()->user());
    }

    /**
     * Get all patients (admin only via web dashboard)
     * This endpoint is for API - only shows current patient profile
     */
    public function index(): JsonResponse
    {
        return $this->patientService->getPatient(request()->user());
    }

    /**
     * Get specific patient (for admin use via web dashboard)
     */
    public function show($id): JsonResponse
    {
        // This will be handled by web dashboard
        return response()->json([
            'success' => false,
            'message' => 'Please use web dashboard for patient management'
        ], 403);
    }

    /**
     * Upload profile photo via API
     */
    public function uploadProfilePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        return $this->mediaService->uploadProfilePhoto(
            $request->user(),
            $request->file('photo')
        );
    }

    /**
     * Upload document via API
     */
    public function uploadDocument(Request $request): JsonResponse
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'name' => 'nullable|string|max:255',
        ]);

        return $this->mediaService->uploadDocument(
            $request->user(),
            $request->file('document'),
            $request->input('name')
        );
    }

    /**
     * Delete document via API
     */
    public function deleteDocument(Request $request, $mediaId): JsonResponse
    {
        return $this->mediaService->deleteDocument($request->user(), $mediaId);
    }

    /**
     * Upload medical record via API
     */
    public function uploadMedicalRecord(Request $request): JsonResponse
    {
        $request->validate([
            'record' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'name' => 'nullable|string|max:255',
        ]);

        $patient = $request->user()->patient;

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }

        return $this->mediaService->uploadMedicalRecord(
            $patient,
            $request->file('record'),
            $request->input('name')
        );
    }

    /**
     * Delete medical record via API
     */
    public function deleteMedicalRecord(Request $request, $mediaId): JsonResponse
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }

        return $this->mediaService->deleteMedicalRecord($patient, $mediaId);
    }
}
