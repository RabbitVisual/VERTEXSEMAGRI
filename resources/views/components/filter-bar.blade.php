<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ $action }}" class="row g-3" id="filterForm">
            @if($showSearch)
                <div class="col-md-3">
                    <label class="form-label">Buscar</label>
                    <div class="input-group">
                        <span class="input-group-text"><x-icon name="magnifying-glass" /></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="{{ $searchPlaceholder }}"
                               value="{{ request('search') }}">
                    </div>
                </div>
            @endif

            @foreach($filters as $filter)
                <div class="col-md-{{ $filter['col'] ?? 3 }}">
                    <label class="form-label">{{ $filter['label'] }}</label>
                    @if($filter['type'] === 'select')
                        <select name="{{ $filter['name'] }}" class="form-select">
                            <option value="">{{ $filter['placeholder'] ?? 'Todos' }}</option>
                            @foreach($filter['options'] as $value => $label)
                                <option value="{{ $value }}"
                                        {{ request($filter['name']) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    @elseif($filter['type'] === 'date')
                        <input type="date" name="{{ $filter['name'] }}"
                               class="form-control"
                               value="{{ request($filter['name']) }}">
                    @elseif($filter['type'] === 'date-range')
                        <div class="input-group">
                            <input type="date" name="{{ $filter['name'] }}_from"
                                   class="form-control"
                                   value="{{ request($filter['name'] . '_from') }}"
                                   placeholder="De">
                            <input type="date" name="{{ $filter['name'] }}_to"
                                   class="form-control"
                                   value="{{ request($filter['name'] . '_to') }}"
                                   placeholder="Até">
                        </div>
                    @endif
                </div>
            @endforeach

            {{ $slot }}

            <div class="col-md-auto d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <x-icon name="filter" /> Filtrar
                </button>
                <a href="{{ $action }}" class="btn btn-outline-secondary">
                    <x-icon name="circle-xmark" /> Limpar
                </a>
            </div>
        </form>
    </div>
</div>
