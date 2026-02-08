@extends('pocos::morador.layouts.app')

@section('title', 'Dashboard - Área do Morador')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <!-- Header -->
    <div class="premium-card p-10 bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 border-none relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-tr from-blue-600 to-indigo-600 p-0.5 shadow-xl shadow-blue-500/20">
                    <div class="w-full h-full rounded-[22px] bg-white dark:bg-slate-900 flex items-center justify-center">
                        <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-tr from-blue-600 to-indigo-600">{{ strtoupper(substr($usuario->nome, 0, 1)) }}</span>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tight">Olá, {{ explode(' ', $usuario->nome)[0] }}!</h1>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest border border-slate-200/50 dark:border-slate-700/50">
                            <x-icon name="file-pdf" class="w-5 h-5" />
            </div>
        </div>
        <div class="p-6">
            @if($faturasAbertas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($faturasAbertas as $fatura)
                <div class="group p-5 rounded-2xl border border-gray-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-900/50 hover:bg-blue-50/10 dark:hover:bg-blue-900/5 transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Competência</p>
                            <h4 class="text-xl font-black text-gray-900 dark:text-white leading-none">{{ $fatura->mensalidade->mes_ano }}</h4>
                        </div>
                        <span class="px-2 py-1 rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-[10px] font-bold uppercase tracking-wider border border-blue-100 dark:border-blue-800/30">
                            Aguardando
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl mb-4">
                        <div class="text-xs">
                            <p class="text-gray-500">Vencimento</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $fatura->data_vencimento->format('d/m/Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-500 text-xs">Valor</p>
                            <p class="text-lg font-black text-blue-600 dark:text-blue-400">R$ {{ number_format($fatura->valor, 2, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('morador-poco.fatura.show', $fatura->id) }}" class="flex items-center justify-center py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-xs font-bold text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Ver Detalhes
                        </a>
                        <a href="{{ route('morador-poco.fatura.segunda-via', $fatura->id) }}" class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-all shadow-md shadow-blue-500/20 active:scale-95">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Baixar 2ª Via
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-12 flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-500 dark:text-slate-400">Nenhuma fatura em aberto. Tudo em dia!</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Últimos Pagamentos -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Últimos Pagamentos</h2>
            <a href="{{ route('morador-poco.historico') }}" class="text-xs font-extrabold text-blue-600 hover:text-blue-700 dark:text-blue-400 uppercase tracking-widest">Histórico Completo</a>
        </div>
        <div class="p-6">
            @if($ultimosPagamentos->count() > 0)
            <div class="space-y-3">
                @foreach($ultimosPagamentos as $pagamento)
                <div class="flex items-center justify-between p-4 border border-gray-100 dark:border-slate-800 rounded-2xl bg-gray-50/30 dark:bg-slate-900/30 hover:bg-white dark:hover:bg-slate-800 transition-colors shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/30 text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $pagamento->mensalidade->mes_ano }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-slate-500 font-medium uppercase tracking-tight">Efetivado em {{ $pagamento->data_pagamento->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-base font-black text-emerald-600 dark:text-emerald-400">R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}</p>
                        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-600 uppercase">{{ $pagamento->forma_pagamento_texto }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-10 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Nenhum pagamento registrado no sistema.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
