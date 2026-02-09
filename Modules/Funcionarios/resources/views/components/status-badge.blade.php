@props(['funcionario'])

@php
$statusConfig = [
    'disponivel' => ['cor' => 'emerald', 'icon' => 'circle-check', 'label' => 'OPERACIONAL / DISPONÍVEL'],
    'em_atendimento' => ['cor' => 'amber', 'icon' => 'truck-fast', 'label' => 'DIRECIONADO / EM CAMPO'],
    'pausado' => ['cor' => 'blue', 'icon' => 'circle-pause', 'label' => 'SUSPENSÃO TEMPORÁRIA'],
    'offline' => ['cor' => 'slate', 'icon' => 'circle-slash', 'label' => 'CONEXÃO INTERROMPIDA'],
];

$conf = $statusConfig[$funcionario->status_campo] ?? $statusConfig['offline'];
@endphp

<div class="inline-flex items-center gap-3 px-4 py-2 bg-{{ $conf['cor'] }}-50 dark:bg-{{ $conf['cor'] }}-950/20 border border-{{ $conf['cor'] }}-100 dark:border-{{ $conf['cor'] }}-900/30 rounded-full animate-fade-in group">
    <div class="relative">
        <x-icon name="{{ $conf['icon'] }}" style="duotone" class="w-4 h-4 text-{{ $conf['cor'] }}-600 dark:text-{{ $conf['cor'] }}-400" />
        @if($funcionario->status_campo === 'em_atendimento')
            <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        @endif
    </div>

    <div class="flex items-center gap-2">
        <span class="text-[9px] font-black uppercase tracking-[0.2em] text-{{ $conf['cor'] }}-800 dark:text-{{ $conf['cor'] }}-300 italic">
            {{ $conf['label'] }}
        </span>

        @if($funcionario->estaEmAtendimento() && $funcionario->tempo_atendimento)
            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
            <span class="text-[9px] font-black tabular-nums text-{{ $conf['cor'] }}-600/70 tracking-tighter">{{ $funcionario->tempo_atendimento }}</span>
        @endif
    </div>
</div>
