@php
    $id = $id ?? $name;
    $hasError = $errors->has($name) || $error;
@endphp

<div class="mb-3">
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        {{ $attributes->class(['form-control', 'is-invalid' => $hasError, $class]) }}>
    @if ($hasError)
        <div class="invalid-feedback">
            {{ $error ?? $errors->first($name) }}
        </div>
    @endif
</div>
