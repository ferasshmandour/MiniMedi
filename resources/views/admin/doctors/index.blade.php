@extends('layouts.app')

@section('title', trans('messages.manage_doctors'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">👨‍⚕️ {{ trans('messages.manage_doctors') }}</h1>
        <x-button href="{{ route('admin.doctors.create') }}" variant="success">
            <i class="bi bi-plus-circle me-2"></i>{{ trans('messages.add_new_doctor') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-list me-2"></i>{{ trans('messages.all_doctors') }}
        @endslot

        @if ($doctors->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('messages.name') }}</th>
                            <th>{{ trans('messages.email') }}</th>
                            <th>{{ trans('messages.specialization') }}</th>
                            <th>{{ trans('messages.department') }}</th>
                            <th>{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->doctor->specialization ?? 'N/A' }}</td>
                                <td>{{ $doctor->doctor->department ?? 'N/A' }}</td>
                                <td class="action-buttons">
                                    <x-button href="{{ route('admin.doctors.show', $doctor->id) }}"
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
                {{ trans('messages.total_doctors', ['count' => $doctors->count()]) }}
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
@endsection
