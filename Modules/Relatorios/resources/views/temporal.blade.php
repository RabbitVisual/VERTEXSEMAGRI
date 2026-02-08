@extends('Co-Admin.layouts.app')

@section('title', 'Análise Temporal')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="clock-history" class="w-6 h-6" />
                Análise Temporal
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de dados por período de tempo</p>
        </div>
        <div class="flex items-center gap-2">
            @php
                $routePrefix = request()->is('co-admin/*') ? 'co-admin.relatorios.' : 'relatorios.';
            @endphp
            <x-relatorios::button href="{{ route($routePrefix . 'index') }}" variant="outline">
                <x-relatorios::icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </x-relatorios::button>
        </div>
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="funnel" class="w-5 h-5" />
                Filtros
            </h3>
        </x-slot>
        <form action="{{ route($routePrefix . 'analise.temporal') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tipo de Análise
                    </label>
                    <select name="tipo_analise" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="demandas" {{ ($tipoAnalise ?? 'demandas') == 'demandas' ? 'selected' : '' }}>Demandas</option>
                        <option value="ordens" {{ ($tipoAnalise ?? '') == 'ordens' ? 'selected' : '' }}>Ordens de Serviço</option>
                        <option value="materiais" {{ ($tipoAnalise ?? '') == 'materiais' ? 'selected' : '' }}>Materiais</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Data Início
                    </label>
                    <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? now()->subMonths(6)->format('Y-m-d') }}" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Data Fim
                    </label>
                    <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? now()->format('Y-m-d') }}" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                @if(isset($localidades) && $localidades->isNotEmpty())
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Localidade
                    </label>
                    <select name="localidade_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas</option>
                        @foreach($localidades as $localidade)
                            <option value="{{ $localidade->id }}" {{ ($filters['localidade_id'] ?? '') == $localidade->id ? 'selected' : '' }}>
                                {{ $localidade->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                <x-relatorios::button type="button" variant="outline" onclick="window.location.href='{{ route($routePrefix . 'analise.temporal') }}'">
                    <x-relatorios::icon name="x-mark" class="w-4 h-4 mr-2" />
                    Limpar
                </x-relatorios::button>
                <x-relatorios::button type="submit" variant="primary">
                    <x-relatorios::icon name="check-circle" class="w-4 h-4 mr-2" />
                    Filtrar
                </x-relatorios::button>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Cards de Métricas -->
    @php
        $totalPorDia = count($chartData['por_dia'] ?? []);
        $totalPorSemana = count($chartData['por_semana'] ?? []);
        $totalPorMes = count($chartData['por_mes'] ?? []);
        $somaTotalDia = array_sum($chartData['por_dia'] ?? []);
        $somaTotalSemana = array_sum($chartData['por_semana'] ?? []);
        $somaTotalMes = array_sum($chartData['por_mes'] ?? []);
        $mediaDiaria = $totalPorDia > 0 ? round($somaTotalDia / $totalPorDia, 2) : 0;
        $mediaSemanal = $totalPorSemana > 0 ? round($somaTotalSemana / $totalPorSemana, 2) : 0;
        $mediaMensal = $totalPorMes > 0 ? round($somaTotalMes / $totalPorMes, 2) : 0;
        $tipoLabel = $tipoAnalise == 'demandas' ? 'Demandas' : ($tipoAnalise == 'ordens' ? 'Ordens de Serviço' : 'Movimentações');
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total no Período"
            :value="$somaTotalDia"
            icon="clipboard-document-list"
            color="primary"
            :subtitle="$tipoLabel"
        />
        <x-relatorios::metrics-card
            title="Média Diária"
            :value="$mediaDiaria"
            icon="calendar"
            color="info"
            subtitle="Por dia"
        />
        <x-relatorios::metrics-card
            title="Média Semanal"
            :value="$mediaSemanal"
            icon="calendar-days"
            color="success"
            subtitle="Por semana"
        />
        <x-relatorios::metrics-card
            title="Média Mensal"
            :value="$mediaMensal"
            icon="chart-bar"
            color="warning"
            subtitle="Por mês"
        />
    </div>

    <!-- Abas de Visualização -->
    <div x-data="{ activeTab: 'mes' }">
        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'dia'" :class="activeTab === 'dia' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-relatorios::icon name="calendar" class="w-4 h-4 inline mr-1" />
                    Por Dia
                </button>
                <button @click="activeTab = 'semana'" :class="activeTab === 'semana' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-relatorios::icon name="calendar-days" class="w-4 h-4 inline mr-1" />
                    Por Semana
                </button>
                <button @click="activeTab = 'mes'" :class="activeTab === 'mes' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-relatorios::icon name="chart-bar" class="w-4 h-4 inline mr-1" />
                    Por Mês
                </button>
            </nav>
        </div>

        <!-- Gráfico Por Dia -->
        <div x-show="activeTab === 'dia'" x-transition>
            <x-relatorios::card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-relatorios::icon name="calendar" class="w-5 h-5" />
                            {{ $tipoLabel }} por Dia
                        </h3>
                    </div>
                </x-slot>
                @if(!empty($chartData['por_dia']))
                    <x-relatorios::chart
                        id="temporalDiaChart"
                        type="line"
                        :data="['labels' => array_keys($chartData['por_dia'] ?? []), 'datasets' => [['label' => $tipoLabel, 'data' => array_values($chartData['por_dia'] ?? []), 'borderColor' => 'rgba(99, 102, 241, 1)', 'backgroundColor' => 'rgba(99, 102, 241, 0.1)', 'fill' => true, 'tension' => 0.4]]]"
                        :height="400"
                    />
                @else
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <x-relatorios::icon name="chart-bar" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                        <p>Nenhum dado disponível para o período selecionado.</p>
                    </div>
                @endif
            </x-relatorios::card>
        </div>

        <!-- Gráfico Por Semana -->
        <div x-show="activeTab === 'semana'" x-transition>
            <x-relatorios::card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-relatorios::icon name="calendar-days" class="w-5 h-5" />
                            {{ $tipoLabel }} por Semana
                        </h3>
                    </div>
                </x-slot>
                @if(!empty($chartData['por_semana']))
                    <x-relatorios::chart
                        id="temporalSemanaChart"
                        type="bar"
                        :data="['labels' => array_keys($chartData['por_semana'] ?? []), 'datasets' => [['label' => $tipoLabel, 'data' => array_values($chartData['por_semana'] ?? []), 'backgroundColor' => 'rgba(34, 197, 94, 0.8)', 'borderColor' => 'rgba(34, 197, 94, 1)', 'borderWidth' => 1]]]"
                        :height="400"
                    />
                @else
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <x-relatorios::icon name="chart-bar" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                        <p>Nenhum dado disponível para o período selecionado.</p>
                    </div>
                @endif
            </x-relatorios::card>
        </div>

        <!-- Gráfico Por Mês -->
        <div x-show="activeTab === 'mes'" x-transition>
            <x-relatorios::card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-relatorios::icon name="chart-bar" class="w-5 h-5" />
                            {{ $tipoLabel }} por Mês
                        </h3>
                    </div>
                </x-slot>
                @if(!empty($chartData['por_mes']))
                    <x-relatorios::chart
                        id="temporalMesChart"
                        type="area"
                        :data="['labels' => array_keys($chartData['por_mes'] ?? []), 'datasets' => [['label' => $tipoLabel, 'data' => array_values($chartData['por_mes'] ?? []), 'borderColor' => 'rgba(99, 102, 241, 1)', 'backgroundColor' => 'rgba(99, 102, 241, 0.2)', 'fill' => true, 'tension' => 0.4]]]"
                        :height="400"
                    />
                @else
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <x-relatorios::icon name="chart-bar" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                        <p>Nenhum dado disponível para o período selecionado.</p>
                    </div>
                @endif
            </x-relatorios::card>
        </div>
    </div>

    <!-- Comparativo entre Tipos -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="chart-pie" class="w-5 h-5" />
                Comparativo - Todos os Tipos (Por Mês)
            </h3>
        </x-slot>
        @php
            $demandasMes = $analises['demandas']['por_mes'] ?? [];
            $ordensMes = $analises['ordens']['por_mes'] ?? [];
            $allLabels = array_unique(array_merge(array_keys($demandasMes), array_keys($ordensMes)));
            sort($allLabels);
            $demandasData = [];
            $ordensData = [];
            foreach($allLabels as $label) {
                $demandasData[] = $demandasMes[$label] ?? 0;
                $ordensData[] = $ordensMes[$label] ?? 0;
            }
        @endphp
        @if(!empty($allLabels))
            <x-relatorios::chart
                id="comparativoChart"
                type="line"
                :data="['labels' => $allLabels, 'datasets' => [['label' => 'Demandas', 'data' => $demandasData, 'borderColor' => 'rgba(99, 102, 241, 1)', 'backgroundColor' => 'rgba(99, 102, 241, 0.1)', 'fill' => false, 'tension' => 0.4], ['label' => 'Ordens de Serviço', 'data' => $ordensData, 'borderColor' => 'rgba(34, 197, 94, 1)', 'backgroundColor' => 'rgba(34, 197, 94, 0.1)', 'fill' => false, 'tension' => 0.4]]]"
                :height="350"
            />
        @else
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <x-relatorios::icon name="chart-bar" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                <p>Nenhum dado disponível para comparação.</p>
            </div>
        @endif
    </x-relatorios::card>

    <!-- Tabela de Dados Detalhados -->
    <x-relatorios::card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="table-cells" class="w-5 h-5" />
                    Dados Detalhados (Por Mês)
                </h3>
            </div>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Período</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Demandas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ordens de Serviço</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($allLabels as $label)
                        @php
                            $demandaVal = $demandasMes[$label] ?? 0;
                            $ordemVal = $ordensMes[$label] ?? 0;
                            $total = $demandaVal + $ordemVal;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-relatorios::badge variant="primary">{{ $demandaVal }}</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-relatorios::badge variant="success">{{ $ordemVal }}</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $total }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Nenhum dado disponível para o período selecionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(!empty($allLabels))
                <tfoot class="bg-gray-100 dark:bg-gray-900/70">
                    <tr>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">Total</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ array_sum($demandasData) }}</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ array_sum($ordensData) }}</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ array_sum($demandasData) + array_sum($ordensData) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
