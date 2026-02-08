@extends('layouts.app')

@section('title', trans('messages.create_permission'))

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">➕ {{ trans('messages.create_permission') }}</h1>
        <x-button href="{{ route('admin.permissions.index') }}" variant="outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ trans('messages.back_to_list') }}
        </x-button>
    </div>

    <x-card>
        @slot('title')
            <i class="bi bi-key me-2"></i>{{ trans('messages.permission_information') }}
        @endslot

        <form method="POST" action="{{ route('admin.permissions.store') }}">
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

            <x-input name="name" label="{{ trans('messages.permission_name') }}" required placeholder="edit_users"
                hint="{{ trans('messages.permission_name_hint') }}" />

            <div class="mt-4">
                <x-button type="submit" variant="success">
                    <i class="bi bi-check-circle me-2"></i>{{ trans('messages.create_permission') }}
                </x-button>
                <x-button href="{{ route('admin.permissions.index') }}" variant="outline-secondary" class="ms-2">
                    {{ trans('messages.cancel') }}
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
