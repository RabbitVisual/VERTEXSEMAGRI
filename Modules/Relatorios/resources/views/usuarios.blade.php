@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Usuários')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="users" class="w-6 h-6" />
                Relatório de Usuários
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Análise de usuários e permissões do sistema</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.usuarios" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtros</h3>
        </x-slot>
        <form method="GET" action="{{ route('relatorios.usuarios') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="active" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todos</option>
                        <option value="1" {{ ($filters['active'] ?? '') == '1' ? 'selected' : '' }}>Ativos</option>
                        <option value="0" {{ ($filters['active'] ?? '') == '0' ? 'selected' : '' }}>Inativos</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Função</label>
                    <select name="role" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                        <option value="">Todas</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ ($filters['role'] ?? '') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-2">
                <x-relatorios::button type="submit" variant="primary">Filtrar</x-relatorios::button>
                <x-relatorios::button href="{{ route('relatorios.usuarios') }}" variant="outline">Limpar</x-relatorios::button>
            </div>
        </form>
    </x-relatorios::card>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total"
            :value="$stats['total'] ?? 0"
            icon="users"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Ativos"
            :value="$stats['ativos'] ?? 0"
            icon="check-circle"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Inativos"
            :value="$stats['inativos'] ?? 0"
            icon="x-circle"
            color="danger"
        />
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Usuários</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Telefone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Funções</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data Criação</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name ?? 'N/A' }}</td>
                    <td>{{ $usuario->email ?? 'N/A' }}</td>
                    <td>{{ $usuario->phone ?? 'N/A' }}</td>
                    <td>
                        @if(($usuario->active ?? 0) == 1)
                            <x-relatorios::badge color="success">Ativo</x-relatorios::badge>
                        @else
                            <x-relatorios::badge color="danger">Inativo</x-relatorios::badge>
                        @endif
                    </td>
                    <td>
                        @if(!empty($usuario->roles))
                            @foreach(explode(',', $usuario->roles) as $role)
                                <x-relatorios::badge color="info" class="mr-1">
                                    {{ trim($role) }}
                                </x-relatorios::badge>
                            @endforeach
                        @else
                            <span class="text-gray-400">Sem funções</span>
                        @endif
                    </td>
                    <td>{{ $usuario->created_at ? \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Nenhum usuário encontrado.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($usuarios->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $usuarios->links() }}
        </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection

