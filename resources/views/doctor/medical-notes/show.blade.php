@extends('layouts.app')

@section('title', trans('messages.medical_note'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">📝 {{ trans('messages.medical_note') }}</h1>
        <x-button href="{{ route('doctor.medical-notes.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-person me-2"></i>{{ trans('messages.patient') }}: {{ $note->appointment->patient->name }}
        @endslot

        <div class="row">
            <div class="col-md-6">
                <x-input name="date" label="{{ trans('messages.date') }}" :value="$note->created_at->format('F d, Y H:i')" disabled />
            </div>
            <div class="col-md-6">
                <x-input name="doctor" label="{{ trans('messages.doctor') }}" :value="'Dr. ' . $note->doctor->name" disabled />
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ trans('messages.symptoms') }}</label>
            <textarea class="form-control" disabled rows="3">{{ $note->symptoms ?? ($note->symptoms_translatable[app()->getLocale()] ?? trans('messages.not_recorded')) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ trans('messages.diagnosis') }}</label>
            <textarea class="form-control" disabled rows="3">{{ $note->diagnosis ?? ($note->diagnosis_translatable[app()->getLocale()] ?? trans('messages.not_recorded')) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ trans('messages.prescription') }}</label>
            <textarea class="form-control" disabled rows="3">{{ $note->prescription ?? ($note->prescription_translatable[app()->getLocale()] ?? trans('messages.not_recorded')) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ trans('messages.treatment_plan') }}</label>
            <textarea class="form-control" disabled rows="3">{{ $note->treatment_plan ?? ($note->treatment_plan_translatable[app()->getLocale()] ?? trans('messages.not_recorded')) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ trans('messages.vital_signs') }}</label>
            <textarea class="form-control" disabled rows="2">{{ $note->vital_signs ?? trans('messages.not_recorded') }}</textarea>
        </div>

        <div class="mt-4">
            <x-button href="{{ route('doctor.medical-notes.index') }}" variant="outline-primary">
                <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
            </x-button>
        </div>
    </x-card>
@endsection
