@extends('campo.layouts.app')

@section('title', 'Dashboard Campo')

@section('content')

<style>[x-cloak] { display: none !important; }</style>

<div x-data="{
    status: 'online',
    filtrosOpen: false,
    exportOpen: false,
    currentTip: 0,
    tips: [
        'Use EPIs sempre que manusear produtos químicos.',
        'Verifique a pressão da água antes de iniciar os reparos.',
        'Mantenha as ferramentas limpas para maior durabilidade.',
        'Reporte qualquer incidente de segurança imediatamente.'
    ],
    init() {
        setInterval(() => {
            this.currentTip = (this.currentTip + 1) % this.tips.length;
        }, 8000);
    }
}" class="space-y-6 md:space-y-8">
    <!-- Hero Section & Status -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600 dark:from-indigo-400 dark:to-violet-400">
                    Olá, {{ Auth::user()->name }}
                </span>
            </h1>
            <p class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                Painel Operacional Ativo
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <!-- Status Toggle (Pill Switch) -->
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-1.5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <span class="text-xs font-bold text-gray-500 dark:text-gray-400 pl-2 uppercase tracking-wide">Status:</span>
                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                    <button @click="status = 'online'"
                            class="px-3 py-1.5 rounded-md text-xs font-bold transition-all duration-200"
                            :class="status === 'online' ? 'bg-white dark:bg-gray-600 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'">
                        DISPONÍVEL
                    </button>
                    <button @click="status = 'busy'"
                            class="px-3 py-1.5 rounded-md text-xs font-bold transition-all duration-200"
                            :class="status === 'busy' ? 'bg-white dark:bg-gray-600 text-red-600 dark:text-red-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'">
                        OCUPADO
                    </button>
                </div>
            </div>

            <!-- Exportar -->
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-300 font-medium transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Exportar</span>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 origin-top-right"
                     style="display: none;">
                    <a href="{{ route('campo.relatorios.pdf') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-t-xl">Exportar PDF</a>
                    <a href="{{ route('campo.relatorios.excel') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-b-xl">Exportar Excel</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Avançados -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                <span>Filtros Avançados</span>
            </h2>
            <button @click="filtrosOpen = !filtrosOpen" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                <span x-text="filtrosOpen ? 'Ocultar' : 'Mostrar'"></span>
            </button>
        </div>
        <div x-show="filtrosOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             id="filtros-container" class="p-6">
            <form id="filtros-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Período</label>
                    <select name="periodo" id="filtro-periodo" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Selecione...</option>
                        <option value="hoje">Hoje</option>
                        <option value="semana">Esta Semana</option>
                        <option value="mes">Este Mês</option>
                        <option value="ultimos_30">Últimos 30 dias</option>
                        <option value="ultimos_90">Últimos 90 dias</option>
                        <option value="custom">Personalizado</option>
                    </select>
                </div>
                <div id="filtro-data-inicio-container" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Início</label>
                    <input type="date" name="data_inicio" id="filtro-data-inicio" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div id="filtro-data-fim-container" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Fim</label>
                    <input type="date" name="data_fim" id="filtro-data-fim" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" id="filtro-status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Todos</option>
                        <option value="pendente">Pendente</option>
                        <option value="em_execucao">Em Execução</option>
                        <option value="concluida">Concluída</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prioridade</label>
                    <select name="prioridade" id="filtro-prioridade" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Todas</option>
                        <option value="alta">Alta</option>
                        <option value="media">Média</option>
                        <option value="baixa">Baixa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localidade</label>
                    <select name="localidade_id" id="filtro-localidade" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Todas</option>
                    </select>
                </div>
                <div class="md:col-span-2 lg:col-span-4 flex gap-3">
                    <button type="button" onclick="aplicarFiltros()" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition-colors">
                        Aplicar Filtros
                    </button>
                    <button type="button" onclick="limparFiltros()" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold transition-colors">
                        Limpar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sistema de Alerta para Ordens Abertas - HyperUI Style -->
    @if($estatisticas['total_pendentes'] > 0)
        <div id="ordens-alerta" class="bg-white dark:bg-gray-800 lg:grid lg:place-content-center rounded-2xl shadow-xl border-2 border-amber-200 dark:border-amber-800 overflow-hidden">
            <div class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 sm:py-12 md:grid md:grid-cols-2 md:items-center md:gap-6 lg:px-8 lg:py-16">
                <!-- Conteúdo do Alerta -->
                <div class="max-w-prose text-left mb-6 md:mb-0">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                            Você tem
                            <strong class="text-amber-600 dark:text-amber-400">{{ $estatisticas['total_pendentes'] }}</strong>
                            {{ $estatisticas['total_pendentes'] == 1 ? 'ordem pendente' : 'ordens pendentes' }}
                        </h2>
                    </div>

                    <p class="mt-4 text-base sm:text-lg text-pretty text-gray-700 dark:text-gray-300 leading-relaxed">
                        Existem <strong class="font-semibold text-gray-900 dark:text-white">{{ $estatisticas['total_pendentes'] }}</strong>
                        {{ $estatisticas['total_pendentes'] == 1 ? 'ordem de serviço aguardando' : 'ordens de serviço aguardando' }} sua atenção.
                        Revise e inicie a execução para manter o fluxo de trabalho atualizado.
                    </p>

                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-amber-600 bg-amber-600 px-5 py-3 font-semibold text-white shadow-sm transition-all duration-300 hover:bg-amber-700 hover:shadow-md hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                            <span>Ver Ordens Pendentes</span>
                        </a>

                        <button onclick="dismissOrdensAlerta()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-3 font-semibold text-gray-700 dark:text-gray-300 shadow-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Fechar</span>
                        </button>
                    </div>
                </div>

                <!-- Ilustração SVG -->
                <div class="hidden md:block mx-auto max-w-md text-gray-900 dark:text-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 768" class="w-full h-auto">
                        <g fill="none" fill-rule="evenodd">
                            <g fill="currentColor" opacity="0.1">
                                <path d="M512 384c0 141.385-114.615 256-256 256S0 525.385 0 384 114.615 128 256 128s256 114.615 256 256z"/>
                                <path d="M1024 384c0 141.385-114.615 256-256 256S512 525.385 512 384 626.615 128 768 128s256 114.615 256 256z"/>
                            </g>
                            <g fill="#f59e0b" opacity="0.8">
                                <path d="M400 300c-46.392 0-84 37.608-84 84s37.608 84 84 84 84-37.608 84-84-37.608-84-84-84zm0 24c33.137 0 60 26.863 60 60s-26.863 60-60 60-60-26.863-60-60 26.863-60 60-60z"/>
                                <path d="M624 300c-46.392 0-84 37.608-84 84s37.608 84 84 84 84-37.608 84-84-37.608-84-84-84zm0 24c33.137 0 60 26.863 60 60s-26.863 60-60 60-60-26.863-60-60 26.863-60 60-60z"/>
                                <path d="M512 200c-46.392 0-84 37.608-84 84s37.608 84 84 84 84-37.608 84-84-37.608-84-84-84zm0 24c33.137 0 60 26.863 60 60s-26.863 60-60 60-60-26.863-60-60 26.863-60 60-60z"/>
                            </g>
                            <g fill="none" stroke="currentColor" stroke-width="2" opacity="0.3">
                                <path d="M256 384h512M512 128v512"/>
                            </g>
                            <g fill="#f59e0b">
                                <path d="M450 450h124v24H450v-24zm0-48h124v24H450v-24zm0-48h124v24H450v-24z"/>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    @endif


    <!-- Widgets: Produtividade & Dicas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Produtividade Semanal -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                    Produtividade Semanal
                </h3>
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">Objetivo: 20 Ordens</span>
            </div>

            <div class="space-y-4">
                <div class="flex items-end justify-between">
                    <div>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['concluidas_semana'] ?? 0 }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">/ 20 concluídas</span>
                    </div>
                    <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                        {{ min(100, round((($estatisticas['concluidas_semana'] ?? 0) / 20) * 100)) }}%
                    </span>
                </div>

                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ min(100, round((($estatisticas['concluidas_semana'] ?? 0) / 20) * 100)) }}%"></div>
                </div>

                <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                    Mantenha o ritmo! Você está indo bem esta semana.
                </p>
            </div>
        </div>

        <!-- Dicas do Dia Widget (Alpine.js) -->
        <div class="bg-gradient-to-br from-indigo-50/90 to-violet-50/90 dark:from-indigo-900/30 dark:to-violet-900/30 backdrop-blur-xl rounded-2xl shadow-lg border border-indigo-200/50 dark:border-indigo-800/50 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10 text-indigo-900 dark:text-indigo-100">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
            </div>

            <div class="relative z-10 h-full flex flex-col justify-between">
                <h3 class="text-base font-bold text-indigo-900 dark:text-indigo-100 flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                    </svg>
                    Dica do Dia
                </h3>

                <div class="text-lg md:text-xl font-medium text-indigo-800 dark:text-indigo-200 min-h-[5rem] flex items-center" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <p x-text="tips[currentTip]"></p>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <div class="flex gap-1.5">
                        <template x-for="(tip, index) in tips" :key="index">
                            <button @click="currentTip = index"
                                    class="w-2 h-2 rounded-full transition-all duration-300"
                                    :class="currentTip === index ? 'bg-indigo-600 dark:bg-indigo-400 w-4' : 'bg-indigo-300 dark:bg-indigo-700'">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Estatísticas - HyperUI Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Pendentes -->
        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-md border border-gray-200/50 dark:border-gray-700/50 p-5 md:p-6 hover:shadow-xl hover:border-amber-300 dark:hover:border-amber-600 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Pendentes</p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white" data-pendentes-count>{{ $estatisticas['total_pendentes'] }}</p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="inline-flex items-center gap-2 text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                <span>Ver pendentes</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        <!-- Em Execução -->
        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-md border border-gray-200/50 dark:border-gray-700/50 p-5 md:p-6 hover:shadow-xl hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Em Execução</p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total_em_execucao'] }}</p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('campo.ordens.index', ['status' => 'em_execucao']) }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                <span>Ver em execução</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        <!-- Concluídas Hoje -->
        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-md border border-gray-200/50 dark:border-gray-700/50 p-5 md:p-6 hover:shadow-xl hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Concluídas Hoje</p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total_concluidas_hoje'] }}</p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                Concluídas nesta semana: <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $estatisticas['total_concluidas_semana'] }}</span>
            </p>
        </div>

        <!-- Total Semana -->
        <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-md border border-gray-200/50 dark:border-gray-700/50 p-5 md:p-6 hover:shadow-xl hover:border-violet-300 dark:hover:border-violet-600 transition-all duration-300 hover:-translate-y-1 active:scale-95">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Semana</p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total_concluidas_semana'] }}</p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                Concluídas nesta semana
            </p>
        </div>
    </div>

    <!-- Gráficos Interativos -->
    @if(isset($dadosGraficos))
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <!-- Gráfico de Ordens por Dia -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Ordens por Dia (Últimos 30 dias)</h2>
                </div>
                <div class="p-6">
                    <canvas id="graficoOrdensPorDia" height="300"></canvas>
                </div>
            </div>

            <!-- Gráfico de Prioridades -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Distribuição por Prioridade</h2>
                </div>
                <div class="p-6">
                    <canvas id="graficoPrioridades" height="300"></canvas>
                </div>
            </div>
        </div>
    @endif

    <!-- Ordem em Execução Atual -->
    @if($estatisticas['ordem_em_execucao'])
        <div class="bg-gradient-to-br from-blue-50/90 to-cyan-50/90 dark:from-blue-900/30 dark:to-cyan-900/30 backdrop-blur-md border-2 border-blue-200/50 dark:border-blue-800/50 rounded-2xl p-6 md:p-8 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-blue-900 dark:text-blue-100">Ordem em Execução</h3>
                    </div>
                    <div class="space-y-2">
                        <p class="text-lg font-bold text-blue-800 dark:text-blue-200">{{ $estatisticas['ordem_em_execucao']->numero }}</p>
                        @if($estatisticas['ordem_em_execucao']->demanda && $estatisticas['ordem_em_execucao']->demanda->localidade)
                            <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $estatisticas['ordem_em_execucao']->demanda->localidade->nome }}
                            </p>
                        @endif
                        <p class="text-sm text-blue-600 dark:text-blue-400 mt-2 line-clamp-2">{{ $estatisticas['ordem_em_execucao']->descricao }}</p>
                    </div>
                </div>
                <a href="{{ route('campo.ordens.show', $estatisticas['ordem_em_execucao']->id) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 whitespace-nowrap">
                    <span>Continuar</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    @endif

    <!-- Ordens Pendentes - HyperUI Card -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
        <div class="px-5 md:px-6 lg:px-8 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900/50 dark:to-gray-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span>Ordens Pendentes</span>
            </h2>
            <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                <span>Ver todas</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
        <div class="p-6 md:p-8">
            @if($ordensPendentes->isEmpty())
                <div class="text-center py-12 md:py-16">
                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Nenhuma ordem pendente</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Não há ordens pendentes no momento.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    @foreach($ordensPendentes as $ordem)
                        <div class="group bg-gradient-to-br from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl p-5 md:p-6 hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-600 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $ordem->numero }}</h3>
                                        @php
                                            $prioridadeClasses = [
                                                'alta' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border-red-200 dark:border-red-800',
                                                'media' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border-amber-200 dark:border-amber-800',
                                                'baixa' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
                                            ];
                                            $badgeClass = $prioridadeClasses[$ordem->prioridade] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300 border-gray-200 dark:border-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                            {{ ucfirst($ordem->prioridade) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ $ordem->descricao }}</p>
                                    @if($ordem->demanda && $ordem->demanda->localidade)
                                        <p class="text-xs text-gray-500 dark:text-gray-500 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            </svg>
                                            <span class="truncate">{{ $ordem->demanda->localidade->nome }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('campo.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg text-sm">
                                <span>Ver Detalhes</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Grid de Conteúdo Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        <!-- Coluna Esquerda - Conteúdo Principal -->
        <div class="lg:col-span-2 space-y-6 md:space-y-8">
            <!-- Avisos Recentes -->
            @if(isset($avisosRecentes) && $avisosRecentes->count() > 0)
                <div class="bg-gradient-to-br from-blue-50/90 to-indigo-50/90 dark:from-blue-900/30 dark:to-indigo-900/30 backdrop-blur-md border-2 border-blue-200/50 dark:border-blue-800/50 rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 md:px-8 md:py-5 border-b border-blue-200 dark:border-blue-800 bg-white/50 dark:bg-gray-800/50">
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.348-1.352c-.252-.416-.55-.819-.888-1.2a5.5 5.5 0 00-1.137-1.086l-.707-.707a1.5 1.5 0 00-1.06-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44l-1.086-1.086A1.5 1.5 0 0011.035 3H8.5a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                            <span>Avisos e Informações</span>
                        </h2>
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="space-y-4">
                            @foreach($avisosRecentes as $aviso)
                                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-blue-200 dark:border-blue-800 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">{{ $aviso->titulo ?? $aviso->nome ?? 'Aviso' }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $aviso->descricao ?? $aviso->conteudo ?? '' }}</p>
                                            @if(isset($aviso->data_fim))
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                                    Válido até: {{ \Carbon\Carbon::parse($aviso->data_fim)->format('d/m/Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Localidades Mais Visitadas -->
            @if(isset($localidadesFrequentes) && $localidadesFrequentes->count() > 0)
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="px-6 py-4 md:px-8 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                            <span>Localidades Mais Visitadas</span>
                        </h2>
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="space-y-3">
                            @foreach($localidadesFrequentes as $item)
                                @if($item['localidade'])
                                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-3 flex-1 min-w-0">
                                            <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                                                <span class="text-emerald-600 dark:text-emerald-400 font-bold text-lg">{{ $loop->iteration }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ $item['localidade']->nome }}</h3>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                    {{ $item['localidade']->tipo ?? 'Localidade' }}
                                                    @if($item['localidade']->cidade)
                                                        • {{ $item['localidade']->cidade }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                {{ $item['total'] }} {{ $item['total'] == 1 ? 'ordem' : 'ordens' }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Timeline de Atividades Recentes -->
            @if(isset($atividadesRecentes) && $atividadesRecentes->count() > 0)
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="px-6 py-4 md:px-8 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span>Atividades Recentes</span>
                        </h2>
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="relative">
                            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                            <div class="space-y-6">
                                @foreach($atividadesRecentes as $atividade)
                                    <div class="relative flex items-start gap-4">
                                        <div class="flex-shrink-0 relative z-10">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700
                                                @if($atividade['cor'] === 'blue') border-blue-500 dark:border-blue-600
                                                @elseif($atividade['cor'] === 'green') border-emerald-500 dark:border-emerald-600
                                                @else border-gray-400 dark:border-gray-600
                                                @endif">
                                                @if($atividade['icone'] === 'play')
                                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0 pt-1">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $atividade['titulo'] }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-1">{{ $atividade['descricao'] }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                                {{ \Carbon\Carbon::parse($atividade['data'])->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Coluna Direita - Sidebar com Métricas -->
        <div class="space-y-6 md:space-y-8">
            <!-- Widget de Clima -->
            <div class="bg-gradient-to-br from-blue-50/90 to-cyan-50/90 dark:from-blue-900/30 dark:to-cyan-900/30 backdrop-blur-md rounded-2xl shadow-lg border border-blue-200/50 dark:border-blue-800/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-blue-200 dark:border-blue-800 bg-white/50 dark:bg-gray-800/50">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H9a3 3 0 003-3V9a3 3 0 00-3-3H6.75a4.5 4.5 0 00-4.5 4.5v6zM2.25 19h19.5M2.25 19l1.5-7.5M21.75 19l-1.5-7.5" />
                        </svg>
                        <span>Clima</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div id="widget-clima-dashboard" class="text-center">
                        <div class="animate-pulse space-y-3">
                            <div class="h-16 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mx-auto"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget de Chat -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-between">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                        <span>Chat</span>
                        <span id="chat-unread-badge" class="hidden ml-2 px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">0</span>
                    </h2>
                    <button onclick="toggleChatWidget()" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                        <span id="chat-toggle-text">Abrir</span>
                    </button>
                </div>
                <div id="chat-widget-container" class="hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <a href="{{ route('campo.chat.page') }}" class="block w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition-colors text-center">
                            Nova Conversa
                        </a>
                    </div>
                    <div id="chat-conversas" class="max-h-96 overflow-y-auto p-4 space-y-2">
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400 py-8">
                            Carregando conversas...
                        </div>
                    </div>
                </div>
            </div>
            <!-- Status do Funcionário -->
            @if(isset($statusFuncionario))
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <span>Meu Status</span>
                        </h2>
                    </div>
                    <div class="p-6">
                        @php
                            $statusClasses = [
                                'disponivel' => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-300', 'icon' => 'check-circle'],
                                'em_atendimento' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-300', 'icon' => 'play-circle'],
                                'pausado' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-300', 'icon' => 'pause-circle'],
                                'offline' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-700 dark:text-gray-300', 'icon' => 'x-circle'],
                            ];
                            $status = $statusClasses[$statusFuncionario['status_campo'] ?? 'disponivel'] ?? $statusClasses['disponivel'];
                        @endphp
                        <div class="flex items-center gap-3 p-4 rounded-xl {{ $status['bg'] }} border border-current/20">
                            <svg class="w-8 h-8 {{ $status['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                @if($status['icon'] === 'check-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($status['icon'] === 'play-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l6 6m0-6l-6 6" />
                                @elseif($status['icon'] === 'pause-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 9h.01M15 15h.01" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @endif
                            </svg>
                            <div>
                                <p class="font-semibold {{ $status['text'] }} capitalize">
                                    {{ str_replace('_', ' ', $statusFuncionario['status_campo'] ?? 'disponivel') }}
                                </p>
                                @if($statusFuncionario['atendimento_iniciado'])
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        Desde: {{ \Carbon\Carbon::parse($statusFuncionario['atendimento_iniciado'])->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Métricas do Mês -->
            @if(isset($estatisticasAvancadas))
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white">Métricas do Mês</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 rounded-xl border border-violet-200 dark:border-violet-800">
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Total Concluídas</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticasAvancadas['total_mes'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-violet-100 dark:bg-violet-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                        </div>

                        @if(isset($estatisticasAvancadas['tempo_medio_execucao']) && $estatisticasAvancadas['tempo_medio_execucao'] > 0)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Tempo Médio</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $estatisticasAvancadas['tempo_medio_execucao'] }}h</p>
                                </div>
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Ações Rápidas -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">Ações Rápidas</h2>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Scan QR Code -->
                    <button type="button" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-200 dark:hover:border-indigo-800 transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/50 transition-colors">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75zM16.5 19.5h.75v.75h-.75v-.75z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">Ler QR Code</span>
                    </button>

                    <!-- Reportar Incidente -->
                    <button type="button" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 dark:hover:border-red-800 transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400">Reportar Incidente</span>
                    </button>

                    <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="flex items-center gap-3 p-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Ver Pendentes</span>
                    </a>

                    <a href="{{ route('campo.materiais.solicitacoes.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 8.25v6.75m0 0l-3-3m3 3l3-3M3.375 19.5h18.75c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Solicitar Material</span>
                    </a>

                    <a href="{{ route('campo.profile.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Meu Perfil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Função para fechar o alerta de ordens pendentes
    function dismissOrdensAlerta() {
        const alerta = document.getElementById('ordens-alerta');
        if (alerta) {
            // Salvar no localStorage que o usuário fechou o alerta
            const hoje = new Date().toDateString();
            localStorage.setItem('ordens-alerta-dismissed', hoje);

            // Animação de fade out
            alerta.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            alerta.style.opacity = '0';
            alerta.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                alerta.remove();
            }, 300);
        }
    }

    // Verificar se o alerta foi fechado hoje
    document.addEventListener('DOMContentLoaded', function() {
        const alerta = document.getElementById('ordens-alerta');
        if (alerta) {
            const hoje = new Date().toDateString();
            const dismissed = localStorage.getItem('ordens-alerta-dismissed');

            // Se foi fechado hoje, não mostrar
            if (dismissed === hoje) {
                alerta.remove();
            } else {
                // Limpar dismiss antigo se for de outro dia
                if (dismissed && dismissed !== hoje) {
                    localStorage.removeItem('ordens-alerta-dismissed');
                }

                // Animação de entrada
                alerta.style.opacity = '0';
                alerta.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alerta.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alerta.style.opacity = '1';
                    alerta.style.transform = 'translateY(0)';
                }, 100);
            }
        }
    });

    // Atualizar alerta quando houver mudanças offline
    if (window.campoOffline) {
        // Verificar ordens pendentes do cache offline periodicamente
        async function verificarOrdensOffline() {
            try {
                const ordens = await window.campoOffline.getAllOrdens();
                const pendentes = ordens.filter(o => o.status === 'pendente');
                const alerta = document.getElementById('ordens-alerta');

                // Se houver pendentes offline e não houver alerta, atualizar contador
                if (pendentes.length > 0) {
                    if (typeof logger !== 'undefined') {
                        logger.log('[Campo Alerta] Ordens pendentes detectadas offline:', pendentes.length);
                    }

                    // Atualizar contador se existir
                    const contador = document.querySelector('[data-pendentes-count]');
                    if (contador) {
                        contador.textContent = pendentes.length;
                    }
                }
            } catch (err) {
                if (typeof logger !== 'undefined') {
                    logger.warn('[Campo Alerta] Erro ao verificar ordens offline:', err);
                }
            }
        }

        // Verificar a cada 30 segundos quando offline
        if (!navigator.onLine) {
            verificarOrdensOffline();
            setInterval(verificarOrdensOffline, 30000);
        }
    }

    // ============================================
    // FUNCIONALIDADES AVANÇADAS
    // ============================================

    // Toggle Export & Filtros
    // (Funcionalidade movida para Alpine.js)

    // Carregar localidades para filtro
    async function carregarLocalidades() {
        try {
            const response = await fetch('{{ route("campo.dashboard.filtros") }}');
            const data = await response.json();

            if (data.success && data.localidades) {
                const select = document.getElementById('filtro-localidade');
                data.localidades.forEach(localidade => {
                    const option = document.createElement('option');
                    option.value = localidade.id;
                    option.textContent = `${localidade.nome} (${localidade.tipo})`;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Erro ao carregar localidades:', error);
        }
    }

    // Aplicar Filtros
    function aplicarFiltros() {
        const form = document.getElementById('filtros-form');
        const formData = new FormData(form);
        const params = new URLSearchParams();

        for (const [key, value] of formData.entries()) {
            if (value && key !== 'periodo') params.append(key, value);
        }

        // Processar período
        const periodo = formData.get('periodo');
        if (periodo && periodo !== 'custom') {
            fetch('{{ route("campo.dashboard.filtros") }}')
                .then(r => r.json())
                .then(data => {
                    if (data.periodos && data.periodos[periodo]) {
                        params.set('data_inicio', data.periodos[periodo].inicio);
                        params.set('data_fim', data.periodos[periodo].fim);
                        window.location.href = '{{ route("campo.ordens.index") }}?' + params.toString();
                    }
                });
        } else if (periodo === 'custom') {
            window.location.href = '{{ route("campo.ordens.index") }}?' + params.toString();
        } else {
            window.location.href = '{{ route("campo.ordens.index") }}?' + params.toString();
        }
    }

    // Limpar Filtros
    function limparFiltros() {
        document.getElementById('filtros-form').reset();
        window.location.href = '{{ route("campo.ordens.index") }}';
    }

    // Mostrar campos de data customizada
    document.addEventListener('DOMContentLoaded', function() {
        const periodoSelect = document.getElementById('filtro-periodo');
        if (periodoSelect) {
            periodoSelect.addEventListener('change', function() {
                const custom = this.value === 'custom';
                document.getElementById('filtro-data-inicio-container').classList.toggle('hidden', !custom);
                document.getElementById('filtro-data-fim-container').classList.toggle('hidden', !custom);
            });
        }
    });

    // ============================================
    // GRÁFICOS COM CHART.JS (Local via Vite)
    // Chart.js já está disponível via resources/js/chart-admin.js importado no app.js
    // chart-admin.js disponibiliza Chart globalmente como window.Chart
    // ============================================
    @if(isset($dadosGraficos))
    // Aguardar Chart.js estar disponível (carregado via app.js -> chart-admin.js)
    function inicializarGraficos() {
        // Verificar se Chart está disponível (disponibilizado globalmente em chart-admin.js)
        if (typeof window.Chart === 'undefined' && typeof Chart === 'undefined') {
            console.warn('Chart.js não está disponível. Aguardando...');
            setTimeout(inicializarGraficos, 100);
            return;
        }

        // Usar Chart disponível globalmente (window.Chart do chart-admin.js)
        const ChartClass = window.Chart || Chart;

        // Gráfico de Ordens por Dia
        const ctxOrdens = document.getElementById('graficoOrdensPorDia');
        if (ctxOrdens && ChartClass) {
            const dados = @json($dadosGraficos['ordens_por_dia'] ?? []);
            new ChartClass(ctxOrdens, {
                type: 'line',
                data: {
                    labels: dados.map(d => d.label),
                    datasets: [
                        {
                            label: 'Pendentes',
                            data: dados.map(d => d.pendente),
                            borderColor: 'rgb(245, 158, 11)',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Em Execução',
                            data: dados.map(d => d.em_execucao),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Concluídas',
                            data: dados.map(d => d.concluida),
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Gráfico de Prioridades
        const ctxPrioridades = document.getElementById('graficoPrioridades');
        if (ctxPrioridades && ChartClass) {
            const dados = @json($dadosGraficos['ordens_por_prioridade'] ?? []);
            new ChartClass(ctxPrioridades, {
                type: 'doughnut',
                data: {
                    labels: ['Alta', 'Média', 'Baixa'],
                    datasets: [{
                        data: [
                            dados.alta || 0,
                            dados.media || 0,
                            dados.baixa || 0
                        ],
                        backgroundColor: [
                            'rgb(239, 68, 68)',
                            'rgb(245, 158, 11)',
                            'rgb(16, 185, 129)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    }

    // Inicializar gráficos quando DOM estiver pronto e Chart.js disponível
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializarGraficos);
    } else {
        inicializarGraficos();
    }
    @endif

    // ============================================
    // WIDGET DE CLIMA (Open-Meteo - API Pública Gratuita)
    // ============================================
    async function carregarClima() {
        // Carregar clima no dashboard
        await carregarClimaDashboard();

        // Carregar clima no sidebar (se existir)
        await carregarClimaSidebar();
    }

    async function carregarClimaDashboard() {
        const widget = document.getElementById('widget-clima-dashboard');
        if (!widget) return;

        // Bloquear se offline
        if (!navigator.onLine) {
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-4xl">🌤️</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Offline - Requer conexão</div>
                </div>
            `;
            return;
        }

        try {
            // Coordenadas padrão (Coração de Maria - BA)
            const lat = -12.2333;
            const lon = -38.7500;

            // Open-Meteo API - Pública e gratuita, sem necessidade de chave
            const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&timezone=America/Bahia&forecast_days=1`);

            if (!response.ok) {
                throw new Error('Erro ao buscar clima');
            }

            const data = await response.json();
            const current = data.current;

            // Mapear códigos de clima do WMO (World Meteorological Organization)
            const weatherCodeMap = {
                0: { icon: '☀️', desc: 'Céu limpo' },
                1: { icon: '🌤️', desc: 'Principalmente limpo' },
                2: { icon: '⛅', desc: 'Parcialmente nublado' },
                3: { icon: '☁️', desc: 'Nublado' },
                45: { icon: '🌫️', desc: 'Nevoeiro' },
                48: { icon: '🌫️', desc: 'Nevoeiro gelado' },
                51: { icon: '🌦️', desc: 'Chuva leve' },
                53: { icon: '🌦️', desc: 'Chuva moderada' },
                55: { icon: '🌧️', desc: 'Chuva forte' },
                56: { icon: '🌨️', desc: 'Chuva congelante leve' },
                57: { icon: '🌨️', desc: 'Chuva congelante forte' },
                61: { icon: '🌧️', desc: 'Chuva leve' },
                63: { icon: '🌧️', desc: 'Chuva moderada' },
                65: { icon: '🌧️', desc: 'Chuva forte' },
                66: { icon: '🌨️', desc: 'Chuva congelante leve' },
                67: { icon: '🌨️', desc: 'Chuva congelante forte' },
                71: { icon: '❄️', desc: 'Neve leve' },
                73: { icon: '❄️', desc: 'Neve moderada' },
                75: { icon: '❄️', desc: 'Neve forte' },
                77: { icon: '❄️', desc: 'Grãos de neve' },
                80: { icon: '🌦️', desc: 'Pancadas de chuva leve' },
                81: { icon: '🌦️', desc: 'Pancadas de chuva moderada' },
                82: { icon: '🌧️', desc: 'Pancadas de chuva forte' },
                85: { icon: '❄️', desc: 'Pancadas de neve leve' },
                86: { icon: '❄️', desc: 'Pancadas de neve forte' },
                95: { icon: '⛈️', desc: 'Trovoada' },
                96: { icon: '⛈️', desc: 'Trovoada com granizo leve' },
                99: { icon: '⛈️', desc: 'Trovoada com granizo forte' }
            };

            const weatherInfo = weatherCodeMap[current.weather_code] || { icon: '🌤️', desc: 'Condições desconhecidas' };
            const temp = Math.round(current.temperature_2m);
            const umidade = Math.round(current.relative_humidity_2m);
            const vento = Math.round(current.wind_speed_10m * 3.6); // Converter m/s para km/h

            widget.innerHTML = `
                <div class="space-y-3">
                    <div class="flex items-center justify-center gap-2">
                        <div class="text-5xl">${weatherInfo.icon}</div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">${temp}°C</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${weatherInfo.desc}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-blue-200 dark:border-blue-800">
                        <div class="text-center">
                            <div class="text-xs text-gray-500 dark:text-gray-400">Umidade</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">${umidade}%</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vento</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">${vento} km/h</div>
                        </div>
                    </div>
                    <div class="text-xs text-center text-gray-500 dark:text-gray-500 pt-1">
                        Coração de Maria - BA
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Erro ao carregar clima no dashboard:', error);
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-4xl">🌤️</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Erro ao carregar</div>
                </div>
            `;
        }
    }

    // Função para carregar clima no sidebar (reutilizável)
    async function carregarClimaSidebar() {
        const widget = document.getElementById('widget-clima');
        if (!widget) return;

        // Bloquear se offline
        if (!navigator.onLine) {
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-3xl">🌤️</div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Offline</div>
                </div>
            `;
            return;
        }

        try {
            // Coordenadas padrão (Coração de Maria - BA)
            const lat = -12.2333;
            const lon = -38.7500;

            // Open-Meteo API - Pública e gratuita, sem necessidade de chave
            const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,weather_code&timezone=America/Bahia&forecast_days=1`);

            if (!response.ok) {
                throw new Error('Erro ao buscar clima');
            }

            const data = await response.json();
            const current = data.current;

            // Mapear códigos de clima do WMO
            const weatherCodeMap = {
                0: { icon: '☀️', desc: 'Céu limpo' },
                1: { icon: '🌤️', desc: 'Principalmente limpo' },
                2: { icon: '⛅', desc: 'Parcialmente nublado' },
                3: { icon: '☁️', desc: 'Nublado' },
                45: { icon: '🌫️', desc: 'Nevoeiro' },
                48: { icon: '🌫️', desc: 'Nevoeiro gelado' },
                51: { icon: '🌦️', desc: 'Chuva leve' },
                53: { icon: '🌦️', desc: 'Chuva moderada' },
                55: { icon: '🌧️', desc: 'Chuva forte' },
                61: { icon: '🌧️', desc: 'Chuva leve' },
                63: { icon: '🌧️', desc: 'Chuva moderada' },
                65: { icon: '🌧️', desc: 'Chuva forte' },
                71: { icon: '❄️', desc: 'Neve leve' },
                73: { icon: '❄️', desc: 'Neve moderada' },
                75: { icon: '❄️', desc: 'Neve forte' },
                80: { icon: '🌦️', desc: 'Pancadas de chuva leve' },
                81: { icon: '🌦️', desc: 'Pancadas de chuva moderada' },
                82: { icon: '🌧️', desc: 'Pancadas de chuva forte' },
                95: { icon: '⛈️', desc: 'Trovoada' },
                96: { icon: '⛈️', desc: 'Trovoada com granizo' },
                99: { icon: '⛈️', desc: 'Trovoada forte' }
            };

            const weatherInfo = weatherCodeMap[current.weather_code] || { icon: '🌤️', desc: 'Condições desconhecidas' };
            const temp = Math.round(current.temperature_2m);
            const umidade = Math.round(current.relative_humidity_2m);

            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="flex items-center justify-center gap-2">
                        <div class="text-4xl">${weatherInfo.icon}</div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">${temp}°C</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${weatherInfo.desc}</div>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-blue-200 dark:border-blue-800">
                        <div class="text-xs text-gray-500 dark:text-gray-400">Umidade: <span class="font-semibold text-gray-900 dark:text-white">${umidade}%</span></div>
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Erro ao carregar clima no sidebar:', error);
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-3xl">🌤️</div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Erro ao carregar</div>
                </div>
            `;
        }
    }

    // ============================================
    // WIDGET DE CHAT
    // ============================================
    let chatWidgetAberto = false;
    let chatSessoes = [];

    function toggleChatWidget() {
        const container = document.getElementById('chat-widget-container');
        const text = document.getElementById('chat-toggle-text');
        chatWidgetAberto = !chatWidgetAberto;
        container.classList.toggle('hidden', !chatWidgetAberto);
        text.textContent = chatWidgetAberto ? 'Fechar' : 'Abrir';

        if (chatWidgetAberto) {
            carregarConversas();
        }
    }

    async function carregarConversas() {
        try {
            const response = await fetch('{{ route("campo.chat.index") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Resposta não é JSON. Status:', response.status);
                console.error('Conteúdo recebido:', text.substring(0, 500));
                throw new Error('Resposta não é JSON. Status: ' + response.status);
            }

            const data = await response.json();

            if (data.success) {
                chatSessoes = data.sessoes.data || [];
                atualizarListaConversas();
            } else {
                console.warn('Resposta sem success:', data);
            }
        } catch (error) {
            console.error('Erro ao carregar conversas:', error);
            const container = document.getElementById('chat-conversas');
            if (container) {
                container.innerHTML = '<div class="text-center text-sm text-red-500 dark:text-red-400 py-8">Erro ao carregar conversas. Verifique o console.</div>';
            }
        }
    }

    function atualizarListaConversas() {
        const container = document.getElementById('chat-conversas');
        if (chatSessoes.length === 0) {
            container.innerHTML = '<div class="text-center text-sm text-gray-500 dark:text-gray-400 py-8">Nenhuma conversa</div>';
            return;
        }

        container.innerHTML = chatSessoes.map(sessao => `
            <div onclick="abrirConversa('${sessao.session_id}')" class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                            ${sessao.assigned_to ? sessao.assigned_to.name : 'Sistema'}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            ${sessao.last_message ? sessao.last_message.message : 'Sem mensagens'}
                        </p>
                    </div>
                    ${sessao.unread_count_user > 0 ? `<span class="ml-2 px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">${sessao.unread_count_user}</span>` : ''}
                </div>
            </div>
        `).join('');
    }

    function abrirConversa(sessionId) {
        // Redirecionar para página de chat com a sessão selecionada
        window.location.href = '{{ route("campo.chat.page") }}?session=' + sessionId;
    }

    // ============================================
    // INICIALIZAÇÃO
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        carregarLocalidades();
        carregarClima(); // Carrega clima no dashboard e sidebar

        // Atualizar clima a cada 10 minutos
        setInterval(carregarClima, 600000);

        // Atualizar chat a cada 30 segundos se widget estiver aberto
        setInterval(() => {
            if (chatWidgetAberto) {
                carregarConversas();
            }
        }, 30000);
    });
</script>
@endpush
@endsection
