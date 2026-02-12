@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => true,
])

@php
    $typeClasses = [
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-900/20 dark:border-emerald-800/50 dark:text-emerald-300',
        'danger' => 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800/50 dark:text-red-300',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800 dark:bg-amber-900/20 dark:border-amber-800/50 dark:text-amber-300',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/20 dark:border-blue-800/50 dark:text-blue-300',
    ];

    $iconNames = [
        'success' => 'circle-check',
        'danger' => 'circle-exclamation',
        'warning' => 'triangle-exclamation',
        'info' => 'circle-info',
    ];

    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $iconName = $iconNames[$type] ?? $iconNames['info'];
@endphp

<div x-data="{ show: true }" x-show="show" {{ $attributes->merge(['class' => "rounded-xl border p-4 transition-all duration-300 $classes"]) }} role="alert">
    <div class="flex items-start gap-4">
        @if($icon)
            <x-icon :name="$iconName" class="w-5 h-5 flex-shrink-0 mt-0.5" />
        @endif
        <div class="flex-1 text-sm font-medium">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button type="button" @click="show = false" class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex h-8 w-8 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                <x-icon name="xmark" class="w-4 h-4" />
            </button>
        @endif
    </div>
</div>
