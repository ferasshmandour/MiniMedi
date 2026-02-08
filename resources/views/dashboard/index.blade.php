@extends('layouts.app')

@section('title', trans('messages.dashboard'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">
            @if (auth()->user()->isAdmin())
                👨‍💼 {{ trans('messages.admin_dashboard') }}
            @elseif(auth()->user()->isDoctor())
                👨‍⚕️ {{ trans('messages.doctor_dashboard') }}
            @else
                👤 {{ trans('messages.patient_dashboard') }}
            @endif
        </h1>
        <div class="d-flex align-items-center">
            <span class="me-3">
                <i class="bi bi-person-circle me-1"></i>
                {{ auth()->user()->name }}
            </span>
            <x-badge type="primary">{{ ucfirst(auth()->user()->role) }}</x-badge>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        @if (auth()->user()->isAdmin())
            <div class="col-md-4">
                <x-card class="text-center h-100">
                    <h3 class="text-success mb-0">{{ \App\Models\User::where('role', 'doctor')->count() }}</h3>
                    <p class="text-muted mb-0">👨‍⚕️ {{ trans('messages.doctors') }}</p>
                </x-card>
            </div>
            <div class="col-md-4">
                <x-card class="text-center h-100">
                    <h3 class="text-info mb-0">{{ \App\Models\User::where('role', 'patient')->count() }}</h3>
                    <p class="text-muted mb-0">👥 {{ trans('messages.patients') }}</p>
                </x-card>
            </div>
            <div class="col-md-4">
                <x-card class="text-center h-100">
                    <h3 class="text-warning mb-0">{{ \App\Models\Appointment::count() }}</h3>
                    <p class="text-muted mb-0">📅 {{ trans('messages.total_appointments') }}</p>
                </x-card>
            </div>
        @elseif(auth()->user()->isDoctor())
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-primary mb-0">{{ auth()->user()->appointmentsAsDoctor()->count() }}</h3>
                    <p class="text-muted mb-0">📅 {{ trans('messages.total_appointments') }}</p>
                </x-card>
            </div>
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-warning mb-0">
                        {{ auth()->user()->appointmentsAsDoctor()->where('status', 'pending')->count() }}</h3>
                    <p class="text-muted mb-0">⏳ {{ trans('messages.pending') }}</p>
                </x-card>
            </div>
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-success mb-0">
                        {{ auth()->user()->appointmentsAsDoctor()->where('status', 'confirmed')->count() }}</h3>
                    <p class="text-muted mb-0">✅ {{ trans('messages.confirmed') }}</p>
                </x-card>
            </div>
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-info mb-0">
                        {{ auth()->user()->appointmentsAsDoctor()->where('status', 'completed')->count() }}</h3>
                    <p class="text-muted mb-0">🏁 {{ trans('messages.completed') }}</p>
                </x-card>
            </div>
        @else
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-primary mb-0">{{ auth()->user()->appointmentsAsPatient()->count() }}</h3>
                    <p class="text-muted mb-0">📅 {{ trans('messages.total_appointments') }}</p>
                </x-card>
            </div>
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-warning mb-0">
                        {{ auth()->user()->appointmentsAsPatient()->where('status', 'pending')->count() }}</h3>
                    <p class="text-muted mb-0">⏳ {{ trans('messages.pending') }}</p>
                </x-card>
            </div>
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-success mb-0">
                        {{ auth()->user()->appointmentsAsPatient()->where('status', 'confirmed')->count() }}</h3>
                    <p class="text-muted mb-0">✅ {{ trans('messages.confirmed') }}</p>
                </x-card>
            </div>
            <div class="col-md-3">
                <x-card class="text-center h-100">
                    <h3 class="text-info mb-0">
                        {{ auth()->user()->appointmentsAsPatient()->where('status', 'completed')->count() }}</h3>
                    <p class="text-muted mb-0">🏁 {{ trans('messages.completed') }}</p>
                </x-card>
            </div>
        @endif
    </div>

    @if (auth()->user()->isAdmin())
        <!-- Patients List for Admin -->
        <x-card class="mb-4">
            @slot('title')
                <i class="bi bi-people me-2"></i>{{ trans('messages.patients') }}
            @endslot

            @php
                $patients = \App\Models\User::where('role', 'patient')->with('patient')->latest()->get();
            @endphp

            @if ($patients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.email') }}</th>
                                <th>{{ trans('messages.phone') }}</th>
                                <th>{{ trans('messages.blood_type') }}</th>
                                <th>{{ trans('messages.appointments') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->email }}</td>
                                    <td>{{ $patient->patient->phone ?? 'N/A' }}</td>
                                    <td>{{ $patient->patient->blood_type ?? 'N/A' }}</td>
                                    <td>
                                        <x-badge type="info">
                                            {{ $patient->appointmentsAsPatient()->count() }}
                                        </x-badge>
                                    </td>
                                    <td>
                                        <x-button href="{{ route('admin.patients.show', $patient->id) }}"
                                            variant="outline-primary" size="sm">
                                            <i class="bi bi-eye me-1"></i>{{ trans('messages.view_details') }}
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <p>{{ trans('messages.no_patients_found') }}</p>
                </div>
            @endif
        </x-card>

        <!-- Quick Actions for Admin -->
        <x-card class="mb-4">
            @slot('title')
                <i class="bi bi-lightning me-2"></i>{{ trans('messages.quick_actions') }}
            @endslot

            <div class="d-flex flex-wrap gap-2">
                <x-button href="{{ route('admin.patients.create') }}" variant="success">
                    <i class="bi bi-person-plus me-2"></i>{{ trans('messages.add_new_patient') }}
                </x-button>
                <x-button href="{{ route('admin.doctors.index') }}" variant="primary">
                    <i class="bi bi-person-badge me-2"></i>{{ trans('messages.manage_doctors') }}
                </x-button>
                <x-button href="{{ route('admin.appointments.index') }}" variant="primary">
                    <i class="bi bi-calendar-event me-2"></i>{{ trans('messages.view_all_appointments') }}
                </x-button>
                <x-button href="{{ route('admin.roles.index') }}" variant="outline-primary">
                    <i class="bi bi-shield-lock me-2"></i>{{ trans('messages.roles_permissions') }}
                </x-button>
            </div>
        </x-card>
    @else
        <!-- Recent Activity for Doctor/Patient -->
        @php
            if (auth()->user()->isDoctor()) {
                $appointments = auth()
                    ->user()
                    ->appointmentsAsDoctor()
                    ->with(['patient', 'doctor'])
                    ->latest()
                    ->take(10)
                    ->get();
            } else {
                $appointments = auth()
                    ->user()
                    ->appointmentsAsPatient()
                    ->with(['patient', 'doctor'])
                    ->latest()
                    ->take(10)
                    ->get();
            }
        @endphp

        <x-card class="mb-4">
            @slot('title')
                <i class="bi bi-clock-history me-2"></i>{{ trans('messages.recent_appointments') }}
            @endslot

            @if ($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.date') }}</th>
                                @if (auth()->user()->isDoctor())
                                    <th>{{ trans('messages.patient') }}</th>
                                @else
                                    <th>{{ trans('messages.doctor') }}</th>
                                @endif
                                <th>{{ trans('messages.reason') }}</th>
                                <th>{{ trans('messages.status') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->appointment_date->format('M d, Y H:i') }}</td>
                                    @if (auth()->user()->isDoctor())
                                        <td>{{ $appointment->patient->name }}</td>
                                    @else
                                        <td>Dr. {{ $appointment->doctor->name }}</td>
                                    @endif
                                    <td>{{ Str::limit($appointment->reason, 50) }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <x-button
                                            href="{{ route(Auth::user()->isAdmin() ? 'admin.appointments.show' : (Auth::user()->isDoctor() ? 'doctor.appointments.show' : 'patient.appointments.show'), $appointment->id) }}"
                                            variant="outline-primary" size="sm">
                                            <i class="bi bi-eye me-1"></i>{{ trans('messages.view') }}
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>{{ trans('messages.no_appointments_found') }}</p>
                </div>
            @endif
        </x-card>

        <!-- Quick Actions -->
        <x-card class="mb-4">
            @slot('title')
                <i class="bi bi-lightning me-2"></i>{{ trans('messages.quick_actions') }}
            @endslot

            <div class="d-flex flex-wrap gap-2">
                @if (auth()->user()->isPatient())
                    <x-button href="{{ route('patient.book.appointment') }}" variant="success">
                        <i class="bi bi-calendar-plus me-2"></i>{{ trans('messages.book_new_appointment') }}
                    </x-button>
                    <x-button href="{{ route('patient.appointments.index') }}" variant="primary">
                        <i class="bi bi-list me-2"></i>{{ trans('messages.view_all_appointments') }}
                    </x-button>
                @elseif(auth()->user()->isDoctor())
                    <x-button href="{{ route('doctor.appointments.index') }}" variant="primary">
                        <i class="bi bi-calendar-event me-2"></i>{{ trans('messages.view_my_appointments') }}
                    </x-button>
                    <x-button href="{{ route('doctor.medical-notes.index') }}" variant="success">
                        <i class="bi bi-file-medical me-2"></i>{{ trans('messages.medical_notes') }}
                    </x-button>
                @endif
                <x-button href="{{ route('profile') }}" variant="secondary">
                    <i class="bi bi-person me-2"></i>{{ trans('messages.my_profile') }}
                </x-button>
            </div>
        </x-card>
    @endif

    <!-- System Info -->
    <x-card>
        @slot('title')
            <i class="bi bi-info-circle me-2"></i>{{ trans('messages.system_information') }}
        @endslot

        <div class="row">
            <div class="col-md-6">
                <h5><i class="bi bi-hdd-network me-2"></i>{{ trans('messages.api_endpoints') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><code class="badge bg-light text-dark">POST</code>
                        <code>/api/v1/auth/register</code> - {{ trans('messages.register_patient') }}
                    </li>
                    <li class="mb-2"><code class="badge bg-light text-dark">POST</code> <code>/api/v1/auth/login</code>
                        - {{ trans('messages.login') }}</li>
                    <li class="mb-2"><code class="badge bg-light text-dark">GET</code>
                        <code>/api/v1/patient/profile</code>
                        - {{ trans('messages.get_patient_profile') }}</li>
                    <li class="mb-2"><code class="badge bg-light text-dark">GET</code> <code>/api/v1/appointments</code>
                        - {{ trans('messages.list_appointments') }}</li>
                    <li class="mb-2"><code class="badge bg-light text-dark">POST</code>
                        <code>/api/v1/appointments</code> - {{ trans('messages.book_appointment') }}
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5><i class="bi bi-book me-2"></i>{{ trans('messages.resources') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">📖 <a href="docs/ERD.md">{{ trans('messages.database_schema') }}</a></li>
                    <li class="mb-2">📡 <a href="docs/API_TESTING.md">{{ trans('messages.api_testing_guide') }}</a>
                    </li>
                    <li class="mb-2">📋 <a href="PROJECT_SUMMARY.md">{{ trans('messages.project_summary') }}</a></li>
                </ul>
            </div>
        </div>
    </x-card>
@endsection
