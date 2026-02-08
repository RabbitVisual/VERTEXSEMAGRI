@props(['title', 'value', 'icon' => null, 'color' => 'primary', 'subtitle' => null, 'link' => null])

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
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />',
        'user-group' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />',
        'user-minus' => '<path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />',
    ];
    
    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $textClass = $textClasses[$color] ?? $textClasses['primary'];
    $iconPath = $icon ? ($iconMap[$icon] ?? '') : '';
@endphp

<div class="relative rounded-lg shadow-sm overflow-hidden {{ $link ? 'cursor-pointer hover:shadow-md transition-shadow' : '' }}">
    <div class="{{ $colorClass }} {{ $textClass }} p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium opacity-90 mb-1">{{ $title }}</p>
                <p class="text-3xl font-bold">{{ number_format((float)$value, 0, ',', '.') }}</p>
                @if($subtitle)
                    <p class="text-xs opacity-80 mt-1">{{ $subtitle }}</p>
                @endif
            </div>
            @if($icon && $iconPath)
                <div class="ml-4 flex-shrink-0 opacity-80">
                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        {!! $iconPath !!}
                    </svg>
                </div>
            @endif
        </div>
    </div>
    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-10" aria-label="{{ $title }}"></a>
    @endif
</div>

