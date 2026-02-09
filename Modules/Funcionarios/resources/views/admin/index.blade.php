@extends('admin.layouts.admin')

@section('title', 'Gestão de Agentes: Funcionários')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Header Premium -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-500/10 transform -rotate-3 group hover:rotate-0 transition-all duration-300">
                <x-module-icon module="Funcionarios" class="w-8 h-8" style="duotone" />
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase leading-none">Dossiê de Colaboradores</h1>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">Admin</a>
                    <x-icon name="chevron-right" class="w-2 h-2" />
                    <span class="text-emerald-600">Gestão de Recursos Humanos</span>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-gray-50 border border-gray-100 hover:bg-gray-100 rounded-xl transition-all dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                <x-icon name="chart-pie" style="duotone" class="w-4 h-4" />
                Painel Analítico
            </a>
        </div>
    </div>

    <!-- Estatísticas de Alto Nível -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats_data = [
                ['label' => 'Total de Agentes', 'value' => $estatisticas['total'] ?? 0, 'icon' => 'users', 'color' => 'indigo'],
                ['label' => 'Contas Ativas', 'value' => $estatisticas['ativos'] ?? 0, 'icon' => 'user-check', 'color' => 'emerald'],
                ['label' => 'Em Operação', 'value' => $estatisticas['com_equipe'] ?? 0, 'icon' => 'truck-fast', 'color' => 'blue'],
                ['label' => 'Disponíveis', 'value' => $estatisticas['sem_equipe'] ?? 0, 'icon' => 'user-clock', 'color' => 'amber'],
            ];
        @endphp
        @foreach($stats_data as $stat)
        <div class="premium-card p-6 flex items-center gap-5 group hover:border-{{ $stat['color'] }}-500 transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/20 flex items-center justify-center text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 group-hover:scale-110 group-hover:bg-{{ $stat['color'] }}-500 group-hover:text-white transition-all">
                <x-icon name="{{ $stat['icon'] }}" style="duotone" class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest leading-none mb-1.5">{{ $stat['label'] }}</p>
                <div class="flex items-baseline gap-1.5">
                    <p class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stat['value'] }}</p>
                    @if($stat['label'] === 'Contas Ativas')
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Filtros Inteligentes -->
    <div class="premium-card overflow-hidden">
        <form method="GET" action="{{ route('admin.funcionarios.index') }}" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                <div class="lg:col-span-5 relative group">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Rastreio de Identidade</label>
                    <div class="relative">
                        <x-icon name="magnifying-glass" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" />
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="NOME, MATRÍCULA OU DOCUMENTO..." class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white placeholder:text-slate-400 transition-all">
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Cargo / Função</label>
                    <select name="funcao" class="w-full py-3.5 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all cursor-pointer appearance-none">
                        <option value="">TODAS AS FUNÇÕES</option>
                        @php
                            $funcoes = ['eletricista', 'encanador', 'operador', 'motorista', 'supervisor', 'tecnico'];
                        @endphp
                        @foreach($funcoes as $f)
                            <option value="{{ $f }}" {{ ($filters['funcao'] ?? '') == $f ? 'selected' : '' }}>{{ strtoupper($f) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Operacional</label>
                    <select name="com_equipe" class="w-full py-3.5 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all cursor-pointer appearance-none">
                        <option value="">STATUS EQUIPE</option>
                        <option value="1" {{ ($filters['com_equipe'] ?? '') == '1' ? 'selected' : '' }}>EM EQUIPE</option>
                        <option value="0" {{ ($filters['com_equipe'] ?? '') == '0' ? 'selected' : '' }}>AVULSO / DISP.</option>
                    </select>
                </div>

                <div class="lg:col-span-3 flex gap-3">
                    <button type="submit" class="flex-1 py-3.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:opacity-90 active:scale-95 transition-all shadow-lg">
                        Filtrar Registros
                    </button>
                    <a href="{{ route('admin.funcionarios.index') }}" class="p-3.5 bg-gray-100 dark:bg-slate-800 text-slate-400 rounded-2xl hover:text-emerald-500 transition-all border border-transparent hover:border-emerald-500/20" title="Resetar Filtros">
                        <x-icon name="rotate-left" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela Estilo Operacional -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto overflow-y-hidden">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Identidade / Matrícula</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Capacitação / Cargo</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Documentação</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Status Vínculo</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Dossiê</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($funcionarios as $funcionario)
                    <tr class="group hover:bg-emerald-50/20 dark:hover:bg-slate-700/30 transition-all duration-200">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-200 dark:from-slate-900 dark:to-slate-800 flex items-center justify-center text-slate-600 font-black border border-gray-100 dark:border-slate-700 group-hover:border-emerald-300 dark:group-hover:border-emerald-500/30 transition-all shadow-sm">
                                    {{ substr($funcionario->nome, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $funcionario->nome }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] font-black font-mono text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-1.5 py-0.5 rounded border border-emerald-100 dark:border-emerald-800 uppercase">{{ $funcionario->codigo ?? 'S/ MATRÍCULA' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <x-icon name="briefcase" style="duotone" class="w-3.5 h-3.5 text-slate-400" />
                                <span class="text-[10px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">{{ $funcionario->funcao ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-mono text-slate-500 tracking-widest">{{ $funcionario->cpf ?? 'NÃO INF.' }}</span>
                        </td>
                        <td class="px-8 py-6 text-sm">
                            @if($funcionario->ativo)
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-full border border-emerald-100 dark:border-emerald-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Ativo</span>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-full border border-rose-100 dark:border-rose-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Inativo</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.funcionarios.show', $funcionario->id) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white dark:bg-slate-800 text-slate-400 hover:text-emerald-600 border border-gray-100 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-500 rounded-2xl shadow-sm transition-all group/btn">
                                <x-icon name="arrow-right" class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="max-w-xs mx-auto">
                                <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-slate-300 dark:text-slate-700">
                                    <x-icon name="user-slash" style="duotone" class="w-10 h-10" />
                                </div>
                                <h3 class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-loose">Nenhum agente localizado nos arquivos ativos.</h3>
                                <a href="{{ route('admin.funcionarios.index') }}" class="mt-4 inline-block text-[10px] font-black uppercase text-emerald-600 hover:underline">Zerar Filtros de Busca</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($funcionarios->hasPages())
        <div class="px-8 py-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-800 pagination-premium">
            {{ $funcionarios->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
