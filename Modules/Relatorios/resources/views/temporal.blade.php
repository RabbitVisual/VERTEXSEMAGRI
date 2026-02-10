@extends('Co-Admin.layouts.app')

@section('title', 'Análise Temporal')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="chart-line" class="w-6 h-6" />
                Análise Temporal
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Evolução de dados ao longo do tempo</p>
        </div>
        <div class="flex gap-2">
            <!-- Botões de período rápido -->
            <a href="{{ request()->fullUrlWithQuery(['periodo' => '7d']) }}" class="px-3 py-1 text-xs font-medium rounded {{ request('periodo') == '7d' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">7 Dias</a>
            <a href="{{ request()->fullUrlWithQuery(['periodo' => '30d']) }}" class="px-3 py-1 text-xs font-medium rounded {{ request('periodo', '30d') == '30d' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">30 Dias</a>
            <a href="{{ request()->fullUrlWithQuery(['periodo' => '6m']) }}" class="px-3 py-1 text-xs font-medium rounded {{ request('periodo') == '6m' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">6 Meses</a>
            <a href="{{ request()->fullUrlWithQuery(['periodo' => '1y']) }}" class="px-3 py-1 text-xs font-medium rounded {{ request('periodo') == '1y' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">1 Ano</a>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Evolução de Demandas -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Evolução de Demandas</h3>
            </x-slot>
            <x-relatorios::chart
                id="evolucaoDemandasChart"
                type="line"
                :data="[
                    'labels' => $chartData['demandas']['labels'] ?? [],
                    'datasets' => [
                        [
                            'label' => 'Abertas',
                            'data' => $chartData['demandas']['abertas'] ?? [],
                            'borderColor' => 'rgba(234, 179, 8, 1)', // Amarelo
                            'backgroundColor' => 'rgba(234, 179, 8, 0.1)',
                            'fill' => true,
                        ],
                        [
                            'label' => 'Concluídas',
                            'data' => $chartData['demandas']['concluidas'] ?? [],
                            'borderColor' => 'rgba(34, 197, 94, 1)', // Verde
                            'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                            'fill' => true,
                        ]
                    ]
                ]"
                :height="400"
            />
        </x-relatorios::card>

        <!-- Evolução de Ordens -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Evolução de Ordens de Serviço</h3>
            </x-slot>
            <x-relatorios::chart
                id="evolucaoOrdensChart"
                type="bar"
                :data="[
                    'labels' => $chartData['ordens']['labels'] ?? [],
                    'datasets' => [
                        [
                            'label' => 'Criadas',
                            'data' => $chartData['ordens']['criadas'] ?? [],
                            'backgroundColor' => 'rgba(99, 102, 241, 0.8)', // Indigo
                        ],
                        [
                            'label' => 'Finalizadas',
                            'data' => $chartData['ordens']['finalizadas'] ?? [],
                            'backgroundColor' => 'rgba(16, 185, 129, 0.8)', // Emerald
                        ]
                    ]
                ]"
                :height="400"
            />
        </x-relatorios::card>
    </div>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
