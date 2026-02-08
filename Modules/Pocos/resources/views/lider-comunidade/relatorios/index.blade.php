@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Análise Fiscal</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Consolidado de arrecadação e movimentação da comunidade</p>
            </div>
        </div>
    </div>

    <!-- Filtros Inteligentes -->
    <form method="GET" action="{{ route('lider-comunidade.relatorios.index') }}" class="premium-card p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Data de Início</label>
                <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Data de Término</label>
                <input type="date" name="data_fim" value="{{ $dataFim }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                    Atualizar Relatório
                </button>
            </div>
        </div>
    </form>

    <!-- Cards de Resumo Modernos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="premium-card p-6 border-l-4 border-l-emerald-500">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Total Arrecadado</p>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tighter">R$ {{ number_format($totalArrecadado, 2, ',', '.') }}</p>
            <p class="mt-2 text-[10px] font-bold text-gray-400 uppercase italic">Referência ao período selecionado</p>
        </div>

        <div class="premium-card p-6 border-l-4 border-l-blue-500">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Transações</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-blue-600 dark:text-blue-400 tracking-tighter">{{ $totalPagamentos }}</p>
            <p class="mt-2 text-[10px] font-bold text-gray-400 uppercase italic">Pagamentos confirmados</p>
        </div>
    </div>

    <!-- Tabela de Movimentação -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/30 dark:bg-slate-900/50">
            <h2 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">Movimentações Detalhadas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Data</th>
                        <th scope="col" class="px-6 py-4 font-bold">Doador / Morador</th>
                        <th scope="col" class="px-6 py-4 font-bold">Referência</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Valor</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Método</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($pagamentos as $pagamento)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $pagamento->data_pagamento->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $pagamento->usuarioPoco->nome }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[10px] text-gray-400 uppercase font-black italic">Mês {{ $pagamento->mensalidade->mes }}/{{ $pagamento->mensalidade->ano }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="font-black text-emerald-600 dark:text-emerald-400">R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[10px] font-black text-gray-500 dark:text-slate-400 uppercase tracking-tighter">{{ $pagamento->forma_pagamento_texto }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                                <p class="text-sm font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest">Nenhuma movimentação no período</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
