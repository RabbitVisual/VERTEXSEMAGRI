@extends('campo.layouts.app')

@section('title', 'Dashboard Operacional')

@section('content')

<style>[x-cloak] { display: none !important; }</style>

<div x-data="{
    status: 'online',
    filtrosOpen: false,
    exportOpen: false,
    currentTip: 0,
    tips: [
        'Priorize sempre a segurança: Verifique seus EPIs antes de qualquer intervenção.',
        'Sincronização Ativa: Seus dados são salvos localmente mesmo sem sinal de rede.',
        'Logística de Materiais: Solicite suprimentos com 24h de antecedência para evitar atrasos.',
        'Documentação Fotográfica: Registre o antes e o depois de cada O.S para auditoria.'
    ],
    init() {
        setInterval(() => {
            this.currentTip = (this.currentTip + 1) % this.tips.length;
        }, 8000);
    }
}" class="space-y-6 md:space-y-10 animate-fade-in pb-12">

    <!-- Header de Inteligência Operacional -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900 rounded-[2.5rem] shadow-2xl p-8 md:p-12 text-white">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 opacity-10 pointer-events-none">
            <x-icon name="wheat-awn" style="duotone" class="w-96 h-96" />
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-10">
            <div class="flex items-center gap-8">
                <div class="relative group">
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-white/10 rounded-[2rem] backdrop-blur-xl flex items-center justify-center shadow-inner border border-white/20 transform transition-transform group-hover:rotate-6">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover rounded-[2rem]">
                        @else
                            <span class="text-3xl font-black">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 border-4 border-slate-900 flex items-center justify-center animate-pulse"></div>
                </div>

                <div>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tighter uppercase leading-none mb-4">
                        Olá, <span class="text-emerald-400">{{ explode(' ', Auth::user()->name)[0] }}</span>
                    </h1>
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-xl border border-white/10 text-[10px] font-black uppercase tracking-widest text-emerald-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_theme(colors.emerald.500)]"></span>
                            Monitoramento Ativo
                        </div>
                        <div class="text-slate-400 text-xs font-medium italic">Unidade de Gestão de Campo SEMAGRI</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 bg-black/20 p-4 rounded-3xl backdrop-blur-sm border border-white/5">
                <div class="flex items-center gap-2 bg-slate-800/50 p-1 rounded-2xl border border-white/5">
                    <button @click="status = 'online'"
                            class="px-5 py-2.5 rounded-xl text-[10px] font-black tracking-widest transition-all uppercase"
                            :class="status === 'online' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-400 hover:text-white'">
                        Disponível
                    </button>
                    <button @click="status = 'busy'"
                            class="px-5 py-2.5 rounded-xl text-[10px] font-black tracking-widest transition-all uppercase"
                            :class="status === 'busy' ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' : 'text-slate-400 hover:text-white'">
                        Ocupado
                    </button>
                </div>

                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="h-12 px-6 flex items-center gap-3 bg-white/10 hover:bg-white/20 rounded-2xl border border-white/10 transition-all text-sm font-black uppercase tracking-widest shadow-xl active:scale-95 group">
                        <x-icon name="file-export" style="duotone" class="w-5 h-5 group-hover:-translate-y-1 transition-transform" />
                        <span>Dossiê</span>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-3 w-56 bg-slate-900 border border-white/10 rounded-2xl shadow-2xl z-50 overflow-hidden py-2 backdrop-blur-xl">
                        <a href="{{ route('campo.relatorios.pdf') }}" class="flex items-center gap-3 px-5 py-3 text-[10px] font-black text-slate-300 hover:bg-emerald-600 hover:text-white uppercase tracking-widest transition-colors">
                            <x-icon name="file-pdf" class="w-4 h-4" /> Relatório PDF
                        </a>
                        <a href="{{ route('campo.relatorios.excel') }}" class="flex items-center gap-3 px-5 py-3 text-[10px] font-black text-slate-300 hover:bg-emerald-600 hover:text-white uppercase tracking-widest transition-colors">
                            <x-icon name="file-excel" class="w-4 h-4" /> Base de Dados Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de Pendências -->
    @if($estatisticas['total_pendentes'] > 0)
    <div id="ordens-alerta" class="premium-card bg-gradient-to-r from-amber-500/5 to-orange-500/5 border-amber-500/30 p-8 flex flex-col md:flex-row items-center justify-between gap-8 group animate-scale-in">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-amber-500/20 transform group-hover:scale-110 transition-transform">
                <x-icon name="triangle-exclamation" style="duotone" class="w-8 h-8 animate-pulse" />
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Ordens Aguardando Início</h3>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1 max-w-sm">Você possui <span class="text-amber-600 font-black">{{ $estatisticas['total_pendentes'] }}</span> protocolos em espera na sua fila operacional.</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="h-14 px-8 flex items-center gap-3 bg-amber-500 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all shadow-xl shadow-amber-500/20 active:scale-95">
                Visualizar Fila
                <x-icon name="arrow-right" class="w-4 h-4" />
            </a>
            <button onclick="dismissOrdensAlerta()" class="p-4 text-slate-400 hover:text-amber-600 transition-colors">
                <x-icon name="xmark" class="w-6 h-6" />
            </button>
        </div>
    </div>
    @endif

    <!-- Métricas Rápidas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $dash_stats = [
                ['label' => 'FILA PENDENTE', 'value' => $estatisticas['total_pendentes'], 'icon' => 'clock-rotate-left', 'color' => 'amber', 'route' => 'pendente'],
                ['label' => 'EM EXECUÇÃO', 'value' => $estatisticas['total_em_execucao'], 'icon' => 'play', 'color' => 'blue', 'route' => 'em_execucao'],
                ['label' => 'FINALIZADAS HOJE', 'value' => $estatisticas['total_concluidas_hoje'], 'icon' => 'circle-check', 'color' => 'emerald', 'route' => 'concluida'],
                ['label' => 'PRODUTIVIDADE SEMANA', 'value' => $estatisticas['total_concluidas_semana'], 'icon' => 'chart-line', 'color' => 'indigo', 'route' => 'concluida'],
            ];
        @endphp
        @foreach($dash_stats as $stat)
        <a href="{{ route('campo.ordens.index', ['status' => $stat['route']]) }}" class="premium-card p-6 flex flex-col justify-between group hover:border-{{ $stat['color'] }}-500 transition-all duration-500 overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 pointer-events-none group-hover:scale-125 transition-transform duration-700">
                <x-icon name="{{ $stat['icon'] }}" class="w-24 h-24" />
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/20 flex items-center justify-center text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 group-hover:bg-{{ $stat['color'] }}-500 group-hover:text-white transition-all shadow-sm">
                    <x-icon name="{{ $stat['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest leading-none mb-2">{{ $stat['label'] }}</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stat['value'] }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Ordem em Execução Atual (Destaque) -->
            @if($estatisticas['ordem_em_execucao'])
            <div class="premium-card p-8 bg-gradient-to-br from-indigo-50/50 to-blue-50/50 dark:from-indigo-900/10 dark:to-blue-900/10 border-indigo-500/30">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-600/20 animate-pulse">
                            <x-icon name="play" class="w-8 h-8" />
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.2em] italic">Protocolo em Operação</span>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $estatisticas['ordem_em_execucao']->numero }}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $estatisticas['ordem_em_execucao']->descricao }}</p>
                        </div>
                    </div>
                    <a href="{{ route('campo.ordens.show', $estatisticas['ordem_em_execucao']->id) }}" class="h-14 px-10 flex items-center gap-3 bg-indigo-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95">
                        Continuar Execução
                        <x-icon name="arrow-right" class="w-4 h-4" />
                    </a>
                </div>
            </div>
            @endif

            <!-- Gráficos de Performance -->
            @if(isset($dadosGraficos))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="premium-card p-8">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                        <x-icon name="chart-area" style="duotone" class="w-5 text-emerald-500" />
                        Fluxo de Ordens (30d)
                    </h2>
                    <canvas id="graficoOrdensPorDia" height="240"></canvas>
                </div>
                <div class="premium-card p-8">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                        <x-icon name="chart-pie" style="duotone" class="w-5 text-indigo-500" />
                        Vetor de Prioridades
                    </h2>
                    <canvas id="graficoPrioridades" height="240"></canvas>
                </div>
            </div>
            @endif

            <!-- Lista de Pendências Táticas -->
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] flex items-center gap-3 italic">
                        <x-icon name="list-tree" style="duotone" class="w-5 text-amber-500" />
                        Fila de Operações Pendentes
                    </h2>
                    <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="text-[9px] font-black text-emerald-600 uppercase tracking-widest hover:underline">Ver Todos</a>
                </div>

                <div class="p-8">
                    @if($ordensPendentes->isEmpty())
                        <div class="py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-200">
                                <x-icon name="clipboard-check" style="duotone" class="w-10 h-10" />
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Nenhum protocolo pendente no radar.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($ordensPendentes as $ordem)
                            <div class="p-6 bg-white dark:bg-slate-950 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm hover:border-emerald-500/40 hover:-translate-y-1 transition-all group">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $ordem->numero }}</span>
                                    @php
                                        $p_colors = ['alta' => 'rose', 'media' => 'amber', 'baixa' => 'emerald'];
                                        $c = $p_colors[$ordem->prioridade] ?? 'slate';
                                    @endphp
                                    <span class="px-2 py-0.5 bg-{{ $c }}-100 dark:bg-{{ $c }}-900/30 text-{{ $c }}-600 dark:text-{{ $c }}-400 rounded text-[8px] font-black uppercase tracking-widest italic border border-{{ $c }}-200 dark:border-{{ $c }}-800">
                                        {{ $ordem->prioridade }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium line-clamp-2 mb-6">{{ $ordem->descricao }}</p>
                                <a href="{{ route('campo.ordens.show', $ordem->id) }}" class="w-full py-4 bg-gray-50 dark:bg-slate-900/50 hover:bg-emerald-600 hover:text-white rounded-2xl text-[9px] font-black uppercase tracking-widest text-slate-400 text-center transition-all border border-gray-100 dark:border-slate-800 group-hover:border-emerald-500">
                                    Visualizar Protocolo
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Avisos e Localidades -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Avisos -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-800 bg-blue-50/20 dark:bg-blue-900/10">
                        <h2 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] flex items-center gap-3 italic">
                            <x-icon name="bullhorn" style="duotone" class="w-5" />
                            Boletim Informativo
                        </h2>
                    </div>
                    <div class="p-8 space-y-6">
                        @forelse($avisosRecentes as $aviso)
                        <div class="p-5 bg-white dark:bg-slate-950 rounded-2xl border border-blue-100 dark:border-blue-900/30">
                            <h4 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight mb-2">{{ $aviso->titulo ?? $aviso->nome }}</h4>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">{{ $aviso->descricao ?? $aviso->conteudo }}</p>
                        </div>
                        @empty
                        <p class="text-center text-[10px] font-black text-slate-400 uppercase italic">Sem novos boletins.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Localidades -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-800 bg-emerald-50/20 dark:bg-emerald-900/10">
                        <h2 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] flex items-center gap-3 italic">
                            <x-icon name="map-location-dot" style="duotone" class="w-5" />
                            Giro de Localidades
                        </h2>
                    </div>
                    <div class="p-8 space-y-4">
                        @foreach($localidadesFrequentes as $item)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800 group hover:border-emerald-500 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 font-black text-xs">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-900 dark:text-white uppercase tracking-wide truncate max-w-[120px]">{{ $item['localidade']->nome }}</p>
                                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest italic">{{ $item['localidade']->tipo ?? 'Geral' }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-emerald-500 text-white rounded text-[8px] font-black uppercase tracking-widest">{{ $item['total'] }} O.S</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Widget de Clima -->
            <div id="widget-clima-dashboard" class="premium-card p-8 bg-gradient-to-br from-blue-600 to-indigo-700 text-white text-center relative overflow-hidden">
                <div class="animate-pulse">
                    <div class="h-12 w-12 bg-white/20 rounded-xl mx-auto mb-4"></div>
                    <div class="h-4 w-24 bg-white/20 rounded-full mx-auto"></div>
                </div>
            </div>

            <!-- Status do Agente -->
            <div class="premium-card p-8">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                    <x-icon name="shield-user" style="duotone" class="w-5 h-5 text-emerald-500" />
                    Situação Individual
                </h3>
                @php
                    $s_campo = $statusFuncionario['status_campo'] ?? 'disponivel';
                    $s_style = [
                        'disponivel' => ['color' => 'emerald', 'label' => 'OPERACIONAL'],
                        'em_atendimento' => ['color' => 'blue', 'label' => 'EM OPERAÇÃO'],
                        'pausado' => ['color' => 'amber', 'label' => 'FILA DE PAUSA'],
                    ][$s_campo] ?? ['color' => 'slate', 'label' => 'OFFLINE'];
                @endphp
                <div class="p-6 bg-{{ $s_style['color'] }}-50/50 dark:bg-{{ $s_style['color'] }}-900/10 rounded-[2rem] border border-{{ $s_style['color'] }}-100 dark:border-{{ $s_style['color'] }}-900/20 text-center">
                    <div class="w-16 h-16 bg-{{ $s_style['color'] }}-500 rounded-full flex items-center justify-center text-white mx-auto mb-4 shadow-xl shadow-{{ $s_style['color'] }}-500/20">
                        <x-icon name="user-check" class="w-8 h-8" />
                    </div>
                    <h4 class="text-xl font-black text-{{ $s_style['color'] }}-600 uppercase tracking-tighter">{{ $s_style['label'] }}</h4>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2">Agente ID: #{{ Auth::id() }}</p>
                </div>
            </div>

            <!-- Métricas do Ciclo -->
            <div class="premium-card p-8 space-y-6">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 flex items-center gap-3 italic">
                    <x-icon name="microchip" style="duotone" class="w-5 h-5 text-indigo-500" />
                    Ciclo Mensal
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-5 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Mês</p>
                        <p class="text-xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $estatisticasAvancadas['total_mes'] ?? 0 }}</p>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">T. Médio</p>
                        <p class="text-xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $estatisticasAvancadas['tempo_medio_execucao'] ?? 0 }}h</p>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="premium-card p-8">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                    <x-icon name="bolt-lightning" style="duotone" class="w-5 h-5 text-amber-500" />
                    Intervenção Rápida
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex flex-col items-center justify-center p-4 bg-slate-100 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-emerald-600 hover:text-white transition-all group active:scale-95">
                        <x-icon name="qrcode" class="w-6 h-6 mb-2" />
                        <span class="text-[8px] font-black uppercase tracking-widest">Ler QR O.S</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 bg-slate-100 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-rose-600 hover:text-white transition-all group active:scale-95">
                        <x-icon name="shield-virus" class="w-6 h-6 mb-2" />
                        <span class="text-[8px] font-black uppercase tracking-widest">Incidente</span>
                    </button>
                    <a href="{{ route('campo.materiais.solicitacoes.index') }}" class="flex flex-col items-center justify-center p-4 bg-slate-100 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-amber-600 hover:text-white transition-all group active:scale-95">
                        <x-icon name="box-open" class="w-6 h-6 mb-2" />
                        <span class="text-[8px] font-black uppercase tracking-widest">Materiais</span>
                    </a>
                    <a href="{{ route('campo.chat.page') }}" class="flex flex-col items-center justify-center p-4 bg-slate-100 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-blue-600 hover:text-white transition-all group active:scale-95">
                        <x-icon name="comments" class="w-6 h-6 mb-2" />
                        <span class="text-[8px] font-black uppercase tracking-widest">Chat Central</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function dismissOrdensAlerta() {
        const alerta = document.getElementById('ordens-alerta');
        if (alerta) {
            alerta.classList.add('opacity-0', '-translate-y-4');
            setTimeout(() => alerta.remove(), 300);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($dadosGraficos))
        // Gráfico de Ordens
        const ctxOrdens = document.getElementById('graficoOrdensPorDia').getContext('2d');
        new Chart(ctxOrdens, {
            type: 'line',
            data: {
                labels: @json($dadosGraficos['labels'] ?? []),
                datasets: [{
                    label: 'Concluídas',
                    data: @json($dadosGraficos['concluidas'] ?? []),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 9, weight: 'bold' } } },
                    x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' } } }
                }
            }
        });

        // Gráfico de Prioridades
        const ctxPrio = document.getElementById('graficoPrioridades').getContext('2d');
        new Chart(ctxPrio, {
            type: 'doughnut',
            data: {
                labels: ['Alta', 'Média', 'Baixa'],
                datasets: [{
                    data: [
                        {{ $dadosGraficos['prioridades']['alta'] ?? 0 }},
                        {{ $dadosGraficos['prioridades']['media'] ?? 0 }},
                        {{ $dadosGraficos['prioridades']['baixa'] ?? 0 }}
                    ],
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 9, weight: 'bold' },
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                },
                cutout: '75%'
            }
        });
        @endif

        // Simulação do Clima (Integrar com API real se disponível)
        const climaContainer = document.getElementById('widget-clima-dashboard');
        if (climaContainer) {
            setTimeout(() => {
                climaContainer.innerHTML = `
                    <div class="flex items-center justify-center gap-6">
                        <x-icon name="sun-cloud" style="duotone" class="w-16 h-16" />
                        <div class="text-left">
                            <p class="text-4xl font-black">28°C</p>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Céu Limpo • Ariquemes</p>
                        </div>
                    </div>
                `;
                climaContainer.classList.remove('animate-pulse');
            }, 1000);
        }
    });
</script>
@endpush
@endsection
