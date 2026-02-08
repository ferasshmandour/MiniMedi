<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'primary',
        public ?string $class = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge');
    }

    /**
     * Get badge type classes.
     */
    public function getTypeClasses(): string
    {
        return match ($this->type) {
            'success' => 'bg-success',
            'danger' => 'bg-danger',
            'warning' => 'bg-warning text-dark',
            'info' => 'bg-info text-dark',
            'secondary' => 'bg-secondary',
            'light' => 'bg-light text-dark',
            'dark' => 'bg-dark',
            default => 'bg-primary',
        };
    }
}
