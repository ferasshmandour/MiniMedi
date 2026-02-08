<?php

namespace App\Observers;

use App\Events\AppointmentCreated;
use App\Jobs\SendAppointmentNotification;
use App\Models\Appointment;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        // Fire the event when an appointment is created
        AppointmentCreated::dispatch($appointment);

        // Queue a job to send notification
        SendAppointmentNotification::dispatch($appointment, 'created');
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        // Queue a job to send notification when appointment is updated
        SendAppointmentNotification::dispatch($appointment, 'updated');
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        // Queue a job to send notification when appointment is deleted
        SendAppointmentNotification::dispatch($appointment, 'deleted');
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
