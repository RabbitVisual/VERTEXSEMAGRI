@props(['title', 'value', 'icon' => null, 'color' => 'primary', 'subtitle' => null, 'link' => null])

@php
    $colorMaps = [
        'primary' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'dark_bg' => 'dark:bg-indigo-950/20', 'dark_text' => 'dark:text-indigo-400', 'glow' => 'group-hover:border-indigo-500'],
        'success' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'dark_bg' => 'dark:bg-emerald-950/20', 'dark_text' => 'dark:text-emerald-400', 'glow' => 'group-hover:border-emerald-500'],
        'warning' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'dark_bg' => 'dark:bg-amber-950/20', 'dark_text' => 'dark:text-amber-400', 'glow' => 'group-hover:border-amber-500'],
        'danger' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'dark_bg' => 'dark:bg-rose-950/20', 'dark_text' => 'dark:text-rose-400', 'glow' => 'group-hover:border-rose-500'],
        'info' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'dark_bg' => 'dark:bg-blue-950/20', 'dark_text' => 'dark:text-blue-400', 'glow' => 'group-hover:border-blue-500'],
    ];

    $c = $colorMaps[$color] ?? $colorMaps['primary'];
@endphp

<div class="premium-card p-8 group {{ $c['glow'] }} transition-all duration-500 relative overflow-hidden">
    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity pointer-events-none">
        @if($icon) <x-icon :name="$icon" class="w-32 h-32" /> @endif
    </div>

    <div class="relative z-10 flex flex-col justify-between h-full">
        <div class="flex items-center justify-between mb-8">
            <div class="w-14 h-14 rounded-2xl {{ $c['bg'] }} {{ $c['dark_bg'] }} flex items-center justify-center {{ $c['text'] }} {{ $c['dark_text'] }} group-hover:scale-110 group-hover:{{ str_replace('text-', 'bg-', $c['text']) }} group-hover:text-white transition-all shadow-sm">
                @if($icon) <x-icon :name="$icon" style="duotone" class="w-7 h-7" /> @endif
            </div>
            @if($link)
                <a href="{{ $link }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 hover:text-indigo-500 transition-colors">
                    <x-icon name="arrow-up-right-from-square" class="w-4 h-4" />
                </a>
            @endif
        </div>

        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-2 italic">{{ $title }}</p>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $value }}</span>
                @if($subtitle)
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest opacity-60 mb-1 italic">{{ $subtitle }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
