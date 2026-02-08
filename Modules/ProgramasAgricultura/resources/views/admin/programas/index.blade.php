@extends('admin.layouts.admin')

@section('title', 'Programas - Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="leaf" class="w-8 h-8 text-amber-600 dark:text-amber-500" />
                Programas do Agricultor
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Programas</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('admin.programas.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                <x-icon name="plus" class="w-5 h-5" />
                Novo Programa
            </a>
        </div>
    </div>
</div>

<!-- Estatísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
    <x-admin.stat-card label="Total" :value="$estatisticas['total']" icon="clipboard-document-check" color="primary" />
    <x-admin.stat-card label="Ativos" :value="$estatisticas['ativos']" icon="check-circle" color="success" />
    <x-admin.stat-card label="Suspensos" :value="$estatisticas['suspensos']" icon="pause-circle" color="warning" />
    <x-admin.stat-card label="Públicos" :value="$estatisticas['publicos']" icon="globe-alt" color="info" />
    <x-admin.stat-card label="Com Vagas" :value="$estatisticas['com_vagas']" icon="user-group" color="secondary" />
</div>

<!-- Filtros -->
<x-admin.card title="Filtros" class="mb-6">
    <form method="GET" action="{{ route('admin.programas.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-admin.input name="search" label="Buscar" placeholder="Nome, código..." value="{{ $filters['search'] ?? '' }}" />

        <x-admin.select name="tipo" label="Tipo" :options="['' => 'Todos', 'governo_federal' => 'Governo Federal', 'governo_estadual' => 'Governo Estadual', 'governo_municipal' => 'Governo Municipal', 'parceria' => 'Parceria', 'outro' => 'Outro']" :selected="$filters['tipo'] ?? ''" />

        <x-admin.select name="status" label="Status" :options="['' => 'Todos', 'ativo' => 'Ativo', 'suspenso' => 'Suspenso', 'encerrado' => 'Encerrado']" :selected="$filters['status'] ?? ''" />

        <x-admin.select name="publico" label="Visibilidade" :options="['' => 'Todos', '1' => 'Público', '0' => 'Privado']" :selected="$filters['publico'] ?? ''" />

        <div class="md:col-span-2 lg:col-span-4 flex gap-2">
            <x-admin.button type="submit" variant="primary" icon="magnifying-glass">Filtrar</x-admin.button>
            <a href="{{ route('admin.programas.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600">
                <x-icon name="arrow-clockwise" class="w-4 h-4 mr-2" />
                Limpar
            </a>
        </div>
    </form>
</x-admin.card>

<!-- Tabela de Programas -->
<x-admin.card title="Lista de Programas">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Vagas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Beneficiários</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Público</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($programas as $programa)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $programa->codigo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $programa->nome }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $programa->tipo_texto }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $statusColors = ['ativo' => 'success', 'suspenso' => 'warning', 'encerrado' => 'danger'];
                        @endphp
                        <x-admin.badge :type="$statusColors[$programa->status] ?? 'info'">{{ $programa->status_texto }}</x-admin.badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        @if($programa->vagas_disponiveis)
                            {{ $programa->vagas_preenchidas }}/{{ $programa->vagas_disponiveis }}
                        @else
                            Ilimitado
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $programa->beneficiarios_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($programa->publico)
                            <x-admin.badge type="success">Sim</x-admin.badge>
                        @else
                            <x-admin.badge type="secondary">Não</x-admin.badge>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.programas.show', $programa->id) }}" class="text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                            <a href="{{ route('admin.programas.edit', $programa->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Editar">
                                <x-icon name="pencil" class="w-5 h-5" />
                            </a>
                            <form action="{{ route('admin.programas.destroy', $programa->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este programa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Excluir">
                                    <x-icon name="trash" class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        Nenhum programa encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($programas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
        {{ $programas->links() }}
    </div>
    @endif
</x-admin.card>
@endsection

