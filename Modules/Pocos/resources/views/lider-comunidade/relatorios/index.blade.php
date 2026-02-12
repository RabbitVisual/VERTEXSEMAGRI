@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Análise Fiscal</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Consolidado de arrecadação e movimentação da comunidade</p>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('lider-comunidade.relatorios.export', request()->all()) }}" class="px-5 py-2.5 bg-emerald-600/10 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-200 dark:border-emerald-600/20 rounded-xl font-bold transition-all shadow-sm flex items-center gap-2">
                <x-icon name="download" class="w-5 h-5" />
                <span>Exportar Excel</span>
            </a>
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
                    <x-icon name="currency-dollar" class="w-5 h-5" />
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white">R$ {{ number_format($totalArrecadado, 2, ',', '.') }}</p>
        </div>

        <div class="premium-card p-6 border-l-4 border-l-blue-500">
             <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Total de Transações</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                    <x-icon name="clipboard-list" class="w-5 h-5" />
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $pagamentos->count() }}</p>
        </div>
    </div>

    <!-- Tabela de Movimentações -->
    <div class="premium-card overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Histórico de Pagamentos</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Listagem detalhada das transações no período</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800 text-left">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Data</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Morador</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Forma</th>
                         <th class="px-6 py-4 text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest text-right">Valor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($pagamentos as $pagamento)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-blue-600 transition-colors">
                                    {{ $pagamento->usuarioPoco->nome ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                         <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border {{ $pagamento->forma_pagamento == 'pix' ? 'bg-cyan-50 text-cyan-700 border-cyan-100' : 'bg-gray-50 text-gray-600 border-gray-200' }}">
                                {{ $pagamento->forma_pagamento }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             <span class="text-sm font-black text-emerald-600">
                                + R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-gray-50 dark:bg-slate-800 flex items-center justify-center text-gray-400">
                                    <x-icon name="file-search" class="w-8 h-8" />
                                </div>
                                <p class="text-base font-bold text-gray-900 dark:text-white">Nenhuma movimentação encontrada</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tente ajustar os filtros de data acima</p>
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
