@extends('campo.layouts.app')

@section('title', 'Requisições de Insumos')

@section('breadcrumbs')
    <x-icon name="chevron-right" class="w-2 h-2" />
    <span class="text-emerald-600">Gestão de Insumos</span>
@endsection

@section('content')
<div class="space-y-6 md:space-y-10 animate-fade-in pb-12">
    <!-- Header de Logística -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl flex items-center justify-center text-white shadow-2xl transform rotate-3 hover:rotate-0 transition-all">
                <x-icon name="truck-ramp-box" style="duotone" class="w-8 h-8" />
            </div>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase leading-none">Fluxo de Materiais</h1>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-2 italic">Acompanhamento de Requisições de Campo</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="px-5 py-3 bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30 rounded-2xl flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ $solicitacoes->total() }} Requisições Iniciadas</span>
            </div>
        </div>
    </div>

    <!-- Guia de Procedimento Tático -->
    <div class="premium-card p-8 bg-gradient-to-r from-blue-500/5 to-indigo-500/5 border-blue-500/20 overflow-hidden relative group">
        <div class="absolute right-0 top-0 p-8 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform duration-700">
            <x-icon name="circle-info" class="w-40 h-40" />
        </div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1 border-r border-gray-100 dark:border-slate-800 pr-8">
                <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight mb-2">Protocolo de Requisição</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Siga as diretrizes para aprovação rápida</p>
            </div>
            <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-start gap-4">
                    <div class="text-xl font-black text-blue-500 flex-shrink-0">01.</div>
                    <p class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase leading-relaxed tracking-wide">Identifique o material sem estoque no ato da execução.</p>
                </div>
                <div class="flex items-start gap-4">
                    <div class="text-xl font-black text-emerald-500 flex-shrink-0">02.</div>
                    <p class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase leading-relaxed tracking-wide">A Central de Comando analisa e processa a ordem de compra.</p>
                </div>
                <div class="flex items-start gap-4">
                    <div class="text-xl font-black text-amber-500 flex-shrink-0">03.</div>
                    <p class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase leading-relaxed tracking-wide">Monitore o status: Pendente → Processada → Disponível.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de Rastreio -->
    <div class="premium-card overflow-hidden">
        <form method="GET" action="{{ route('campo.materiais.solicitacoes.index') }}" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-end">
                <div class="md:col-span-6 lg:col-span-8">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-2 ml-1 italic">Vetor de Status</label>
                    <div class="relative">
                        <x-icon name="filter" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                        <select name="status" class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-slate-900/50 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 dark:text-white appearance-none cursor-pointer">
                            <option value="">FILTRAR POR STATUS DE PROCESSAMENTO</option>
                            <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>PENDENTE (EM ANÁLISE)</option>
                            <option value="processada" {{ request('status') === 'processada' ? 'selected' : '' }}>PROCESSADA (APROVADO)</option>
                            <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>CANCELADA</option>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-6 lg:col-span-4 flex gap-3">
                    <button type="submit" class="flex-1 py-4 bg-blue-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-blue-700 active:scale-95 transition-all shadow-lg shadow-blue-600/20">
                        Sincronizar Lista
                    </button>
                    <a href="{{ route('campo.materiais.solicitacoes.index') }}" class="p-4 bg-gray-100 dark:bg-slate-800 text-slate-400 rounded-2xl hover:text-blue-500 transition-all border border-transparent hover:border-blue-500/20" title="Resetar Filtros">
                        <x-icon name="rotate-left" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela de Logística -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto overflow-y-hidden">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Material / Identificação</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Carga Requisitada</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Vínculo O.S</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Status Atual</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">Registro</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($solicitacoes as $solicitacao)
                    <tr class="group hover:bg-blue-50/30 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600">
                                    <x-icon name="box-open" class="w-5 h-5" />
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $solicitacao->material_nome }}</p>
                                    @if($solicitacao->material_codigo)
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Cód: {{ $solicitacao->material_codigo }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-black text-gray-900 dark:text-white tracking-tighter">{{ number_format($solicitacao->quantidade, 2, ',', '.') }}</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">{{ $solicitacao->unidade_medida }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($solicitacao->ordemServico)
                                <a href="{{ route('campo.ordens.show', $solicitacao->ordem_servico_id) }}" class="inline-flex items-center gap-2 group/link">
                                    <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest decoration-2 underline-offset-4 group-hover/link:underline">#{{ $solicitacao->ordemServico->numero }}</span>
                                    <x-icon name="arrow-up-right-from-square" class="w-3 h-3 text-slate-300 group-hover/link:text-indigo-500 transition-colors" />
                                </a>
                            @else
                                <span class="text-[10px] font-black text-slate-300 uppercase italic">Avulso</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $s_map = [
                                    'pendente' => ['c' => 'amber', 'l' => 'EM ANÁLISE'],
                                    'processada' => ['c' => 'emerald', 'l' => 'PROCESSADA'],
                                    'cancelada' => ['c' => 'rose', 'l' => 'CANCELADA']
                                ];
                                $s = $s_map[$solicitacao->status] ?? ['c' => 'slate', 'l' => 'DESCONHECIDO'];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-{{ $s['c'] }}-100 dark:bg-{{ $s['c'] }}-900/30 text-{{ $s['c'] }}-600 dark:text-{{ $s['c'] }}-400 rounded-lg text-[8px] font-black uppercase tracking-widest border border-{{ $s['c'] }}-200 dark:border-{{ $s['c'] }}-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $s['c'] }}-500"></span>
                                {{ $s['l'] }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-right">
                                <p class="text-[10px] font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $solicitacao->created_at->format('d/m/Y') }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $solicitacao->created_at->format('H:i') }}</p>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-slate-200">
                                <x-icon name="magnifying-glass-chart" style="duotone" class="w-10 h-10" />
                            </div>
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] italic">Nenhuma Requisição Registrada</h3>
                            <p class="text-[10px] text-slate-500 font-medium mt-2">Suas solicitações aparecerão aqui conforme forem geradas em campo.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($solicitacoes->hasPages())
        <div class="p-8 border-t border-gray-50 dark:border-slate-800 bg-gray-50/20 dark:bg-slate-950/20">
            {{ $solicitacoes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
