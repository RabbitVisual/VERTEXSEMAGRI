@props(['title', 'value', 'icon' => null, 'color' => 'primary', 'subtitle' => null, 'link' => null])

@php
    $colorClasses = [
        'primary' => 'bg-indigo-500 dark:bg-indigo-600',
        'success' => 'bg-emerald-500 dark:bg-emerald-600',
        'warning' => 'bg-amber-400 dark:bg-amber-500',
        'danger' => 'bg-red-500 dark:bg-red-600',
        'info' => 'bg-blue-500 dark:bg-blue-600',
        'secondary' => 'bg-violet-500 dark:bg-violet-600',
    ];

    $bgClasses = [
        'primary' => 'bg-indigo-50/50 dark:bg-indigo-900/10',
        'success' => 'bg-emerald-50/50 dark:bg-emerald-900/10',
        'warning' => 'bg-amber-50/50 dark:bg-amber-900/10',
        'danger' => 'bg-red-50/50 dark:bg-red-900/10',
        'info' => 'bg-blue-50/50 dark:bg-blue-900/10',
        'secondary' => 'bg-violet-50/50 dark:bg-violet-900/10',
    ];

    $textColorClasses = [
        'primary' => 'text-indigo-600 dark:text-indigo-400',
        'success' => 'text-emerald-600 dark:text-emerald-400',
        'warning' => 'text-amber-600 dark:text-amber-400',
        'danger' => 'text-red-600 dark:text-red-400',
        'info' => 'text-blue-600 dark:text-blue-400',
        'secondary' => 'text-violet-600 dark:text-violet-400',
    ];

    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $bgClass = $bgClasses[$color] ?? $bgClasses['primary'];
    $textColorClass = $textColorClasses[$color] ?? $textColorClasses['primary'];
@endphp

<div class="relative group p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 rounded-2xl shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300 {{ $link ? 'cursor-pointer' : '' }}">
    <div class="flex items-center gap-4">
        @if($icon)
            <div class="w-12 h-12 rounded-xl {{ $colorClass }} flex items-center justify-center text-white shadow-lg shadow-current/20 group-hover:scale-110 transition-transform duration-300">
                <x-icon :name="$icon" class="w-6 h-6" />
            </div>
        @endif

        <div class="flex-1">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $title }}</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ is_numeric($value) ? number_format((float)$value, 0, ',', '.') : $value }}</h3>
                @if($subtitle)
                    <span class="text-xs {{ $textColorClass }} font-medium">{{ $subtitle }}</span>
                @endif
            </div>
        </div>
    </div>

    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-10" aria-label="{{ $title }}"></a>
    @endif
</div>
