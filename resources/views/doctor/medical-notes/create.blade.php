@extends('layouts.app')

@section('title', trans('messages.add_medical_note'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">📝 {{ trans('messages.add_medical_note') }}</h1>
        <x-button href="{{ route('doctor.medical-notes.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-calendar-check me-2"></i>{{ trans('messages.appointment_with') }} {{ $appointment->patient->name }}
        @endslot

        <form method="POST" action="{{ route('doctor.medical-notes.store') }}">
            @csrf

            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

            @if ($errors->any())
                <x-alert type="danger" dismissible>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <!-- Translatable Fields Tabs -->
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#en-tab" type="button">
                        <i class="bi bi-translate me-1"></i>English
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ar-tab" type="button">
                        <i class="bi bi-translate me-1"></i>العربية
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- English Tab -->
                <div class="tab-pane fade show active" id="en-tab">
                    <div class="mb-3">
                        <label for="symptoms_en" class="form-label">{{ trans('messages.symptoms_en') }}</label>
                        <textarea name="symptoms[en]" id="symptoms_en" class="form-control"
                            placeholder="{{ trans('messages.describe_symptoms') }}" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosis_en" class="form-label">{{ trans('messages.diagnosis_en') }}</label>
                        <textarea name="diagnosis[en]" id="diagnosis_en" class="form-control"
                            placeholder="{{ trans('messages.enter_diagnosis') }}" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="prescription_en" class="form-label">{{ trans('messages.prescription_en') }}</label>
                        <textarea name="prescription[en]" id="prescription_en" class="form-control"
                            placeholder="{{ trans('messages.enter_medications') }}" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="treatment_plan_en" class="form-label">{{ trans('messages.treatment_plan_en') }}</label>
                        <textarea name="treatment_plan[en]" id="treatment_plan_en" class="form-control"
                            placeholder="{{ trans('messages.enter_treatment_plan') }}" rows="3"></textarea>
                    </div>
                </div>

                <!-- Arabic Tab -->
                <div class="tab-pane fade" id="ar-tab">
                    <div class="mb-3">
                        <label for="symptoms_ar" class="form-label">{{ trans('messages.symptoms_ar') }}</label>
                        <textarea name="symptoms[ar]" id="symptoms_ar" class="form-control" placeholder="أعراض المريض..." rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosis_ar" class="form-label">{{ trans('messages.diagnosis_ar') }}</label>
                        <textarea name="diagnosis[ar]" id="diagnosis_ar" class="form-control" placeholder="التشخيص الطبي..." rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="prescription_ar" class="form-label">{{ trans('messages.prescription_ar') }}</label>
                        <textarea name="prescription[ar]" id="prescription_ar" class="form-control" placeholder="الأدوية الموصوفة..."
                            rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="treatment_plan_ar" class="form-label">{{ trans('messages.treatment_plan_ar') }}</label>
                        <textarea name="treatment_plan[ar]" id="treatment_plan_ar" class="form-control" placeholder="خطة العلاج..."
                            rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="vital_signs" class="form-label">{{ trans('messages.vital_signs') }}</label>
                <textarea name="vital_signs" id="vital_signs" class="form-control"
                    placeholder="{{ trans('messages.vital_signs_placeholder') }}" rows="2"></textarea>
            </div>

            <div class="mt-4">
                <x-button type="submit" variant="success">
                    <i class="bi bi-check-circle me-2"></i>{{ trans('messages.save_medical_note') }}
                </x-button>
                <x-button href="{{ route('doctor.appointments.index') }}" variant="outline-secondary" class="ms-2">
                    {{ trans('messages.cancel') }}
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
