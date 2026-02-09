@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => true,
])

@php
    $typeClasses = [
        'success' => 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-100 dark:border-emerald-900/30 text-emerald-800 dark:text-emerald-400 shadow-sm shadow-emerald-500/5',
        'danger' => 'bg-rose-50 dark:bg-rose-950/20 border-rose-100 dark:border-rose-900/30 text-rose-800 dark:text-rose-400 shadow-sm shadow-rose-500/5',
        'warning' => 'bg-amber-50 dark:bg-amber-950/20 border-amber-100 dark:border-amber-900/30 text-amber-800 dark:text-amber-400 shadow-sm shadow-amber-500/5',
        'info' => 'bg-blue-50 dark:bg-blue-950/20 border-blue-100 dark:border-blue-900/30 text-blue-800 dark:text-blue-400 shadow-sm shadow-blue-500/5',
    ];

    $icons = [
        'success' => 'circle-check',
        'danger' => 'triangle-exclamation',
        'warning' => 'circle-exclamation',
        'info' => 'circle-info',
    ];

    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $iconName = $icons[$type] ?? $icons['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl border p-5 transition-all duration-300 $classes animate-fade-in"]) }} role="alert">
    <div class="flex items-center gap-4">
        @if($icon)
            <div class="flex-shrink-0">
                <x-icon name="{{ $iconName }}" style="duotone" class="w-6 h-6" />
            </div>
        @endif
        <div class="flex-1 text-[11px] font-black uppercase tracking-widest italic leading-relaxed">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button type="button" @click="$el.closest('[role=alert]').remove()" class="flex-shrink-0 ml-auto p-1.5 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-all outline-none">
                <x-icon name="xmark" class="w-4 h-4" />
            </button>
        @endif
    </div>
</div>
