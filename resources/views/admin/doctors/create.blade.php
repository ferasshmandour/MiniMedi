@extends('layouts.app')

@section('title', trans('messages.add_new_doctor'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">➕ {{ trans('messages.add_new_doctor') }}</h1>
        <x-button href="{{ route('admin.doctors.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-person-plus me-2"></i>{{ trans('messages.doctor_information') }}
        @endslot

        <form method="POST" action="{{ route('admin.doctors.store') }}">
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
                    <x-input name="name" label="{{ trans('messages.full_name') }}" required
                        placeholder="Dr. John Smith" />
                </div>
                <div class="col-md-6">
                    <x-input name="email" type="email" label="{{ trans('messages.email_address') }}" required
                        placeholder="doctor@hospital.com" />
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

            <hr class="my-4">
            <h5 class="mb-3"><i class="bi bi-briefcase me-2"></i>{{ trans('messages.doctor_information') }}</h5>

            <div class="row">
                <div class="col-md-6">
                    <x-input name="license_number" label="{{ trans('messages.license_number') }}" required
                        placeholder="MD-12345" />
                </div>
                <div class="col-md-6">
                    <x-input name="phone" label="{{ trans('messages.phone') }}" placeholder="+1-555-0100" />
                </div>
            </div>

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
                    <div class="row">
                        <div class="col-md-6">
                            <x-input name="specialization[en]" label="{{ trans('messages.specialization_en') }}"
                                placeholder="Cardiology" />
                        </div>
                        <div class="col-md-6">
                            <x-input name="department[en]" label="{{ trans('messages.department_en') }}"
                                placeholder="Cardiology Department" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bio_en" class="form-label">{{ trans('messages.bio_en') }}</label>
                        <textarea name="bio[en]" id="bio_en" class="form-control" rows="4"
                            placeholder="Doctor's biography in English..."></textarea>
                    </div>
                </div>

                <!-- Arabic Tab -->
                <div class="tab-pane fade" id="ar-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <x-input name="specialization[ar]" label="{{ trans('messages.specialization_ar') }}"
                                placeholder="أمراض القلب" />
                        </div>
                        <div class="col-md-6">
                            <x-input name="department[ar]" label="{{ trans('messages.department_ar') }}"
                                placeholder="قسم أمراض القلب" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bio_ar" class="form-label">{{ trans('messages.bio_ar') }}</label>
                        <textarea name="bio[ar]" id="bio_ar" class="form-control" rows="4"
                            placeholder="السيرة الذاتية للطبيب بالعربية..."></textarea>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3"><i class="bi bi-clock me-2"></i>{{ trans('messages.general') }}
                {{ trans('messages.appointments') }}</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="available_from" class="form-label">{{ trans('messages.general') }}
                            {{ trans('messages.date') }} {{ __('messages.from') }}</label>
                        <input type="time" name="available_from" id="available_from" class="form-control"
                            value="09:00:00">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="available_to" class="form-label">{{ trans('messages.general') }}
                            {{ trans('messages.date') }} {{ __('messages.to') }}</label>
                        <input type="time" name="available_to" id="available_to" class="form-control"
                            value="17:00:00">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-button type="submit" variant="success">
                    <i class="bi bi-check-circle me-2"></i>{{ trans('messages.create_doctor') }}
                </x-button>
                <x-button href="{{ route('admin.doctors.index') }}" variant="outline-secondary" class="ms-2">
                    {{ trans('messages.cancel') }}
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
