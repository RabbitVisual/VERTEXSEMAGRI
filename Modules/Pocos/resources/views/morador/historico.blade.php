@extends('pocos::morador.layouts.app')

@section('title', 'Histórico de Faturas')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('morador-poco.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" style="duotone" class="w-6 h-6" />
            </a>
            <div>
                <h1 class="text-3xl font-black font-poppins text-gray-900 dark:text-white uppercase tracking-tight">Histórico Fiscal</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Relação completa de faturas e pagamentos realizados</p>
            </div>
        </div>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-800">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Competência</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Vencimento</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Valor</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest text-center">Situação</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($faturas as $fatura)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-900/20 transition-colors">
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-gray-900 dark:text-white uppercase">{{ $fatura->mensalidade->mes_ano }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-gray-500 dark:text-slate-400">{{ $fatura->data_vencimento->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-slate-900 dark:text-white">R$ {{ number_format($fatura->valor, 2, ',', '.') }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-center">
                                @if($fatura->status === 'pago')
                                <span class="px-3 py-1 rounded-full bg-emerald-100/50 dark:bg-emerald-900/20 text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/30">Pago</span>
                                @elseif($fatura->status === 'vencido' || $fatura->esta_vencido)
                                <span class="px-3 py-1 rounded-full bg-red-100/50 dark:bg-red-900/20 text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-widest border border-red-100 dark:border-red-800/30">Atrasado</span>
                                @else
                                <span class="px-3 py-1 rounded-full bg-amber-100/50 dark:bg-amber-900/20 text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-widest border border-amber-100 dark:border-amber-800/30">Pendente</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('morador-poco.fatura.show', $fatura->id) }}" class="p-2 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-400 hover:text-blue-600 border border-gray-100 dark:border-slate-800 transition-all shadow-sm" title="Ver Detalhes">
                                    <x-icon name="eye" style="duotone" class="w-5 h-5" />
                                </a>
                                @if($fatura->status === 'pago')
                                <a href="{{ route('morador-poco.fatura.comprovante', $fatura->id) }}" class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/30 transition-all shadow-sm" title="Baixar Comprovante">
                                    <x-icon name="file-invoice" style="duotone" class="w-5 h-5" />
                                </a>
                                @else
                                <a href="{{ route('morador-poco.fatura.segunda-via', $fatura->id) }}" class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800/30 transition-all shadow-sm" title="Baixar 2ª Via">
                                    <x-icon name="download" style="solid" class="w-5 h-5" />
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Nenhuma fatura encontrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-slate-700">
            {{ $faturas->links() }}
        </div>
    </div>
</div>
@endsection
