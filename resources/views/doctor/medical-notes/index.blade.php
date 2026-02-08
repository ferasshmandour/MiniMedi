@extends('layouts.app')

@section('title', trans('messages.medical_notes'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">📝 {{ trans('messages.medical_notes') }}</h1>
    </div>

    <x-card>
        @if ($notes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('messages.date') }}</th>
                            <th>{{ trans('messages.patient') }}</th>
                            <th>{{ trans('messages.diagnosis') }}</th>
                            <th>{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notes as $note)
                            <tr>
                                <td>{{ $note->created_at->format('M d, Y') }}</td>
                                <td>{{ $note->appointment->patient->name }}</td>
                                <td>{{ Str::limit($note->diagnosis ?? 'N/A', 30) }}</td>
                                <td class="action-buttons">
                                    <x-button href="{{ route('doctor.medical-notes.show', $note->id) }}"
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
                <i class="bi bi-file-text"></i>
                <p>{{ trans('messages.no_medical_notes_found') }}</p>
            </div>
        @endif
    </x-card>
@endsection
