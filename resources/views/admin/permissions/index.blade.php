@extends('layouts.app')

@section('title', trans('messages.permissions'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">🔑 {{ trans('messages.permissions') }}</h1>
        <x-button href="{{ route('admin.permissions.create') }}" variant="success">
            <i class="bi bi-plus-circle me-2"></i>{{ trans('messages.create_permission') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-key me-2"></i>{{ trans('messages.all_permissions') }}
        @endslot

        @if ($permissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('messages.permission_name') }}</th>
                            <th>{{ trans('messages.guard') }}</th>
                            <th>{{ trans('messages.roles_using') }}</th>
                            <th>{{ trans('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td><strong>{{ str_replace('_', ' ', ucfirst($permission->name)) }}</strong></td>
                                <td>{{ $permission->guard_name }}</td>
                                <td>{{ $permission->roles->count() }}</td>
                                <td>
                                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="outline-danger" size="sm"
                                            onclick="return confirm('{{ trans('messages.confirm_delete_permission') }}')">
                                            <i class="bi bi-trash me-1"></i>{{ trans('messages.delete') }}
                                        </x-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-key"></i>
                <p>{{ trans('messages.no_permissions_found') }}</p>
                <x-button href="{{ route('admin.permissions.create') }}" variant="success">
                    <i class="bi bi-plus-circle me-2"></i>{{ trans('messages.create_first_permission') }}
                </x-button>
            </div>
        @endif
    </x-card>
@endsection
