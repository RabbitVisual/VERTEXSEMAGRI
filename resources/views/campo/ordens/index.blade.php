@extends('campo.layouts.app')

@section('title', 'Ordens Táticas')

@section('breadcrumbs')
    <x-icon name="chevron-right" class="w-2 h-2" />
    <span class="text-emerald-600">Fila de Operações</span>
@endsection

@section('content')
<div class="space-y-6 md:space-y-10 animate-fade-in pb-12">
    <!-- Header de Missão -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl flex items-center justify-center text-white shadow-2xl transform rotate-3 hover:rotate-0 transition-all">
                <x-icon name="list-check" style="duotone" class="w-8 h-8" />
            </div>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase leading-none">Minhas Ordens</h1>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-2 italic">Gerenciamento de Fluxo Operacional de Campo</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="px-5 py-3 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/30 rounded-2xl flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">{{ $ordens->total() }} Protocolos no Radar</span>
            </div>
        </div>
    </div>

    <!-- Filtros Táticos de Busca -->
    <div class="premium-card overflow-hidden">
        <form method="GET" action="{{ route('campo.ordens.index') }}" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                <div class="lg:col-span-6 relative group">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Rastreio de Protocolo</label>
                    <div class="relative">
                        <x-icon name="magnifying-glass" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors" />
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="BUSCAR POR NÚMERO OU DESCRIÇÃO..." class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white placeholder:text-slate-400 transition-all">
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Vetor de Status</label>
                    <select name="status" class="w-full py-4 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all cursor-pointer appearance-none">
                        <option value="">TODOS OS STATUS</option>
                        <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>PENDENTE (AGUARDANDO)</option>
                        <option value="em_execucao" {{ request('status') === 'em_execucao' ? 'selected' : '' }}>EM EXECUÇÃO (ATIVO)</option>
                        <option value="concluida" {{ request('status') === 'concluida' ? 'selected' : '' }}>CONCLUÍDA (FINALIZADA)</option>
                    </select>
                </div>

                <div class="lg:col-span-3 flex gap-3">
                    <button type="submit" class="flex-1 py-4 bg-emerald-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 active:scale-95 transition-all shadow-lg shadow-emerald-600/20">
                        Aplicar Filtros
                    </button>
                    <a href="{{ route('campo.ordens.index') }}" class="p-4 bg-gray-100 dark:bg-slate-800 text-slate-400 rounded-2xl hover:text-emerald-500 transition-all border border-transparent hover:border-emerald-500/20" title="Limpar Filtros">
                        <x-icon name="rotate-left" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Interface em Grade Operacional -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($ordens as $ordem)
        <div class="premium-card flex flex-col group hover:border-emerald-500/50 hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute -right-6 -top-6 opacity-[0.03] group-hover:opacity-[0.08] pointer-events-none group-hover:rotate-12 transition-all duration-700">
                <x-icon name="clipboard-check" class="w-40 h-40" />
            </div>

            <!-- Card Header -->
            <div class="p-8 border-b border-gray-50 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 rounded bg-emerald-500/10 dark:bg-emerald-500/20 flex items-center justify-center">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                    </div>
                    <span class="text-xs font-black text-gray-900 dark:text-white tracking-widest uppercase">O.S #{{ $ordem->numero }}</span>
                </div>

                @php
                    $s_colors = [
                        'pendente' => 'amber',
                        'em_execucao' => 'blue',
                        'concluida' => 'emerald',
                        'cancelada' => 'rose'
                    ];
                    $c = $s_colors[$ordem->status] ?? 'slate';
                @endphp
                <span class="px-3 py-1 bg-{{ $c }}-100 dark:bg-{{ $c }}-900/30 text-{{ $c }}-600 dark:text-{{ $c }}-400 rounded-full text-[8px] font-black uppercase tracking-[0.2em] border border-{{ $c }}-200 dark:border-{{ $c }}-800">
                    {{ strtoupper($ordem->status) }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="p-8 flex-1 space-y-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-[9px] font-black text-slate-400 uppercase tracking-widest italic">
                        <x-icon name="map-pin" class="w-3 h-3 text-emerald-500" />
                        {{ $ordem->demanda->localidade->nome ?? 'LOCALIDADE NÃO DEFINIDA' }}
                    </div>
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-3">{{ $ordem->descricao }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-50 dark:border-slate-800">
                    <div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Prioridade</p>
                        <p class="text-[10px] font-black text-gray-900 dark:text-white uppercase tracking-tighter flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-{{ $ordem->prioridade === 'alta' ? 'rose' : ($ordem->prioridade === 'baixa' ? 'emerald' : 'amber') }}-500"></span>
                            {{ $ordem->prioridade }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Data Emissão</p>
                        <p class="text-[10px] font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $ordem->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Actions -->
            <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between gap-4">
                <a href="{{ route('campo.ordens.show', $ordem->id) }}" class="flex-1 h-12 flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-emerald-600 dark:hover:text-emerald-400 transition-all border border-gray-100 dark:border-slate-700 shadow-sm active:scale-95">
                    <x-icon name="eye" class="w-4 h-4" />
                    Dossiê O.S
                </a>

                @if($ordem->status === 'pendente')
                <form method="POST" action="{{ route('campo.ordens.iniciar', $ordem->id) }}" class="flex-1" onsubmit="return confirm('ATENÇÃO: Deseja iniciar a execução desta ordem tática agora?')">
                    @csrf
                    <button type="submit" class="w-full h-12 flex items-center justify-center gap-2 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-95">
                        <x-icon name="circle-play" class="w-4 h-4" />
                        Ativar
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 flex flex-col items-center justify-center space-y-8 animate-fade-in">
            <div class="w-32 h-32 bg-slate-50 dark:bg-slate-900 rounded-[3rem] flex items-center justify-center text-slate-200 dark:text-slate-800 shadow-inner">
                <x-icon name="clipboard-question" style="duotone" class="w-16 h-16" />
            </div>
            <div class="text-center">
                <h3 class="text-xl font-black text-slate-400 uppercase tracking-widest italic">Nenhuma Operação Localizada</h3>
                <p class="text-sm text-slate-500 font-medium mt-2">Ajuste os filtros ou aguarde por novas atribuições da central.</p>
                <a href="{{ route('campo.ordens.index') }}" class="inline-block mt-8 text-[11px] font-black text-emerald-600 hover:text-emerald-700 uppercase tracking-[0.3em] decoration-2 underline-offset-8 underline">Resetar Sistema</a>
            </div>
        </div>
        @endforelse
    </div>

    @if($ordens->hasPages())
    <div class="mt-12 bg-white/50 dark:bg-slate-900/50 p-6 rounded-3xl border border-gray-100 dark:border-slate-800">
        {{ $ordens->links() }}
    </div>
    @endif
</div>
@endsection
