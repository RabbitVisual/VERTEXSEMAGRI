@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Mensalidades')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                <x-icon name="calendar-days" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Fluxo de Cobrança</h1>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                    <span>Arrecadação Mensal</span>
                    <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                    <span class="text-blue-600">Gestão de Ciclos</span>
                </nav>
            </div>
        </div>
        <a href="{{ route('lider-comunidade.mensalidades.create') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-xs font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 active:scale-95 transition-all uppercase tracking-widest group">
            <x-icon name="calendar-plus" style="duotone" class="w-5 h-5 group-hover:rotate-12 transition-transform" />
            Abrir Novo Ciclo
        </a>
    </div>

    <!-- Filtros Avançados -->
    <div class="premium-card p-6 md:p-8">
        <form method="GET" action="{{ route('lider-comunidade.mensalidades.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Mês de Referência</label>
                <select name="mes" class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                    <option value="">Todo o Ano</option>
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ \Carbon\Carbon::create(null, $i)->locale('pt_BR')->monthName }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Ano Civil</label>
                <input type="number" name="ano" value="{{ request('ano', date('Y')) }}" min="2020" max="2100" class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Status do Ciclo</label>
                <select name="status" class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                    <option value="">Todos os Estados</option>
                    <option value="aberta" {{ request('status') === 'aberta' ? 'selected' : '' }}>Aberto / Em Cobrança</option>
                    <option value="fechada" {{ request('status') === 'fechada' ? 'selected' : '' }}>Fechado / Concluído</option>
                    <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-8 py-4 text-xs font-black text-white bg-slate-900 dark:bg-blue-600 rounded-2xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-[0.98] uppercase tracking-widest flex items-center justify-center gap-2">
                    <x-icon name="filter" class="w-4 h-4" />
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Ciclos -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-slate-400 uppercase tracking-[0.2em] bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-8 py-5 font-black">Referência</th>
                        <th scope="col" class="px-8 py-5 font-black">Valor Base</th>
                        <th scope="col" class="px-8 py-5 font-black">Vencimento</th>
                        <th scope="col" class="px-8 py-5 font-black">Desempenho Financeiro</th>
                        <th scope="col" class="px-8 py-5 font-black text-center">Status</th>
                        <th scope="col" class="px-8 py-5 font-black text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($mensalidades as $mensalidade)
                    <tr class="hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/10 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                                    <x-icon name="calendar-check" style="duotone" class="w-5 h-5" />
                                </div>
                                <div>
                                    <div class="font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $mensalidade->mes_ano }}</div>
                                    <div class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Ciclo Mensal</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-gray-900 dark:text-white font-black text-base">R$ {{ number_format($mensalidade->valor_mensalidade, 2, ',', '.') }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase">
                                <x-icon name="clock" class="w-3.5 h-3.5 text-slate-300" />
                                {{ $mensalidade->data_vencimento->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="space-y-2 max-w-[200px]">
                                <div class="flex justify-between text-[9px] font-black uppercase tracking-widest">
                                    <span class="text-emerald-500">Arrecadado</span>
                                    <span class="text-gray-900 dark:text-white">R$ {{ number_format($mensalidade->total_arrecadado, 2, ',', '.') }}</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    @php
                                        $total = $mensalidade->total_arrecadado + $mensalidade->total_pendente;
                                        $percent = $total > 0 ? ($mensalidade->total_arrecadado / $total) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-emerald-500 transition-all duration-500" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $statusStyles = [
                                    'aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    'fechada' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'cancelada' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400',
                                ];
                                $style = $statusStyles[$mensalidade->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-400';
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.15em] {{ $style }}">
                                {{ $mensalidade->status_texto }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('lider-comunidade.mensalidades.show', $mensalidade->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all dark:bg-blue-900/10 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white">
                                Gerenciar
                                <x-icon name="arrow-right-long" class="w-3.5 h-3.5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center text-gray-200 dark:text-slate-800">
                                    <x-icon name="calendar-xmark" style="duotone" class="w-10 h-10" />
                                </div>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Nenhum ciclo financeiro registrado</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mensalidades->hasPages())
        <div class="p-8 bg-gray-50/30 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-800">
            {{ $mensalidades->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
