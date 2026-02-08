@extends('Co-Admin.layouts.app')

@section('title', 'Relatório Geral')

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <x-relatorios::card>
        <form method="GET" action="{{ route('relatorios.geral') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Início</label>
                <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Fim</label>
                <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
            </div>
        <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localidade</label>
                <select name="localidade_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    <option value="">Todas</option>
                    @foreach($localidades as $localidade)
                        <option value="{{ $localidade->id }}" {{ ($filters['localidade_id'] ?? '') == $localidade->id ? 'selected' : '' }}>
                            {{ $localidade->nome }}
                        </option>
                    @endforeach
                </select>
        </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Filtrar
                </button>
    </div>
        </form>
    </x-relatorios::card>

    <!-- Cards Principais -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card title="Pessoas" :value="$stats['geral']['pessoas'] ?? 0" icon="user-group" color="primary" />
        <x-relatorios::metrics-card title="Localidades" :value="$stats['geral']['localidades'] ?? 0" icon="map-pin" color="success" />
        <x-relatorios::metrics-card title="Demandas" :value="$stats['geral']['demandas_total'] ?? 0" icon="clipboard-check" color="info" />
        <x-relatorios::metrics-card title="Ordens de Serviço" :value="$stats['geral']['ordens_total'] ?? 0" icon="document-text" color="warning" />
    </div>

    <!-- Estatísticas Detalhadas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Demandas -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas</h3>
            </x-slot>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['geral']['demandas_total'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Abertas</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $stats['geral']['demandas_abertas'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Em Andamento</span>
                    <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $stats['geral']['demandas_em_andamento'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Concluídas</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $stats['geral']['demandas_concluidas'] ?? 0 }}</span>
                </div>
            </div>
        </x-relatorios::card>

        <!-- Ordens de Serviço -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordens de Serviço</h3>
            </x-slot>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['geral']['ordens_total'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Pendentes</span>
                    <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $stats['geral']['ordens_pendentes'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Em Execução</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $stats['geral']['ordens_em_execucao'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Concluídas</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $stats['geral']['ordens_concluidas'] ?? 0 }}</span>
                </div>
            </div>
        </x-relatorios::card>
    </div>

    <!-- Infraestrutura -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Infraestrutura</h3>
        </x-slot>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pontos de Luz</div>
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['geral']['infraestrutura']['pontos_luz'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                    {{ $stats['geral']['infraestrutura']['pontos_luz_funcionando'] ?? 0 }} funcionando
                </div>
            </div>
            <div class="p-4 bg-cyan-50 dark:bg-cyan-900/20 rounded-lg">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Redes de Água</div>
                <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ $stats['geral']['infraestrutura']['redes_agua'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Poços Artesianos</div>
                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['geral']['infraestrutura']['pocos'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                    {{ $stats['geral']['infraestrutura']['pocos_ativos'] ?? 0 }} ativos
                </div>
                @if(isset($stats['geral']['infraestrutura']['pocos_vazao_total']) && $stats['geral']['infraestrutura']['pocos_vazao_total'] > 0)
                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        Vazão total: {{ formatar_quantidade($stats['geral']['infraestrutura']['pocos_vazao_total'], 'litro') }}/h
                    </div>
                @endif
            </div>
            <div class="p-4 bg-teal-50 dark:bg-teal-900/20 rounded-lg">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pontos de Distribuição</div>
                <div class="text-2xl font-bold text-teal-600 dark:text-teal-400">{{ $stats['geral']['infraestrutura']['pontos_distribuicao'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                    {{ $stats['geral']['infraestrutura']['pontos_distribuicao_funcionando'] ?? 0 }} funcionando
                </div>
            </div>
        </div>
    </x-relatorios::card>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas por Mês</h3>
            </x-slot>
            <x-relatorios::chart
                id="geralDemandasChart"
                type="line"
                :data="['labels' => array_keys($chartData['demandas_por_mes'] ?? []), 'datasets' => [['label' => 'Demandas', 'data' => array_values($chartData['demandas_por_mes'] ?? []), 'borderColor' => 'rgba(99, 102, 241, 1)']]]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">OS por Status</h3>
            </x-slot>
            <x-relatorios::chart
                id="geralOSChart"
                type="doughnut"
                :data="['labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateStatus($k); }, array_keys($chartData['os_por_status'] ?? [])), 'values' => array_values($chartData['os_por_status'] ?? [])]"
                :height="300"
            />
        </x-relatorios::card>
    </div>

    <!-- Materiais -->
    @if(isset($stats['materiais']))
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Materiais</h3>
        </x-slot>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total de Materiais</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['materiais']['total'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Baixo Estoque</div>
                <div class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['materiais']['baixo_estoque'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Valor Total do Estoque</div>
                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                    R$ {{ number_format($stats['materiais']['valor_total'] ?? 0, 2, ',', '.') }}
                </div>
            </div>
        </div>
    </x-relatorios::card>
    @endif
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

