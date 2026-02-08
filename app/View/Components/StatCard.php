<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class StatCard extends Component
{
    public function __construct(
        public string $title,
        public string|int $value,
        public ?string $icon = null,
        public string $color = 'primary',
        public ?string $subtitle = null,
        public ?string $link = null,
        public bool $animated = true,
    ) {}

    public function render(): View
    {
        return view('components.stat-card');
    }
}

