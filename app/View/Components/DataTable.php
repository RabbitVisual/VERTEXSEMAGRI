<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class DataTable extends Component
{
    public function __construct(
        public array $headers,
        public LengthAwarePaginator|array $data,
        public ?string $emptyMessage = 'Nenhum registro encontrado',
        public bool $showActions = true,
        public ?string $editRoute = null,
        public ?string $showRoute = null,
        public ?string $deleteRoute = null,
        public bool $sortable = false,
        public ?string $exportRoute = null,
    ) {}

    public function render(): View
    {
        return view('components.data-table', [
            'data' => $this->data,
        ]);
    }
}

