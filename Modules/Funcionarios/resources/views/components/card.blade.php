@props(['class' => '', 'header' => null, 'footer' => null, 'title' => null, 'subtitle' => null])

<div {{ $attributes->merge(['class' => "premium-card overflow-hidden $class"]) }}>
    @if($header || $title)
        <div class="px-10 py-8 border-b border-gray-100 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
            <div>
                @if($title)
                    <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 italic">{{ $subtitle }}</p>
                @endif
                @if($header) {{ $header }} @endif
            </div>
        </div>
    @endif

    <div class="px-10 py-8">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-10 py-6 border-t border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
            {{ $footer }}
        </div>
    @endif
</div>
