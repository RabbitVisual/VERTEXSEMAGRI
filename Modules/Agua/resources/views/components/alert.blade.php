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
    
    $icons = [
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'danger' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />',
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $iconClass = $iconClasses[$type] ?? $iconClasses['info'];
    $iconPath = $icons[$type] ?? $icons['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 $classes"]) }} role="alert">
    <div class="flex items-start">
        @if($icon)
            <svg class="h-5 w-5 flex-shrink-0 {{ $iconClass }} mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                {!! $iconPath !!}
            </svg>
        @endif
        <div class="ml-3 flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button type="button" onclick="this.closest('[role=alert]').remove()" class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex h-8 w-8 {{ $iconClass }} hover:opacity-75">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        @endif
    </div>
</div>

