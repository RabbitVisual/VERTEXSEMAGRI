@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Materiais')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="cube" class="w-6 h-6" />
                Relatório de Materiais
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de estoque e consumo de materiais</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.materiais" :filters="$filters" />
    </div>

    <x-relatorios::advanced-filters action="{{ route('relatorios.materiais') }}" :filters="$filters" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-relatorios::metrics-card title="Total" :value="$stats['total'] ?? 0" icon="cube" color="primary" />
        <x-relatorios::metrics-card title="Baixo Estoque" :value="$stats['baixo_estoque'] ?? 0" icon="exclamation-triangle" color="warning" />
        <x-relatorios::metrics-card title="Valor Total" :value="'R$ ' . number_format($stats['valor_total'] ?? 0, 2, ',', '.')" icon="check-circle" color="success" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-relatorios::card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Materiais por Categoria</h3>
            </x-slot>
            <x-relatorios::chart
                id="materiaisCategoriaChart"
                type="pie"
                :data="['labels' => array_map('ucfirst', array_keys($chartData['por_categoria'] ?? [])), 'values' => array_values($chartData['por_categoria'] ?? [])]"
                :height="400"
            />
        </x-relatorios::card>
    </div>

    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Materiais</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estoque</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mínimo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Unidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor Unit.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($materiais as $material)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 {{ ($material->quantidade_estoque ?? 0) <= ($material->quantidade_minima ?? 0) ? 'bg-amber-50 dark:bg-amber-900/10' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $material->codigo ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <div class="flex items-center gap-2">
                                    {{ $material->nome }}
                                    @if(($material->quantidade_estoque ?? 0) <= ($material->quantidade_minima ?? 0))
                                        <x-relatorios::icon name="exclamation-triangle" class="w-4 h-4 text-red-500" title="Estoque baixo" />
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ ucfirst(str_replace('_', ' ', $material->categoria ?? 'N/A')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ formatar_quantidade($material->quantidade_estoque ?? 0, $material->unidade_medida ?? null) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ formatar_quantidade($material->quantidade_minima ?? 0, $material->unidade_medida ?? null) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ ucfirst($material->unidade_medida ?? 'unidade') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                R$ {{ number_format($material->valor_unitario ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if(($material->ativo ?? false))
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Ativo
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
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

