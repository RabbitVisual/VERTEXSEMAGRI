@props(['class' => '', 'header' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden $class"]) }}>
    @if($header)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            {{ $header }}
        </div>
    @endif
    
    <div class="px-6 py-4">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            {{ $footer }}
        </div>
    @endif
</div>

