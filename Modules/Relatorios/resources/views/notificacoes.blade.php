@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Notificações')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="bell" class="w-6 h-6" />
                Relatório de Notificações
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise completa de notificações do sistema</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.notificacoes" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtros</h3>
        </x-slot>
        <form method="GET" action="{{ route('relatorios.notificacoes') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                    <select name="type" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todos</option>
                        <option value="success" {{ ($filters['type'] ?? '') == 'success' ? 'selected' : '' }}>Sucesso</option>
                        <option value="info" {{ ($filters['type'] ?? '') == 'info' ? 'selected' : '' }}>Informação</option>
                        <option value="warning" {{ ($filters['type'] ?? '') == 'warning' ? 'selected' : '' }}>Aviso</option>
                        <option value="error" {{ ($filters['type'] ?? '') == 'error' ? 'selected' : '' }}>Erro</option>
                        <option value="alert" {{ ($filters['type'] ?? '') == 'alert' ? 'selected' : '' }}>Alerta</option>
                        <option value="system" {{ ($filters['type'] ?? '') == 'system' ? 'selected' : '' }}>Sistema</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Módulo</label>
                    <select name="module_source" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todos</option>
                        <option value="Notificacoes" {{ ($filters['module_source'] ?? '') == 'Notificacoes' ? 'selected' : '' }}>Notificações</option>
                        <option value="Ordens" {{ ($filters['module_source'] ?? '') == 'Ordens' ? 'selected' : '' }}>Ordens</option>
                        <option value="Demandas" {{ ($filters['module_source'] ?? '') == 'Demandas' ? 'selected' : '' }}>Demandas</option>
                        <option value="Materiais" {{ ($filters['module_source'] ?? '') == 'Materiais' ? 'selected' : '' }}>Materiais</option>
                        <option value="Equipes" {{ ($filters['module_source'] ?? '') == 'Equipes' ? 'selected' : '' }}>Equipes</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="is_read" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todas</option>
                        <option value="0" {{ ($filters['is_read'] ?? '') == '0' ? 'selected' : '' }}>Não Lidas</option>
                        <option value="1" {{ ($filters['is_read'] ?? '') == '1' ? 'selected' : '' }}>Lidas</option>
                    </select>
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
                <x-relatorios::button href="{{ route('relatorios.notificacoes') }}" variant="outline">Limpar</x-relatorios::button>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total"
            :value="$stats['total'] ?? 0"
            icon="bell"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Não Lidas"
            :value="$stats['nao_lidas'] ?? 0"
            icon="envelope"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Lidas"
            :value="$stats['lidas'] ?? 0"
            icon="check-circle"
            color="success"
        />
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notificações</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Título</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Módulo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuário</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($notificacoes as $notificacao)
                <tr>
                    <td>{{ Str::limit($notificacao->title, 50) }}</td>
                    <td>
                        <x-relatorios::badge :color="$notificacao->type ?? 'info'">
                            {{ ucfirst($notificacao->type ?? 'N/A') }}
                        </x-relatorios::badge>
                    </td>
                    <td>{{ $notificacao->module_source ?? 'N/A' }}</td>
                    <td>{{ $notificacao->usuario_nome ?? 'Global' }}</td>
                    <td>
                        @if($notificacao->is_read)
                            <x-relatorios::badge color="success">Lida</x-relatorios::badge>
                        @else
                            <x-relatorios::badge color="warning">Não Lida</x-relatorios::badge>
                        @endif
                    </td>
                    <td>{{ $notificacao->created_at ? \Carbon\Carbon::parse($notificacao->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Nenhuma notificação encontrada.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($notificacoes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $notificacoes->links() }}
        </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

