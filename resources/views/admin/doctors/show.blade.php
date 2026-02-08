@extends('layouts.app')

@section('title', trans('messages.doctor_details'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">👨‍⚕️ {{ trans('messages.doctor_details') }}</h1>
        <x-button href="{{ route('admin.doctors.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-person-badge me-2"></i>Dr. {{ $doctor->name }}
        @endslot

        <div class="row">
            <div class="col-md-6">
                <x-input name="email" label="{{ trans('messages.email') }}" :value="$doctor->email" disabled />
            </div>
            <div class="col-md-6">
                <x-input name="role" label="{{ trans('messages.role') }}" :value="ucfirst($doctor->role)" disabled />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-input name="specialization" label="{{ trans('messages.specialization') }}" :value="$doctor->doctor->specialization ?? 'N/A'" disabled />
            </div>
            <div class="col-md-6">
                <x-input name="license_number" label="{{ trans('messages.license_number') }}" :value="$doctor->doctor->license_number ?? 'N/A'" disabled />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-input name="department" label="{{ trans('messages.department') }}" :value="$doctor->doctor->department ?? 'N/A'" disabled />
            </div>
            <div class="col-md-6">
                <x-input name="phone" label="{{ trans('messages.phone') }}" :value="$doctor->doctor->phone ?? 'N/A'" disabled />
            </div>
        </div>

        <!-- Assigned Roles -->
        <div class="mt-4">
            <h5><i class="bi bi-shield-check me-2"></i>{{ trans('messages.assigned_roles') }}</h5>
            @if ($doctor->roles->count() > 0)
                <div class="mb-3 d-flex flex-wrap gap-2">
                    @foreach ($doctor->roles as $role)
                        <div class="d-flex align-items-center gap-1">
                            <span class="badge bg-primary">{{ $role->name }}</span>
                            <form action="{{ route('admin.doctors.unassign-role', $doctor->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                <x-button type="submit" variant="outline-danger" size="sm"
                                    onclick="return confirm('{{ trans('messages.confirm_unassign_role', ['role' => $role->name, 'doctor' => $doctor->name]) }}')">
                                    <i class="bi bi-dash-circle"></i>
                                </x-button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">{{ trans('messages.no_roles_assigned') }}</p>
            @endif
        </div>

        <!-- Assign Role Form -->
        <div class="mt-4">
            <h5><i class="bi bi-person-plus me-2"></i>{{ trans('messages.assign_role') }}</h5>
            <form action="{{ route('admin.doctors.assign-role', $doctor->id) }}" method="POST" class="d-flex gap-2">
                @csrf
                <div class="flex-grow-1" style="max-width: 300px;">
                    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                        <option value="">{{ trans('messages.select_role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <x-button type="submit" variant="primary">
                    <i class="bi bi-check-circle me-2"></i>{{ trans('messages.assign') }}
                </x-button>
            </form>
        </div>

        <div class="mt-4">
            <x-button href="{{ route('admin.doctors.index') }}" variant="outline-primary">
                <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
            </x-button>
        </div>
    </x-card>
@endsection
