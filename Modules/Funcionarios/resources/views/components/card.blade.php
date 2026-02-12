@props(['class' => '', 'header' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 overflow-hidden $class"]) }}>
    @if($header)
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/40">
            {{ $header }}
        </div>
    @endif

    <div class="px-6 py-6">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-5 border-t border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/40">
            {{ $footer }}
        </div>
    @endif
</div>
