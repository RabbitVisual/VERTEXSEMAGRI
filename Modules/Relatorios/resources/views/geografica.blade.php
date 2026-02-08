@extends('Co-Admin.layouts.app')

@section('title', 'Análise Geográfica')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="map-pin" class="w-6 h-6" />
                Análise Geográfica
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de dados por localidade e distribuição geográfica</p>
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
        <form action="{{ route($routePrefix . 'analise.geografica') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Data Início
                    </label>
                    <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? '' }}" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Data Fim
                    </label>
                    <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? '' }}" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                <x-relatorios::button type="button" variant="outline" onclick="window.location.href='{{ route($routePrefix . 'analise.geografica') }}'">
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

    <!-- Mapa Interativo -->
    @if(!empty($mapMarkers))
    <x-relatorios::card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="map" class="w-5 h-5" />
                    Mapa Interativo - Distribuição Geográfica
                </h3>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        Localidades
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                        Poços
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                        Iluminação
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        Distribuição
                    </span>
                </div>
            </div>
        </x-slot>
        <x-relatorios::map
            id="mapa-geografico-principal"
            :markers="$mapMarkers"
            height="550px"
            :center-lat="-12.2336"
            :center-lng="-38.7454"
            :zoom="12"
            :show-legend="true"
            :show-fullscreen="true"
            :show-layer-control="true"
        />
        <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-600 dark:text-gray-400">
                <strong>Dica:</strong> Clique nos marcadores para ver detalhes. Use os controles no canto superior direito para alternar entre mapa, satélite e topográfico.
                O botão de tela cheia permite visualizar o mapa em tamanho completo.
            </p>
        </div>
    </x-relatorios::card>
    @else
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="map" class="w-5 h-5" />
                Mapa Interativo
            </h3>
        </x-slot>
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <x-relatorios::icon name="map-pin" class="w-16 h-16 mx-auto mb-4 opacity-50" />
            <p class="text-lg font-medium mb-2">Nenhum dado geográfico disponível</p>
            <p class="text-sm">Cadastre localidades com coordenadas (latitude/longitude) para visualizar no mapa.</p>
        </div>
    </x-relatorios::card>
    @endif

    <!-- Cards de Métricas -->
    @php
        $totalLocalidades = count($analises['comparativo'] ?? []);
        $totalPessoas = collect($analises['comparativo'] ?? [])->sum('pessoas');
        $totalDemandas = collect($analises['comparativo'] ?? [])->sum('demandas');
        $totalBeneficiarias = collect($analises['comparativo'] ?? [])->sum('beneficiarias');
        $mediaPessoasLoc = $totalLocalidades > 0 ? round($totalPessoas / $totalLocalidades, 1) : 0;
        $mediaDemandasLoc = $totalLocalidades > 0 ? round($totalDemandas / $totalLocalidades, 1) : 0;
        $totalMarcadores = count($mapMarkers ?? []);
        $totalInfraestrutura = $totalMarcadores - $totalLocalidades;
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <x-relatorios::metrics-card
            title="Total de Localidades"
            :value="$totalLocalidades"
            icon="map-pin"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Pontos no Mapa"
            :value="$totalMarcadores"
            icon="map"
            color="secondary"
            :subtitle="$totalInfraestrutura . ' de infraestrutura'"
        />
        <x-relatorios::metrics-card
            title="Total de Pessoas"
            :value="$totalPessoas"
            icon="users"
            color="success"
            :subtitle="'Média: ' . $mediaPessoasLoc . ' por localidade'"
        />
        <x-relatorios::metrics-card
            title="Total de Demandas"
            :value="$totalDemandas"
            icon="clipboard-document-list"
            color="info"
            :subtitle="'Média: ' . $mediaDemandasLoc . ' por localidade'"
        />
        <x-relatorios::metrics-card
            title="Beneficiários PBF"
            :value="$totalBeneficiarias"
            icon="currency-dollar"
            color="warning"
            :subtitle="$totalPessoas > 0 ? round(($totalBeneficiarias / $totalPessoas) * 100, 1) . '% do total' : '0%'"
        />
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pessoas por Localidade -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="users" class="w-5 h-5" />
                    Pessoas por Localidade
                </h3>
            </x-slot>
            @if(!empty($chartData['pessoas_por_localidade']))
                <x-relatorios::chart
                    id="geograficaPessoasChart"
                    type="bar"
                    :data="['labels' => array_keys($chartData['pessoas_por_localidade'] ?? []), 'datasets' => [['label' => 'Pessoas', 'data' => array_values($chartData['pessoas_por_localidade'] ?? []), 'backgroundColor' => 'rgba(34, 197, 94, 0.8)', 'borderColor' => 'rgba(34, 197, 94, 1)', 'borderWidth' => 1]]]"
                    :height="350"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="users" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado de pessoas disponível.</p>
                </div>
            @endif
        </x-relatorios::card>

        <!-- Demandas por Localidade -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="clipboard-document-list" class="w-5 h-5" />
                    Demandas por Localidade
                </h3>
            </x-slot>
            @if(!empty($chartData['demandas_por_localidade']))
                <x-relatorios::chart
                    id="geograficaDemandasChart"
                    type="bar"
                    :data="['labels' => array_keys($chartData['demandas_por_localidade'] ?? []), 'datasets' => [['label' => 'Demandas', 'data' => array_values($chartData['demandas_por_localidade'] ?? []), 'backgroundColor' => 'rgba(99, 102, 241, 0.8)', 'borderColor' => 'rgba(99, 102, 241, 1)', 'borderWidth' => 1]]]"
                    :height="350"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="clipboard-document-list" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado de demandas disponível.</p>
                </div>
            @endif
        </x-relatorios::card>

        <!-- Distribuição de Pessoas -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-pie" class="w-5 h-5" />
                    Distribuição de Pessoas
                </h3>
            </x-slot>
            @if(!empty($chartData['pessoas_por_localidade']))
                <x-relatorios::chart
                    id="distribuicaoPessoasChart"
                    type="doughnut"
                    :data="['labels' => array_keys($chartData['pessoas_por_localidade'] ?? []), 'values' => array_values($chartData['pessoas_por_localidade'] ?? [])]"
                    :height="350"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="chart-pie" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado disponível.</p>
                </div>
            @endif
        </x-relatorios::card>

        <!-- Infraestrutura por Localidade -->
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="building-office" class="w-5 h-5" />
                    Infraestrutura por Localidade
                </h3>
            </x-slot>
            @php
                $infraData = $chartData['infraestrutura_por_localidade'] ?? [];
                $pontosLuzData = $infraData['pontos_luz'] ?? [];
                $redesAguaData = $infraData['redes_agua'] ?? [];
                $pocosData = $infraData['pocos'] ?? [];
                
                // Combinar todas as localidades
                $allLocalidades = array_unique(array_merge(
                    array_keys($pontosLuzData),
                    array_keys($redesAguaData),
                    array_keys($pocosData)
                ));
                sort($allLocalidades);
                
                $pontosLuz = [];
                $redesAgua = [];
                $pocos = [];
                foreach($allLocalidades as $loc) {
                    $pontosLuz[] = $pontosLuzData[$loc] ?? 0;
                    $redesAgua[] = $redesAguaData[$loc] ?? 0;
                    $pocos[] = $pocosData[$loc] ?? 0;
                }
            @endphp
            @if(!empty($allLocalidades))
                <x-relatorios::chart
                    id="infraestruturaChart"
                    type="bar"
                    :data="['labels' => $allLocalidades, 'datasets' => [['label' => 'Pontos de Luz', 'data' => $pontosLuz, 'backgroundColor' => 'rgba(234, 179, 8, 0.8)'], ['label' => 'Redes de Água', 'data' => $redesAgua, 'backgroundColor' => 'rgba(59, 130, 246, 0.8)'], ['label' => 'Poços', 'data' => $pocos, 'backgroundColor' => 'rgba(16, 185, 129, 0.8)']]]"
                    :height="350"
                />
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-relatorios::icon name="building-office" class="w-12 h-12 mx-auto mb-4 opacity-50" />
                    <p>Nenhum dado de infraestrutura disponível.</p>
                </div>
            @endif
        </x-relatorios::card>
    </div>

    <!-- Tabela Comparativa Completa -->
    <x-relatorios::card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="table-cells" class="w-5 h-5" />
                    Comparativo por Localidade
                </h3>
            </div>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Localidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pessoas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Demandas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Beneficiários PBF</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">% PBF</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Demandas/Pessoa</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($analises['comparativo'] ?? [] as $localidade => $dados)
                        @php
                            $pessoas = $dados['pessoas'] ?? 0;
                            $demandas = $dados['demandas'] ?? 0;
                            $beneficiarias = $dados['beneficiarias'] ?? 0;
                            $percentPbf = $pessoas > 0 ? round(($beneficiarias / $pessoas) * 100, 1) : 0;
                            $demandasPorPessoa = $pessoas > 0 ? round($demandas / $pessoas, 3) : 0;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <x-relatorios::icon name="map-pin" class="w-4 h-4 text-gray-400" />
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $localidade }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-relatorios::badge variant="success">{{ number_format($pessoas) }}</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-relatorios::badge variant="primary">{{ number_format($demandas) }}</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-relatorios::badge variant="warning">{{ number_format($beneficiarias) }}</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $pbfColor = $percentPbf >= 50 ? 'danger' : ($percentPbf >= 30 ? 'warning' : 'info');
                                @endphp
                                <x-relatorios::badge :variant="$pbfColor">{{ $percentPbf }}%</x-relatorios::badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $demandasPorPessoa }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Nenhum dado disponível.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(!empty($analises['comparativo']))
                <tfoot class="bg-gray-100 dark:bg-gray-900/70">
                    <tr>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">Total</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ number_format($totalPessoas) }}</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ number_format($totalDemandas) }}</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ number_format($totalBeneficiarias) }}</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ $totalPessoas > 0 ? round(($totalBeneficiarias / $totalPessoas) * 100, 1) : 0 }}%</td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 dark:text-white">{{ $totalPessoas > 0 ? round($totalDemandas / $totalPessoas, 3) : 0 }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </x-relatorios::card>

    <!-- Top 10 Localidades com Mais Demandas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="arrow-trending-up" class="w-5 h-5" />
                    Top 10 - Mais Demandas
                </h3>
            </x-slot>
            @php
                $topDemandas = collect($analises['comparativo'] ?? [])->sortByDesc('demandas')->take(10);
            @endphp
            <div class="space-y-3">
                @forelse($topDemandas as $localidade => $dados)
                    @php
                        $maxDemandas = $topDemandas->max('demandas') ?: 1;
                        $percent = round(($dados['demandas'] / $maxDemandas) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 dark:text-gray-300">{{ $localidade }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $dados['demandas'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">Nenhum dado disponível.</p>
                @endforelse
            </div>
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="users" class="w-5 h-5" />
                    Top 10 - Mais Pessoas
                </h3>
            </x-slot>
            @php
                $topPessoas = collect($analises['comparativo'] ?? [])->sortByDesc('pessoas')->take(10);
            @endphp
            <div class="space-y-3">
                @forelse($topPessoas as $localidade => $dados)
                    @php
                        $maxPessoas = $topPessoas->max('pessoas') ?: 1;
                        $percent = round(($dados['pessoas'] / $maxPessoas) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 dark:text-gray-300">{{ $localidade }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($dados['pessoas']) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">Nenhum dado disponível.</p>
                @endforelse
            </div>
        </x-relatorios::card>
    </div>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
