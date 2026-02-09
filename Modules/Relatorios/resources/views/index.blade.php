@extends('Co-Admin.layouts.app')

@section('title', 'Inteligência e Relatórios')

@section('content')
<div class="space-y-8 animate-fade-in">

    <!-- Premium Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-500/20">
                    <x-icon name="chart-mixed" class="w-8 h-8" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Inteligência & Relatórios
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="flex items-center px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-wider border border-indigo-100 dark:border-indigo-800/50">
                            Mission Control
                        </span>
                        <span class="text-slate-400 dark:text-slate-500">•</span>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Análise de dados e métricas operacionais</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-slide-up">
        <x-relatorios::stat-card
            title="Demandas"
            :value="$stats['demandas']['total'] ?? 0"
            icon="clipboard-list"
            color="primary"
            :subtitle="'Abertas: ' . ($stats['demandas']['abertas'] ?? 0) . ' | Concluídas: ' . ($stats['demandas']['concluidas'] ?? 0)" />

        <x-relatorios::stat-card
            title="Ordens de Serviço"
            :value="$stats['ordens']['total'] ?? 0"
            icon="file-lines"
            color="info"
            :subtitle="'Pendentes: ' . ($stats['ordens']['pendentes'] ?? 0) . ' | Em Execução: ' . ($stats['ordens']['em_execucao'] ?? 0)" />

        <x-relatorios::stat-card
            title="Localidades"
            :value="$stats['localidades']['total'] ?? 0"
            icon="location-dot"
            color="success"
            :subtitle="'Ativas: ' . ($stats['localidades']['ativas'] ?? 0)" />

        <x-relatorios::stat-card
            title="Materiais"
            :value="$stats['materiais']['total'] ?? 0"
            icon="boxes-stacked"
            color="warning"
            :subtitle="'Baixo Estoque: ' . ($stats['materiais']['baixo_estoque'] ?? 0)" />
    </div>

    <!-- Main Navigation Grid -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden animate-slide-up">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/20">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <x-icon name="layer-group" class="w-5 h-5 text-indigo-500" />
                Análises Disponíveis
            </h3>
        </div>

        @php
            $routePrefix = request()->is('co-admin/*') ? 'co-admin.relatorios.' : 'relatorios.';
        @endphp

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $analyses = [
                    ['route' => 'demandas', 'icon' => 'clipboard-check', 'label' => 'Análise de Demandas', 'color' => 'indigo'],
                    ['route' => 'ordens', 'icon' => 'file-invoice', 'label' => 'Análise de Ordens', 'color' => 'blue'],
                    ['route' => 'materiais', 'icon' => 'box-open', 'label' => 'Análise de Materiais', 'color' => 'amber'],
                    ['route' => 'infraestrutura', 'icon' => 'map-location-dot', 'label' => 'Análise de Infraestrutura', 'color' => 'emerald'],
                    ['route' => 'equipes', 'icon' => 'users-gear', 'label' => 'Análise de Equipes', 'color' => 'slate'],
                    ['route' => 'geral', 'icon' => 'chart-pie', 'label' => 'Relatório Geral', 'color' => 'green'],
                    ['route' => 'analise.temporal', 'icon' => 'clock-rotate-left', 'label' => 'Análise Temporal', 'color' => 'indigo'],
                    ['route' => 'analise.geografica', 'icon' => 'earth-americas', 'label' => 'Análise Geográfica', 'color' => 'blue'],
                    ['route' => 'analise.performance', 'icon' => 'gauge-high', 'label' => 'Análise de Performance', 'color' => 'amber'],
                    ['route' => 'notificacoes', 'icon' => 'bell', 'label' => 'Relatório de Notificações', 'color' => 'purple'],
                    ['route' => 'auditoria', 'icon' => 'shield-halved', 'label' => 'Relatório de Auditoria', 'color' => 'sky'],
                    ['route' => 'solicitacoes_materiais', 'icon' => 'clipboard-list', 'label' => 'Solicitações de Materiais', 'color' => 'amber'],
                ];
            @endphp

            @foreach($analyses as $item)
                <a href="{{ route($routePrefix . $item['route']) }}"
                   class="group p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 hover:border-{{ $item['color'] }}-500 dark:hover:border-{{ $item['color'] }}-400 hover:shadow-xl hover:shadow-{{ $item['color'] }}-500/5 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-{{ $item['color'] }}-50 dark:bg-{{ $item['color'] }}-900/30 flex items-center justify-center text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400 group-hover:scale-110 transition-transform">
                            <x-icon :name="$item['icon']" class="w-6 h-6" />
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-900 dark:text-white group-hover:text-{{ $item['color'] }}-600 transition-colors">{{ $item['label'] }}</span>
                            <span class="block text-[10px] text-slate-400 font-medium uppercase tracking-wider">Acessar Inteligência</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up" style="animation-delay: 100ms">
        <!-- Demandas Chart -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/20">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <x-icon name="chart-area" class="w-4 h-4 text-indigo-500" />
                    Demandas por Mês
                </h3>
            </div>
            <div class="p-6">
                <x-relatorios::chart
                    id="demandasMesChart"
                    type="line"
                    :data="['labels' => array_keys($chartData['demandas_por_mes'] ?? []), 'datasets' => [['label' => 'Demandas', 'data' => array_values($chartData['demandas_por_mes'] ?? []), 'borderColor' => 'rgba(99, 102, 241, 1)', 'backgroundColor' => 'rgba(99, 102, 241, 0.1)', 'fill' => true]]]"
                    :height="300"
                    empty-message="Não há demandas registradas neste período." />
            </div>
        </div>

        <!-- OS Status Chart -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/20">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <x-icon name="chart-pie" class="w-4 h-4 text-emerald-500" />
                    OS por Status
                </h3>
            </div>
            <div class="p-6 text-center">
                <x-relatorios::chart
                    id="osStatusChart"
                    type="doughnut"
                    :data="['labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateStatus($k); }, array_keys($chartData['os_por_status'] ?? [])), 'values' => array_values($chartData['os_por_status'] ?? [])]"
                    :height="300"
                    empty-message="Não há ordens de serviço registradas no sistema." />
            </div>
        </div>
    </div>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
