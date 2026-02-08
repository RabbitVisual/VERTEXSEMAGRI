@props(['title', 'value', 'icon' => null, 'color' => 'primary', 'subtitle' => null, 'link' => null, 'prefix' => null])

@php
    $colorClasses = [
        'primary' => 'bg-indigo-600 dark:bg-indigo-500',
        'success' => 'bg-emerald-600 dark:bg-emerald-500',
        'warning' => 'bg-amber-500 dark:bg-amber-500',
        'danger' => 'bg-red-600 dark:bg-red-500',
        'info' => 'bg-blue-600 dark:bg-blue-500',
        'secondary' => 'bg-violet-600 dark:bg-violet-500',
    ];

    $textClasses = [
        'primary' => 'text-indigo-50',
        'success' => 'text-emerald-50',
        'warning' => 'text-amber-50',
        'danger' => 'text-red-50',
        'info' => 'text-blue-50',
        'secondary' => 'text-violet-50',
    ];

    $iconMap = [
        'clipboard-check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />',
        'folder-open' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />',
        'clock-history' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'check-circle' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'exclamation-triangle' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />',
        'document-x' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />',
        'cube' => '<path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />',
        'x-circle' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'currency-dollar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
    ];

    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $textClass = $textClasses[$color] ?? $textClasses['primary'];
    $iconPath = $icon ? ($iconMap[$icon] ?? '') : '';
@endphp

<div class="relative rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-opacity-50 h-full flex flex-col {{ $link ? 'cursor-pointer transform hover:scale-105' : '' }}">
    <div class="relative {{ $colorClass }} {{ $textClass }} p-4 md:p-5 overflow-hidden flex-1 flex flex-col">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full -ml-12 -mb-12"></div>
        <div class="relative flex items-start justify-between gap-2 flex-1">
            <div class="flex-1 z-10 min-w-0 flex flex-col justify-between">
                <div class="w-full">
                    <p class="text-xs font-semibold opacity-90 mb-2 uppercase tracking-wide leading-tight">{{ $title }}</p>
                    @php
                        $valueStr = is_numeric($value) ? number_format((float)$value, 0, ',', '.') : $value;
                        $fullValue = $prefix ? $prefix . $valueStr : $valueStr;
                        $isLongValue = strlen($fullValue) > 12;
                    @endphp
                    <div class="{{ $isLongValue ? 'text-base md:text-lg' : 'text-xl md:text-2xl' }} font-extrabold mb-1 drop-shadow-sm leading-tight">
                        @if($prefix)
                            <span class="text-xs md:text-sm opacity-90 mr-0.5">{{ $prefix }}</span>
                        @endif
                        <span class="whitespace-nowrap inline-block">{{ $valueStr }}</span>
                    </div>
                </div>
                @if($subtitle)
                    <p class="text-xs opacity-90 mt-2 font-medium leading-tight">{{ $subtitle }}</p>
                @endif
            </div>
            @if($icon && $iconPath)
                <div class="flex-shrink-0 opacity-90 z-10">
                    <div class="p-1.5 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            {!! $iconPath !!}
                        </svg>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-10" aria-label="{{ $title }}"></a>
    @endif
</div>

