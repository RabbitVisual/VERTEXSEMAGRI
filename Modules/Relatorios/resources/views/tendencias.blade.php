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
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Identificação de padrões e tendências ao longo do tempo</p>
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
        <form action="{{ route($routePrefix . 'analise.tendencias') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tipo de Análise
                    </label>
                    <select name="tipo" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="todos" {{ ($filters['tipo'] ?? 'todos') == 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="demandas" {{ ($filters['tipo'] ?? '') == 'demandas' ? 'selected' : '' }}>Demandas</option>
                        <option value="ordens" {{ ($filters['tipo'] ?? '') == 'ordens' ? 'selected' : '' }}>Ordens de Serviço</option>
                        <option value="materiais" {{ ($filters['tipo'] ?? '') == 'materiais' ? 'selected' : '' }}>Materiais</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Data Início
                    </label>
                    <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? now()->subYear()->format('Y-m-d') }}" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Data Fim
                    </label>
                    <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? now()->format('Y-m-d') }}" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                <x-relatorios::button type="button" variant="outline" onclick="window.location.href='{{ route($routePrefix . 'analise.tendencias') }}'">
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
        $demandasData = $tendencias['demandas'] ?? [];
        $ordensData = $tendencias['ordens'] ?? [];
        $totalDemandas = array_sum($demandasData);
        $totalOrdens = array_sum($ordensData);
        $mesesDemandas = count($demandasData);
        $mesesOrdens = count($ordensData);
        $mediaDemandas = $mesesDemandas > 0 ? round($totalDemandas / $mesesDemandas, 1) : 0;
        $mediaOrdens = $mesesOrdens > 0 ? round($totalOrdens / $mesesOrdens, 1) : 0;
        
        // Calcular tendência (comparar últimos 3 meses com 3 meses anteriores)
        $demandasValues = array_values($demandasData);
        $ordensValues = array_values($ordensData);
        $tendenciaDemandas = 0;
        $tendenciaOrdens = 0;
        if (count($demandasValues) >= 6) {
            $ultimos3 = array_sum(array_slice($demandasValues, -3));
            $anteriores3 = array_sum(array_slice($demandasValues, -6, 3));
            $tendenciaDemandas = $anteriores3 > 0 ? round((($ultimos3 - $anteriores3) / $anteriores3) * 100, 1) : 0;
        }
        if (count($ordensValues) >= 6) {
            $ultimos3 = array_sum(array_slice($ordensValues, -3));
            $anteriores3 = array_sum(array_slice($ordensValues, -6, 3));
            $tendenciaOrdens = $anteriores3 > 0 ? round((($ultimos3 - $anteriores3) / $anteriores3) * 100, 1) : 0;
        }
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total de Demandas"
            :value="$totalDemandas"
            icon="clipboard-document-list"
            color="primary"
            :subtitle="'Média: ' . $mediaDemandas . '/mês'"
        />
        <x-relatorios::metrics-card
            title="Total de OS"
            :value="$totalOrdens"
            icon="document-text"
            color="info"
            :subtitle="'Média: ' . $mediaOrdens . '/mês'"
        />
        <x-relatorios::metrics-card
            title="Tendência Demandas"
            :value="($tendenciaDemandas >= 0 ? '+' : '') . $tendenciaDemandas . '%'"
            :icon="$tendenciaDemandas >= 0 ? 'arrow-trending-up' : 'arrow-trending-down'"
            :color="$tendenciaDemandas >= 0 ? 'danger' : 'success'"
            subtitle="Últimos 3 meses vs anteriores"
        />
        <x-relatorios::metrics-card
            title="Tendência OS"
            :value="($tendenciaOrdens >= 0 ? '+' : '') . $tendenciaOrdens . '%'"
            :icon="$tendenciaOrdens >= 0 ? 'arrow-trending-up' : 'arrow-trending-down'"
            :color="$tendenciaOrdens >= 0 ? 'warning' : 'success'"
            subtitle="Últimos 3 meses vs anteriores"
        />
    </div>

    <!-- Gráfico Principal de Tendências -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="chart-bar" class="w-5 h-5" />
                Evolução Temporal - Demandas vs Ordens de Serviço
            </h3>
        </x-slot>
        @php
            $allLabels = array_unique(array_merge(array_keys($demandasData), array_keys($ordensData)));
            sort($allLabels);
            $chartDemandasData = [];
            $chartOrdensData = [];
            foreach($allLabels as $label) {
                $chartDemandasData[] = $demandasData[$label] ?? 0;
                $chartOrdensData[] = $ordensData[$label] ?? 0;
            }
        @endphp
        @if(!empty($allLabels))
            <x-relatorios::chart
                id="tendenciasMainChart"
                type="line"
                :data="['labels' => $allLabels, 'datasets' => [['label' => 'Demandas', 'data' => $chartDemandasData, 'borderColor' => 'rgba(99, 102, 241, 1)', 'backgroundColor' => 'rgba(99, 102, 241, 0.1)', 'fill' => true, 'tension' => 0.4], ['label' => 'Ordens de Serviço', 'data' => $chartOrdensData, 'borderColor' => 'rgba(34, 197, 94, 1)', 'backgroundColor' => 'rgba(34, 197, 94, 0.1)', 'fill' => true, 'tension' => 0.4]]]"
                :height="400"
            />
        @else
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <x-relatorios::icon name="chart-bar" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                <p>Nenhum dado disponível para o período selecionado.</p>
            </div>
        @endif
    </x-relatorios::card>

    <!-- Gráficos Individuais -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tendência de Demandas -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="clipboard-document-list" class="w-5 h-5" />
                    Tendência de Demandas
                </h3>
            </x-slot>
            @if(!empty($demandasData))
                <x-relatorios::chart
                    id="tendenciasDemandasChart"
                    type="area"
                    :data="['labels' => array_keys($demandasData), 'datasets' => [['label' => 'Demandas', 'data' => array_values($demandasData), 'borderColor' => 'rgba(99, 102, 241, 1)', 'backgroundColor' => 'rgba(99, 102, 241, 0.2)', 'fill' => true, 'tension' => 0.4]]]"
                    :height="300"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="clipboard-document-list" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado de demandas disponível.</p>
                </div>
            @endif
        </x-relatorios::card>

        <!-- Tendência de OS -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="document-text" class="w-5 h-5" />
                    Tendência de Ordens de Serviço
                </h3>
            </x-slot>
            @if(!empty($ordensData))
                <x-relatorios::chart
                    id="tendenciasOrdensChart"
                    type="area"
                    :data="['labels' => array_keys($ordensData), 'datasets' => [['label' => 'Ordens de Serviço', 'data' => array_values($ordensData), 'borderColor' => 'rgba(34, 197, 94, 1)', 'backgroundColor' => 'rgba(34, 197, 94, 0.2)', 'fill' => true, 'tension' => 0.4]]]"
                    :height="300"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="document-text" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado de ordens disponível.</p>
                </div>
            @endif
        </x-relatorios::card>

        <!-- Taxa de Conversão -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="arrow-path" class="w-5 h-5" />
                    Taxa de Conversão (Demanda → OS)
                </h3>
            </x-slot>
            @php
                $taxaConversao = [];
                foreach($allLabels as $label) {
                    $dem = $demandasData[$label] ?? 0;
                    $ord = $ordensData[$label] ?? 0;
                    $taxaConversao[$label] = $dem > 0 ? round(($ord / $dem) * 100, 1) : 0;
                }
            @endphp
            @if(!empty($taxaConversao))
                <x-relatorios::chart
                    id="taxaConversaoChart"
                    type="line"
                    :data="['labels' => array_keys($taxaConversao), 'datasets' => [['label' => 'Taxa de Conversão (%)', 'data' => array_values($taxaConversao), 'borderColor' => 'rgba(234, 179, 8, 1)', 'backgroundColor' => 'rgba(234, 179, 8, 0.1)', 'fill' => true, 'tension' => 0.4]]]"
                    :height="300"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="arrow-path" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado disponível.</p>
                </div>
            @endif
        </x-relatorios::card>

        <!-- Comparativo Mensal -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-pie" class="w-5 h-5" />
                    Distribuição por Mês
                </h3>
            </x-slot>
            @if(!empty($allLabels))
                <x-relatorios::chart
                    id="distribuicaoMesChart"
                    type="bar"
                    :data="['labels' => $allLabels, 'datasets' => [['label' => 'Demandas', 'data' => $chartDemandasData, 'backgroundColor' => 'rgba(99, 102, 241, 0.8)'], ['label' => 'Ordens de Serviço', 'data' => $chartOrdensData, 'backgroundColor' => 'rgba(34, 197, 94, 0.8)']]]"
                    :height="300"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="chart-pie" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado disponível.</p>
                </div>
            @endif
        </x-relatorios::card>
    </div>

    <!-- Tabela de Dados Detalhados -->
    <x-relatorios::card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="table-cells" class="w-5 h-5" />
                    Dados Detalhados por Período
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Taxa Conversão</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Variação Demandas</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @php
                        $prevDemandas = null;
                    @endphp
                    @forelse($allLabels as $index => $label)
                        @php
                            $dem = $demandasData[$label] ?? 0;
                            $ord = $ordensData[$label] ?? 0;
                            $taxa = $dem > 0 ? round(($ord / $dem) * 100, 1) : 0;
                            $variacao = $prevDemandas !== null && $prevDemandas > 0 ? round((($dem - $prevDemandas) / $prevDemandas) * 100, 1) : null;
                            $prevDemandas = $dem;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-relatorios::badge variant="primary">{{ $dem }}</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-relatorios::badge variant="success">{{ $ord }}</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $taxaColor = $taxa >= 80 ? 'success' : ($taxa >= 50 ? 'warning' : 'danger');
                                @endphp
                                <x-relatorios::badge :variant="$taxaColor">{{ $taxa }}%</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($variacao !== null)
                                    @php
                                        $varColor = $variacao > 0 ? 'danger' : ($variacao < 0 ? 'success' : 'secondary');
                                        $varIcon = $variacao > 0 ? '↑' : ($variacao < 0 ? '↓' : '→');
                                    @endphp
                                    <x-relatorios::badge :variant="$varColor">
                                        {{ $varIcon }} {{ abs($variacao) }}%
                                    </x-relatorios::badge>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Nenhum dado disponível para o período selecionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(!empty($allLabels))
                <tfoot class="bg-gray-100 dark:bg-gray-900/70">
                    <tr>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">Total/Média</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ $totalDemandas }}</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ $totalOrdens }}</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ $totalDemandas > 0 ? round(($totalOrdens / $totalDemandas) * 100, 1) : 0 }}%</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">-</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </x-relatorios::card>

    <!-- Insights -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="light-bulb" class="w-5 h-5" />
                Insights Automáticos
            </h3>
        </x-slot>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
                $insights = [];
                if ($tendenciaDemandas > 20) {
                    $insights[] = ['type' => 'warning', 'icon' => 'exclamation-triangle', 'text' => 'Aumento significativo de demandas nos últimos meses. Considere reforçar a equipe.'];
                } elseif ($tendenciaDemandas < -20) {
                    $insights[] = ['type' => 'success', 'icon' => 'check-circle', 'text' => 'Redução significativa de demandas. Bom indicador de melhoria na infraestrutura.'];
                }
                
                $taxaMedia = $totalDemandas > 0 ? round(($totalOrdens / $totalDemandas) * 100, 1) : 0;
                if ($taxaMedia < 50) {
                    $insights[] = ['type' => 'danger', 'icon' => 'x-circle', 'text' => 'Taxa de conversão baixa (' . $taxaMedia . '%). Muitas demandas não estão gerando OS.'];
                } elseif ($taxaMedia >= 80) {
                    $insights[] = ['type' => 'success', 'icon' => 'check-circle', 'text' => 'Excelente taxa de conversão (' . $taxaMedia . '%). A maioria das demandas está sendo atendida.'];
                }
                
                if ($mediaDemandas > 100) {
                    $insights[] = ['type' => 'info', 'icon' => 'information-circle', 'text' => 'Volume alto de demandas mensais (média de ' . $mediaDemandas . '). Considere automatizar processos.'];
                }
                
                if (empty($insights)) {
                    $insights[] = ['type' => 'info', 'icon' => 'information-circle', 'text' => 'Os indicadores estão dentro da normalidade. Continue monitorando.'];
                }
            @endphp
            @foreach($insights as $insight)
                <div class="p-4 rounded-lg border {{ $insight['type'] === 'success' ? 'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800' : ($insight['type'] === 'warning' ? 'bg-yellow-50 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800' : ($insight['type'] === 'danger' ? 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800' : 'bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800')) }}">
                    <div class="flex items-start gap-3">
                        <x-relatorios::icon :name="$insight['icon']" class="w-5 h-5 {{ $insight['type'] === 'success' ? 'text-green-600 dark:text-green-400' : ($insight['type'] === 'warning' ? 'text-yellow-600 dark:text-yellow-400' : ($insight['type'] === 'danger' ? 'text-red-600 dark:text-red-400' : 'text-blue-600 dark:text-blue-400')) }} flex-shrink-0 mt-0.5" />
                        <p class="text-sm {{ $insight['type'] === 'success' ? 'text-green-800 dark:text-green-200' : ($insight['type'] === 'warning' ? 'text-yellow-800 dark:text-yellow-200' : ($insight['type'] === 'danger' ? 'text-red-800 dark:text-red-200' : 'text-blue-800 dark:text-blue-200')) }}">
                            {{ $insight['text'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

