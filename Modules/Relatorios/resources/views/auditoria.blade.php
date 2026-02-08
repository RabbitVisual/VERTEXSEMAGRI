@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Auditoria')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="shield-check" class="w-6 h-6" />
                Relatório de Auditoria
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Logs de auditoria e rastreamento de ações do sistema</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.auditoria" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtros</h3>
        </x-slot>
        <form method="GET" action="{{ route('relatorios.auditoria') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ação</label>
                    <input type="text" name="action" value="{{ $filters['action'] ?? '' }}" placeholder="Ex: create, update, delete" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Módulo</label>
                    <input type="text" name="module" value="{{ $filters['module'] ?? '' }}" placeholder="Ex: Demandas, Ordens" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Usuário</label>
                    <select name="user_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todos</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ ($filters['user_id'] ?? '') == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Modelo</label>
                    <input type="text" name="model_type" value="{{ $filters['model_type'] ?? '' }}" placeholder="Ex: Demanda, OrdemServico" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" />
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
                <x-relatorios::button href="{{ route('relatorios.auditoria') }}" variant="outline">Limpar</x-relatorios::button>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total de Logs"
            :value="$stats['total'] ?? 0"
            icon="document-text"
            color="primary"
        />
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Logs de Auditoria</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data/Hora</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuário</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ação</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Módulo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Modelo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Descrição</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') : 'N/A' }}</td>
                    <td>{{ $log->usuario_nome ?? 'Sistema' }}</td>
                    <td>
                        <x-relatorios::badge color="info">
                            {{ $log->action ?? 'N/A' }}
                        </x-relatorios::badge>
                    </td>
                    <td>{{ $log->module ?? 'N/A' }}</td>
                    <td>{{ $log->model_type ? class_basename($log->model_type) : 'N/A' }}</td>
                    <td>{{ Str::limit($log->description ?? 'N/A', 50) }}</td>
                    <td>{{ $log->ip_address ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Nenhum log de auditoria encontrado.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $logs->links() }}
        </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

