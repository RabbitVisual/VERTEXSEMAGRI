@props([
    'title',
    'value',
    'subtitle' => null,
    'icon' => null,
    'color' => 'primary',
    'trend' => null, // 'up', 'down', null
    'trendValue' => null,
    'link' => null,
])

@php
    $colorClasses = [
        'primary' => 'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-200 dark:border-indigo-800',
        'success' => 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800',
        'warning' => 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800',
        'danger' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800',
        'info' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800',
        'secondary' => 'bg-violet-50 dark:bg-violet-900/20 border-violet-200 dark:border-violet-800',
    ];
    
    $iconColorClasses = [
        'primary' => 'text-indigo-600 dark:text-indigo-400',
        'success' => 'text-emerald-600 dark:text-emerald-400',
        'warning' => 'text-amber-600 dark:text-amber-400',
        'danger' => 'text-red-600 dark:text-red-400',
        'info' => 'text-blue-600 dark:text-blue-400',
        'secondary' => 'text-violet-600 dark:text-violet-400',
    ];
    
    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $iconColorClass = $iconColorClasses[$color] ?? $iconColorClasses['primary'];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg border {{ $colorClass }} p-6 {{ $link ? 'cursor-pointer hover:shadow-lg transition-shadow' : '' }}">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ is_numeric($value) ? number_format($value, 0, ',', '.') : $value }}</p>
            @if($subtitle)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
            @if($trend && $trendValue)
                <div class="flex items-center mt-2">
                    @if($trend === 'up')
                        <svg class="w-4 h-4 text-emerald-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-red-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                    @endif
                    <span class="text-xs font-medium {{ $trend === 'up' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $trendValue }}
                    </span>
                </div>
            @endif
        </div>
        @if($icon)
            <div class="flex-shrink-0 ml-4">
                <div class="w-12 h-12 {{ $iconColorClass }} rounded-lg flex items-center justify-center">
                    <x-relatorios::icon :name="$icon" class="w-6 h-6" />
                </div>
            </div>
        @endif
    </div>
    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-10" aria-label="{{ $title }}"></a>
    @endif
</div>

