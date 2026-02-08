<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class FilterBar extends Component
{
    public function __construct(
        public string $action,
        public array $filters = [],
        public ?string $searchPlaceholder = 'Buscar...',
        public bool $showSearch = true,
    ) {}

    public function render(): View
    {
        return view('components.filter-bar');
    }
}

