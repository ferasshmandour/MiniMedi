@extends('layouts.app')

@section('title', trans('messages.add_new_patient'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">➕ {{ trans('messages.add_new_patient') }}</h1>
        <x-button href="{{ route('admin.patients.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-person-plus me-2"></i>{{ trans('messages.patient_information') }}
        @endslot

        <form method="POST" action="{{ route('admin.patients.store') }}">
            @csrf

            @if ($errors->any())
                <x-alert type="danger" dismissible>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <h5 class="mb-3"><i class="bi bi-person me-2"></i>{{ trans('messages.user_information') }}</h5>
            <div class="row">
                <div class="col-md-6">
                    <x-input name="name" label="{{ trans('messages.full_name') }}" required placeholder="John Doe" />
                </div>
                <div class="col-md-6">
                    <x-input name="email" type="email" label="{{ trans('messages.email_address') }}" required
                        placeholder="patient@example.com" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-input name="password" type="password" label="{{ trans('messages.password') }}" required
                        placeholder="********" />
                </div>
                <div class="col-md-6">
                    <x-input name="password_confirmation" type="password" label="{{ trans('messages.confirm_password') }}"
                        required placeholder="********" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-input name="phone" label="{{ trans('messages.phone') }}" placeholder="+1-555-0200" />
                </div>
                <div class="col-md-6">
                    <x-input name="date_of_birth" type="date" label="{{ trans('messages.date_of_birth') }}" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="blood_type" class="form-label">{{ trans('messages.blood_type') }}</label>
                        <select name="blood_type" id="blood_type" class="form-select">
                            <option value="">{{ trans('messages.select') }}</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label">{{ trans('messages.address') }}</label>
                        <textarea name="address" id="address" class="form-control" placeholder="123 Main Street" rows="1"></textarea>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3"><i class="bi bi-heart-pulse me-2"></i>{{ trans('messages.medical_information') }}</h5>

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
                        <label for="allergies_en" class="form-label">{{ trans('messages.allergies_en') }}</label>
                        <textarea name="allergies[en]" id="allergies_en" class="form-control" rows="2" placeholder="Penicillin, etc."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="medical_history_en"
                            class="form-label">{{ trans('messages.medical_history_en') }}</label>
                        <textarea name="medical_history[en]" id="medical_history_en" class="form-control"
                            placeholder="Previous illnesses, surgeries, etc." rows="3"></textarea>
                    </div>
                </div>

                <!-- Arabic Tab -->
                <div class="tab-pane fade" id="ar-tab">
                    <div class="mb-3">
                        <label for="allergies_ar" class="form-label">{{ trans('messages.allergies_ar') }}</label>
                        <textarea name="allergies[ar]" id="allergies_ar" class="form-control" rows="2"
                            placeholder="البنسلين، وما إلى ذلك..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="medical_history_ar"
                            class="form-label">{{ trans('messages.medical_history_ar') }}</label>
                        <textarea name="medical_history[ar]" id="medical_history_ar" class="form-control"
                            placeholder="الأمراض السابقة، العمليات، وما إلى ذلك..." rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-button type="submit" variant="success">
                    <i class="bi bi-check-circle me-2"></i>{{ trans('messages.create_patient') }}
                </x-button>
                <x-button href="{{ route('admin.patients.index') }}" variant="outline-secondary" class="ms-2">
                    {{ trans('messages.cancel') }}
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
