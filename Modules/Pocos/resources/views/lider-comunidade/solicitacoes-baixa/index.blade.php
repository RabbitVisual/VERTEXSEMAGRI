@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Solicitações de Baixa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.dashboard') }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Solicitações de Baixa</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Analise os comprovantes enviados pelos moradores</p>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <!-- Filtros -->
    <form method="GET" action="{{ route('lider-comunidade.solicitacoes-baixa.index') }}" class="premium-card p-5">
        <div class="flex flex-wrap items-end gap-6">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Filtrar por Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="">Todas as Solicitações</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="aprovada" {{ request('status') == 'aprovada' ? 'selected' : '' }}>Aprovada</option>
                    <option value="rejeitada" {{ request('status') == 'rejeitada' ? 'selected' : '' }}>Rejeitada</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                    Filtrar
                </button>
                @if(request('status'))
                <a href="{{ route('lider-comunidade.solicitacoes-baixa.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 dark:bg-slate-800 rounded-xl hover:bg-gray-200 transition-all active:scale-95 uppercase tracking-tighter">
                    Limpar
                </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Tabela Premium -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/30 dark:bg-slate-900/50">
            <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Lista de Pedidos ({{ $solicitacoes->total() }})</h2>
        </div>
        <div class="overflow-x-auto">
            @if($solicitacoes->count() > 0)
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Usuário / Referência</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Valor do Pagamento</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold">Data do Envio</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @foreach($solicitacoes as $solicitacao)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $solicitacao->usuarioPoco->nome }}</div>
                            <div class="text-[10px] text-gray-400 uppercase font-black italic">Mensalidade {{ $solicitacao->mensalidade->mes_ano }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm font-black text-gray-900 dark:text-white">R$ {{ number_format($solicitacao->valor_pago, 2, ',', '.') }}</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-tighter italic">Pago em {{ $solicitacao->data_pagamento->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $solicitacao->status === 'aprovada' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : ($solicitacao->status === 'rejeitada' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/20 dark:text-amber-400') }}">
                                {{ $solicitacao->status_texto }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-500 font-medium">{{ $solicitacao->created_at->format('d/m/Y') }}</div>
                            <div class="text-[10px] text-gray-400">{{ $solicitacao->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('lider-comunidade.solicitacoes-baixa.show', $solicitacao->id) }}" class="inline-flex items-center gap-1 text-xs font-black text-blue-600 hover:text-blue-700 dark:text-blue-400 uppercase tracking-tighter hover:underline">
                                Analisar
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($solicitacoes->hasPages())
            <div class="p-6 border-t border-gray-100 dark:border-slate-800">
                {{ $solicitacoes->links() }}
            </div>
            @endif
            @else
            <div class="p-16 text-center">
                <div class="flex flex-col items-center gap-3">
                    <svg class="w-12 h-12 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest">Nenhuma solicitação encontrada</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
