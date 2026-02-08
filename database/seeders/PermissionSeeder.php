<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'view_dashboard' => 'View Dashboard',

            // Doctors
            'create_doctors' => 'Create Doctors',
            'view_doctors' => 'View Doctors',
            'edit_doctors' => 'Edit Doctors',
            'delete_doctors' => 'Delete Doctors',
            'assign_doctor_roles' => 'Assign Doctor Roles',

            // Patients
            'create_patients' => 'Create Patients',
            'view_patients' => 'View Patients',
            'edit_patients' => 'Edit Patients',
            'delete_patients' => 'Delete Patients',

            // Appointments
            'create_appointments' => 'Create Appointments',
            'view_appointments' => 'View Appointments',
            'edit_appointments' => 'Edit Appointments',
            'delete_appointments' => 'Delete Appointments',
            'cancel_appointments' => 'Cancel Appointments',
            'approve_appointments' => 'Approve Appointments',

            // Medical Notes
            'create_medical_notes' => 'Create Medical Notes',
            'view_medical_notes' => 'View Medical Notes',
            'edit_medical_notes' => 'Edit Medical Notes',
            'delete_medical_notes' => 'Delete Medical Notes',

            // Roles & Permissions
            'view_roles' => 'View Roles',
            'create_roles' => 'Create Roles',
            'edit_roles' => 'Edit Roles',
            'delete_roles' => 'Delete Roles',
            'assign_roles' => 'Assign Roles',

            // Users
            'view_users' => 'View Users',
            'create_users' => 'Create Users',
            'edit_users' => 'Edit Users',
            'delete_users' => 'Delete Users',

            // Reports
            'view_reports' => 'View Reports',
            'export_reports' => 'Export Reports',
        ];

        foreach ($permissions as $name => $description) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }
    }
}
