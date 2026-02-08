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

            <div class="row">
                <div class="col-md-6">
                    <x-input name="specialization" label="{{ trans('messages.specialization') }}" required
                        placeholder="Cardiology" />
                </div>
                <div class="col-md-6">
                    <x-input name="license_number" label="{{ trans('messages.license_number') }}" required
                        placeholder="MD-12345" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-input name="department" label="{{ trans('messages.department') }}" placeholder="Cardiology" />
                </div>
                <div class="col-md-6">
                    <x-input name="phone" label="{{ trans('messages.phone') }}" placeholder="+1-555-0100" />
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
