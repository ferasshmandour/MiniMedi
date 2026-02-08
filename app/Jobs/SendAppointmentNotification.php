<?php

namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAppointmentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $appointment;
    public $action;

    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment, string $action)
    {
        $this->appointment = $appointment;
        $this->action = $action;
        $this->queue = 'notifications';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $patient = $this->appointment->patient;
        $doctor = $this->appointment->doctor;

        $message = match ($this->action) {
            'created' => "New appointment scheduled for {$patient->name} with Dr. {$doctor->name} on {$this->appointment->appointment_date}",
            'updated' => "Appointment updated for {$patient->name} with Dr. {$doctor->name}. New status: {$this->appointment->status}",
            'deleted' => "Appointment cancelled for {$patient->name} with Dr. {$doctor->name}",
            default => "Appointment notification",
        };

        // Log the notification (in real app, this would send email/SMS/push notification)
        Log::info('Appointment Notification', [
            'action' => $this->action,
            'appointment_id' => $this->appointment->id,
            'patient' => $patient->name,
            'doctor' => $doctor->name,
            'message' => $message,
            'timestamp' => now(),
        ]);

        // Simulate sending notification
        // In production, integrate with:
        // - Mail::to($patient->email)->send(new AppointmentNotification($this->appointment));
        // - SMS service for mobile notifications
        // - Push notification service
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return ['appointment', $this->appointment->id, $this->action];
    }
}
