@extends('pocos::morador.layouts.app')

@section('title', 'Meus Pagamentos - Área do Morador')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Header: Perfil do Morador -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full -mr-32 -mt-32 blur-3xl transition-all group-hover:bg-blue-500/10"></div>
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 p-0.5 shadow-xl shadow-blue-500/20">
                    <div class="w-full h-full rounded-[14px] bg-white dark:bg-slate-900 flex items-center justify-center text-3xl font-black text-blue-600">
                        {{ strtoupper(substr($usuario->nome, 0, 1)) }}
                    </div>
                </div>
                <div>
                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-1">Bem-vindo(a) de volta</p>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ explode(' ', $usuario->nome)[0] }}</h1>
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                         <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-900/50 text-[10px] font-black text-slate-500 uppercase tracking-widest border border-slate-200/50 dark:border-slate-700/50 transition-all hover:bg-slate-200 dark:hover:bg-slate-800">
                            <x-icon name="bore-hole" style="duotone" class="w-3.5 h-3.5" />
                            {{ $usuario->poco->nome_mapa ?? $usuario->poco->codigo }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/50 dark:bg-emerald-900/20 text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/30">
                            Ficha Ativa
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-900/20 shadow-inner group/code max-w-fit">
                <div class="text-right">
                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-1 group-hover/code:text-blue-600 transition-colors">Código de Acesso</p>
                    <code class="text-2xl font-mono font-black text-blue-700 dark:text-blue-400 tracking-[0.15em]">{{ $usuario->codigo_acesso }}</code>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center shadow-sm border border-blue-50 dark:border-slate-700 group-hover/code:rotate-12 transition-transform">
                    <x-icon name="key" style="duotone" class="w-6 h-6 text-blue-500" />
                </div>
            </div>
        </div>
    </div>

    @if($faturasVencidas->count() > 0)
    <!-- Alerta de Vencimento -->
    <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 rounded-3xl p-6 md:p-8 animate-pulse-slow">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 shadow-sm">
                <x-icon name="circle-exclamation" style="duotone" class="w-8 h-8 text-red-600" />
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-xl font-black text-red-900 dark:text-red-200 uppercase tracking-tight mb-1">Atenção: Pagamentos em Atraso</h3>
                <p class="text-sm text-red-700 dark:text-red-400 font-medium">Você possui competências vencidas que precisam ser regularizadas imediatamente.</p>
            </div>
            <div class="grid grid-cols-1 gap-2 w-full md:w-auto min-w-[200px]">
                @foreach($faturasVencidas->take(2) as $fatura)
                <a href="{{ route('morador-poco.fatura.show', $fatura->id) }}" class="flex items-center justify-between px-5 py-3 bg-white dark:bg-slate-800 rounded-xl border border-red-200 dark:border-red-900/40 hover:shadow-md transition-all active:scale-95 group">
                    <div class="text-left">
                        <p class="text-[10px] font-black text-red-400 uppercase tracking-widest leading-none">{{ $fatura->mensalidade->mes_ano }}</p>
                        <p class="text-sm font-black text-gray-900 dark:text-white leading-tight">R$ {{ number_format($fatura->valor, 2, ',', '.') }}</p>
                    </div>
                    <x-icon name="chevron-right" class="w-4 h-4 text-red-400 group-hover:translate-x-1 transition-transform" />
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Faturas em Aberto -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h2 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="file-invoice-dollar" style="duotone" class="w-5 text-blue-500" />
                        Aguardando Pagamento
                    </h2>
                </div>
                <div class="p-8">
                    @if($faturasAbertas->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($faturasAbertas as $fatura)
                        <div class="bg-gray-50/50 dark:bg-slate-900/40 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 transition-all hover:bg-white dark:hover:bg-slate-800 hover:shadow-lg hover:shadow-blue-500/5 group">
                             <div class="flex items-center justify-between mb-4">
                                 <div>
                                     <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Competência</p>
                                     <h4 class="text-xl font-black text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors uppercase tracking-tight">{{ $fatura->mensalidade->mes_ano }}</h4>
                                 </div>
                                 <span class="px-3 py-1 bg-blue-100/50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-lg border border-blue-200/50 dark:border-blue-900/30">PENDENTE</span>
                             </div>

                             <div class="grid grid-cols-2 gap-4 mb-6">
                                 <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700">
                                      <p class="text-[8px] font-black text-gray-400 uppercase mb-1">Vencimento</p>
                                      <p class="text-xs font-black text-gray-900 dark:text-white">{{ $fatura->data_vencimento->format('d/m/Y') }}</p>
                                 </div>
                                 <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700">
                                      <p class="text-[8px] font-black text-gray-400 uppercase mb-1">Valor Total</p>
                                      <p class="text-xs font-black text-blue-600">R$ {{ number_format($fatura->valor, 2, ',', '.') }}</p>
                                 </div>
                             </div>

                             <div class="grid grid-cols-1 gap-2">
                                <a href="{{ route('morador-poco.fatura.show', $fatura->id) }}" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-[0.15em] hover:bg-blue-700 transition-all shadow-md shadow-blue-500/10 group/btn">
                                    Pagar Agora (PIX)
                                    <x-icon name="arrow-right" class="w-3.5 h-3.5 group-hover/btn:translate-x-1 transition-transform" />
                                </a>
                                <div class="flex gap-2">
                                    <a href="{{ route('morador-poco.fatura.segunda-via', $fatura->id) }}" class="flex-1 flex items-center justify-center gap-2 py-2 bg-gray-100 dark:bg-slate-800 rounded-lg text-[9px] font-black text-gray-500 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors">
                                        <x-icon name="file-pdf" style="duotone" class="w-3 h-3" />
                                        PDF
                                    </a>
                                     <a href="{{ route('morador-poco.fatura.show', $fatura->id) }}#detalhes" class="flex-1 flex items-center justify-center gap-2 py-2 bg-gray-100 dark:bg-slate-800 rounded-lg text-[9px] font-black text-gray-500 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors">
                                        Explorar
                                    </a>
                                </div>
                             </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="py-16 flex flex-col items-center justify-center text-center opacity-50">
                        <div class="w-20 h-20 bg-emerald-50 dark:bg-emerald-900/10 rounded-full flex items-center justify-center mb-4 text-emerald-500">
                             <x-icon name="circle-check" style="duotone" class="w-12 h-12" />
                        </div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Tudo em Dia!</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Você não possui faturas pendentes de pagamento no momento.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Histórico Lateral -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Últimas Baixas</h3>
                    <a href="{{ route('morador-poco.historico') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Ver Histórico</a>
                </div>

                <div class="space-y-4">
                    @forelse($ultimosPagamentos as $pagamento)
                    <div class="flex items-center gap-4 p-4 bg-emerald-50/30 dark:bg-emerald-900/10 rounded-2xl border border-emerald-100/50 dark:border-emerald-900/20 group hover:shadow-md transition-all">
                        <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center text-emerald-500 shadow-sm transition-transform group-hover:rotate-12">
                             <x-icon name="receipt" style="duotone" class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-gray-400 uppercase leading-none mb-1">{{ $pagamento->data_pagamento->format('d/m/Y') }}</p>
                            <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $pagamento->mensalidade->mes_ano }}</p>
                        </div>
                        <div class="text-right">
                             <p class="text-xs font-black text-emerald-600">R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}</p>
                             <span class="text-[9px] font-bold text-emerald-500 uppercase leading-none">{{ $pagamento->forma_pagamento_texto }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 dark:border-slate-800 rounded-3xl opacity-50">
                         <x-icon name="clock-rotate-left" style="duotone" class="w-8 h-8 text-gray-400 mx-auto mb-2" />
                         <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Aguardando Primeiro Recibo</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
