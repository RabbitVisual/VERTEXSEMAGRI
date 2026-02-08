@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Infraestrutura')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="map-pin" class="w-6 h-6" />
                Relatório de Infraestrutura
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de infraestrutura do sistema</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card title="Pontos de Luz" :value="$stats['pontos_luz']['total'] ?? 0" icon="light-bulb" color="primary" />
        <x-relatorios::metrics-card title="Redes de Água" :value="$stats['redes_agua']['total'] ?? 0" icon="droplet" color="info" />
        <x-relatorios::metrics-card title="Poços Artesianos" :value="$stats['pocos']['total'] ?? 0" icon="droplet" color="success" />
        <x-relatorios::metrics-card title="Trechos" :value="$stats['trechos']['total'] ?? 0" icon="road" color="warning" />
    </div>

    <!-- Detalhes de Infraestrutura -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::card>
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Pontos de Luz</div>
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $stats['pontos_luz']['total'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-500">
                    {{ $stats['pontos_luz']['ativos'] ?? 0 }} funcionando
                </div>
            </div>
        </x-relatorios::card>

        <x-relatorios::card>
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Redes de Água</div>
                <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400 mb-1">{{ $stats['redes_agua']['total'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-500">
                    {{ $stats['redes_agua']['ativos'] ?? 0 }} funcionando
                </div>
            </div>
        </x-relatorios::card>

        <x-relatorios::card>
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Poços Artesianos</div>
                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mb-1">{{ $stats['pocos']['total'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-500">
                    {{ $stats['pocos']['ativos'] ?? 0 }} ativos
                </div>
            </div>
        </x-relatorios::card>

        <x-relatorios::card>
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Trechos</div>
                <div class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-1">{{ $stats['trechos']['total'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-500">
                    {{ $stats['trechos']['ativos'] ?? 0 }} em bom estado
                </div>
            </div>
        </x-relatorios::card>
    </div>

    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Distribuição de Infraestrutura</h3>
        </x-slot>
        <x-relatorios::chart
            id="infraestruturaChart"
            type="doughnut"
            :data="['labels' => array_keys($chartData['distribuicao'] ?? []), 'values' => array_values($chartData['distribuicao'] ?? [])]"
            :height="400"
        />
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

