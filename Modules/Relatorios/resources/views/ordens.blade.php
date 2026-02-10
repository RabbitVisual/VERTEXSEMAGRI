@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Ordens de Serviço')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="clipboard-list" class="w-6 h-6" />
                Relatório de Ordens de Serviço
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise detalhada das ordens de serviço</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.ordens" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::advanced-filters
        action="{{ route('relatorios.ordens') }}"
        :filters="$filters"
        :localidades="$localidades"
    />

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total"
            :value="$stats['total'] ?? 0"
            icon="clipboard-check"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Pendentes"
            :value="$stats['pendentes'] ?? 0"
            icon="clock"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Em Execução"
            :value="$stats['em_execucao'] ?? 0"
            icon="clock-history"
            color="info"
        />
        <x-relatorios::metrics-card
            title="Concluídas"
            :value="$stats['concluidas'] ?? 0"
            icon="check-circle"
            color="success"
        />
    </div>

    @php
        $mesLabels = array_keys($chartData['por_mes'] ?? []);
        $mesData = array_values($chartData['por_mes'] ?? []);

        $statusKeys = array_keys($chartData['por_status'] ?? []);
        $statusLabels = array_map(function($k) { return \App\Helpers\TranslationHelper::translateStatus($k); }, $statusKeys);
        $statusValues = array_values($chartData['por_status'] ?? []);

        $equipeLabels = array_keys($chartData['por_equipe'] ?? []);
        $equipeData = array_values($chartData['por_equipe'] ?? []);

        $prioridadeKeys = array_keys($chartData['por_prioridade'] ?? []);
        $prioridadeLabels = array_map(function($k) { return ucfirst($k); }, $prioridadeKeys);
        $prioridadeData = array_values($chartData['por_prioridade'] ?? []);
    @endphp

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordens por Mês</h3>
            </x-slot>
            <x-relatorios::chart
                id="ordensMesChart"
                type="line"
                :data="[
                    'labels' => $mesLabels,
                    'datasets' => [[
                        'label' => 'Ordens',
                        'data' => $mesData,
                        'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                        'borderColor' => 'rgba(99, 102, 241, 1)',
                        'borderWidth' => 2,
                        'fill' => true,
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordens por Status</h3>
            </x-slot>
            <x-relatorios::chart
                id="ordensStatusChart"
                type="doughnut"
                :data="[
                    'labels' => $statusLabels,
                    'values' => $statusValues
                ]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordens por Equipe</h3>
            </x-slot>
            <x-relatorios::chart
                id="ordensEquipeChart"
                type="bar"
                :data="[
                    'labels' => $equipeLabels,
                    'datasets' => [[
                        'label' => 'Ordens',
                        'data' => $equipeData,
                        'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordens por Prioridade</h3>
            </x-slot>
            <x-relatorios::chart
                id="ordensPrioridadeChart"
                type="bar"
                :data="[
                    'labels' => $prioridadeLabels,
                    'datasets' => [[
                        'label' => 'Ordens',
                        'data' => $prioridadeData,
                        'backgroundColor' => [
                            'rgba(239, 68, 68, 0.8)', // Alta/Urgente - Vermelho
                            'rgba(245, 158, 11, 0.8)', // Média - Laranja
                            'rgba(59, 130, 246, 0.8)', // Baixa - Azul
                        ],
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Ordens</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Demanda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Equipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data Início</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data Fim</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($ordens as $ordem)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $ordem->codigo ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $ordem->demanda ? $ordem->demanda->codigo : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $ordem->equipe ? $ordem->equipe->nome : 'Sem Equipe' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusColors = [
                                        'pendente' => 'bg-yellow-100 text-yellow-800',
                                        'em_execucao' => 'bg-blue-100 text-blue-800',
                                        'concluida' => 'bg-green-100 text-green-800',
                                        'cancelada' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $statusColors[$ordem->status ?? ''] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $color }}">
                                    {{ \App\Helpers\TranslationHelper::translateStatus($ordem->status ?? 'pendente') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $ordem->data_inicio ? \Carbon\Carbon::parse($ordem->data_inicio)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $ordem->data_conclusao ? \Carbon\Carbon::parse($ordem->data_conclusao)->format('d/m/Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhuma ordem encontrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($ordens, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $ordens->links() }}
            </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
