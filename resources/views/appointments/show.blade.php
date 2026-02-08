@extends('layouts.app')

@section('title', trans('messages.appointment_details'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">📅 {{ trans('messages.appointment_details') }}</h1>
        <x-button href="{{ URL::previous() }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back') }}
        </x-button>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <x-card>
                @slot('title')
                    <i class="bi bi-calendar-event me-2"></i>{{ trans('messages.appointment_information') }}
                @endslot

                <x-input name="date" label="{{ trans('messages.date_time') }}" :value="$appointment->appointment_date->format('F d, Y \\a\\t H:i')" disabled />
                <div class="mb-3">
                    <label class="form-label">{{ trans('messages.status') }}</label>
                    <div>
                        @switch($appointment->status)
                            @case('pending')
                                <x-badge type="warning">{{ ucfirst($appointment->status) }}</x-badge>
                            @break

                            @case('confirmed')
                                <x-badge type="success">{{ ucfirst($appointment->status) }}</x-badge>
                            @break

                            @case('completed')
                                <x-badge type="info">{{ ucfirst($appointment->status) }}</x-badge>
                            @break

                            @case('cancelled')
                                <x-badge type="danger">{{ ucfirst($appointment->status) }}</x-badge>
                            @break

                            @default
                                <x-badge type="secondary">{{ ucfirst($appointment->status) }}</x-badge>
                        @endswitch
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ trans('messages.reason') }}</label>
                    <textarea class="form-control" disabled rows="3">{{ $appointment->reason ?? ($appointment->reason_translatable[app()->getLocale()] ?? '') }}</textarea>
                </div>
            </x-card>
        </div>

        <div class="col-md-4">
            <x-card>
                @slot('title')
                    <i class="bi bi-person me-2"></i>{{ trans('messages.patient') }}
                @endslot

                <x-input name="name" label="{{ trans('messages.name') }}" :value="$appointment->patient->name" disabled />
                <x-input name="email" label="{{ trans('messages.email') }}" :value="$appointment->patient->email" disabled />
            </x-card>
        </div>

        <div class="col-md-4">
            <x-card>
                @slot('title')
                    <i class="bi bi-activity me-2"></i>{{ trans('messages.doctor') }}
                @endslot

                <x-input name="name" label="{{ trans('messages.name') }}" :value="'Dr. ' . $appointment->doctor->name" disabled />
                <x-input name="specialization" label="{{ trans('messages.specialization') }}" :value="$appointment->doctor->doctor->specialization ?? 'N/A'" disabled />
            </x-card>
        </div>
    </div>

    @if ($appointment->medicalNote)
        <x-card class="mb-4">
            @slot('title')
                <i class="bi bi-file-medical me-2"></i>{{ trans('messages.medical_note') }}
            @endslot

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{ trans('messages.diagnosis') }}</label>
                        <textarea class="form-control" disabled rows="3">{{ $appointment->medicalNote->diagnosis ?? ($appointment->medicalNote->diagnosis_translatable[app()->getLocale()] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{ trans('messages.prescription') }}</label>
                        <textarea class="form-control" disabled rows="3">{{ $appointment->medicalNote->prescription ?? ($appointment->medicalNote->prescription_translatable[app()->getLocale()] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            @if ($appointment->medicalNote->treatment_plan)
                <div class="mb-3">
                    <label class="form-label">{{ trans('messages.treatment_plan') }}</label>
                    <textarea class="form-control" disabled rows="2">{{ $appointment->medicalNote->treatment_plan ?? ($appointment->medicalNote->treatment_plan_translatable[app()->getLocale()] ?? '') }}</textarea>
                </div>
            @endif
        </x-card>
    @endif

    <div class="mt-4">
        <x-button href="{{ URL::previous() }}" variant="outline-primary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back') }}
        </x-button>
    </div>
@endsection
