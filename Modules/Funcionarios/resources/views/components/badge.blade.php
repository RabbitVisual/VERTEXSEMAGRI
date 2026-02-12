@props(['variant' => 'default', 'size' => 'md'])

@php
    $variantClasses = [
        'default' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200 border-slate-200 dark:border-slate-700',
        'primary' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800',
        'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
        'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border-amber-200 dark:border-amber-800',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border-red-200 dark:border-red-800',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border-blue-200 dark:border-blue-800',
        'secondary' => 'bg-violet-100 text-violet-800 dark:bg-violet-900/30 dark:text-violet-300 border-violet-200 dark:border-violet-800',
    ];

    $sizeClasses = [
        'sm' => 'text-[10px] px-2 py-0.5',
        'md' => 'text-xs px-2.5 py-1',
        'lg' => 'text-sm px-3 py-1.5',
    ];

    $classes = $variantClasses[$variant] ?? $variantClasses['default'];
    $classes .= ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-semibold border $classes uppercase tracking-wider transition-all duration-200"]) }}>
    {{ $slot }}
</span>
