@extends('admin.layouts.admin')

@section('title', 'Detalhes do Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex-1">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-1">
                <span>{{ $lider->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors uppercase tracking-wider font-bold">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors uppercase tracking-wider font-bold">Líderes de Comunidade</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-black uppercase tracking-wider">{{ $lider->nome }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.lideres-comunidade.edit', $lider) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Perfil -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="p-6 text-center">
                    <div class="mb-4">
                        <div class="rounded-full border-4 border-blue-500 mx-auto bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center w-32 h-32 text-4xl font-bold shadow-lg">
                            {{ strtoupper(substr($lider->nome, 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $lider->nome }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 break-all">{{ $lider->email ?? $lider->user->email ?? '-' }}</p>
                    <div class="mb-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $lider->status === 'ativo' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                @if($lider->status === 'ativo')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                @endif
                            </svg>
                            {{ $lider->status_texto }}
                        </span>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        <p>Código: <strong class="text-gray-900 dark:text-white">{{ $lider->codigo }}</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Líder</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400 w-48">Nome:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $lider->nome }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">CPF:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $lider->cpf_formatado ?: '-' }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Email:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $lider->email ?? $lider->user->email ?? '-' }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Telefone:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $lider->telefone ?? '-' }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Endereço:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $lider->endereco ?? '-' }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Localidade:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $lider->localidade->nome ?? '-' }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Poço:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $lider->poco->nome_mapa ?? $lider->poco->codigo ?? '-' }}
                                    @if($lider->poco)
                                    <a href="{{ route('admin.pocos.show', $lider->poco->id) }}" class="ml-2 text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                        <svg class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Usuário do Sistema:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    @if($lider->user)
                                    <a href="{{ route('admin.users.show', $lider->user->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                        {{ $lider->user->name }} ({{ $lider->user->email }})
                                    </a>
                                    @else
                                    <span class="text-gray-400">Não vinculado</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Pessoa do CadÚnico:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    @if($lider->pessoa)
                                    <a href="{{ route('admin.pessoas.show', $lider->pessoa->id) }}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
                                        {{ $lider->pessoa->nom_pessoa }}
                                        @if($lider->pessoa->num_nis_pessoa_atual)
                                        <span class="text-xs text-gray-500 dark:text-gray-400">(NIS: {{ $lider->pessoa->num_nis_pessoa_atual }})</span>
                                        @endif
                                    </a>
                                    @else
                                    <span class="text-gray-400">Não vinculado</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Cadastrado em:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $lider->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if($lider->observacoes)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Observações</h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $lider->observacoes }}</p>
                </div>
            </div>
            @endif

            <!-- Resumo de Gestão -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em]">Resumo de Gestão</h2>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75m15 0h.75a.75.75 0 01.75.75v.75m0 0H9m11.25-9h.75a.75.75 0 01.75.75v.75m0 0H21m-1.5-1.5H3.75m0 0h-.375c-.621 0-1.125.504-1.125 1.125v9.75c0 .621.504 1.125 1.125 1.125h.375M9 19.5v-1.5m0-1.5h1.5m-1.5 0H9m0 0v-1.5m0 1.5h1.5m-1.5 0H9" />
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="p-5 rounded-2xl bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-700/50">
                            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Mensalidades</p>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $estatisticas['total_mensalidades'] ?? $lider->mensalidades->count() }}</p>
                            <div class="mt-2 text-[10px] font-bold text-gray-400 uppercase">Ciclos Criados</div>
                        </div>
                        <div class="p-5 rounded-2xl bg-blue-50/30 dark:bg-blue-900/10 border border-blue-50 dark:border-blue-900/20">
                            <p class="text-[10px] font-black text-blue-400 dark:text-blue-500 uppercase tracking-widest mb-1">Pagamentos</p>
                            <p class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ $estatisticas['total_pagamentos'] ?? $lider->pagamentos->where('status', 'confirmado')->count() }}</p>
                            <div class="mt-2 text-[10px] font-bold text-blue-500/60 uppercase italic">Confirmados</div>
                        </div>
                        <div class="p-5 rounded-2xl bg-emerald-50/30 dark:bg-emerald-900/10 border border-emerald-50 dark:border-emerald-900/20">
                            <p class="text-[10px] font-black text-emerald-400 dark:text-emerald-500 uppercase tracking-widest mb-1">Arrecadação</p>
                            <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400">
                                R$ {{ number_format($estatisticas['total_arrecadado'] ?? $lider->pagamentos->where('status', 'confirmado')->sum('valor_pago') ?? 0, 2, ',', '.') }}
                            </p>
                            <div class="mt-2 text-[10px] font-bold text-emerald-500/60 uppercase">Valor Acumulado</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
