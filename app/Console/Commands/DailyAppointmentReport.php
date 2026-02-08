<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyAppointmentReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily appointment report';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = now()->startOfDay();
        $tomorrow = now()->endOfDay();

        $appointments = Appointment::whereBetween('appointment_date', [$today, $tomorrow])
            ->with(['patient', 'doctor'])
            ->get();

        $stats = [
            'total' => $appointments->count(),
            'pending' => $appointments->where('status', 'pending')->count(),
            'confirmed' => $appointments->where('status', 'confirmed')->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
            'cancelled' => $appointments->where('status', 'cancelled')->count(),
        ];

        // Log the report
        Log::info('Daily Appointment Report', [
            'date' => $today->toDateString(),
            'stats' => $stats,
            'appointments' => $appointments->map(function ($apt) {
                return [
                    'id' => $apt->id,
                    'patient' => $apt->patient->name,
                    'doctor' => $apt->doctor->name,
                    'time' => $apt->appointment_date->format('H:i'),
                    'status' => $apt->status,
                ];
            }),
        ]);

        $this->info("Daily Appointment Report - {$today->toDateString()}");
        $this->info("Total Appointments: {$stats['total']}");
        $this->info("Pending: {$stats['pending']}");
        $this->info("Confirmed: {$stats['confirmed']}");
        $this->info("Completed: {$stats['completed']}");
        $this->info("Cancelled: {$stats['cancelled']}");

        return Command::SUCCESS;
    }
}
