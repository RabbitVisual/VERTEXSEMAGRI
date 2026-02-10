<div class="card shadow-sm mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            @if($icon)
                <i class="{{ $icon }} me-2"></i>
            @endif
            {{ $title }}
            <span class="badge bg-secondary ms-2">{{ $items->count() }}</span>
        </h6>
        @if($items->count() > $limit)
            <a href="{{ route($route) }}" class="btn btn-sm btn-outline-primary">
                Ver todos <x-icon name="arrow-right" />
            </a>
        @endif
    </div>
    <div class="card-body">
        @forelse($items->take($limit) as $item)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    @if(is_object($item))
                        <a href="{{ route($route, $item->id) }}" class="text-decoration-none">
                            {{ $item->{$displayField} ?? $item->id }}
                        </a>
                    @else
                        <span>{{ $item[$displayField] ?? $item['id'] }}</span>
                    @endif
                </div>
                @if(is_object($item) && isset($item->created_at))
                    <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                @endif
            </div>
        @empty
            <p class="text-muted mb-0 text-center py-3">
                <x-icon name="inbox" class="fs-4 d-block mb-2" />
                Nenhum registro encontrado
            </p>
        @endforelse
    </div>
</div>
