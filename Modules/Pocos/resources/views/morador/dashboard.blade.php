@extends('pocos::morador.layouts.app')

@section('title', 'Dashboard - Área do Morador')

@section('content')
<div class="space-y-6">
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
                    <h1 class="text-3xl md:text-4xl font-black font-poppins text-gray-900 dark:text-white tracking-tight">Olá, {{ explode(' ', $usuario->nome)[0] }}!</h1>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest border border-slate-200/50 dark:border-slate-700/50">
                            <x-icon name="map-location-dot" style="duotone" class="w-3.5 h-3.5" />
                            {{ $usuario->poco->nome_mapa ?? $usuario->poco->codigo }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/50 dark:bg-emerald-900/20 text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/30">
                            Morador Ativo
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4 group">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1">Seu Acesso</p>
                    <code class="text-2xl font-mono font-black text-blue-600 dark:text-blue-400 tracking-wider group-hover:scale-105 transition-transform block">{{ $usuario->codigo_acesso }}</code>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center shadow-sm group-hover:shadow-md transition-all">
                    <x-icon name="key" style="duotone" class="w-6 h-6 text-blue-500" />
                </div>
            </div>
        </div>
    </div>

    <!-- Faturas Vencidas -->
    @if($faturasVencidas->count() > 0)
    <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 animate-pulse">
                <x-icon name="circle-exclamation" style="duotone" class="w-6 h-6 text-red-600 dark:text-red-400" />
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold font-poppins text-red-900 dark:text-red-200 mb-1">Faturas Pendentes</h3>
                <p class="text-sm text-red-700 dark:text-red-300 mb-4 opacity-80">Você possui pagamentos em atraso. Regularize para evitar suspensão.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($faturasVencidas as $fatura)
                    <div class="flex items-center justify-between p-4 bg-white/60 dark:bg-slate-800/60 backdrop-blur rounded-xl border border-red-100 dark:border-red-800/30 shadow-sm">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $fatura->mensalidade->mes_ano }}</p>
                            <p class="text-xs text-red-600 dark:text-red-400 font-medium">Vencido em {{ $fatura->data_vencimento->format('d/m/Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-red-600 dark:text-red-400">R$ {{ number_format($fatura->valor, 2, ',', '.') }}</p>
                            <a href="{{ route('morador-poco.fatura.show', $fatura->id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 uppercase tracking-tighter">Detalhes</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Faturas em Aberto -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
            <h2 class="text-lg font-bold font-poppins text-gray-900 dark:text-white">Faturas em Aberto</h2>
            <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                <x-icon name="file-invoice-dollar" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
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
                            <x-icon name="download" style="solid" class="w-4 h-4" />
                            Baixar 2ª Via
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-12 flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                    <x-icon name="check-circle" style="duotone" class="w-8 h-8 text-emerald-500" />
                </div>
                <p class="text-sm font-bold text-slate-500 dark:text-slate-400">Nenhuma fatura em aberto. Tudo em dia!</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Últimos Pagamentos -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
            <h2 class="text-lg font-bold font-poppins text-gray-900 dark:text-white">Últimos Pagamentos</h2>
            <a href="{{ route('morador-poco.historico') }}" class="text-xs font-extrabold text-blue-600 hover:text-blue-700 dark:text-blue-400 uppercase tracking-widest">Histórico Completo</a>
        </div>
        <div class="p-6">
            @if($ultimosPagamentos->count() > 0)
            <div class="space-y-3">
                @foreach($ultimosPagamentos as $pagamento)
                <div class="flex items-center justify-between p-4 border border-gray-100 dark:border-slate-800 rounded-2xl bg-gray-50/30 dark:bg-slate-900/30 hover:bg-white dark:hover:bg-slate-800 transition-colors shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/30 text-emerald-600 dark:text-emerald-400">
                            <x-icon name="check" style="solid" class="w-5 h-5" />
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
