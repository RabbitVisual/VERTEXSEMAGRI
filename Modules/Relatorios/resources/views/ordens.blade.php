@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Ordens de Serviço')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="document-text" class="w-6 h-6" />
                Relatório de Ordens de Serviço
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise completa de ordens de serviço</p>
        </div>
        <x-relatorios::export-buttons route="co-admin.relatorios.ordens" :filters="$filters ?? []" />
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <form method="GET" action="{{ route('co-admin.relatorios.ordens') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Início</label>
                <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? '' }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Fim</label>
                <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? '' }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todos</option>
                    <option value="pendente" {{ ($filters['status'] ?? '') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="em_execucao" {{ ($filters['status'] ?? '') === 'em_execucao' ? 'selected' : '' }}>Em Execução</option>
                    <option value="concluida" {{ ($filters['status'] ?? '') === 'concluida' ? 'selected' : '' }}>Concluída</option>
                    <option value="cancelada" {{ ($filters['status'] ?? '') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Equipe</label>
                <select name="equipe_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todas</option>
                    @foreach($equipes ?? [] as $equipe)
                        <option value="{{ $equipe->id }}" {{ ($filters['equipe_id'] ?? '') == $equipe->id ? 'selected' : '' }}>
                            {{ $equipe->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filtrar
                </button>
                <a href="{{ route('co-admin.relatorios.ordens') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Limpar
                </a>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <x-relatorios::metrics-card
            title="Total de OS"
            :value="$stats['total'] ?? 0"
            icon="document-text"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Pendentes"
            :value="$stats['pendentes'] ?? 0"
            icon="clock"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Em Execução"
            :value="$stats['em_execucao'] ?? 0"
            icon="cog"
            color="info"
        />
        <x-relatorios::metrics-card
            title="Concluídas"
            :value="$stats['concluidas'] ?? 0"
            icon="check-circle"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Taxa Conclusão"
            :value="($stats['total'] ?? 0) > 0 ? round((($stats['concluidas'] ?? 0) / ($stats['total'] ?? 1)) * 100) . '%' : '0%'"
            icon="chart-bar"
            color="primary"
        />
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">OS por Mês</h3>
            </x-slot>
            @if(!empty($chartData['por_mes']))
                <x-relatorios::chart
                    id="ordensMesChart"
                    type="line"
                    :data="[
                        'labels' => array_keys($chartData['por_mes'] ?? []),
                        'datasets' => [[
                            'label' => 'Ordens de Serviço',
                            'data' => array_values($chartData['por_mes'] ?? []),
                            'borderColor' => 'rgba(99, 102, 241, 1)',
                            'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                            'fill' => true,
                            'tension' => 0.3
                        ]]
                    ]"
                    :height="300"
                />
            @else
                <div class="flex items-center justify-center h-64 text-gray-500 dark:text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <p>Sem dados para exibir</p>
                    </div>
                </div>
            @endif
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">OS por Status</h3>
            </x-slot>
            @if(!empty($chartData['por_status']))
                <x-relatorios::chart
                    id="ordensStatusChart"
                    type="doughnut"
                    :data="[
                        'labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateStatus($k); }, array_keys($chartData['por_status'] ?? [])),
                        'values' => array_values($chartData['por_status'] ?? [])
                    ]"
                    :height="300"
                />
            @else
                <div class="flex items-center justify-center h-64 text-gray-500 dark:text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        </svg>
                        <p>Sem dados de status</p>
                    </div>
                </div>
            @endif
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">OS por Tipo</h3>
            </x-slot>
            @if(!empty($chartData['por_tipo']))
                <x-relatorios::chart
                    id="ordensTipoChart"
                    type="bar"
                    :data="[
                        'labels' => array_map(function($k) { return \App\Helpers\TranslationHelper::translateType($k); }, array_keys($chartData['por_tipo'] ?? [])),
                        'datasets' => [[
                            'label' => 'Ordens',
                            'data' => array_values($chartData['por_tipo'] ?? []),
                            'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                        ]]
                    ]"
                    :height="300"
                />
            @else
                <div class="flex items-center justify-center h-64 text-gray-500 dark:text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <p>Sem dados de tipo</p>
                    </div>
                </div>
            @endif
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">OS por Equipe</h3>
            </x-slot>
            @if(!empty($chartData['por_equipe']))
                <x-relatorios::chart
                    id="ordensEquipeChart"
                    type="bar"
                    :data="[
                        'labels' => array_keys($chartData['por_equipe'] ?? []),
                        'datasets' => [[
                            'label' => 'Ordens',
                            'data' => array_values($chartData['por_equipe'] ?? []),
                            'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                        ]]
                    ]"
                    :height="300"
                />
            @else
                <div class="flex items-center justify-center h-64 text-gray-500 dark:text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p>Sem dados de equipe</p>
                    </div>
                </div>
            @endif
        </x-relatorios::card>
    </div>

    <!-- Tabela de Ordens -->
    <x-relatorios::card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Ordens de Serviço</h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $ordens->total() ?? count($ordens) }} ordem(ns) encontrada(s)
                </span>
            </div>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Equipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prioridade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data Criação</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data Conclusão</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tempo Exec.</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($ordens as $ordem)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-indigo-600 dark:text-indigo-400">{{ $ordem->codigo ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ \App\Helpers\TranslationHelper::translateType($ordem->tipo ?? 'outros') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $ordem->equipe_nome ?? 'Não atribuída' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pendente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'em_execucao' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'concluida' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $statusColor = $statusColors[$ordem->status ?? 'pendente'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                    {{ \App\Helpers\TranslationHelper::translateStatus($ordem->status ?? 'pendente') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $prioridadeColors = [
                                        'baixa' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                        'normal' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'alta' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                        'urgente' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $prioridadeColor = $prioridadeColors[$ordem->prioridade ?? 'normal'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $prioridadeColor }}">
                                    {{ ucfirst($ordem->prioridade ?? 'Normal') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $ordem->created_at ? \Carbon\Carbon::parse($ordem->created_at)->format('d/m/Y H:i') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($ordem->data_conclusao)
                                    {{ \Carbon\Carbon::parse($ordem->data_conclusao)->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                @if($ordem->tempo_execucao)
                                    {{ round($ordem->tempo_execucao) }} min
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Nenhuma ordem encontrada</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tente ajustar os filtros ou crie novas ordens de serviço.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($ordens, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $ordens->appends($filters ?? [])->links() }}
            </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
