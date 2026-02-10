@extends('Co-Admin.layouts.app')

@section('title', 'Análise Geográfica')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="map" class="w-6 h-6" />
                Análise Geográfica
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Distribuição espacial de demandas e serviços</p>
        </div>
        <x-relatorios::advanced-filters
            action="{{ route('relatorios.analise.geografica') }}"
            :filters="$filters"
            :localidades="$localidades"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Demandas por Localidade (Mapa de Calor) -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Concentração de Demandas</h3>
            </x-slot>
            <div class="h-96 w-full rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                <!-- Placeholder para Mapa - Em produção, usar Leaflet/Google Maps -->
                <div class="text-center">
                    <x-relatorios::icon name="map" class="w-16 h-16 mx-auto text-gray-400 mb-2" />
                    <p class="text-gray-500">Mapa Interativo (Em Breve)</p>
                </div>
            </div>
        </x-relatorios::card>

        <!-- Top Localidades -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Localidades com Mais Demandas</h3>
            </x-slot>
            <x-relatorios::chart
                id="topLocalidadesChart"
                type="bar"
                :data="[
                    'labels' => array_keys($chartData['top_localidades'] ?? []),
                    'datasets' => [[
                        'label' => 'Total Demandas',
                        'data' => array_values($chartData['top_localidades'] ?? []),
                        'backgroundColor' => 'rgba(249, 115, 22, 0.8)', // Laranja
                        'indexAxis' => 'y', // Barra horizontal
                    ]]
                ]"
                :height="350"
            />
        </x-relatorios::card>
    </div>

    <!-- Tabela Detalhada -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detalhes por Localidade</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Localidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total Demandas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Pendentes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Concluídas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Taxa Resolução</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tabelaData as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $row['nome'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $row['total'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-bold">{{ $row['pendentes'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-bold">{{ $row['concluidas'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $row['total'] > 0 ? number_format(($row['concluidas'] / $row['total']) * 100, 1) . '%' : '0%' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhum dado disponível
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
