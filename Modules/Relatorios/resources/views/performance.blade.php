@extends('Co-Admin.layouts.app')

@section('title', 'Análise de Performance')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="chart-bar" class="w-6 h-6" />
                Análise de Performance
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de desempenho de equipes e operações</p>
        </div>
    </div>

    <!-- Filtros -->
    <x-relatorios::advanced-filters
        action="{{ route('relatorios.analise.performance') }}"
        :filters="$filters ?? []"
        :equipes="$equipes ?? collect([])"
    />

    <!-- Cards de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total de Equipes"
            :value="count($performance['equipes'] ?? [])"
            icon="user-group"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Taxa Média de Conclusão"
            :value="round(collect($performance['equipes'] ?? [])->avg('taxa_conclusao') ?? 0, 1) . '%'"
            icon="check-circle"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Tempo Médio (min)"
            :value="round(collect($performance['equipes'] ?? [])->avg('tempo_medio') ?? 0, 0)"
            icon="clock"
            color="info"
        />
        <x-relatorios::metrics-card
            title="Total de OS"
            :value="collect($performance['equipes'] ?? [])->sum('total_os')"
            icon="document-text"
            color="warning"
        />
    </div>

    <!-- Performance por Equipe -->
    <x-relatorios::card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="user-group" class="w-5 h-5" />
                    Performance por Equipe
                </h3>
                <x-relatorios::export-buttons
                    route="relatorios.equipes"
                    :filters="$filters ?? []"
                />
            </div>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Equipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total OS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Concluídas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Taxa Conclusão</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tempo Médio</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($performance['equipes'] ?? [] as $equipe)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $equipe['nome'] ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $equipe['total_os'] ?? 0 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $equipe['concluidas'] ?? 0 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $taxa = $equipe['taxa_conclusao'] ?? 0;
                                    $color = $taxa >= 80 ? 'success' : ($taxa >= 60 ? 'warning' : 'danger');
                                @endphp
                                <x-relatorios::badge :variant="$color">
                                    {{ number_format($taxa, 1) }}%
                                </x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ number_format($equipe['tempo_medio'] ?? 0, 0) }} min
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Nenhuma equipe encontrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-relatorios::card>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Taxa de Conclusão por Mês -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-line" class="w-5 h-5" />
                    Taxa de Conclusão por Mês
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="taxaConclusaoChart"
                type="line"
                :data="['labels' => array_keys($chartData['taxa_conclusao'] ?? []), 'datasets' => [['label' => 'Taxa de Conclusão (%)', 'data' => array_values($chartData['taxa_conclusao'] ?? []), 'borderColor' => 'rgba(34, 197, 94, 1)', 'backgroundColor' => 'rgba(34, 197, 94, 0.1)', 'fill' => true]]]"
                :height="300"
            />
        </x-relatorios::card>

        <!-- Tempo Médio por Mês -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="clock" class="w-5 h-5" />
                    Tempo Médio de Execução
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="tempoMedioChart"
                type="bar"
                :data="['labels' => array_keys($chartData['tempo_medio'] ?? []), 'datasets' => [['label' => 'Tempo Médio (min)', 'data' => array_values($chartData['tempo_medio'] ?? []), 'backgroundColor' => 'rgba(59, 130, 246, 0.8)']]]"
                :height="300"
            />
        </x-relatorios::card>

        <!-- Performance por Equipe -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-bar" class="w-5 h-5" />
                    OS Concluídas por Equipe
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="performanceEquipesChart"
                type="bar"
                :data="['labels' => array_column($performance['equipes'] ?? [], 'nome'), 'datasets' => [['label' => 'Concluídas', 'data' => array_column($performance['equipes'] ?? [], 'concluidas'), 'backgroundColor' => 'rgba(34, 197, 94, 0.8)'], ['label' => 'Total', 'data' => array_column($performance['equipes'] ?? [], 'total_os'), 'backgroundColor' => 'rgba(99, 102, 241, 0.8)']]]"
                :height="300"
            />
        </x-relatorios::card>

        <!-- Taxa de Conclusão por Equipe -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-pie" class="w-5 h-5" />
                    Taxa de Conclusão por Equipe
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="taxaEquipesChart"
                type="doughnut"
                :data="['labels' => array_column($performance['equipes'] ?? [], 'nome'), 'values' => array_column($performance['equipes'] ?? [], 'taxa_conclusao')]"
                :height="300"
            />
        </x-relatorios::card>
    </div>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

