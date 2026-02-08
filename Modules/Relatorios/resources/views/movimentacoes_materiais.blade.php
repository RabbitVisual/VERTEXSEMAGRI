@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Movimentações de Materiais')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="arrow-path" class="w-6 h-6" />
                Relatório de Movimentações de Materiais
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de entradas e saídas de materiais</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.movimentacoes_materiais" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtros</h3>
        </x-slot>
        <form method="GET" action="{{ route('relatorios.movimentacoes_materiais') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                    <select name="tipo" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todos</option>
                        <option value="entrada" {{ ($filters['tipo'] ?? '') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ ($filters['tipo'] ?? '') == 'saida' ? 'selected' : '' }}>Saída</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todos</option>
                        <option value="pendente" {{ ($filters['status'] ?? '') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="confirmado" {{ ($filters['status'] ?? '') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="cancelado" {{ ($filters['status'] ?? '') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Material</label>
                    <select name="material_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todos</option>
                        @foreach($materiais as $material)
                            <option value="{{ $material->id }}" {{ ($filters['material_id'] ?? '') == $material->id ? 'selected' : '' }}>{{ $material->nome }} ({{ $material->codigo }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Início</label>
                    <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? '' }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Fim</label>
                    <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? '' }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" />
                </div>
            </div>
            <div class="flex gap-2">
                <x-relatorios::button type="submit" variant="primary">Filtrar</x-relatorios::button>
                <x-relatorios::button href="{{ route('relatorios.movimentacoes_materiais') }}" variant="outline">Limpar</x-relatorios::button>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total"
            :value="$stats['total'] ?? 0"
            icon="arrow-path"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Entradas"
            :value="$stats['entradas'] ?? 0"
            icon="arrow-down-tray"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Saídas"
            :value="$stats['saidas'] ?? 0"
            icon="arrow-up-tray"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Confirmadas"
            :value="$stats['confirmadas'] ?? 0"
            icon="check-circle"
            color="success"
        />
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Movimentações de Materiais</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Material</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantidade</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Funcionário</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($movimentacoes as $movimentacao)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $movimentacao->material_nome ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $movimentacao->material_codigo ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if(($movimentacao->tipo ?? '') === 'entrada')
                            <x-relatorios::badge color="success">Entrada</x-relatorios::badge>
                        @else
                            <x-relatorios::badge color="warning">Saída</x-relatorios::badge>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $statusColors = [
                                'pendente' => 'warning',
                                'confirmado' => 'success',
                                'cancelado' => 'danger'
                            ];
                            $color = $statusColors[$movimentacao->status ?? 'pendente'] ?? 'info';
                        @endphp
                        <x-relatorios::badge :color="$color">
                            {{ ucfirst($movimentacao->status ?? 'N/A') }}
                        </x-relatorios::badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        {{ formatar_quantidade($movimentacao->quantidade ?? 0, $movimentacao->material_unidade_medida ?? null) }}
                        @if($movimentacao->material_unidade_medida ?? null)
                            <span class="text-gray-400 dark:text-gray-500 ml-1">{{ $movimentacao->material_unidade_medida }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">R$ {{ number_format($movimentacao->valor_total ?? 0, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $movimentacao->funcionario_nome ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $movimentacao->created_at ? \Carbon\Carbon::parse($movimentacao->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Nenhuma movimentação encontrada.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($movimentacoes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $movimentacoes->links() }}
        </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

