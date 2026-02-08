@props(['variant' => 'default', 'size' => 'md'])

@php
    $variantClasses = [
        'default' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
        'primary' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
        'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
        'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'secondary' => 'bg-violet-100 text-violet-800 dark:bg-violet-900 dark:text-violet-200',
    ];

    $sizeClasses = [
        'sm' => 'text-xs px-2 py-0.5',
        'md' => 'text-sm px-2.5 py-1',
        'lg' => 'text-base px-3 py-1.5',
    ];

    $classes = $variantClasses[$variant] ?? $variantClasses['default'];
    $classes .= ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-medium $classes"]) }}>
    {{ $slot }}
</span>

