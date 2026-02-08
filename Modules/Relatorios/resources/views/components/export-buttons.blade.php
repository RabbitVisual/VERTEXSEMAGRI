@props([
    'route' => null,
    'filters' => [],
    'formats' => ['csv', 'excel', 'pdf'],
])

@php
    // Se route for uma string (nome da rota), usar diretamente
    // Se for null, usar a rota atual
    if ($route === null) {
        $baseRoute = request()->route()->getName();
    } elseif (is_string($route) && !str_starts_with($route, 'http')) {
        // É um nome de rota
        $baseRoute = $route;
    } else {
        // É uma URL completa, usar como está
        $baseRoute = $route;
    }
    
    // Filtrar apenas valores não vazios dos filtros
    $cleanFilters = array_filter($filters, function($value) {
        return $value !== null && $value !== '';
    });
@endphp

<div class="flex items-center gap-2">
    @if(in_array('csv', $formats))
        @if(is_string($baseRoute) && !str_starts_with($baseRoute, 'http'))
            @php
                $csvParams = array_merge($cleanFilters, ['format' => 'csv']);
                $csvUrl = route($baseRoute) . '?' . http_build_query($csvParams);
            @endphp
            <a 
                href="{{ $csvUrl }}" 
                target="_blank"
                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
            >
                <x-relatorios::icon name="document-plus" class="w-4 h-4 mr-2" />
                CSV
            </a>
        @else
            <a 
                href="{{ $baseRoute }}?{{ http_build_query(array_merge($cleanFilters, ['format' => 'csv'])) }}" 
                target="_blank"
                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
            >
                <x-relatorios::icon name="document-plus" class="w-4 h-4 mr-2" />
                CSV
            </a>
        @endif
    @endif

    @if(in_array('excel', $formats))
        @if(is_string($baseRoute) && !str_starts_with($baseRoute, 'http'))
            @php
                $excelParams = array_merge($cleanFilters, ['format' => 'excel']);
                $excelUrl = route($baseRoute) . '?' . http_build_query($excelParams);
            @endphp
            <a 
                href="{{ $excelUrl }}" 
                target="_blank"
                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
            >
                <x-relatorios::icon name="document-plus" class="w-4 h-4 mr-2" />
                Excel
            </a>
        @else
            <a 
                href="{{ $baseRoute }}?{{ http_build_query(array_merge($cleanFilters, ['format' => 'excel'])) }}" 
                target="_blank"
                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
            >
                <x-relatorios::icon name="document-plus" class="w-4 h-4 mr-2" />
                Excel
            </a>
        @endif
    @endif

    @if(in_array('pdf', $formats))
        @if(is_string($baseRoute) && !str_starts_with($baseRoute, 'http'))
            @php
                $pdfParams = array_merge($cleanFilters, ['format' => 'pdf']);
                $pdfUrl = route($baseRoute) . '?' . http_build_query($pdfParams);
            @endphp
            <a 
                href="{{ $pdfUrl }}" 
                target="_blank"
                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
            >
                <x-relatorios::icon name="printer" class="w-4 h-4 mr-2" />
                PDF
            </a>
        @else
            <a 
                href="{{ $baseRoute }}?{{ http_build_query(array_merge($cleanFilters, ['format' => 'pdf'])) }}" 
                target="_blank"
                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors"
            >
                <x-relatorios::icon name="printer" class="w-4 h-4 mr-2" />
                PDF
            </a>
        @endif
    @endif
</div>

