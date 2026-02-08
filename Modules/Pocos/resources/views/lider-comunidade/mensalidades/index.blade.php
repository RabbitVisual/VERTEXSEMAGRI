@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Mensalidades')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-blue-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Fluxo de Cobrança</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Arrecadação mensal e controle de ciclos financeiros</p>
            </div>
        </div>
        <a href="{{ route('lider-comunidade.mensalidades.create') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-xs font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 active:scale-95 transition-all uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Abrir Ciclo
        </a>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('lider-comunidade.mensalidades.index') }}" class="premium-card p-5">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Mês</label>
                <select name="mes" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all">
                    <option value="">Todos</option>
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Ano</label>
                <input type="number" name="ano" value="{{ request('ano') }}" min="2020" max="2100" placeholder="Ex: 2025" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all">
            </div>
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all">
                    <option value="">Todos os Status</option>
                    <option value="aberta" {{ request('status') === 'aberta' ? 'selected' : '' }}>Aberta</option>
                    <option value="fechada" {{ request('status') === 'fechada' ? 'selected' : '' }}>Fechada</option>
                    <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-[0.98]">
                    Aplicar Filtros
                </button>
            </div>
        </div>
    </form>

    <!-- Tabela -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Referência</th>
                        <th scope="col" class="px-6 py-4 font-bold">Valor Base</th>
                        <th scope="col" class="px-6 py-4 font-bold">Vencimento</th>
                        <th scope="col" class="px-6 py-4 font-bold">Resumo Financeiro</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($mensalidades as $mensalidade)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $mensalidade->mes_ano }}</div>
                            <div class="text-[10px] text-gray-400 uppercase font-black italic">Ciclo de Cobrança</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900 dark:text-white font-black">R$ {{ number_format($mensalidade->valor_mensalidade, 2, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-600 dark:text-slate-400 font-medium">{{ $mensalidade->data_vencimento->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Pago:</span>
                                    <span class="text-xs font-black text-emerald-600 dark:text-emerald-400">R$ {{ number_format($mensalidade->total_arrecadado, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Pendente:</span>
                                    <span class="text-xs font-black text-amber-600 dark:text-amber-400">R$ {{ number_format($mensalidade->total_pendente, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $mensalidade->status === 'aberta' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' : ($mensalidade->status === 'fechada' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-400') }}">
                                {{ $mensalidade->status_texto }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('lider-comunidade.mensalidades.show', $mensalidade->id) }}" class="inline-flex items-center gap-1 text-xs font-black text-blue-600 hover:text-blue-700 dark:text-blue-400 uppercase tracking-tighter hover:underline">
                                Detalhes
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                                <p class="text-sm font-bold text-gray-500 dark:text-slate-400">Nenhuma mensalidade encontrada</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mensalidades->hasPages())
        <div class="p-6 border-t border-gray-100 dark:border-slate-800">
            {{ $mensalidades->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
