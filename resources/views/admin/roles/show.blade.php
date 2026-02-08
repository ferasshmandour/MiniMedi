@extends('layouts.app')

@section('title', trans('messages.role_details'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">🔐 {{ trans('messages.role_details') }}</h1>
        <x-button href="{{ route('admin.roles.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-shield me-2"></i>{{ $role->name }}
        @endslot

        <div class="mb-3">
            <label class="form-label">{{ trans('messages.description') }}</label>
            <textarea class="form-control" disabled rows="3">{{ $role->description ?? trans('messages.no_description') }}</textarea>
        </div>
    </x-card>

    <x-card class="mt-4">
        @slot('title')
            <i class="bi bi-key me-2"></i>{{ trans('messages.permissions') }}
        @endslot

        @if ($role->permissions->count() > 0)
            <div class="d-flex flex-wrap gap-2">
                @foreach ($role->permissions as $permission)
                    <x-badge type="success">{{ str_replace('_', ' ', ucfirst($permission->name)) }}</x-badge>
                @endforeach
            </div>
        @else
            <p class="mb-0 text-muted">{{ trans('messages.no_permissions_assigned') }}</p>
        @endif
    </x-card>

    <x-card class="mt-4">
        @slot('title')
            <i class="bi bi-people me-2"></i>{{ trans('messages.users_with_this_role') }}
        @endslot

        @if ($role->users->count() > 0)
            <ul class="list-group list-group-flush">
                @foreach ($role->users as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person me-2"></i>{{ $user->name }}</span>
                        <span class="text-muted">{{ $user->email }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mb-0 text-muted">{{ trans('messages.no_users_have_this_role') }}</p>
        @endif
    </x-card>

    <div class="mt-4">
        <x-button href="{{ route('admin.roles.index') }}" variant="outline-primary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>
@endsection
