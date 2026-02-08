@extends('admin.layouts.admin')

@section('title', 'Perfil: ' . $funcionario->nome)

@section('content')
<div class="space-y-6">
    <!-- Header Simples e Elegante -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 dark:shadow-none">
                <x-module-icon module="Funcionarios" class="w-7 h-7" />
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Perfil do Funcionário</h1>
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mt-1 uppercase tracking-wider">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">Admin</a>
                    <span class="text-gray-300">/</span>
                    <a href="{{ route('admin.funcionarios.index') }}" class="hover:text-emerald-600 transition-colors">Funcionários</a>
                    <span class="text-gray-300">/</span>
                    <span class="text-emerald-600">{{ $funcionario->nome }}</span>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.funcionarios.index') }}" class="inline-flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors dark:bg-slate-800 dark:border-slate-700 dark:text-gray-400" title="Voltar">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            @if($funcionario->email)
            <a href="{{ route('admin.funcionarios.senha.show', $funcionario->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 dark:shadow-none transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                </svg>
                Gerenciar Acesso
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Coluna Esquerda: Identity Card (Sticky) -->
        <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <!-- Capa/Gradient -->
                <div class="h-24 bg-gradient-to-r from-emerald-500 to-indigo-600"></div>

                <!-- Conteúdo Profile -->
                <div class="px-6 pb-6 text-center">
                    <div class="-mt-12 mb-4">
                        <div class="w-24 h-24 mx-auto rounded-2xl bg-white dark:bg-slate-800 p-1.5 shadow-xl">
                            <div class="w-full h-full rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/40 dark:to-indigo-900/40 flex items-center justify-center text-emerald-700 dark:text-emerald-300 text-3xl font-black border border-emerald-50 dark:border-emerald-800/50">
                                {{ substr($funcionario->nome, 0, 1) }}
                            </div>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $funcionario->nome }}</h2>
                    <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 mt-1 uppercase tracking-wide">
                        {{ $funcionario->funcao ?? 'Colaborador' }}
                    </p>
                    <p class="text-xs text-gray-500 font-mono mt-1">{{ $funcionario->codigo ?? 'SEM MATRÍCULA' }}</p>

                    <div class="mt-6 flex flex-wrap justify-center gap-2">
                        @if($funcionario->ativo)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Ativo
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Inativo
                            </span>
                        @endif

                        @if($estatisticas['esta_em_equipe_ativa'])
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Em Equipe
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info Grid Quick -->
                <div class="border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-900 flex items-center justify-center text-gray-400 border border-gray-100 dark:border-slate-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">E-mail</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">{{ $funcionario->email ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-900 flex items-center justify-center text-gray-400 border border-gray-100 dark:border-slate-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Telefone</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $funcionario->telefone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Visão Rápida (Padrão PWA) -->
            <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-100 dark:shadow-none overflow-hidden relative group">
                <div class="absolute -right-6 -bottom-6 opacity-20 group-hover:scale-110 transition-transform">
                    <svg class="w-32 h-32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h4 class="text-sm font-bold uppercase tracking-widest opacity-80 mb-4 text-indigo-100">Visão do Painel</h4>
                <a href="{{ route('admin.funcionarios.login-as', $funcionario->id) }}" class="inline-flex items-center gap-2 text-white bg-indigo-500/50 hover:bg-indigo-500 px-4 py-2 rounded-xl text-sm font-bold transition-all border border-indigo-400/30">
                    Ver como o Usuário vê
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <!-- Coluna Direita: Content Area -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Estatísticas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-black uppercase text-gray-400 tracking-widest">Vínculo com Equipes</p>
                        <p class="text-xl font-black text-gray-900 dark:text-white">{{ $estatisticas['total_equipes'] ?? 0 }} <span class="text-sm font-medium text-gray-400">Equipes</span></p>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-black uppercase text-gray-400 tracking-widest">Execuções Recentes</p>
                        <p class="text-xl font-black text-gray-900 dark:text-white">{{ $ordensServico->count() }} <span class="text-sm font-medium text-gray-400">Ordens</span></p>
                    </div>
                </div>
            </div>

            <!-- Dados Profissionais -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden shadow-sm">
                <div class="px-6 py-4 bg-gray-50/80 dark:bg-slate-900/40 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-sm font-black uppercase tracking-widest text-gray-500">Dados Profissionais</h3>
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <x-detail-info label="Nome Completo" :value="$funcionario->nome" bold />
                        <x-detail-info label="CPF" :value="$funcionario->cpf ?? 'Não Informado'" />
                        <x-detail-info label="Data Admissão" :value="$funcionario->data_admissao ? $funcionario->data_admissao->format('d/m/Y') : 'Não Informada'" />
                        <x-detail-info label="Função / Cargo" :value="strtoupper($funcionario->funcao ?? 'Colaborador')" />

                        @if($funcionario->observacoes)
                        <div class="md:col-span-2">
                            <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1.5">Observações</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-slate-900/50 p-4 rounded-xl border border-gray-100 dark:border-slate-700">{{ $funcionario->observacoes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Equipes -->
            @if($funcionario->equipes->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden shadow-sm transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-sm font-black uppercase tracking-widest text-gray-500 italic">Equipes Vinculadas</h3>
                    <span class="px-2 py-1 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 rounded text-[10px] font-black uppercase tracking-widest">{{ $funcionario->equipes->count() }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead class="bg-gray-50/50 dark:bg-slate-900/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4">Equipe</th>
                                <th class="px-6 py-4">Líder</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-slate-700">
                            @foreach($funcionario->equipes as $equipe)
                            <tr class="group hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                            {{ substr($equipe->nome, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $equipe->nome }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium lowercase italic">{{ $equipe->tipo }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $equipe->lider->nome ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($equipe->ativo)
                                        <span class="text-[10px] font-black uppercase text-emerald-500 flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Ativa
                                        </span>
                                    @else
                                        <span class="text-[10px] font-black uppercase text-gray-400 flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Ociosa
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.equipes.show', $equipe->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all dark:hover:bg-indigo-900/30">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Histórico de Ordens -->
            @if(isset($ordensServico) && $ordensServico->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden shadow-sm transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-emerald-500/5 dark:bg-transparent">
                    <h3 class="text-sm font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400">Ordens em Execução / Recentes</h3>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-black uppercase tracking-wider">Tempo Real</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead class="bg-gray-50/50 dark:bg-slate-900/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4">O.S #</th>
                                <th class="px-6 py-4">Equipe Responsável</th>
                                <th class="px-6 py-4">Status Atual</th>
                                <th class="px-6 py-4">Data Registro</th>
                                <th class="px-6 py-4 text-right">Ver</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-slate-700">
                            @foreach($ordensServico as $ordem)
                            <tr class="group hover:bg-emerald-50/30 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-black text-gray-900 dark:text-white">#{{ $ordem->numero }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $ordem->equipe->nome ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusStyles = [
                                            'pendente' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                            'em_execucao' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400',
                                            'concluida' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400',
                                            'cancelada' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400'
                                        ];
                                        $currentStyle = $statusStyles[$ordem->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-tight {{ $currentStyle }}">
                                        {{ str_replace('_', ' ', $ordem->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-500 font-medium">{{ $ordem->data_abertura ? $ordem->data_abertura->format('d/m/Y') : '-' }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-emerald-600 hover:bg-emerald-100 rounded-lg transition-all dark:hover:bg-emerald-900/30">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
