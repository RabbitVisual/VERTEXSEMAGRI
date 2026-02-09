@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Painel de Gestão - Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="chart-pie" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Visão Geral</span>
            </h1>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                 <x-icon name="bore-hole" style="duotone" class="w-4 h-4 text-blue-500" />
                 <span class="font-bold">Poço Responsável:</span>
                 <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-black uppercase tracking-widest">{{ $poco->nome_mapa ?? $poco->codigo }}</span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
             <a href="{{ route('lider-comunidade.solicitacoes-baixa.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-black uppercase tracking-widest text-white bg-amber-600 rounded-xl hover:bg-amber-700 transition-all shadow-md relative group">
                <x-icon name="file-invoice-dollar" style="duotone" class="w-5 h-5 group-hover:rotate-12 transition-transform" />
                Solicitações
                @if($solicitacoesPendentes > 0)
                <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white ring-4 ring-white dark:ring-slate-900 animate-bounce">
                    {{ $solicitacoesPendentes }}
                </span>
                @endif
            </a>
            <a href="{{ route('lider-comunidade.pix.edit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-black uppercase tracking-widest text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-md group">
                <x-icon name="qrcode" style="duotone" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                Chave PIX
            </a>
            <a href="{{ route('lider-comunidade.mensalidades.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-black uppercase tracking-widest text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-md group">
                <x-icon name="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform" />
                Novo Ciclo
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    @if($mensalidadeAtual)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Arrecadado -->
        <div class="p-6 premium-card group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                <x-icon name="hand-holding-dollar" class="w-24 h-24" />
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl text-emerald-600 transition-transform group-hover:scale-110">
                    <x-icon name="money-bill-transfer" style="duotone" class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black text-emerald-500/50 uppercase tracking-widest">Efetivado (Mês)</span>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white leading-none">R$ {{ number_format($stats['total_arrecadado_mes'], 2, ',', '.') }}</p>
            <div class="mt-4 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span class="text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Saldo Confirmado</span>
            </div>
        </div>

        <!-- Pendente -->
        <div class="p-6 premium-card group overflow-hidden relative text-amber-600">
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                <x-icon name="clock" class="w-24 h-24" />
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-2xl text-amber-600 transition-transform group-hover:scale-110">
                    <x-icon name="hourglass-start" style="duotone" class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black text-amber-500/50 uppercase tracking-widest text-right leading-tight">Aguardando<br>Pagamento</span>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white leading-none">R$ {{ number_format($stats['total_pendente_mes'], 2, ',', '.') }}</p>
            <div class="mt-4 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-widest">Volume Pendente</span>
            </div>
        </div>

        <!-- Pagantes -->
        <div class="p-6 premium-card group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                <x-icon name="users" class="w-24 h-24" />
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-2xl text-blue-600 transition-transform group-hover:scale-110">
                    <x-icon name="user-check" style="duotone" class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black text-blue-500/50 uppercase tracking-widest">Quitação</span>
            </div>
            <div class="flex items-baseline gap-1">
                <p class="text-3xl font-black text-gray-900 dark:text-white leading-none">{{ $stats['usuarios_pagantes'] }}</p>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">/ {{ $stats['total_usuarios'] }}</p>
            </div>
            <div class="mt-4 w-full bg-gray-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                <div class="bg-blue-500 h-full rounded-full transition-all duration-1000" style="width: {{ $stats['total_usuarios'] > 0 ? ($stats['usuarios_pagantes'] / $stats['total_usuarios'] * 100) : 0 }}%"></div>
            </div>
        </div>

        <!-- Volume Hoje -->
        <div class="p-6 premium-card group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-indigo-500">
                <x-icon name="calendar-day" class="w-24 h-24" />
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl text-indigo-600 transition-transform group-hover:scale-110">
                    <x-icon name="bolt" style="duotone" class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black text-indigo-500/50 uppercase tracking-widest text-right leading-tight">Atividade<br>Recente</span>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white leading-none">{{ $stats['pagamentos_hoje'] }}</p>
            <p class="mt-4 text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Recebidos hoje</p>
        </div>
    </div>
    @else
    <div class="p-8 bg-amber-50/50 dark:bg-amber-900/10 border-2 border-dashed border-amber-200 dark:border-amber-800/50 rounded-3xl text-center">
        <div class="w-20 h-20 bg-amber-100 dark:bg-amber-900/20 rounded-full flex items-center justify-center mx-auto mb-6 text-amber-600 shadow-sm">
            <x-icon name="calendar-plus" style="duotone" class="w-10 h-10" />
        </div>
        <h3 class="text-2xl font-black text-amber-900 dark:text-amber-200 uppercase tracking-tight">Nenhuma Mensalidade Iniciada</h3>
        <p class="text-sm text-amber-700 dark:text-amber-400 mt-2 max-w-sm mx-auto leading-relaxed">Não foi encontrado um ciclo de cobrança para o mês atual. Inicie um novo ciclo para liberar os pagamentos dos moradores.</p>
        <a href="{{ route('lider-comunidade.mensalidades.create') }}" class="inline-flex items-center gap-2 mt-8 px-8 py-3 text-sm font-black uppercase tracking-widest text-white bg-amber-600 rounded-2xl hover:bg-amber-700 transition-all shadow-xl shadow-amber-500/20 group">
             Começar Novo Ciclo
             <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
        </a>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Tabela de Últimos Pagamentos -->
        <div class="lg:col-span-2 space-y-6">
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="receipt" style="duotone" class="w-5 text-blue-500" />
                        Fluxo de Caixa Recente
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] text-gray-400 uppercase tracking-[0.15em] bg-gray-50/30 dark:bg-slate-800/20 border-b border-gray-100 dark:border-slate-800">
                            <tr>
                                <th scope="col" class="px-8 py-4 font-black">Identificação</th>
                                <th scope="col" class="px-8 py-4 font-black">Referência</th>
                                <th scope="col" class="px-8 py-4 font-black">Data / Valor</th>
                                <th scope="col" class="px-8 py-4 font-black text-right">Canal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                            @forelse($ultimosPagamentos as $pagamento)
                            <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-800/30 transition-all group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black text-gray-500 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            {{ strtoupper(substr($pagamento->usuarioPoco->nome, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $pagamento->usuarioPoco->nome }}</div>
                                            <div class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Acesso: {{ $pagamento->usuarioPoco->codigo_acesso }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 rounded-lg text-[10px] font-black uppercase tracking-tighter">{{ $pagamento->mensalidade->mes_ano }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-tighter">{{ $pagamento->data_pagamento->format('d/m/y') }}</span>
                                        <span class="text-md font-black text-emerald-600">R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30">
                                             {{ $pagamento->forma_pagamento_texto }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center opacity-40">
                                    <div class="flex flex-col items-center">
                                         <x-icon name="receipt" style="duotone" class="w-12 h-12 mb-3" />
                                         <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Nenhum registro de entrada</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coluna de Ciclos -->
        <div class="space-y-6">
            <div class="premium-card p-8">
                 <div class="flex items-center justify-between mb-8 border-b border-gray-100 dark:border-slate-800 pb-4">
                    <h2 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Ciclos Históricos</h2>
                    <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Gerenciar</a>
                </div>

                <div class="space-y-4">
                    @forelse($mensalidadesRecentes as $mensalidade)
                    <a href="{{ route('lider-comunidade.mensalidades.show', $mensalidade->id) }}" class="block p-5 bg-gray-50/50 dark:bg-slate-900/40 rounded-2xl border border-gray-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-900/50 hover:bg-white dark:hover:bg-slate-800 transition-all group">
                         <div class="flex items-center justify-between mb-4">
                             <div class="flex flex-col">
                                 <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $mensalidade->mes_ano }}</span>
                                 <span class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">Período Fiscal</span>
                             </div>
                             <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $mensalidade->status === 'aberta' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}">
                                 {{ $mensalidade->status_texto }}
                             </span>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                              <div class="p-3 bg-white dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm">
                                  <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter mb-1">Taxa Base</p>
                                  <p class="text-xs font-black text-blue-600 uppercase">R$ {{ number_format($mensalidade->valor_mensalidade, 2, ',', '.') }}</p>
                              </div>
                               <div class="p-3 bg-white dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm">
                                  <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter mb-1">Volume</p>
                                  <p class="text-xs font-black text-emerald-600 uppercase">R$ {{ number_format($mensalidade->total_arrecadado, 2, ',', '.') }}</p>
                              </div>
                         </div>
                    </a>
                    @empty
                    <p class="text-xs text-center text-gray-400 py-12 italic border-2 border-dashed border-gray-100 dark:border-slate-800 rounded-3xl">Não há outros ciclos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
