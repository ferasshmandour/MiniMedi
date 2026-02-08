<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Display user profile
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Upload profile photo
     */
    public function uploadProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        return $this->mediaService->uploadProfilePhoto(
            Auth::user(),
            $request->file('photo')
        );
    }

    /**
     * Upload document
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'name' => 'nullable|string|max:255',
        ]);

        return $this->mediaService->uploadDocument(
            Auth::user(),
            $request->file('document'),
            $request->input('name')
        );
    }

    /**
     * Delete document
     */
    public function deleteDocument(Request $request, $mediaId)
    {
        return $this->mediaService->deleteDocument(Auth::user(), $mediaId);
    }

    /**
     * Upload doctor photo (for doctor profile)
     */
    public function uploadDoctorPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor profile not found'
            ], 404);
        }

        return $this->mediaService->uploadDoctorPhoto($doctor, $request->file('photo'));
    }

    /**
     * Upload certification (for doctor profile)
     */
    public function uploadCertification(Request $request)
    {
        $request->validate([
            'certification' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'name' => 'nullable|string|max:255',
        ]);

        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor profile not found'
            ], 404);
        }

        return $this->mediaService->uploadCertification(
            $doctor,
            $request->file('certification'),
            $request->input('name')
        );
    }

    /**
     * Delete certification
     */
    public function deleteCertification(Request $request, $mediaId)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor profile not found'
            ], 404);
        }

        return $this->mediaService->deleteCertification($doctor, $mediaId);
    }

    /**
     * Upload patient photo
     */
    public function uploadPatientPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $patient = Auth::user()->patient;

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }

        return $this->mediaService->uploadPatientPhoto($patient, $request->file('photo'));
    }

    /**
     * Upload medical record
     */
    public function uploadMedicalRecord(Request $request)
    {
        $request->validate([
            'record' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'name' => 'nullable|string|max:255',
        ]);

        $patient = Auth::user()->patient;

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
     * Delete medical record
     */
    public function deleteMedicalRecord(Request $request, $mediaId)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }

        return $this->mediaService->deleteMedicalRecord($patient, $mediaId);
    }
}
