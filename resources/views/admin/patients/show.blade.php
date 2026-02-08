@extends('layouts.app')

@section('title', trans('messages.patient_details'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">👤 {{ trans('messages.patient_details') }}</h1>
        <x-button href="{{ route('admin.patients.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <x-card>
                @slot('title')
                    <i class="bi bi-person me-2"></i>{{ trans('messages.user_information') }}
                @endslot

                <x-input name="name" label="{{ trans('messages.name') }}" :value="$patient->name" disabled />
                <x-input name="email" label="{{ trans('messages.email') }}" :value="$patient->email" disabled />
                <x-input name="member_since" label="{{ trans('messages.member_since') }}" :value="$patient->created_at->format('F d, Y')" disabled />
            </x-card>
        </div>
        <div class="col-md-6">
            <x-card>
                @slot('title')
                    <i class="bi bi-heart-pulse me-2"></i>{{ trans('messages.medical_information') }}
                @endslot

                <x-input name="phone" label="{{ trans('messages.phone') }}" :value="$patient->patient->phone ?? 'N/A'" disabled />
                <x-input name="date_of_birth" label="{{ trans('messages.date_of_birth') }}" :value="$patient->patient->date_of_birth
                    ? $patient->patient->date_of_birth->format('F d, Y')
                    : 'N/A'" disabled />
                <x-input name="blood_type" label="{{ trans('messages.blood_type') }}" :value="$patient->patient->blood_type ?? 'N/A'" disabled />
            </x-card>
        </div>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-geo-alt me-2"></i>{{ trans('messages.address') }}
        @endslot
        <p class="mb-0">{{ $patient->patient->address ?? trans('messages.not_provided') }}</p>
    </x-card>

    <x-card class="mt-4">
        @slot('title')
            <i class="bi bi-exclamation-triangle me-2"></i>{{ trans('messages.allergies') }}
        @endslot
        <p class="mb-0">{{ $patient->patient->allergies ?? trans('messages.none_known') }}</p>
    </x-card>

    <x-card class="mt-4">
        @slot('title')
            <i class="bi bi-file-medical me-2"></i>{{ trans('messages.medical_history') }}
        @endslot
        <p class="mb-0">{{ $patient->patient->medical_history ?? trans('messages.no_medical_history') }}</p>
    </x-card>

    <div class="mt-4">
        <x-button href="{{ route('admin.patients.index') }}" variant="outline-primary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>
@endsection
