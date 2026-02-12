@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'iconRight' => null,
])

@php
    $variantClasses = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-indigo-500/20 dark:bg-indigo-500 dark:hover:bg-indigo-600',
        'secondary' => 'bg-slate-700 hover:bg-slate-800 text-white shadow-slate-500/20 dark:bg-slate-600 dark:hover:bg-slate-700',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-500/20 dark:bg-emerald-500 dark:hover:bg-emerald-600',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-red-500/20 dark:bg-red-500 dark:hover:bg-red-600',
        'warning' => 'bg-amber-500 hover:bg-amber-600 text-white shadow-amber-500/20',
        'info' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-500/20 dark:bg-blue-500 dark:hover:bg-blue-600',
        'outline' => 'border border-slate-300 hover:bg-slate-50 text-slate-700 dark:border-slate-600 dark:hover:bg-slate-800 dark:text-slate-300',
        'outline-primary' => 'border border-indigo-600 hover:bg-indigo-50 text-indigo-600 dark:border-indigo-400 dark:hover:bg-indigo-900/20 dark:text-indigo-400',
        'ghost' => 'hover:bg-slate-100 text-slate-600 dark:hover:bg-slate-800 dark:text-slate-400',
    ];

    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3.5 text-base',
    ];

    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-xl font-semibold shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
    $classes .= ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) <x-icon :name="$icon" class="w-4 h-4" /> @endif
        {{ $slot }}
        @if($iconRight) <x-icon :name="$iconRight" class="w-4 h-4" /> @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) <x-icon :name="$icon" class="w-4 h-4" /> @endif
        {{ $slot }}
        @if($iconRight) <x-icon :name="$iconRight" class="w-4 h-4" /> @endif
    </button>
@endif
