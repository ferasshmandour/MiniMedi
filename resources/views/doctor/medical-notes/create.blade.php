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

            <div class="mb-3">
                <label for="symptoms" class="form-label">{{ trans('messages.symptoms') }}</label>
                <textarea name="symptoms" id="symptoms" class="form-control" placeholder="{{ trans('messages.describe_symptoms') }}"
                    rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="diagnosis" class="form-label">{{ trans('messages.diagnosis') }}</label>
                <textarea name="diagnosis" id="diagnosis" class="form-control" placeholder="{{ trans('messages.enter_diagnosis') }}"
                    rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="prescription" class="form-label">{{ trans('messages.prescription') }}</label>
                <textarea name="prescription" id="prescription" class="form-control"
                    placeholder="{{ trans('messages.enter_medications') }}" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="treatment_plan" class="form-label">{{ trans('messages.treatment_plan') }}</label>
                <textarea name="treatment_plan" id="treatment_plan" class="form-control"
                    placeholder="{{ trans('messages.enter_treatment_plan') }}" rows="3"></textarea>
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
