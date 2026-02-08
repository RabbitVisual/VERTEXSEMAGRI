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
    $subtitleClasses = [
        'primary' => 'text-indigo-100 dark:text-indigo-200',
        'success' => 'text-emerald-100 dark:text-emerald-200',
        'warning' => 'text-amber-100 dark:text-amber-200',
        'danger' => 'text-red-100 dark:text-red-200',
        'info' => 'text-blue-100 dark:text-blue-200',
        'secondary' => 'text-violet-100 dark:text-violet-200',
    ];
    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $textClass = $textClasses[$color] ?? $textClasses['primary'];
    $subtitleClass = $subtitleClasses[$color] ?? $subtitleClasses['primary'];

    // Mapeamento de ícones Bootstrap para Heroicons
    $iconMap = [
        'bi-clipboard-check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />',
        'bi-file-earmark-text' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
        'bi-check-circle' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'bi-exclamation-triangle' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
        'bi-clipboard-data' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />',
        'bi-file-earmark-check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'bi-geo-alt' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />',
        'bi-people' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
        'bi-arrow-right-circle' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />',
        'bi-clock-history' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'bi-person-check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'bi-person-badge' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6a5 5 0 110 10 5 5 0 010-10zM4 22a8 8 0 1116 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />',
        'bi-box-seam' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
        'bi-x-circle' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'bi-lightbulb' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />',
        'bi-droplet' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
    ];
    $iconPath = $iconMap[$icon] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />';
@endphp

<div class="relative rounded-lg shadow-sm overflow-hidden {{ $link ? 'card-hover cursor-pointer' : '' }}">
    <div class="{{ $colorClass }} {{ $textClass }} p-6 relative z-10">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium {{ $subtitleClass }} mb-1">
                    {{ $title }}
                </p>
                <p class="text-3xl font-bold {{ $textClass }}">
                    {{ number_format((float)$value, 0, ',', '.') }}
                </p>
                @if($subtitle)
                    <p class="text-xs {{ $subtitleClass }} mt-1">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            @if($icon)
                <div class="ml-4 flex-shrink-0 opacity-80">
                    <svg class="h-12 w-12 {{ $textClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $iconPath !!}
                    </svg>
                </div>
            @endif
        </div>
    </div>
    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-20" aria-label="{{ $title }}"></a>
    @endif
</div>
