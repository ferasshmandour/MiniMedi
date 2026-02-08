@extends('layouts.app')

@section('title', trans('messages.roles_permissions'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">🔐 {{ trans('messages.roles_permissions') }}</h1>
        <div class="d-flex gap-2">
            <x-button href="{{ route('admin.permissions.index') }}" variant="warning">
                <i class="bi bi-key me-2"></i>{{ trans('messages.manage_permissions') }}
            </x-button>
            <x-button href="{{ route('admin.doctors.roles.manage') }}" variant="info">
                <i class="bi bi-people me-2"></i>{{ trans('messages.manage_doctor_roles') }}
            </x-button>
            <x-button href="{{ route('admin.roles.create') }}" variant="success">
                <i class="bi bi-plus-circle me-2"></i>{{ trans('messages.create_new_role') }}
            </x-button>
        </div>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-shield-lock me-2"></i>{{ trans('messages.all_roles') }}
        @endslot

        @if ($roles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('messages.role_name') }}</th>
                            <th>{{ trans('messages.description') }}</th>
                            <th>{{ trans('messages.permissions') }}</th>
                            <th>{{ trans('messages.users') }}</th>
                            <th>{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td><strong>{{ $role->name }}</strong></td>
                                <td>{{ $role->description ?? trans('messages.no_description') }}</td>
                                <td>
                                    @if ($role->permissions->count() > 0)
                                        @foreach ($role->permissions as $permission)
                                            <x-badge type="success" class="mb-1">{{ $permission->name }}</x-badge>
                                        @endforeach
                                    @else
                                        <span class="text-muted">{{ trans('messages.no_permissions') }}</span>
                                    @endif
                                </td>
                                <td>{{ $role->users->count() }}</td>
                                <td class="action-buttons">
                                    <x-button href="{{ route('admin.roles.show', $role->id) }}" variant="outline-primary"
                                        size="sm">
                                        <i class="bi bi-eye me-1"></i>{{ trans('messages.view') }}
                                    </x-button>
                                    @if ($role->name !== 'admin')
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" variant="outline-danger" size="sm"
                                                onclick="return confirm('{{ trans('messages.confirm_delete_role') }}')">
                                                <i class="bi bi-trash me-1"></i>{{ trans('messages.delete') }}
                                            </x-button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-shield-x"></i>
                <p>{{ trans('messages.no_roles_found') }}</p>
                <x-button href="{{ route('admin.roles.create') }}" variant="success">
                    <i class="bi bi-plus-circle me-2"></i>{{ trans('messages.create_first_role') }}
                </x-button>
            </div>
        @endif
    </x-card>
@endsection
