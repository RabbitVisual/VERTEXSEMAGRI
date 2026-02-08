@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Dashboard - Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex-1">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-1">
                <span>Visão Geral</span>
            </h1>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-1.5">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                    Poço: <span class="font-bold text-gray-700 dark:text-slate-200">{{ $poco->nome_mapa ?? $poco->codigo }}</span>
                </span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ route('lider-comunidade.solicitacoes-baixa.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800 relative">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
                Solicitações de Baixa
                @if($solicitacoesPendentes > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $solicitacoesPendentes }}</span>
                @endif
            </a>
            <a href="{{ route('lider-comunidade.pix.edit') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75m15 0h.75a.75.75 0 01.75.75v.75m0 0H9m11.25-9h.75a.75.75 0 01.75.75v.75m0 0H21m-1.5-1.5H3.75m0 0h-.375c-.621 0-1.125.504-1.125 1.125v9.75c0 .621.504 1.125 1.125 1.125h.375M9 19.5v-1.5m0-1.5h1.5m-1.5 0H9m0 0v-1.5m0 1.5h1.5m-1.5 0H9" />
                </svg>
                Configurar PIX
            </a>
            <a href="{{ route('lider-comunidade.mensalidades.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nova Mensalidade
            </a>
        </div>
    </div>

    <!-- Estatísticas do Mês Atual -->
    @if($mensalidadeAtual)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="p-6 premium-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Arrecadado</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">R$ {{ number_format($stats['total_arrecadado_mes'], 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/30">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100/50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400">EFETIVADO</span>
            </div>
        </div>

        <div class="p-6 premium-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Pendente</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">R$ {{ number_format($stats['total_pendente_mes'], 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-xl dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/30">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-amber-100/50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400">EM ABERTO</span>
            </div>
        </div>

        <div class="p-6 premium-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Pagantes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['usuarios_pagantes'] }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-xs text-gray-500 dark:text-gray-500">de {{ $stats['total_usuarios'] }} total de usuários</p>
            </div>
        </div>

        <div class="p-6 premium-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Hoje</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['pagamentos_hoje'] }}</p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-800/30">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75m15 0h.75a.75.75 0 01.75.75v.75m0 0H9m11.25-9h.75a.75.75 0 01.75.75v.75m0 0H21m-1.5-1.5H3.75m0 0h-.375c-.621 0-1.125.504-1.125 1.125v9.75c0 .621.504 1.125 1.125 1.125h.375M9 19.5v-1.5m0-1.5h1.5m-1.5 0H9m0 0v-1.5m0 1.5h1.5m-1.5 0H9" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-indigo-100/50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-400">PAGAMENTOS</span>
            </div>
        </div>
    </div>
    @else
    <div class="p-6 bg-amber-50 border border-amber-200 rounded-lg dark:bg-amber-900/20 dark:border-amber-800">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-200">Nenhuma mensalidade criada para este mês</h3>
                <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">Crie uma nova mensalidade para começar a controlar os pagamentos.</p>
                <a href="{{ route('lider-comunidade.mensalidades.create') }}" class="inline-flex items-center mt-3 px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700">
                    Criar Mensalidade
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Últimos Pagamentos -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Últimos Pagamentos</h2>
            <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Usuário</th>
                        <th scope="col" class="px-6 py-4 font-bold">Mês/Ano</th>
                        <th scope="col" class="px-6 py-4 font-bold">Data</th>
                        <th scope="col" class="px-6 py-4 font-bold">Valor</th>
                        <th scope="col" class="px-6 py-4 font-bold">Forma</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($ultimosPagamentos as $pagamento)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900 dark:text-white">{{ $pagamento->usuarioPoco->nome }}</div>
                            <div class="text-[10px] text-gray-500 uppercase">Cód: {{ $pagamento->usuarioPoco->codigo_acesso }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-slate-400 font-medium">{{ $pagamento->mensalidade->mes }}/{{ $pagamento->mensalidade->ano }}</td>
                        <td class="px-6 py-4 text-gray-500 dark:text-slate-500 font-medium">{{ $pagamento->data_pagamento->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-800/30">
                                {{ $pagamento->forma_pagamento_texto }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Nenhum pagamento registrado ainda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mensalidades Recentes -->
    <div class="premium-card">
        <div class="p-6 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Mensalidades Recentes</h2>
            <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 transition-colors">Ver Todas</a>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($mensalidadesRecentes as $mensalidade)
                <a href="{{ route('lider-comunidade.mensalidades.show', $mensalidade->id) }}" class="group relative block p-5 bg-gray-50/50 dark:bg-slate-800/30 rounded-2xl border border-gray-100 dark:border-slate-800 hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 hover:border-blue-200 dark:hover:border-blue-900/50 hover:shadow-lg hover:shadow-blue-500/5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2.5 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $mensalidade->status === 'aberta' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-400' }}">
                            {{ $mensalidade->status_texto }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $mensalidade->mes_ano }}</h3>
                    <div class="mt-4 flex items-center justify-between p-3 bg-white dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-slate-700/50">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest">Arrecadado</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">R$ {{ number_format($mensalidade->total_arrecadado, 2, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest">Valor</p>
                            <p class="text-sm font-bold text-blue-600 dark:text-blue-400">R$ {{ number_format($mensalidade->valor_mensalidade, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-12 flex flex-col items-center gap-3">
                    <svg class="w-12 h-12 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Nenhuma mensalidade criada ainda</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
