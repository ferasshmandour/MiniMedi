<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Doctors table - add JSON columns for translatable fields
        Schema::table('doctors', function (Blueprint $table) {
            $table->json('specialization_translatable')->nullable()->after('specialization');
            $table->json('department_translatable')->nullable()->after('department');
            $table->json('bio_translatable')->nullable()->after('bio');
        });

        // Patients table - add JSON columns for translatable fields
        Schema::table('patients', function (Blueprint $table) {
            $table->json('allergies_translatable')->nullable()->after('allergies');
            $table->json('medical_history_translatable')->nullable()->after('medical_history');
        });

        // Appointments table - add JSON columns for translatable fields
        Schema::table('appointments', function (Blueprint $table) {
            $table->json('reason_translatable')->nullable()->after('reason');
            $table->json('notes_translatable')->nullable()->after('notes');
        });

        // Medical notes table - add JSON columns for translatable fields
        Schema::table('medical_notes', function (Blueprint $table) {
            $table->json('diagnosis_translatable')->nullable()->after('diagnosis');
            $table->json('prescription_translatable')->nullable()->after('prescription');
            $table->json('treatment_plan_translatable')->nullable()->after('treatment_plan');
            $table->json('symptoms_translatable')->nullable()->after('symptoms');
            $table->json('vital_signs_translatable')->nullable()->after('vital_signs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'specialization_translatable',
                'department_translatable',
                'bio_translatable',
            ]);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'allergies_translatable',
                'medical_history_translatable',
            ]);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'reason_translatable',
                'notes_translatable',
            ]);
        });

        Schema::table('medical_notes', function (Blueprint $table) {
            $table->dropColumn([
                'diagnosis_translatable',
                'prescription_translatable',
                'treatment_plan_translatable',
                'symptoms_translatable',
                'vital_signs_translatable',
            ]);
        });
    }
};
