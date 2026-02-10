@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Materiais')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="box" class="w-6 h-6" />
                Relatório de Materiais
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Controle de estoque e movimentações</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.materiais" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::advanced-filters
        action="{{ route('relatorios.materiais') }}"
        :filters="$filters"
    />

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total Itens"
            :value="$stats['total_itens'] ?? 0"
            icon="box"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Valor Total"
            :value="'R$ ' . number_format($stats['valor_total'] ?? 0, 2, ',', '.')"
            icon="currency-dollar"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Baixo Estoque"
            :value="$stats['baixo_estoque'] ?? 0"
            icon="exclamation-circle"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Sem Estoque"
            :value="$stats['sem_estoque'] ?? 0"
            icon="x-circle"
            color="danger"
        />
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Materiais por Categoria</h3>
            </x-slot>
            <x-relatorios::chart
                id="materiaisCategoriaChart"
                type="doughnut"
                :data="[
                    'labels' => array_keys($chartData['por_categoria'] ?? []),
                    'values' => array_values($chartData['por_categoria'] ?? [])
                ]"
                :height="300"
            />
        </x-relatorios::card>

        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top 5 Mais Utilizados</h3>
            </x-slot>
            <x-relatorios::chart
                id="materiaisTopChart"
                type="bar"
                :data="[
                    'labels' => array_keys($chartData['mais_utilizados'] ?? []),
                    'datasets' => [[
                        'label' => 'Quantidade',
                        'data' => array_values($chartData['mais_utilizados'] ?? []),
                        'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    ]]
                ]"
                :height="300"
            />
        </x-relatorios::card>
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estoque Atual</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Categoria</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Quantidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Unidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Valor Unit.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($materiais as $material)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $material->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $material->categoria->nome ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $material->quantidade_estoque <= $material->quantidade_minima ? 'text-red-600' : 'text-green-600' }}">
                                {{ $material->quantidade_estoque }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $material->unidade_medida }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">R$ {{ number_format($material->valor_unitario, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($material->quantidade_estoque == 0)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Sem Estoque</span>
                                @elseif($material->quantidade_estoque <= $material->quantidade_minima)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Baixo Estoque</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Normal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhum material encontrado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($materiais, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $materiais->links() }}
            </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
