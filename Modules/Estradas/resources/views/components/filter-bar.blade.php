@props(['action', 'filters' => [], 'searchPlaceholder' => 'Buscar...', 'showSearch' => true])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
    <form method="GET" action="{{ $action }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if($showSearch)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300 sm:text-sm">
                    </div>
                </div>
            @endif

            @foreach($filters as $filter)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $filter['label'] }}</label>
                    @if($filter['type'] === 'select')
                        <select name="{{ $filter['name'] }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 text-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">{{ $filter['placeholder'] ?? 'Todos' }}</option>
                            @foreach($filter['options'] as $value => $label)
                                <option value="{{ $value }}" {{ request($filter['name']) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    @elseif($filter['type'] === 'date')
                        <input type="date" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 text-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ $action }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                Limpar
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                Filtrar
            </button>
        </div>
    </form>
</div>
