@props(['title' => null, 'class' => ''])

<div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 {{ $class }}">
    @if(isset($header) || $title)
    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
        @if(isset($header))
            {{ $header }}
        @elseif($title)
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
        @endif
    </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
    
    @if(isset($footer))
    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        {{ $footer }}
    </div>
    @endif
</div>

