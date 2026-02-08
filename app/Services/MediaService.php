<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MediaService
{
    /**
     * Upload profile photo for user
     */
    public function uploadProfilePhoto($user, $file): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Remove existing profile photo
            if ($user->hasMedia('profile_photo')) {
                $user->clearMediaCollection('profile_photo');
            }

            // Add new profile photo
            $user->addMedia($file)
                ->toMediaCollection('profile_photo');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profile photo uploaded successfully',
                'data' => [
                    'photo_url' => $user->profile_photo_url,
                    'thumbnail_url' => $user->profile_photo_thumbnail_url,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile photo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload document for user
     */
    public function uploadDocument($user, $file, string $name = null): JsonResponse
    {
        try {
            $user->addMedia($file)
                ->usingName($name ?? $file->getClientOriginalName())
                ->toMediaCollection('documents');

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'data' => [
                    'documents' => $user->documents->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'name' => $media->name,
                            'file_name' => $media->file_name,
                            'mime_type' => $media->mime_type,
                            'size' => $media->size,
                            'url' => $media->getUrl(),
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload document',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete document
     */
    public function deleteDocument($user, int $mediaId): JsonResponse
    {
        try {
            $media = $user->getMedia('documents')->find($mediaId);

            if (!$media) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document not found'
                ], 404);
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete document',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload doctor photo
     */
    public function uploadDoctorPhoto($doctor, $file): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Remove existing photo
            if ($doctor->hasMedia('doctor_photo')) {
                $doctor->clearMediaCollection('doctor_photo');
            }

            // Add new photo
            $doctor->addMedia($file)
                ->toMediaCollection('doctor_photo');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Doctor photo uploaded successfully',
                'data' => [
                    'photo_url' => $doctor->photo_url,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload doctor photo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload certification for doctor
     */
    public function uploadCertification($doctor, $file, string $name = null): JsonResponse
    {
        try {
            $doctor->addMedia($file)
                ->usingName($name ?? $file->getClientOriginalName())
                ->toMediaCollection('certifications');

            return response()->json([
                'success' => true,
                'message' => 'Certification uploaded successfully',
                'data' => [
                    'certifications' => $doctor->certifications->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'name' => $media->name,
                            'file_name' => $media->file_name,
                            'mime_type' => $media->mime_type,
                            'size' => $media->size,
                            'url' => $media->getUrl(),
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload certification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete certification
     */
    public function deleteCertification($doctor, int $mediaId): JsonResponse
    {
        try {
            $media = $doctor->getMedia('certifications')->find($mediaId);

            if (!$media) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certification not found'
                ], 404);
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certification deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete certification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload patient photo
     */
    public function uploadPatientPhoto($patient, $file): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Remove existing photo
            if ($patient->hasMedia('patient_photo')) {
                $patient->clearMediaCollection('patient_photo');
            }

            // Add new photo
            $patient->addMedia($file)
                ->toMediaCollection('patient_photo');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Patient photo uploaded successfully',
                'data' => [
                    'photo_url' => $patient->photo_url,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload patient photo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload medical record for patient
     */
    public function uploadMedicalRecord($patient, $file, string $name = null): JsonResponse
    {
        try {
            $patient->addMedia($file)
                ->usingName($name ?? $file->getClientOriginalName())
                ->toMediaCollection('medical_records');

            return response()->json([
                'success' => true,
                'message' => 'Medical record uploaded successfully',
                'data' => [
                    'medical_records' => $patient->medical_records->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'name' => $media->name,
                            'file_name' => $media->file_name,
                            'mime_type' => $media->mime_type,
                            'size' => $media->size,
                            'url' => $media->getUrl(),
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload medical record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete medical record
     */
    public function deleteMedicalRecord($patient, int $mediaId): JsonResponse
    {
        try {
            $media = $patient->getMedia('medical_records')->find($mediaId);

            if (!$media) {
                return response()->json([
                    'success' => false,
                    'message' => 'Medical record not found'
                ], 404);
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Medical record deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete medical record',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
