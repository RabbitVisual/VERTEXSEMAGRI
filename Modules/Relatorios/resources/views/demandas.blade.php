@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Demandas')


@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="clipboard-check" class="w-6 h-6" />
                Relatório de Demandas
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise completa de demandas do sistema</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.demandas" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::advanced-filters
        action="{{ route('relatorios.demandas') }}"
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
            title="Abertas"
            :value="$stats['abertas'] ?? 0"
            icon="clock"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Em Andamento"
            :value="$stats['em_andamento'] ?? 0"
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

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas por Mês</h3>
            </x-slot>
            <x-relatorios::chart
                id="demandasMesChart"
                type="line"
                :data="[
                    'labels' => array_keys($chartData['por_mes'] ?? []),
                    'datasets' => [[
                        'label' => 'Demandas',
                        'data' => array_values($chartData['por_mes'] ?? []),
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
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas por Status</h3>
            </x-slot>
            <x-relatorios::chart
                id="demandasStatusChart"
                type="doughnut"
                :data="[
                    'labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateStatus($k); }, array_keys($chartData['por_status'] ?? [])),
                    'values' => array_values($chartData['por_status'] ?? [])
                ]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas por Tipo</h3>
            </x-slot>
            <x-relatorios::chart
                id="demandasTipoChart"
                type="bar"
                :data="[
                    'labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateType($k); }, array_keys($chartData['por_tipo'] ?? [])),
                    'datasets' => [[
                        'label' => 'Demandas',
                        'data' => array_values($chartData['por_tipo'] ?? []),
                        'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas por Localidade</h3>
            </x-slot>
            <x-relatorios::chart
                id="demandasLocalidadeChart"
                type="bar"
                :data="[
                    'labels' => array_keys($chartData['por_localidade'] ?? []),
                    'datasets' => [[
                        'label' => 'Demandas',
                        'data' => array_values($chartData['por_localidade'] ?? []),
                        'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>
    </div>

    <!-- Tabela de Demandas -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Demandas</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Solicitante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Localidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data Abertura</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($demandas as $demanda)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $demanda->codigo ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $demanda->solicitante_nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ \App\Helpers\TranslationHelper::translateType($demanda->tipo ?? 'outros') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusColors = [
                                        'aberta' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'em_andamento' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'concluida' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $color = $statusColors[$demanda->status ?? ''] ?? 'bg-gray-100 text-gray-800';
                                    $statusTraduzido = \App\Helpers\TranslationHelper::translateStatus($demanda->status ?? 'pendente');
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $color }}">
                                    {{ $statusTraduzido }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $demanda->localidade_nome ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $demanda->data_abertura ? \Carbon\Carbon::parse($demanda->data_abertura)->format('d/m/Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhuma demanda encontrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($demandas, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $demandas->links() }}
            </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

