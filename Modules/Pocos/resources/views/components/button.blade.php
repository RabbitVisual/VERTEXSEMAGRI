@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
])

@php
    $variantClasses = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500 dark:bg-gray-500 dark:hover:bg-gray-600',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-600',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600',
        'warning' => 'bg-amber-600 hover:bg-amber-700 text-white focus:ring-amber-500 dark:bg-amber-500 dark:hover:bg-amber-600',
        'info' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600',
        'outline' => 'border-2 border-gray-300 hover:bg-gray-50 text-gray-700 focus:ring-gray-500 dark:border-gray-600 dark:hover:bg-gray-800 dark:text-gray-300',
        'outline-primary' => 'border-2 border-indigo-600 hover:bg-indigo-50 text-indigo-600 focus:ring-indigo-500 dark:border-indigo-400 dark:hover:bg-indigo-900/20 dark:text-indigo-400',
        'outline-success' => 'border-2 border-emerald-600 hover:bg-emerald-50 text-emerald-600 focus:ring-emerald-500 dark:border-emerald-400 dark:hover:bg-emerald-900/20 dark:text-emerald-400',
        'outline-danger' => 'border-2 border-red-600 hover:bg-red-50 text-red-600 focus:ring-red-500 dark:border-red-400 dark:hover:bg-red-900/20 dark:text-red-400',
    ];
    
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
    ];
    
    $baseClasses = 'inline-flex items-center justify-center rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
    $classes .= ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

