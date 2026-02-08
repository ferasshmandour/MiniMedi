@extends('layouts.app')

@section('title', trans('messages.manage_doctor_roles'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">👨‍⚕️ {{ trans('messages.manage_doctor_roles') }}</h1>
        <x-button href="{{ route('admin.doctors.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-people me-2"></i>{{ trans('messages.all_doctors_with_roles') }}
        @endslot

        @if ($doctors->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('messages.doctor_name') }}</th>
                            <th>{{ trans('messages.email') }}</th>
                            <th>{{ trans('messages.specialization') }}</th>
                            <th>{{ trans('messages.assigned_roles') }}</th>
                            <th>{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $doctor)
                            <tr>
                                <td><strong>Dr. {{ $doctor->name }}</strong></td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->doctor->specialization ?? 'N/A' }}</td>
                                <td>
                                    @if ($doctor->roles->count() > 0)
                                        @foreach ($doctor->roles as $role)
                                            <x-badge type="info" class="mb-1">{{ $role->name }}</x-badge>
                                        @endforeach
                                    @else
                                        <span class="text-muted">{{ trans('messages.no_roles_assigned') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Assign Role Form -->
                                        <form action="{{ route('admin.doctors.assign-role', $doctor->id) }}" method="POST"
                                            class="d-flex gap-2">
                                            @csrf
                                            <select name="role_id" class="form-select form-select-sm" style="width: auto;">
                                                <option value="">{{ trans('messages.select_role') }}</option>
                                                @foreach ($roles as $role)
                                                    @if (!$doctor->roles->contains($role->id))
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <x-button type="submit" variant="success" size="sm">
                                                <i class="bi bi-plus-circle me-1"></i>{{ trans('messages.assign') }}
                                            </x-button>
                                        </form>

                                        <!-- Unassign Role Forms -->
                                        @foreach ($doctor->roles as $role)
                                            <form action="{{ route('admin.doctors.unassign-role', $doctor->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                                <x-button type="submit" variant="outline-danger" size="sm"
                                                    onclick="return confirm('{{ trans('messages.confirm_unassign_role', ['role' => $role->name, 'doctor' => $doctor->name]) }}')">
                                                    <i class="bi bi-dash-circle me-1"></i>{{ $role->name }}
                                                </x-button>
                                            </form>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-person-x"></i>
                <p>{{ trans('messages.no_doctors_found') }}</p>
                <x-button href="{{ route('admin.doctors.create') }}" variant="success">
                    <i class="bi bi-plus-circle me-2"></i>{{ trans('messages.add_first_doctor') }}
                </x-button>
            </div>
        @endif
    </x-card>

    <!-- Available Roles Info -->
    <x-card class="mt-4">
        @slot('title')
            <i class="bi bi-shield-check me-2"></i>{{ trans('messages.available_roles') }}
        @endslot
        <div class="row">
            @foreach ($roles as $role)
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <h6><strong>{{ $role->name }}</strong></h6>
                        <p class="mb-1 text-muted small">{{ $role->description ?? trans('messages.no_description') }}</p>
                        @if ($role->permissions->count() > 0)
                            <div class="mt-2">
                                @foreach ($role->permissions as $permission)
                                    <x-badge type="secondary" class="mb-1">{{ $permission->name }}</x-badge>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
@endsection
