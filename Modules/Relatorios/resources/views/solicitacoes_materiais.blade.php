@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Solicitações de Materiais')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="clipboard-document-list" class="w-6 h-6" />
                Relatório de Solicitações de Materiais
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de solicitações de materiais do sistema</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.solicitacoes_materiais" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtros</h3>
        </x-slot>
        <form method="GET" action="{{ route('relatorios.solicitacoes_materiais') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Removido filtro de status pois a tabela solicitacoes_materiais não tem essa coluna --}}
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
                <x-relatorios::button href="{{ route('relatorios.solicitacoes_materiais') }}" variant="outline">Limpar</x-relatorios::button>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total"
            :value="$stats['total'] ?? 0"
            icon="clipboard-document-list"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Pendentes"
            :value="$stats['pendentes'] ?? 0"
            icon="clock"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Aprovadas"
            :value="$stats['aprovadas'] ?? 0"
            icon="check-circle"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Rejeitadas"
            :value="$stats['rejeitadas'] ?? 0"
            icon="x-circle"
            color="danger"
        />
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Solicitações de Materiais</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nº Ofício</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Solicitante</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Secretário</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Observações</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data Solicitação</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($solicitacoes as $solicitacao)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $solicitacao->numero_oficio ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $solicitacao->usuario_nome ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $solicitacao->secretario_nome ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($solicitacao->observacoes ?? 'N/A', 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $solicitacao->created_at ? \Carbon\Carbon::parse($solicitacao->created_at)->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        Nenhuma solicitação encontrada.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($solicitacoes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $solicitacoes->links() }}
        </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

