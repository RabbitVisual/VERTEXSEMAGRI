@php
    $colorClasses = [
        'primary' => 'border-l-indigo-500 bg-indigo-50 dark:bg-indigo-900/10',
        'success' => 'border-l-emerald-500 bg-emerald-50 dark:bg-emerald-900/10',
        'warning' => 'border-l-amber-500 bg-amber-50 dark:bg-amber-900/10',
        'danger' => 'border-l-red-500 bg-red-50 dark:bg-red-900/10',
        'info' => 'border-l-blue-500 bg-blue-50 dark:bg-blue-900/10',
        'secondary' => 'border-l-violet-500 bg-violet-50 dark:bg-violet-900/10',
    ];
    $iconColorClasses = [
        'primary' => 'text-indigo-600 dark:text-indigo-400',
        'success' => 'text-emerald-600 dark:text-emerald-400',
        'warning' => 'text-amber-600 dark:text-amber-400',
        'danger' => 'text-red-600 dark:text-red-400',
        'info' => 'text-blue-600 dark:text-blue-400',
        'secondary' => 'text-violet-600 dark:text-violet-400',
    ];
    $buttonClasses = [
        'primary' => 'text-indigo-600 hover:bg-indigo-100 dark:text-indigo-400 dark:hover:bg-indigo-900/20 border-indigo-200 dark:border-indigo-800',
        'success' => 'text-emerald-600 hover:bg-emerald-100 dark:text-emerald-400 dark:hover:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800',
        'warning' => 'text-amber-600 hover:bg-amber-100 dark:text-amber-400 dark:hover:bg-amber-900/20 border-amber-200 dark:border-amber-800',
        'danger' => 'text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/20 border-red-200 dark:border-red-800',
        'info' => 'text-blue-600 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/20 border-blue-200 dark:border-blue-800',
        'secondary' => 'text-violet-600 hover:bg-violet-100 dark:text-violet-400 dark:hover:bg-violet-900/20 border-violet-200 dark:border-violet-800',
    ];
    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $iconColorClass = $iconColorClasses[$color] ?? $iconColorClasses['primary'];
    $buttonClass = $buttonClasses[$color] ?? $buttonClasses['primary'];

    // Se um módulo for fornecido, usar ícones padronizados
    use App\Helpers\ModuleIcons;
    
    // Mapear nome da rota/módulo para nome do módulo no helper
    $moduleMap = [
        'demandas' => 'Demandas',
        'ordens' => 'Ordens',
        'localidades' => 'Localidades',
        'pessoas' => 'Pessoas',
        'iluminacao' => 'Iluminacao',
        'agua' => 'Agua',
        'pocos' => 'Pocos',
        'estradas' => 'Estradas',
        'funcionarios' => 'Funcionarios',
        'equipes' => 'Equipes',
        'materiais' => 'Materiais',
        'relatorios' => 'Relatorios',
        'notificacoes' => 'Notificacoes',
        'caf' => 'CAF',
        'chat' => 'Chat',
        'homepage' => 'Homepage',
        'programasagricultura' => 'ProgramasAgricultura',
    ];
    
    $iconPath = '';
    $viewBox = '0 0 24 24';
    $iconType = 'stroke';
    
    if ($module) {
        // Usar o módulo fornecido diretamente
        $moduleName = $moduleMap[strtolower($module)] ?? ucfirst($module);
        $iconPath = ModuleIcons::getIconPath($moduleName);
        $viewBox = ModuleIcons::getViewBox($moduleName);
        $iconType = ModuleIcons::getIconType($moduleName);
        
        // Se não encontrar ícone padronizado, tentar detectar da rota
        if (!$iconPath) {
            $routeParts = explode('.', $route);
            $routeModule = $routeParts[0] ?? '';
            if ($routeModule && isset($moduleMap[strtolower($routeModule)])) {
                $moduleName = $moduleMap[strtolower($routeModule)];
                $iconPath = ModuleIcons::getIconPath($moduleName);
                $viewBox = ModuleIcons::getViewBox($moduleName);
                $iconType = ModuleIcons::getIconType($moduleName);
            }
        }
    } else {
        // Tentar detectar módulo da rota automaticamente
        $routeParts = explode('.', $route);
        $routeModule = $routeParts[0] ?? '';
        if ($routeModule && isset($moduleMap[strtolower($routeModule)])) {
            $moduleName = $moduleMap[strtolower($routeModule)];
            $iconPath = ModuleIcons::getIconPath($moduleName);
            $viewBox = ModuleIcons::getViewBox($moduleName);
            $iconType = ModuleIcons::getIconType($moduleName);
        }
    }
    
    // Se ainda não tiver ícone, usar mapeamento de compatibilidade (fallback)
    if (empty($iconPath) && isset($icon)) {
        $iconMap = [
            'bi-clipboard-check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />',
            'bi-file-earmark-text' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
            'bi-geo-alt' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />',
            'bi-box-seam' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
            'bi-people' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
            'bi-person-badge' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6a5 5 0 110 10 5 5 0 010-10zM4 22a8 8 0 1116 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />',
            'bi-person' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />',
            'bi-lightbulb' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />',
            'bi-droplet' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
            'bi-water' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
            'bi-road' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />',
            'bi-graph-up' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />',
        ];
        $iconPath = $iconMap[$icon] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />';
    }
    
    // Fallback final se nenhum ícone foi encontrado
    if (empty($iconPath)) {
        $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />';
    }
@endphp

<div class="relative rounded-lg border-l-4 {{ $colorClass }} bg-white dark:bg-gray-800 shadow-sm card-hover h-full flex flex-col">
    <div class="p-6 flex-1 flex flex-col">
        <div class="flex items-start justify-between mb-4">
            <div class="{{ $iconColorClass }}">
                <svg class="h-10 w-10" 
                     viewBox="{{ $viewBox }}"
                     @if($iconType === 'fill')
                     fill="currentColor"
                     @else
                     fill="none" 
                     stroke="currentColor" 
                     stroke-width="1.5"
                     @endif>
                    {!! $iconPath !!}
                </svg>
            </div>
            @if($badge)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $iconColorClass }} bg-opacity-20">
                    {{ $badge }}
                </span>
            @endif
        </div>

        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            {{ $title }}
        </h3>

        <p class="text-sm text-gray-600 dark:text-gray-400 flex-1 mb-4">
            {{ $description }}
        </p>

        @if(Route::has($route))
            <a href="{{ route($route) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded-lg transition-colors {{ $buttonClass }}">
                Acessar
                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @else
            <span class="text-sm text-gray-500 dark:text-gray-400">Rota não disponível</span>
        @endif
    </div>
</div>
