@extends('Co-Admin.layouts.app')

@section('title', 'Análise de Tendências')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="arrow-trending-up" class="w-6 h-6" />
                Análise de Tendências
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Previsões e padrões identificados</p>
        </div>
        <div class="flex gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                <x-relatorios::icon name="sparkles" class="w-3 h-3 mr-1" />
                IA Beta
            </span>
        </div>
    </div>

    <!-- Insights Automáticos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-relatorios::card class="bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-900/20 dark:to-gray-800">
            <x-slot name="header">
                <div class="flex items-center gap-2">
                    <x-relatorios::icon name="light-bulb" class="w-5 h-5 text-yellow-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Padrões Detectados</h3>
                </div>
            </x-slot>
            <ul class="space-y-3">
                @forelse($insights['padroes'] ?? [] as $padrao)
                    <li class="flex items-start gap-3 p-3 bg-white dark:bg-gray-700 rounded-lg shadow-sm">
                        <span class="mt-1 text-indigo-500">•</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $padrao }}</span>
                    </li>
                @empty
                    <li class="text-sm text-gray-500 italic">Nenhum padrão significativo detectado no período recente.</li>
                @endforelse
            </ul>
        </x-relatorios::card>

        <x-relatorios::card class="bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/20 dark:to-gray-800">
            <x-slot name="header">
                <div class="flex items-center gap-2">
                    <x-relatorios::icon name="forward" class="w-5 h-5 text-emerald-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Previsão Próximo Mês</h3>
                </div>
            </x-slot>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-700 rounded-lg shadow-sm">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Volume Esperado de Demandas</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $insights['previsao']['demandas'] ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-700 rounded-lg shadow-sm">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Materiais Críticos</span>
                    <span class="text-sm font-bold text-red-500">{{ implode(', ', $insights['previsao']['materiais_criticos'] ?? []) ?: 'Nenhum' }}</span>
                </div>
            </div>
        </x-relatorios::card>
    </div>

    <!-- Gráfico de Tendência -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tendência de Crescimento (Demandas)</h3>
        </x-slot>
        <x-relatorios::chart
            id="tendenciaChart"
            type="line"
            :data="[
                'labels' => $chartData['tendencia']['labels'] ?? [],
                'datasets' => [
                    [
                        'label' => 'Histórico',
                        'data' => $chartData['tendencia']['historico'] ?? [],
                        'borderColor' => 'rgba(107, 114, 128, 0.5)', // Cinza
                        'borderDash' => [0, 0],
                        'fill' => false,
                    ],
                    [
                        'label' => 'Tendência (Regressão)',
                        'data' => $chartData['tendencia']['projecao'] ?? [],
                        'borderColor' => 'rgba(79, 70, 229, 1)', // Indigo
                        'borderDash' => [5, 5],
                        'fill' => false,
                    ]
                ]
            ]"
            :height="400"
        />
        <p class="mt-4 text-xs text-center text-gray-500">
            * A linha de tendência é uma projeção baseada em regressão linear simples dos últimos 6 meses.
        </p>
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
