@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->class(['btn', $getVariantClasses(), $getSizeClasses(), $class])->merge(['type' => null]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->class(['btn', $getVariantClasses(), $getSizeClasses(), $class])->merge(['disabled' => $disabled]) }}>
        {{ $slot }}
    </button>
@endif
