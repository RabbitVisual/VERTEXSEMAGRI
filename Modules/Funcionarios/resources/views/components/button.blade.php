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
        'primary' => 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-xl shadow-emerald-600/20 active:scale-95 border border-emerald-500/10',
        'secondary' => 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:opacity-90 active:scale-95 shadow-xl shadow-black/10',
        'success' => 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-xl shadow-emerald-500/20 active:scale-95',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 shadow-xl shadow-rose-600/20 active:scale-95',
        'outline' => 'bg-transparent border-2 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-900 active:scale-95',
        'ghost' => 'bg-transparent text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-900 hover:text-emerald-600 active:scale-95',
    ];

    $sizeClasses = [
        'sm' => 'px-5 py-2.5 text-[9px]',
        'md' => 'px-8 py-4 text-[10px]',
        'lg' => 'px-10 py-5 text-[11px]',
        'xl' => 'px-12 py-6 text-[12px]',
    ];

    $baseClasses = 'inline-flex items-center justify-center gap-3 rounded-2xl font-black uppercase tracking-widest transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer';
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
    $classes .= ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) <x-icon :name="$icon" class="w-4 h-4" /> @endif
        <span>{{ $slot }}</span>
        @if($iconRight) <x-icon :name="$iconRight" class="w-4 h-4" /> @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) <x-icon :name="$icon" class="w-4 h-4" /> @endif
        <span>{{ $slot }}</span>
        @if($iconRight) <x-icon :name="$iconRight" class="w-4 h-4" /> @endif
    </button>
@endif
