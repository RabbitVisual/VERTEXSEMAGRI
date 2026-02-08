@extends('Co-Admin.layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Relatorios" class="w-6 h-6" />
                Relatórios
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Visualização de estatísticas e relatórios do sistema</p>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::stat-card
            title="Demandas"
            :value="$stats['demandas']['total'] ?? 0"
            icon="clipboard-document-check"
            color="primary"
            :subtitle="'Abertas: ' . ($stats['demandas']['abertas'] ?? 0) . ' | Concluídas: ' . ($stats['demandas']['concluidas'] ?? 0)"
        />
        <x-relatorios::stat-card
            title="Ordens de Serviço"
            :value="$stats['ordens']['total'] ?? 0"
            icon="document-text"
            color="info"
            :subtitle="'Pendentes: ' . ($stats['ordens']['pendentes'] ?? 0) . ' | Em Execução: ' . ($stats['ordens']['em_execucao'] ?? 0)"
        />
        <x-relatorios::stat-card
            title="Localidades"
            :value="$stats['localidades']['total'] ?? 0"
            icon="map-pin"
            color="success"
            :subtitle="'Ativas: ' . ($stats['localidades']['ativas'] ?? 0)"
        />
        <x-relatorios::stat-card
            title="Equipes"
            :value="$stats['equipes']['total'] ?? 0"
            icon="user-group"
            color="warning"
            :subtitle="'Ativas: ' . ($stats['equipes']['ativas'] ?? 0)"
        />
        <x-relatorios::stat-card
            title="Pontos de Luz"
            :value="$stats['infraestrutura']['pontos_luz'] ?? 0"
            icon="light-bulb"
            color="primary"
        />
        <x-relatorios::stat-card
            title="Redes de Água"
            :value="$stats['infraestrutura']['redes_agua'] ?? 0"
            icon="water"
            color="info"
        />
        <x-relatorios::stat-card
            title="Poços"
            :value="$stats['infraestrutura']['pocos'] ?? 0"
            icon="water"
            color="success"
        />
        <x-relatorios::stat-card
            title="Trechos"
            :value="$stats['infraestrutura']['trechos'] ?? 0"
            icon="map"
            color="secondary"
        />
        <x-relatorios::stat-card
            title="Materiais"
            :value="$stats['materiais']['total'] ?? 0"
            icon="cube"
            color="warning"
            :subtitle="'Baixo Estoque: ' . ($stats['materiais']['baixo_estoque'] ?? 0)"
        />
    </div>

    <!-- Navegação Rápida -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="chart-bar" class="w-5 h-5" />
                Análises Disponíveis
            </h3>
        </x-slot>
        @php
            $routePrefix = request()->is('co-admin/*') ? 'co-admin.relatorios.' : 'relatorios.';
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-relatorios::button href="{{ route($routePrefix . 'demandas') }}" variant="outline-primary" class="w-full justify-center">
                <x-relatorios::icon name="clipboard-check" class="w-4 h-4 mr-2" />
                Análise de Demandas
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'ordens') }}" variant="outline-info" class="w-full justify-center">
                <x-relatorios::icon name="document-text" class="w-4 h-4 mr-2" />
                Análise de Ordens
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'materiais') }}" variant="outline-warning" class="w-full justify-center">
                <x-relatorios::icon name="cube" class="w-4 h-4 mr-2" />
                Análise de Materiais
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'infraestrutura') }}" variant="outline-success" class="w-full justify-center">
                <x-relatorios::icon name="map-pin" class="w-4 h-4 mr-2" />
                Análise de Infraestrutura
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'equipes') }}" variant="outline" class="w-full justify-center">
                <x-relatorios::icon name="user-group" class="w-4 h-4 mr-2" />
                Análise de Equipes
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'geral') }}" variant="outline-success" class="w-full justify-center">
                <x-relatorios::icon name="chart-bar" class="w-4 h-4 mr-2" />
                Relatório Geral
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'analise.temporal') }}" variant="outline-primary" class="w-full justify-center">
                <x-relatorios::icon name="clock-history" class="w-4 h-4 mr-2" />
                Análise Temporal
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'analise.geografica') }}" variant="outline-info" class="w-full justify-center">
                <x-relatorios::icon name="map-pin" class="w-4 h-4 mr-2" />
                Análise Geográfica
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'analise.performance') }}" variant="outline-warning" class="w-full justify-center">
                <x-relatorios::icon name="chart-bar" class="w-4 h-4 mr-2" />
                Análise de Performance
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'notificacoes') }}" variant="outline-primary" class="w-full justify-center">
                <x-relatorios::icon name="bell" class="w-4 h-4 mr-2" />
                Relatório de Notificações
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'auditoria') }}" variant="outline-info" class="w-full justify-center">
                <x-relatorios::icon name="shield-check" class="w-4 h-4 mr-2" />
                Relatório de Auditoria
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'solicitacoes_materiais') }}" variant="outline-warning" class="w-full justify-center">
                <x-relatorios::icon name="clipboard-document-list" class="w-4 h-4 mr-2" />
                Solicitações de Materiais
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'movimentacoes_materiais') }}" variant="outline-success" class="w-full justify-center">
                <x-relatorios::icon name="arrow-path" class="w-4 h-4 mr-2" />
                Movimentações de Materiais
            </x-relatorios::button>
            <x-relatorios::button href="{{ route($routePrefix . 'usuarios') }}" variant="outline" class="w-full justify-center">
                <x-relatorios::icon name="users" class="w-4 h-4 mr-2" />
                Relatório de Usuários
            </x-relatorios::button>
        </div>
    </x-relatorios::card>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-bar" class="w-5 h-5" />
                    Demandas por Mês
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="demandasMesChart"
                type="line"
                :data="['labels' => array_keys($chartData['demandas_por_mes'] ?? []), 'datasets' => [['label' => 'Demandas', 'data' => array_values($chartData['demandas_por_mes'] ?? []), 'borderColor' => 'rgba(99, 102, 241, 1)', 'backgroundColor' => 'rgba(99, 102, 241, 0.1)', 'fill' => true]]]"
                :height="300"
                empty-message="Não há demandas registradas neste período."
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-pie" class="w-5 h-5" />
                    OS por Status
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="osStatusChart"
                type="doughnut"
                :data="['labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateStatus($k); }, array_keys($chartData['os_por_status'] ?? [])), 'values' => array_values($chartData['os_por_status'] ?? [])]"
                :height="300"
                empty-message="Não há ordens de serviço registradas no sistema."
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="chart-pie" class="w-5 h-5" />
                    Materiais por Categoria
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="materiaisCategoriaChart"
                type="pie"
                :data="['labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateType($k); }, array_keys($chartData['materiais_por_categoria'] ?? [])), 'values' => array_values($chartData['materiais_por_categoria'] ?? [])]"
                :height="300"
                empty-message="Não há materiais cadastrados no sistema."
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-relatorios::icon name="map-pin" class="w-5 h-5" />
                    Pessoas por Localidade
                </h3>
            </x-slot>
            <x-relatorios::chart
                id="pessoasLocalidadeChart"
                type="bar"
                :data="['labels' => array_keys($chartData['pessoas_por_localidade'] ?? []), 'datasets' => [['label' => 'Pessoas', 'data' => array_values($chartData['pessoas_por_localidade'] ?? []), 'backgroundColor' => 'rgba(34, 197, 94, 0.8)']]]"
                :height="300"
                empty-message="Não há pessoas cadastradas nas localidades."
            />
        </x-relatorios::card>
    </div>

    <!-- Relatórios Disponíveis -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="document-text" class="w-5 h-5" />
                Relatórios Disponíveis
            </h3>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <x-relatorios::icon name="clipboard-document-check" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Relatório de Demandas</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Relatório completo de todas as demandas do sistema com filtros avançados</p>
                        <div class="flex gap-2">
                            <x-relatorios::button href="{{ route($routePrefix . 'demandas') }}" variant="primary" size="sm">
                                <x-relatorios::icon name="eye" class="w-4 h-4 mr-2" />
                                Ver Análise
                            </x-relatorios::button>
                            <x-relatorios::button href="{{ route($routePrefix . 'demandas', ['format' => 'pdf']) }}" variant="outline" size="sm">
                                <x-relatorios::icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                                PDF
                            </x-relatorios::button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <x-relatorios::icon name="document-text" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Relatório de OS</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Relatório de ordens de serviço por período e status</p>
                        <div class="flex gap-2">
                            <x-relatorios::button href="{{ route($routePrefix . 'ordens') }}" variant="info" size="sm">
                                <x-relatorios::icon name="eye" class="w-4 h-4 mr-2" />
                                Ver Análise
                            </x-relatorios::button>
                            <x-relatorios::button href="{{ route($routePrefix . 'ordens', ['format' => 'pdf']) }}" variant="outline" size="sm">
                                <x-relatorios::icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                                PDF
                            </x-relatorios::button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                            <x-relatorios::icon name="cube" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Relatório de Materiais</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Relatório de estoque e consumo de materiais</p>
                        <div class="flex gap-2">
                            <x-relatorios::button href="{{ route($routePrefix . 'materiais') }}" variant="warning" size="sm">
                                <x-relatorios::icon name="eye" class="w-4 h-4 mr-2" />
                                Ver Análise
                            </x-relatorios::button>
                            <x-relatorios::button href="{{ route($routePrefix . 'materiais', ['format' => 'pdf']) }}" variant="outline" size="sm">
                                <x-relatorios::icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                                PDF
                            </x-relatorios::button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <x-relatorios::icon name="chart-bar" class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Relatório Geral</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Relatório consolidado de todas as atividades do sistema</p>
                        <x-relatorios::button href="{{ route($routePrefix . 'geral') }}" variant="success" size="sm">
                            <x-relatorios::icon name="chart-bar" class="w-4 h-4 mr-2" />
                            Ver Relatório
                        </x-relatorios::button>
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <x-relatorios::icon name="bell" class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Relatório de Notificações</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Análise completa de notificações do sistema</p>
                        <div class="flex gap-2">
                            <x-relatorios::button href="{{ route($routePrefix . 'notificacoes') }}" variant="primary" size="sm">
                                <x-relatorios::icon name="eye" class="w-4 h-4 mr-2" />
                                Ver Relatório
                            </x-relatorios::button>
                            <x-relatorios::button href="{{ route($routePrefix . 'notificacoes', ['format' => 'pdf']) }}" variant="outline" size="sm">
                                <x-relatorios::icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                                PDF
                            </x-relatorios::button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <x-relatorios::icon name="shield-check" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Relatório de Auditoria</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Logs de auditoria e rastreamento de ações</p>
                        <div class="flex gap-2">
                            <x-relatorios::button href="{{ route($routePrefix . 'auditoria') }}" variant="info" size="sm">
                                <x-relatorios::icon name="eye" class="w-4 h-4 mr-2" />
                                Ver Relatório
                            </x-relatorios::button>
                            <x-relatorios::button href="{{ route($routePrefix . 'auditoria', ['format' => 'pdf']) }}" variant="outline" size="sm">
                                <x-relatorios::icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                                PDF
                            </x-relatorios::button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <x-relatorios::icon name="users" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Relatório de Usuários</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Análise de usuários e permissões do sistema</p>
                        <div class="flex gap-2">
                            <x-relatorios::button href="{{ route($routePrefix . 'usuarios') }}" variant="primary" size="sm">
                                <x-relatorios::icon name="eye" class="w-4 h-4 mr-2" />
                                Ver Relatório
                            </x-relatorios::button>
                            <x-relatorios::button href="{{ route($routePrefix . 'usuarios', ['format' => 'pdf']) }}" variant="outline" size="sm">
                                <x-relatorios::icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                                PDF
                            </x-relatorios::button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
