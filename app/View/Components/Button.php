<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'button',
        public string $variant = 'primary',
        public ?string $size = null,
        public ?string $href = null,
        public bool $disabled = false,
        public ?string $class = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }

    /**
     * Get button variant classes.
     */
    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'success' => 'btn-success',
            'danger' => 'btn-danger',
            'warning' => 'btn-warning',
            'info' => 'btn-info',
            'secondary' => 'btn-secondary',
            'light' => 'btn-light',
            'dark' => 'btn-dark',
            'outline-primary' => 'btn-outline-primary',
            'outline-success' => 'btn-outline-success',
            'outline-danger' => 'btn-outline-danger',
            'outline-warning' => 'btn-outline-warning',
            'outline-secondary' => 'btn-outline-secondary',
            default => 'btn-primary',
        };
    }

    /**
     * Get button size classes.
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'btn-sm',
            'lg' => 'btn-lg',
            default => '',
        };
    }
}
