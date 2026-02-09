@props(['variant' => 'default', 'size' => 'md'])

@php
    $variantClasses = [
        'default' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200 border-slate-200 dark:border-slate-700',
        'primary' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 border-indigo-100 dark:border-indigo-800',
        'success' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800',
        'warning' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border-amber-100 dark:border-amber-800',
        'danger' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border-rose-100 dark:border-rose-800',
        'info' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border-blue-100 dark:border-blue-800',
    ];

    $sizeClasses = [
        'sm' => 'text-[8px] px-2 py-0.5',
        'md' => 'text-[9px] px-3 py-1',
        'lg' => 'text-[10px] px-4 py-1.5',
    ];

    $classes = $variantClasses[$variant] ?? $variantClasses['default'];
    $classes .= ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-black uppercase tracking-widest border italic $classes"]) }}>
    {{ $slot }}
</span>
