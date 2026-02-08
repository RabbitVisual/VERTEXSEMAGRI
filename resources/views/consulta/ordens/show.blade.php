@extends('consulta.layouts.consulta')

@section('title', 'Ordem de Serviço #' . $ordem->codigo . ' - Consulta')

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
                <span>Ordem de Serviço #{{ $ordem->codigo }}</span>
                <span class="text-sm bg-blue-500/20 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full border border-blue-300 dark:border-blue-700">Somente Leitura</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('consulta.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Consulta</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('consulta.ordens.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Ordens de Serviço</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white">#{{ $ordem->codigo }}</span>
            </nav>
        </div>
        <a href="{{ route('consulta.ordens.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Informações da Ordem -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Dados Principais -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Informações da Ordem de Serviço</h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código</label>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $ordem->codigo }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        @php
                            $status = ['aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300', 'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status[$ordem->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst(str_replace('_', ' ', $ordem->status)) }}</span>
                    </div>
                    @if($ordem->demanda)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Demanda Relacionada</label>
                        <a href="{{ route('consulta.demandas.show', $ordem->demanda->id) }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ $ordem->demanda->codigo }}
                        </a>
                    </div>
                    @endif
                    @if($ordem->equipe)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Equipe</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $ordem->equipe->nome }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Abertura</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $ordem->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($ordem->data_inicio)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Início</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $ordem->data_inicio->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                    @if($ordem->data_conclusao)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Conclusão</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $ordem->data_conclusao->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                    @if($ordem->descricao)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $ordem->descricao }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        @if($ordem->usuarioAbertura)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Usuário de Abertura</h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->usuarioAbertura->name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $ordem->usuarioAbertura->email }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($ordem->usuarioExecucao)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Usuário de Execução</h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->usuarioExecucao->name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $ordem->usuarioExecucao->email }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

