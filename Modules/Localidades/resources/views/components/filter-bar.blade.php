@props(['action', 'filters' => [], 'searchPlaceholder' => 'Buscar...', 'showSearch' => true])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
    <form method="GET" action="{{ $action }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if($showSearch)
                <div>
                    <label for="hs-search-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Buscar
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </div>
                        <input type="text" id="hs-search-input" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" class="py-2 pl-10 pr-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:placeholder-gray-400">
                    </div>
                </div>
            @endif

            @foreach($filters as $filter)
                <div>
                    <label for="filter-{{ $filter['name'] }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ $filter['label'] }}
                    </label>
                    @if($filter['type'] === 'select')
                        @php
                            $currentValue = request($filter['name'], '');
                            if ($filter['name'] === 'ativo') {
                                $currentValue = $currentValue === '' ? '' : (string)$currentValue;
                            }
                        @endphp
                        <select id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}" class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            <option value="">{{ $filter['placeholder'] ?? 'Todos' }}</option>
                            @foreach($filter['options'] as $value => $label)
                                <option value="{{ $value }}" {{ (string)$currentValue === (string)$value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    @elseif($filter['type'] === 'date')
                        <input type="date" id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ $action }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/>
                </svg>
                Limpar
            </a>
            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                Filtrar
            </button>
        </div>
    </form>
</div>

