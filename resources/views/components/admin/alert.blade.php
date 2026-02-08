@props(['type' => 'info', 'dismissible' => false])

@php
    $types = [
        'success' => 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-800 dark:text-green-300',
        'error' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-800 dark:text-red-300',
        'warning' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-300',
        'info' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300',
    ];
    
    $icons = [
        'success' => 'check-circle',
        'error' => 'exclamation-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle',
    ];
    
    $typeClass = $types[$type] ?? $types['info'];
    $icon = $icons[$type] ?? 'information-circle';
    $id = 'alert-' . uniqid();
@endphp

<div id="{{ $id }}" class="relative rounded-lg border p-4 {{ $typeClass }} transition-opacity duration-300" role="alert">
    <div class="flex items-start">
        <x-icon :name="$icon" class="w-5 h-5 mt-0.5 mr-3 flex-shrink-0" />
        <div class="flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button onclick="document.getElementById('{{ $id }}').style.opacity='0'; setTimeout(() => document.getElementById('{{ $id }}').remove(), 300)" class="ml-4 flex-shrink-0 text-current opacity-50 hover:opacity-75 transition-opacity">
                <x-icon name="x-mark" class="w-5 h-5" />
            </button>
        @endif
    </div>
</div>

