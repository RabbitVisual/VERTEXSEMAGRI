<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class RelationshipList extends Component
{
    public function __construct(
        public string $title,
        public Collection $items,
        public string $route,
        public string $displayField = 'nome',
        public ?string $icon = null,
        public int $limit = 10,
    ) {}

    public function render(): View
    {
        return view('components.relationship-list');
    }
}

