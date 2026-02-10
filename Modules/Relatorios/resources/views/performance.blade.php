@extends('Co-Admin.layouts.app')

@section('title', 'Análise de Performance')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="presentation-chart-line" class="w-6 h-6" />
                Análise de Performance
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Indicadores de eficiência operacional</p>
        </div>
        <x-relatorios::advanced-filters
            action="{{ route('relatorios.analise.performance') }}"
            :filters="$filters"
        />
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Tempo Médio Resposta"
            :value="$stats['tempo_medio_resposta'] ?? '0h'"
            icon="clock"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Tempo Médio Solução"
            :value="$stats['tempo_medio_solucao'] ?? '0d'"
            icon="tools"
            color="info"
        />
        <x-relatorios::metrics-card
            title="Ordens no Prazo"
            :value="$stats['percentual_no_prazo'] ?? '0%'"
            icon="calendar-check"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Satisfação (NPS)"
            :value="$stats['nps'] ?? 'N/A'"
            icon="face-smile"
            color="warning"
        />
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Eficiência por Equipe -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Eficiência por Equipe (Ordens/Mês)</h3>
            </x-slot>
            <x-relatorios::chart
                id="eficienciaEquipeChart"
                type="bar"
                :data="[
                    'labels' => array_keys($chartData['eficiencia_equipe'] ?? []),
                    'datasets' => [[
                        'label' => 'Média Ordens/Mês',
                        'data' => array_values($chartData['eficiencia_equipe'] ?? []),
                        'backgroundColor' => 'rgba(139, 92, 246, 0.8)', // Violeta
                    ]]
                ]"
                :height="350"
            />
        </x-relatorios::card>

        <!-- Gargalos (Status mais demorados) -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tempo por Etapa (Horas)</h3>
            </x-slot>
            <x-relatorios::chart
                id="gargalosChart"
                type="bar"
                :data="[
                    'labels' => array_keys($chartData['gargalos'] ?? []),
                    'datasets' => [[
                        'label' => 'Horas Médias',
                        'data' => array_values($chartData['gargalos'] ?? []),
                        'backgroundColor' => 'rgba(236, 72, 153, 0.8)', // Rosa
                    ]]
                ]"
                :height="350"
            />
        </x-relatorios::card>
    </div>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
