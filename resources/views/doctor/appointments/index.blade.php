@extends('layouts.app')

@section('title', trans('messages.my_appointments'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">📅 {{ trans('messages.my_appointments') }}</h1>
    </div>

    <x-card>
        @if ($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('messages.date') }}</th>
                            <th>{{ trans('messages.patient') }}</th>
                            <th>{{ trans('messages.reason') }}</th>
                            <th>{{ trans('messages.status') }}</th>
                            <th>{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->appointment_date->format('M d, Y H:i') }}</td>
                                <td>{{ $appointment->patient->name }}</td>
                                <td>{{ Str::limit($appointment->reason, 30) }}</td>
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
                                <td class="action-buttons">
                                    <x-button href="{{ route('doctor.appointments.show', $appointment->id) }}"
                                        variant="outline-primary" size="sm">
                                        <i class="bi bi-eye me-1"></i>{{ trans('messages.view') }}
                                    </x-button>
                                    @if ($appointment->status === 'confirmed')
                                        <x-button
                                            href="{{ route('doctor.medical-notes.create', ['appointment' => $appointment->id]) }}"
                                            variant="outline-success" size="sm">
                                            <i class="bi bi-file-medical me-1"></i>{{ trans('messages.add_note') }}
                                        </x-button>
                                    @endif
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
@endsection
