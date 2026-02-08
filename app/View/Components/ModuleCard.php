<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ModuleCard extends Component
{
    public function __construct(
        public string $title,
        public string $description,
        public string $route,
        public ?string $icon = null,
        public ?string $badge = null,
        public string $color = 'primary',
        public ?string $module = null,
    ) {}

    public function render(): View
    {
        return view('components.module-card');
    }
}

