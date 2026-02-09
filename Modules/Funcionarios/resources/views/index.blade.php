@extends('Co-Admin.layouts.app')

@section('title', 'Gestão de Funcionários')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header Premium -->
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 rounded-3xl shadow-2xl p-8 md:p-12 text-white">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 opacity-10 pointer-events-none">
            <x-icon name="users" style="duotone" class="w-96 h-96" />
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-white/20 rounded-[2rem] backdrop-blur-xl flex items-center justify-center shadow-inner border border-white/30 transform transition-transform hover:rotate-6">
                    <x-module-icon module="Funcionarios" class="w-10 h-10 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight uppercase leading-none mb-3">Gestão de Agentes</h1>
                    <p class="text-emerald-50 text-xs md:text-sm font-black uppercase tracking-[0.3em] opacity-80 italic">Operacionalização de Recursos Humanos</p>
                </div>
            </div>

            <a href="{{ route('funcionarios.create') }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-emerald-700 rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-xl hover:shadow-2xl hover:-translate-y-1 active:scale-95 transition-all">
                <x-icon name="plus" class="w-4 h-4" />
                Novo Recrutamento
            </a>
        </div>
    </div>

    <!-- Alertas de Sistema -->
    @if(session('success') || session('error') || session('warning'))
    <div class="space-y-4">
        @if(session('success'))
            <div class="p-5 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800 rounded-2xl flex items-center gap-4 text-emerald-800 dark:text-emerald-400 animate-scale-in">
                <x-icon name="circle-check" style="duotone" class="w-6 h-6" />
                <span class="text-xs font-black uppercase tracking-tight">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-5 bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-800 rounded-2xl flex items-center gap-4 text-rose-800 dark:text-rose-400 animate-scale-in">
                <x-icon name="triangle-exclamation" style="duotone" class="w-6 h-6" />
                <span class="text-xs font-black uppercase tracking-tight">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    @endif

    <!-- Painel de Performance Operacional -->
    @if(isset($stats))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $co_stats = [
                ['label' => 'Total de Agentes', 'value' => $stats['total'] ?? 0, 'icon' => 'users', 'color' => 'indigo'],
                ['label' => 'Efetivos Ativos', 'value' => $stats['ativos'] ?? 0, 'icon' => 'user-check', 'color' => 'emerald'],
                ['label' => 'Alocados em Campo', 'value' => $stats['com_equipe'] ?? 0, 'icon' => 'truck-fast', 'color' => 'blue'],
                ['label' => 'Disponibilidade', 'value' => $stats['sem_equipe'] ?? 0, 'icon' => 'user-clock', 'color' => 'amber'],
            ];
        @endphp
        @foreach($co_stats as $stat)
        <div class="premium-card p-6 flex flex-col justify-between group hover:border-{{ $stat['color'] }}-500 transition-all duration-500 overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 pointer-events-none group-hover:scale-110 transition-transform">
                <x-icon name="{{ $stat['icon'] }}" class="w-24 h-24" />
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/20 flex items-center justify-center text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 group-hover:bg-{{ $stat['color'] }}-500 group-hover:text-white transition-all shadow-sm">
                    <x-icon name="{{ $stat['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-[10px] font-black uppercase text-slate-300 italic">Módulo RH</div>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest leading-none mb-2">{{ $stat['label'] }}</p>
                <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Filtros Táticos -->
    <div class="premium-card overflow-hidden">
        <form method="GET" action="{{ route('funcionarios.index') }}" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                <div class="lg:col-span-5 relative group">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Rastreio de Registro</label>
                    <div class="relative">
                        <x-icon name="magnifying-glass" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" />
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="BUSCAR POR NOME OU MATRÍCULA..." class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white placeholder:text-slate-400 transition-all">
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Qualificação</label>
                    <select name="funcao" class="w-full py-4 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all cursor-pointer appearance-none">
                        <option value="">TODAS AS FUNÇÕES</option>
                        @php
                            $co_funcoes = ['eletricista', 'encanador', 'operador', 'motorista', 'supervisor', 'tecnico', 'outro'];
                        @endphp
                        @foreach($co_funcoes as $f)
                            <option value="{{ $f }}" {{ request('funcao') == $f ? 'selected' : '' }}>{{ strtoupper($f) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-2 flex items-center justify-center p-4 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl h-[58px]">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="ativo" id="filtro_ativo" value="1" {{ request('ativo') == '1' ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-gray-300 text-emerald-600 focus:ring-emerald-500 bg-white dark:bg-slate-800">
                        <label for="filtro_ativo" class="text-[9px] font-black uppercase text-slate-500 dark:text-slate-400 tracking-widest cursor-pointer">Apenas Ativos</label>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 active:scale-95 transition-all shadow-lg shadow-emerald-600/20">
                        Aplicar Filtros
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela de Inteligência de Recursos -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Identificação de Agente</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Qualificação</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Operacional</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($funcionarios as $funcionario)
                    <tr class="group hover:bg-emerald-50/20 dark:hover:bg-slate-700/30 transition-all duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-200 dark:from-slate-900 dark:to-slate-800 flex items-center justify-center text-slate-600 font-black border-2 border-white dark:border-slate-700 shadow-xl group-hover:scale-105 group-hover:border-emerald-200 transition-all">
                                    {{ substr($funcionario->nome, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $funcionario->nome }}</span>
                                    <span class="text-[9px] font-black font-mono text-slate-400 uppercase tracking-widest mt-1">{{ $funcionario->codigo ?? 'SEM MATRÍCULA' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">{{ $funcionario->funcao ?? '-' }}</span>
                                <span class="text-[9px] font-bold text-slate-400 tracking-tighter">{{ $funcionario->cpf ?? '' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                @if($funcionario->ativo)
                                    <div class="p-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                        <x-icon name="check" class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400">Ativo</span>
                                @else
                                    <div class="p-1 bg-rose-100 dark:bg-rose-900/30 rounded-lg">
                                        <x-icon name="xmark" class="w-3.5 h-3.5 text-rose-600 dark:text-rose-400" />
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-widest text-rose-600 dark:text-rose-400">Inativo</span>
                                @endif

                                @if($funcionario->equipes && $funcionario->equipes->count() > 0)
                                    <div class="ml-2 flex items-center gap-1.5 px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30 rounded-full">
                                        <x-icon name="user-group" class="w-2.5 h-2.5" />
                                        <span class="text-[8px] font-black uppercase tracking-tighter">Em Equipe</span>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('funcionarios.show', $funcionario->id) }}" class="w-10 h-10 flex items-center justify-center bg-gray-50 dark:bg-slate-800 text-slate-400 hover:text-emerald-600 rounded-xl transition-all hover:shadow-lg border border-transparent hover:border-emerald-200 dark:hover:border-emerald-900/50">
                                    <x-icon name="eye" class="w-5 h-5" />
                                </a>
                                <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="w-10 h-10 flex items-center justify-center bg-gray-50 dark:bg-slate-800 text-slate-400 hover:text-indigo-600 rounded-xl transition-all hover:shadow-lg border border-transparent hover:border-indigo-200 dark:hover:border-indigo-900/50">
                                    <x-icon name="pen-to-square" class="w-5 h-5" />
                                </a>
                                <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" class="inline" onsubmit="return confirm('ATENÇÃO: Deseja realmente excluir este agente do sistema?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center bg-gray-50 dark:bg-slate-800 text-slate-400 hover:text-rose-600 rounded-xl transition-all hover:shadow-lg border border-transparent hover:border-rose-200 dark:hover:border-rose-900/50">
                                        <x-icon name="trash-can" class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-32 text-center">
                            <div class="max-w-xs mx-auto space-y-4">
                                <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-[2.5rem] flex items-center justify-center mx-auto text-slate-200 dark:text-slate-800">
                                    <x-icon name="user-slash" style="duotone" class="w-12 h-12" />
                                </div>
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] leading-relaxed">Nenhum agente operacional localizado com os parâmetros definidos.</p>
                                <a href="{{ route('funcionarios.index') }}" class="text-[10px] font-black uppercase text-emerald-600 hover:underline tracking-widest decoration-2 underline-offset-4">Limpar Critérios</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($funcionarios->hasPages())
        <div class="px-8 py-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-800">
            {{ $funcionarios->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
