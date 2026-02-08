<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'primary',
        public ?string $dismissible = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }

    /**
     * Get alert type classes.
     */
    public function getTypeClasses(): string
    {
        return match ($this->type) {
            'success' => 'alert-success',
            'danger' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
            'secondary' => 'alert-secondary',
            'light' => 'alert-light',
            'dark' => 'alert-dark',
            default => 'alert-primary',
        };
    }
}
