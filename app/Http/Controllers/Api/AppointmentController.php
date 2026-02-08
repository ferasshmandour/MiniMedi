<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AppointmentStoreRequest;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Book a new appointment (Patient only)
     */
    public function store(AppointmentStoreRequest $request): JsonResponse
    {
        return $this->appointmentService->store($request->validated(), $request->user());
    }

    /**
     * View own appointments (Patient) or assigned appointments (Doctor)
     */
    public function index(): JsonResponse
    {
        return $this->appointmentService->index(request()->user());
    }

    /**
     * View a specific appointment
     */
    public function show($id): JsonResponse
    {
        return $this->appointmentService->show(request()->user(), $id);
    }

    /**
     * Cancel own appointment (Patient)
     */
    public function cancel($id): JsonResponse
    {
        return $this->appointmentService->cancel(request()->user(), $id);
    }
}
