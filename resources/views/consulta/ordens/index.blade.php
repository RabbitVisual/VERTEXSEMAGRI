@extends('consulta.layouts.consulta')

@section('title', 'Ordens de Serviço - Consulta')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <span>Ordens de Serviço</span>
                <span class="text-sm bg-blue-500/20 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full border border-blue-300 dark:border-blue-700">Somente Leitura</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('consulta.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Consulta</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white">Ordens de Serviço</span>
            </nav>
        </div>
        <a href="{{ route('consulta.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Estatísticas -->
@if(isset($estatisticas))
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Total</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Abertas</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['abertas'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Em Andamento</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['em_andamento'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Concluídas</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['concluidas'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Canceladas</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['canceladas'] }}</p>
    </div>
</div>
@endif

<!-- Filtros -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden mb-6">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Filtros</h2>
    </div>
    <div class="p-4 md:p-6">
        <form method="GET" action="{{ route('consulta.ordens.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Código, descrição..." class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="aberta" {{ ($filters['status'] ?? '') === 'aberta' ? 'selected' : '' }}>Aberta</option>
                    <option value="em_andamento" {{ ($filters['status'] ?? '') === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="concluida" {{ ($filters['status'] ?? '') === 'concluida' ? 'selected' : '' }}>Concluída</option>
                    <option value="cancelada" {{ ($filters['status'] ?? '') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                <select name="tipo" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="agua" {{ ($filters['tipo'] ?? '') === 'agua' ? 'selected' : '' }}>Água</option>
                    <option value="luz" {{ ($filters['tipo'] ?? '') === 'luz' ? 'selected' : '' }}>Luz</option>
                    <option value="estrada" {{ ($filters['tipo'] ?? '') === 'estrada' ? 'selected' : '' }}>Estrada</option>
                    <option value="poco" {{ ($filters['tipo'] ?? '') === 'poco' ? 'selected' : '' }}>Poço</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prioridade</label>
                <select name="prioridade" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todas</option>
                    <option value="baixa" {{ ($filters['prioridade'] ?? '') === 'baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="media" {{ ($filters['prioridade'] ?? '') === 'media' ? 'selected' : '' }}>Média</option>
                    <option value="alta" {{ ($filters['prioridade'] ?? '') === 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="urgente" {{ ($filters['prioridade'] ?? '') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>

            <div class="md:col-span-2 lg:col-span-4 flex gap-2">
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    Filtrar
                </button>
                <a href="{{ route('consulta.ordens.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de Ordens -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Lista de Ordens de Serviço</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Demanda</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Equipe</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Data</th>
                    <th class="px-4 md:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($ordens as $ordem)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->codigo }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white hidden md:table-cell">
                        @if($ordem->demanda)
                            <a href="{{ route('consulta.demandas.show', $ordem->demanda->id) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ $ordem->demanda->codigo }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 hidden lg:table-cell">{{ $ordem->equipe->nome ?? '-' }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $status = ['aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300', 'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status[$ordem->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst(str_replace('_', ' ', $ordem->status)) }}</span>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">{{ $ordem->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('consulta.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Visualizar">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma ordem de serviço encontrada.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($ordens->hasPages())
    <div class="px-4 md:px-6 py-4 border-t border-gray-200 dark:border-slate-700">
        {{ $ordens->links() }}
    </div>
    @endif
</div>
@endsection

