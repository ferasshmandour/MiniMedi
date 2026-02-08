<div {{ $attributes->class(['card', 'border' => $bordered]) }}>
    @if ($title || $headerClass)
        <div class="card-header {{ $headerClass }}">
            {{ $title ?? $slot->first }}
        </div>
    @endif
    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>
    @if ($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
