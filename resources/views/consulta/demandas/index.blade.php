@extends('consulta.layouts.consulta')

@php
use App\Helpers\LgpdHelper;
@endphp

@section('title', 'Demandas - Consulta')

@section('content')
<!-- Alerta LGPD -->
<div class="mb-6 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-4">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-200">Proteção de Dados (LGPD)</h3>
            <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">Dados pessoais sensíveis estão mascarados para proteção conforme Lei nº 13.709/2018.</p>
        </div>
    </div>
</div>

<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <span>Demandas</span>
                <span class="text-sm bg-blue-500/20 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full border border-blue-300 dark:border-blue-700">Somente Leitura</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('consulta.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Consulta</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white">Demandas</span>
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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Total</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Urgentes</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['urgentes'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-slate-500 to-slate-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
        </div>
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Sem OS</h3>
        <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['sem_os'] }}</p>
    </div>
</div>

<!-- Estatísticas por Tipo -->
@if(isset($estatisticas['por_tipo']))
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden mb-6 md:mb-8">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Demandas por Tipo</h2>
    </div>
    <div class="p-4 md:p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728m0 0l-2.25-2.25m2.25 2.25l-2.25 2.25m-12.728-6a9 9 0 010-12.728m0 0l2.25 2.25m-2.25-2.25l2.25-2.25" />
                </svg>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['por_tipo']['agua'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Água</div>
            </div>
            <div class="text-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                <svg class="w-8 h-8 text-amber-600 dark:text-amber-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m4.5 0a12.05 12.05 0 004.5 0m0 0a12.05 12.05 0 00-4.5 0m4.5 0v5.25M9 18v-5.25m0 0a6.01 6.01 0 00-1.5-.189M9 12.75a6.01 6.01 0 011.5-.189m-1.5.189a6.01 6.01 0 00-1.5-.189m1.5.189v5.25m0 0a12.05 12.05 0 01-4.5 0m4.5 0v5.25" />
                </svg>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['por_tipo']['luz'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Iluminação</div>
            </div>
            <div class="text-center p-4 bg-violet-50 dark:bg-violet-900/20 rounded-lg">
                <svg class="w-8 h-8 text-violet-600 dark:text-violet-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['por_tipo']['estrada'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Estrada</div>
            </div>
            <div class="text-center p-4 bg-cyan-50 dark:bg-cyan-900/20 rounded-lg">
                <svg class="w-8 h-8 text-cyan-600 dark:text-cyan-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728m0 0l-2.25-2.25m2.25 2.25l-2.25 2.25m-12.728-6a9 9 0 010-12.728m0 0l2.25 2.25m-2.25-2.25l2.25-2.25" />
                </svg>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['por_tipo']['poco'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Poço</div>
            </div>
        </div>
    </div>
</div>
@endif
@endif

<!-- Filtros -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden mb-6">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Filtros</h2>
    </div>
    <div class="p-4 md:p-6">
        <form method="GET" action="{{ route('consulta.demandas.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Código..." class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localidade</label>
                <select name="localidade_id" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todas</option>
                    @foreach($localidades as $localidade)
                        <option value="{{ $localidade->id }}" {{ ($filters['localidade_id'] ?? '') == $localidade->id ? 'selected' : '' }}>{{ $localidade->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 lg:col-span-5 flex gap-2">
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    Filtrar
                </button>
                <a href="{{ route('consulta.demandas.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de Demandas -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
            Lista de Demandas (Dados Protegidos - LGPD)
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Solicitante</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Localidade</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Prioridade</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Data</th>
                    <th class="px-4 md:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($demandas as $demanda)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $demanda->codigo }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <span class="text-sm text-gray-900 dark:text-white">{{ LgpdHelper::maskName($demanda->solicitante_nome) }}</span>
                        </div>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">{{ $demanda->localidade->nome ?? '-' }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $tipos = ['agua' => 'Água', 'luz' => 'Luz', 'estrada' => 'Estrada', 'poco' => 'Poço'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ $tipos[$demanda->tipo] ?? $demanda->tipo }}</span>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm hidden lg:table-cell">
                        @php
                            $prioridades = ['baixa' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'media' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'alta' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300', 'urgente' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $prioridades[$demanda->prioridade] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst($demanda->prioridade) }}</span>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $status = ['aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300', 'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status[$demanda->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst(str_replace('_', ' ', $demanda->status)) }}</span>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">
                        @if($demanda->data_abertura instanceof \Carbon\Carbon)
                            {{ $demanda->data_abertura->format('d/m/Y') }}
                        @elseif(is_string($demanda->data_abertura))
                            {{ \Carbon\Carbon::parse($demanda->data_abertura)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('consulta.demandas.show', $demanda->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Visualizar">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma demanda encontrada.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($demandas->hasPages())
    <div class="px-4 md:px-6 py-4 border-t border-gray-200 dark:border-slate-700">
        {{ $demandas->links() }}
    </div>
    @endif
</div>
@endsection
