@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'href' => null])

@php
    $variants = [
        'primary' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500',
        'secondary' => 'bg-slate-600 hover:bg-slate-700 text-white focus:ring-slate-500',
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'warning' => 'bg-yellow-600 hover:bg-yellow-700 text-white focus:ring-yellow-500',
        'info' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
        'outline' => 'border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 focus:ring-gray-500',
        'ghost' => 'text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 focus:ring-gray-500',
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
    
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $baseClass = 'inline-flex items-center justify-center rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseClass} {$variantClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClass} {$variantClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </button>
@endif

