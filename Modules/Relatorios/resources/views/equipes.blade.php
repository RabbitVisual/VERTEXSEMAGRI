@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Equipes')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="user-group" class="w-6 h-6" />
                Relatório de Equipes
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise completa de performance das equipes</p>
        </div>
        <x-relatorios::export-buttons route="co-admin.relatorios.equipes" :filters="$filters ?? []" />
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <form method="GET" action="{{ route('co-admin.relatorios.equipes') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                <select name="tipo" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todos os tipos</option>
                    <option value="eletricistas" {{ ($filters['tipo'] ?? '') === 'eletricistas' ? 'selected' : '' }}>Eletricistas</option>
                    <option value="encanadores" {{ ($filters['tipo'] ?? '') === 'encanadores' ? 'selected' : '' }}>Encanadores</option>
                    <option value="manutencao" {{ ($filters['tipo'] ?? '') === 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                    <option value="limpeza" {{ ($filters['tipo'] ?? '') === 'limpeza' ? 'selected' : '' }}>Limpeza</option>
                    <option value="obras" {{ ($filters['tipo'] ?? '') === 'obras' ? 'selected' : '' }}>Obras</option>
                    <option value="geral" {{ ($filters['tipo'] ?? '') === 'geral' ? 'selected' : '' }}>Geral</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="ativo" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Todos</option>
                    <option value="1" {{ ($filters['ativo'] ?? '') === '1' ? 'selected' : '' }}>Ativas</option>
                    <option value="0" {{ ($filters['ativo'] ?? '') === '0' ? 'selected' : '' }}>Inativas</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filtrar
                </button>
                <a href="{{ route('co-admin.relatorios.equipes') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Limpar
                </a>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total de Equipes"
            :value="$stats['total'] ?? 0"
            icon="user-group"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Equipes Ativas"
            :value="$stats['ativas'] ?? 0"
            icon="check-circle"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Equipes Inativas"
            :value="($stats['total'] ?? 0) - ($stats['ativas'] ?? 0)"
            icon="x-circle"
            color="danger"
        />
        <x-relatorios::metrics-card
            title="Taxa de Atividade"
            :value="($stats['total'] ?? 0) > 0 ? round((($stats['ativas'] ?? 0) / ($stats['total'] ?? 1)) * 100) . '%' : '0%'"
            icon="chart-bar"
            color="info"
        />
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Equipes por Tipo</h3>
            </x-slot>
            @if(!empty($chartData['por_tipo']))
                <x-relatorios::chart
                    id="equipesTipoChart"
                    type="bar"
                    :data="[
                        'labels' => array_map('ucfirst', array_keys($chartData['por_tipo'] ?? [])),
                        'datasets' => [[
                            'label' => 'Equipes',
                            'data' => array_values($chartData['por_tipo'] ?? []),
                            'backgroundColor' => [
                                'rgba(99, 102, 241, 0.8)',
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(234, 179, 8, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(168, 85, 247, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                            ],
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
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Performance das Equipes</h3>
            </x-slot>
            @if(!empty($chartData['performance']))
                <x-relatorios::chart
                    id="equipesPerformanceChart"
                    type="doughnut"
                    :data="[
                        'labels' => ['OS Concluídas', 'OS Pendentes'],
                        'values' => [
                            array_sum(array_column($chartData['performance'] ?? [], 'concluidas')),
                            array_sum(array_column($chartData['performance'] ?? [], 'pendentes'))
                        ]
                    ]"
                    :height="300"
                />
            @else
                <div class="flex items-center justify-center h-64 text-gray-500 dark:text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        <p>Sem dados de performance</p>
                    </div>
                </div>
            @endif
        </x-relatorios::card>
    </div>

    <!-- Tabela de Equipes -->
    <x-relatorios::card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Equipes</h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $equipes->total() ?? count($equipes) }} equipe(s) encontrada(s)
                </span>
            </div>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Líder</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total OS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">OS Concluídas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tempo Médio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Criado em</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($equipes as $equipe)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-indigo-600 dark:text-indigo-400">{{ $equipe->codigo ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $equipe->nome }}</div>
                                        @if($equipe->descricao)
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($equipe->descricao, 30) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $tipoColors = [
                                        'eletricistas' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'encanadores' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'manutencao' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                        'limpeza' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'obras' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                        'geral' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                    ];
                                    $tipoColor = $tipoColors[$equipe->tipo ?? 'geral'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $tipoColor }}">
                                    {{ ucfirst($equipe->tipo ?? 'Geral') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $equipe->lider_nome ?? 'Não definido' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($equipe->ativo)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Ativa
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        Inativa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <span class="font-semibold">{{ $equipe->total_os ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $totalOs = $equipe->total_os ?? 0;
                                    $osConcluidas = $equipe->os_concluidas ?? 0;
                                    $taxaConclusao = $totalOs > 0 ? round(($osConcluidas / $totalOs) * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="text-green-600 dark:text-green-400 font-semibold">{{ $osConcluidas }}</span>
                                    <span class="text-xs text-gray-500">({{ $taxaConclusao }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-1">
                                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $taxaConclusao }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                @if($equipe->tempo_medio_execucao)
                                    {{ round($equipe->tempo_medio_execucao) }} min
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $equipe->created_at ? \Carbon\Carbon::parse($equipe->created_at)->format('d/m/Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Nenhuma equipe encontrada</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tente ajustar os filtros ou cadastre novas equipes.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($equipes, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $equipes->appends($filters ?? [])->links() }}
            </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
