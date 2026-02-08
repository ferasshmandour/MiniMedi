<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalNote;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Doctor User
        $doctorUser = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor@hospital.com',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'General Medicine',
            'license_number' => 'MD-12345',
            'department' => 'General',
            'phone' => '+1-555-0100',
            'bio' => 'Experienced general physician with 15 years of practice.',
        ]);

        // Create Second Doctor
        $doctorUser2 = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'doctor2@hospital.com',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
        ]);

        $doctor2 = Doctor::create([
            'user_id' => $doctorUser2->id,
            'specialization' => 'Cardiology',
            'license_number' => 'MD-12346',
            'department' => 'Cardiology',
            'phone' => '+1-555-0101',
            'bio' => 'Specialist in cardiovascular diseases.',
        ]);

        // Create Patient User
        $patientUser = User::create([
            'name' => 'Alice Williams',
            'email' => 'patient@example.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);

        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'phone' => '+1-555-0200',
            'address' => '123 Main Street, City',
            'date_of_birth' => '1990-05-15',
            'blood_type' => 'A+',
            'allergies' => 'Penicillin',
            'medical_history' => 'No major illnesses',
        ]);

        // Create Second Patient
        $patientUser2 = User::create([
            'name' => 'Bob Brown',
            'email' => 'patient2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);

        $patient2 = Patient::create([
            'user_id' => $patientUser2->id,
            'phone' => '+1-555-0201',
            'address' => '456 Oak Avenue, Town',
            'date_of_birth' => '1985-08-22',
            'blood_type' => 'O-',
            'allergies' => 'None known',
            'medical_history' => 'Seasonal asthma',
        ]);

        // Create Sample Appointments
        $appointment1 = Appointment::create([
            'patient_id' => $patientUser->id,
            'doctor_id' => $doctorUser->id,
            'appointment_date' => now()->addDays(2),
            'status' => 'confirmed',
            'reason' => 'Annual checkup',
            'notes' => 'Patient requested morning appointment',
        ]);

        $appointment2 = Appointment::create([
            'patient_id' => $patientUser->id,
            'doctor_id' => $doctorUser2->id,
            'appointment_date' => now()->addDays(5),
            'status' => 'pending',
            'reason' => 'Heart palpitations',
        ]);

        $appointment3 = Appointment::create([
            'patient_id' => $patientUser2->id,
            'doctor_id' => $doctorUser->id,
            'appointment_date' => now()->addDays(1),
            'status' => 'pending',
            'reason' => 'Flu symptoms',
        ]);

        // Create Medical Note for completed appointment
        $completedAppointment = Appointment::create([
            'patient_id' => $patientUser->id,
            'doctor_id' => $doctorUser->id,
            'appointment_date' => now()->subDays(7),
            'status' => 'completed',
            'reason' => 'Follow-up visit',
        ]);

        MedicalNote::create([
            'appointment_id' => $completedAppointment->id,
            'doctor_id' => $doctorUser->id,
            'diagnosis' => 'Mild respiratory infection',
            'prescription' => 'Amoxicillin 500mg, 3 times daily for 7 days',
            'treatment_plan' => 'Rest and plenty of fluids. Follow up in 2 weeks if symptoms persist.',
            'symptoms' => 'Cough, mild fever, fatigue',
            'vital_signs' => 'BP: 120/80, HR: 72, Temp: 37.5°C',
        ]);

        // Create Role for Permission Example
        $doctorRole = Role::create([
            'name' => 'Senior Doctor',
            'description' => 'Senior doctor with additional permissions',
            'permissions' => [
                'create_medical_notes',
                'view_all_patients',
                'edit_appointments',
                'prescribe_medication',
            ],
        ]);

        // Assign role to first doctor
        $doctorUser->roles()->attach($doctorRole->id);

        // Output information
        $this->command->info('Database seeded successfully!');
        $this->command->info('Sample users created:');
        $this->command->info('- Admin: admin@hospital.com / password123');
        $this->command->info('- Doctor: doctor@hospital.com / password123');
        $this->command->info('- Doctor 2: doctor2@hospital.com / password123');
        $this->command->info('- Patient: patient@example.com / password123');
        $this->command->info('- Patient 2: patient2@example.com / password123');
    }
}
