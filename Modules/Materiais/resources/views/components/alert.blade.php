@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => true,
])

@php
    $typeClasses = [
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-900/20 dark:border-emerald-800 dark:text-emerald-200',
        'danger' => 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800 dark:bg-amber-900/20 dark:border-amber-800 dark:text-amber-200',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-200',
    ];
    
    $iconClasses = [
        'success' => 'text-emerald-400',
        'danger' => 'text-red-400',
        'warning' => 'text-amber-400',
        'info' => 'text-blue-400',
    ];
    
    $iconNames = [
        'success' => 'circle-check',
        'danger' => 'triangle-exclamation',
        'warning' => 'triangle-exclamation',
        'info' => 'circle-info',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $iconClass = $iconClasses[$type] ?? $iconClasses['info'];
    $iconName = $iconNames[$type] ?? $iconNames['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 $classes"]) }} role="alert">
    <div class="flex items-start">
        @if($icon)
            <div class="flex-shrink-0 {{ $iconClass }} mt-0.5">
                <x-icon :name="$iconName" class="h-5 w-5" />
            </div>
        @endif
        <div class="ml-3 flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button type="button" onclick="this.closest('[role=alert]').remove()" class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex h-8 w-8 {{ $iconClass }} hover:opacity-75">
                <x-icon name="xmark" class="w-5 h-5" />
            </button>
        @endif
    </div>
</div>
