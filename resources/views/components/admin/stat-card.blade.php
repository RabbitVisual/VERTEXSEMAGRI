@props(['label', 'value', 'icon', 'color' => 'primary', 'description' => null])

@php
    $colors = [
        'primary' => 'bg-emerald-500 dark:bg-emerald-600',
        'info' => 'bg-blue-500 dark:bg-blue-600',
        'success' => 'bg-green-500 dark:bg-green-600',
        'warning' => 'bg-yellow-500 dark:bg-yellow-600',
        'danger' => 'bg-red-500 dark:bg-red-600',
        'secondary' => 'bg-slate-600 dark:bg-slate-700',
    ];
    $colorClass = $colors[$color] ?? $colors['primary'];
@endphp

<div class="relative overflow-hidden rounded-xl {{ $colorClass }} text-white p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-white/90 text-sm font-medium mb-1">{{ $label }}</p>
                <p class="text-3xl font-bold mb-2">{{ $value }}</p>
                @if(isset($description) && $description)
                    <p class="text-white/80 text-xs">{{ $description }}</p>
                @endif
            </div>
            @if($icon)
                <div class="ml-4">
                    <x-icon :name="$icon" class="w-12 h-12 text-white/80" />
                </div>
            @endif
        </div>
    </div>
</div>

