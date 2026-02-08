@extends('layouts.app')

@section('title', trans('messages.manage_patients'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">👥 {{ trans('messages.manage_patients') }}</h1>
        <x-button href="{{ route('admin.patients.create') }}" variant="success">
            <i class="bi bi-person-plus me-2"></i>{{ trans('messages.add_new_patient') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-people me-2"></i>{{ trans('messages.all_patients') }}
        @endslot

        @if ($patients->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('messages.name') }}</th>
                            <th>{{ trans('messages.email') }}</th>
                            <th>{{ trans('messages.phone') }}</th>
                            <th>{{ trans('messages.blood_type') }}</th>
                            <th>{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->email }}</td>
                                <td>{{ $patient->patient->phone ?? 'N/A' }}</td>
                                <td>
                                    @if ($patient->patient->blood_type ?? null)
                                        <x-badge type="danger">{{ $patient->patient->blood_type }}</x-badge>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <x-button href="{{ route('admin.patients.show', $patient->id) }}"
                                        variant="outline-primary" size="sm">
                                        <i class="bi bi-eye me-1"></i>{{ trans('messages.view') }}
                                    </x-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-muted">
                {{ trans('messages.total_patients', ['count' => $patients->count()]) }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-person-x"></i>
                <p>{{ trans('messages.no_patients_found') }}</p>
            </div>
        @endif
    </x-card>
@endsection
