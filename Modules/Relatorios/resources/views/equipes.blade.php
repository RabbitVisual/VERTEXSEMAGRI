@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Equipes')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="users" class="w-6 h-6" />
                Relatório de Equipes
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Desempenho e produtividade das equipes</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.equipes" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::advanced-filters
        action="{{ route('relatorios.equipes') }}"
        :filters="$filters"
    />

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-relatorios::metrics-card
            title="Total Equipes"
            :value="$stats['total_equipes'] ?? 0"
            icon="users"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Ordens Concluídas"
            :value="$stats['total_ordens_concluidas'] ?? 0"
            icon="check-circle"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Média Tempo Execução"
            :value="$stats['media_tempo_execucao'] ?? '0h'"
            icon="clock"
            color="info"
        />
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Produtividade por Equipe</h3>
            </x-slot>
            <x-relatorios::chart
                id="equipesProdutividadeChart"
                type="bar"
                :data="[
                    'labels' => array_keys($chartData['produtividade'] ?? []),
                    'datasets' => [[
                        'label' => 'Ordens Concluídas',
                        'data' => array_values($chartData['produtividade'] ?? []),
                        'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordens em Aberto por Equipe</h3>
            </x-slot>
            <x-relatorios::chart
                id="equipesPendentesChart"
                type="bar"
                :data="[
                    'labels' => array_keys($chartData['pendentes'] ?? []),
                    'datasets' => [[
                        'label' => 'Ordens Pendentes',
                        'data' => array_values($chartData['pendentes'] ?? []),
                        'backgroundColor' => 'rgba(234, 179, 8, 0.8)',
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Desempenho Detalhado</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Equipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Líder</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Ordens Concluídas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Ordens Pendentes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tempo Médio</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($equipes as $equipe)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $equipe->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $equipe->lider->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-bold">{{ $equipe->ordens_concluidas_count ?? 0 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-bold">{{ $equipe->ordens_pendentes_count ?? 0 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $equipe->tempo_medio ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhuma equipe encontrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($equipes, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $equipes->links() }}
            </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
