@extends('layouts.app')

@section('title', trans('messages.create_role'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">➕ {{ trans('messages.create_role') }}</h1>
        <x-button href="{{ route('admin.roles.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-shield-plus me-2"></i>{{ trans('messages.role_information') }}
        @endslot

        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            @if ($errors->any())
                <x-alert type="danger" dismissible>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <x-input name="name" label="{{ trans('messages.role_name') }}" required placeholder="Senior Doctor" />

            <div class="mb-3">
                <label for="description" class="form-label">{{ trans('messages.description') }}</label>
                <textarea name="description" id="description" class="form-control" placeholder="Describe this role..." rows="3"></textarea>
            </div>

            <x-card class="mt-4">
                @slot('title')
                    <i class="bi bi-key me-2"></i>{{ trans('messages.permissions') }}
                @endslot

                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    id="permission_{{ $permission->id }}" class="form-check-input">
                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                    {{ str_replace('_', ' ', ucfirst($permission->name)) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <div class="mt-4">
                <x-button type="submit" variant="success">
                    <i class="bi bi-check-circle me-2"></i>{{ trans('messages.create_role') }}
                </x-button>
                <x-button href="{{ route('admin.roles.index') }}" variant="outline-secondary" class="ms-2">
                    {{ trans('messages.cancel') }}
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
