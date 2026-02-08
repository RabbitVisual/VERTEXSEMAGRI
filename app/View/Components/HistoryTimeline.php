<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class HistoryTimeline extends Component
{
    public function __construct(
        public Collection $history,
        public ?string $title = 'Histórico de Alterações',
    ) {}

    public function render(): View
    {
        return view('components.history-timeline');
    }
}

