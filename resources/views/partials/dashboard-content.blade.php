@section('title', trans('messages.dashboard'))

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
        <p>{{ trans('messages.admin') }}</p>
    </div>
    <div class="stat-card">
        <h3>{{ \App\Models\User::where('role', 'doctor')->count() }}</h3>
        <p>{{ trans('messages.doctors') }}</p>
    </div>
    <div class="stat-card">
        <h3>{{ \App\Models\User::where('role', 'patient')->count() }}</h3>
        <p>{{ trans('messages.patients') }}</p>
    </div>
    <div class="stat-card">
        <h3>{{ \App\Models\Appointment::count() }}</h3>
        <p>{{ trans('messages.appointments') }}</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">{{ trans('messages.quick_actions') }}</div>
    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        @if (auth()->user()->isAdmin())
            <a href="{{ route('admin.doctors.create') }}"
                class="btn btn-primary">{{ trans('messages.create_doctor') }}</a>
            <a href="{{ route('admin.patients.create') }}"
                class="btn btn-success">{{ trans('messages.create_patient') }}</a>
            <a href="{{ route('admin.appointments.index') }}"
                class="btn btn-info">{{ trans('messages.view_appointments') }}</a>
        @elseif(auth()->user()->isDoctor())
            <a href="{{ route('doctor.appointments.index') }}"
                class="btn btn-primary">{{ trans('messages.view_appointments') }}</a>
            <a href="{{ route('doctor.medical-notes.index') }}"
                class="btn btn-success">{{ trans('messages.medical_notes') }}</a>
        @endif
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">{{ trans('messages.recent_appointments') }}</div>
    @if ($recentAppointments->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>{{ trans('messages.patient') }}</th>
                        <th>{{ trans('messages.doctor') }}</th>
                        <th>{{ trans('messages.date') }}</th>
                        <th>{{ trans('messages.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>Dr. {{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>
                                <span class="badge badge-{{ $appointment->status }}">
                                    {{ trans('messages.status_' . $appointment->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>{{ trans('messages.no_recent_activity') }}</p>
        </div>
    @endif
</div>
