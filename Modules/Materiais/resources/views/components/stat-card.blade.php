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

    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $textClass = $textClasses[$color] ?? $textClasses['primary'];

    // Map old icon names to new FA names if necessary
    $iconMap = [
        'clipboard-check' => 'clipboard-check',
        'folder-open' => 'folder-open',
        'clock-history' => 'clock-rotate-left',
        'check-circle' => 'circle-check',
        'exclamation-triangle' => 'triangle-exclamation',
        'document-x' => 'file-circle-xmark',
        'cube' => 'cube',
        'x-circle' => 'circle-xmark',
        'currency-dollar' => 'dollar-sign',
        'archive-box' => 'box-archive',
        'arrow-path' => 'rotate',
        'arrow-down-circle' => 'circle-arrow-down',
        'arrow-up-circle' => 'circle-arrow-up',
        'circle' => 'circle',
        'building-office' => 'building',
        'link' => 'link',
        'information-circle' => 'circle-info',
        'inbox' => 'inbox',
        'bolt' => 'bolt',
        'magnifying-glass' => 'magnifying-glass',
        'cog' => 'gear',
        'document-text' => 'file-lines',
        'pencil' => 'pen',
        'trash' => 'trash',
        'printer' => 'print',
        'map-pin' => 'map-pin',
        'calendar' => 'calendar',
        'clock' => 'clock',
        'droplet' => 'droplet',
        'light-bulb' => 'lightbulb',
        'road' => 'road',
        'phone' => 'phone',
        'envelope' => 'envelope',
        'arrow-left' => 'arrow-left',
        'x-mark' => 'xmark',
        'arrow-right' => 'arrow-right',
    ];

    $iconName = $icon ? ($iconMap[$icon] ?? $icon) : null;
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
            @if($iconName)
                <div class="flex-shrink-0 opacity-90 z-10">
                    <div class="p-1.5 bg-white/20 rounded-lg backdrop-blur-sm">
                        <x-icon :name="$iconName" class="h-5 w-5 md:h-6 md:w-6" />
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-10" aria-label="{{ $title }}"></a>
    @endif
</div>
