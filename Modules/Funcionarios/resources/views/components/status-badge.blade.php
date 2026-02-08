@props(['funcionario'])

@php
$statusClasses = [
    'disponivel' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400',
    'em_atendimento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/20 dark:text-amber-400',
    'pausado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
    'offline' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
];

$statusIcons = [
    'disponivel' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
    'em_atendimento' => '<svg class="w-4 h-4 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" /></svg>',
    'pausado' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" /></svg>',
    'offline' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l8.735 8.735m0 0a.374.374 0 11.53.53m-.53-.53l.53.53m0 0L21 21" /></svg>',
];

$class = $statusClasses[$funcionario->status_campo] ?? $statusClasses['offline'];
$icon = $statusIcons[$funcionario->status_campo] ?? $statusIcons['offline'];
@endphp

<div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium {{ $class }}">
    <span class="flex-shrink-0">
        {!! $icon !!}
    </span>
    <span>{{ $funcionario->status_campo_texto }}</span>
    @if($funcionario->estaEmAtendimento() && $funcionario->tempo_atendimento)
        <span class="text-xs opacity-75">• {{ $funcionario->tempo_atendimento }}</span>
    @endif
</div>

