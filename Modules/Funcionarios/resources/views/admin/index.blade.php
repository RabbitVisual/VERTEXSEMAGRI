@extends('admin.layouts.admin')

@section('title', 'Funcionários - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header Premium -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 dark:shadow-none">
                <x-module-icon module="Funcionarios" class="w-7 h-7" />
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight text-shadow-sm">Gestão de Funcionários</h1>
                <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mt-1 uppercase tracking-widest">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">Admin</a>
                    <span class="text-gray-300">/</span>
                    <span class="text-emerald-600">Lista de Colaboradores</span>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors dark:bg-slate-800 dark:border-slate-700 dark:text-gray-400" title="Dashboard">
                <x-icon name="eye" class="w-5 h-5" />
                Painel Padrão
            </a>
        </div>
    </div>

    <!-- Estatísticas Estilizadas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4 group hover:border-indigo-300 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Registros Totais</p>
                <p class="text-xl font-black text-gray-900 dark:text-white">{{ $estatisticas['total'] ?? 0 }}</p>
            </div>
        </div>

        <!-- Ativos -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4 group hover:border-emerald-300 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Contas Ativas</p>
                <div class="flex items-center gap-2">
                    <p class="text-xl font-black text-gray-900 dark:text-white">{{ $estatisticas['ativos'] ?? 0 }}</p>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </div>
            </div>
        </div>

        <!-- Com Equipe -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4 group hover:border-blue-300 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Em Operação</p>
                <p class="text-xl font-black text-gray-900 dark:text-white">{{ $estatisticas['com_equipe'] ?? 0 }} <span class="text-xs font-bold text-gray-400">Em Equipe</span></p>
            </div>
        </div>

        <!-- Sem Equipe -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm flex items-center gap-4 group hover:border-amber-300 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Atenção</p>
                <p class="text-xl font-black text-gray-900 dark:text-white">{{ $estatisticas['sem_equipe'] ?? 0 }} <span class="text-xs font-bold text-gray-400 text-amber-500">Disponíveis</span></p>
            </div>
        </div>
    </div>
    @endif

    <!-- Filtros Inteligentes -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <form method="GET" action="{{ route('admin.funcionarios.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2">
                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1.5 ml-1">Palavra-chave</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nome, Matrícula ou CPF..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 dark:text-white transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1.5 ml-1">Função</label>
                    <select name="funcao" class="w-full py-2.5 text-sm bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 dark:text-white appearance-none cursor-pointer">
                        <option value="">Todas as Funções</option>
                        <option value="eletricista" {{ ($filters['funcao'] ?? '') == 'eletricista' ? 'selected' : '' }}>Eletricista</option>
                        <option value="encanador" {{ ($filters['funcao'] ?? '') == 'encanador' ? 'selected' : '' }}>Encanador</option>
                        <option value="operador" {{ ($filters['funcao'] ?? '') == 'operador' ? 'selected' : '' }}>Operador</option>
                        <option value="motorista" {{ ($filters['funcao'] ?? '') == 'motorista' ? 'selected' : '' }}>Motorista</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1.5 ml-1">Operacional</label>
                    <select name="com_equipe" class="w-full py-2.5 text-sm bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 dark:text-white appearance-none cursor-pointer">
                        <option value="">Status Equipe</option>
                        <option value="1" {{ ($filters['com_equipe'] ?? '') == '1' ? 'selected' : '' }}>Sim (Em Equipe)</option>
                        <option value="0" {{ ($filters['com_equipe'] ?? '') == '0' ? 'selected' : '' }}>Não (Avulso)</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-sm font-bold hover:opacity-90 transition-opacity">
                        Aplicar
                    </button>
                    <a href="{{ route('admin.funcionarios.index') }}" class="p-2.5 bg-gray-100 dark:bg-slate-700 text-gray-500 rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors" title="Limpar Filtros">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela Estilo Member List -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest border-b border-gray-100 dark:border-slate-700">Identificação</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest border-b border-gray-100 dark:border-slate-700">Função / Cargo</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest border-b border-gray-100 dark:border-slate-700">Documento</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest border-b border-gray-100 dark:border-slate-700">Status</th>
                        <th class="px-6 py-4 text-right text-[10px] font-black uppercase text-gray-400 tracking-widest border-b border-gray-100 dark:border-slate-700">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700">
                    @forelse($funcionarios as $funcionario)
                    <tr class="group hover:bg-emerald-50/30 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-900 dark:to-slate-800 flex items-center justify-center text-gray-500 font-bold border border-gray-100 dark:border-slate-700 group-hover:border-emerald-200 transition-colors">
                                    {{ substr($funcionario->nome, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900 dark:text-white leading-tight">{{ $funcionario->nome }}</span>
                                    <span class="text-[10px] font-mono text-gray-400 uppercase tracking-tighter">{{ $funcionario->codigo ?? 'S/ MATRÍCULA' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ $funcionario->funcao ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-gray-500 font-medium">{{ $funcionario->cpf ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($funcionario->ativo)
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-[10px] font-black uppercase text-emerald-600 dark:text-emerald-400">Ativo</span>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    <span class="text-[10px] font-black uppercase text-gray-400">Inativo</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.funcionarios.show', $funcionario->id) }}" class="inline-flex items-center justify-center w-9 h-9 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-xl transition-all border border-transparent hover:border-emerald-100 dark:hover:border-emerald-800">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-500 dark:text-gray-400 italic">Nenhum colaborador encontrado com os filtros aplicados.</p>
                                <a href="{{ route('admin.funcionarios.index') }}" class="mt-4 text-xs font-black uppercase text-emerald-600 hover:underline">Zerar Filtros</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($funcionarios->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/30 dark:bg-slate-900/20">
            {{ $funcionarios->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
