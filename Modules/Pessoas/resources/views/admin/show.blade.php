@extends('admin.layouts.admin')

@section('title', $pessoa->nom_pessoa . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm p-5 md:p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-emerald-500 flex items-center justify-center shadow-lg text-white">
                    <x-icon module="pessoas" class="w-8 h-8" />
                </div>
                <div class="min-w-0 space-y-1">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white truncate">
                        {{ $pessoa->nom_pessoa }}
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 flex-wrap">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="eye" class="w-5 h-5" />
                    Ver no Painel Padrão
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-100 dark:bg-gray-800 dark:text-green-300 dark:border-green-900/40" role="alert">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    <!-- Informações da Pessoa -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Dados Principais -->
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/60 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações da Pessoa</h3>
                    @if($pessoa->recebe_pbf)
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">PBF Ativo</span>
                    @endif
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flowbite-form-label">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                            <dd class="text-base font-semibold text-gray-900 dark:text-white">{{ $pessoa->nom_pessoa }}</dd>
                        </div>
                        @if($pessoa->nom_apelido_pessoa)
                        <div class="flowbite-form-label">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Apelido</dt>
                            <dd class="text-base text-gray-900 dark:text-white">{{ $pessoa->nom_apelido_pessoa }}</dd>
                        </div>
                        @endif
                        <div class="flowbite-form-label">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIS</dt>
                            <dd class="text-base text-gray-900 dark:text-white font-mono">{{ $pessoa->num_nis_pessoa_atual ?? '-' }}</dd>
                        </div>
                        <div class="flowbite-form-label">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">CPF</dt>
                            <dd class="text-base text-gray-900 dark:text-white font-mono">{{ $pessoa->num_cpf_pessoa ?? '-' }}</dd>
                        </div>
                        @if($pessoa->localidade)
                        <div class="flowbite-form-label">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Localidade</dt>
                            <dd class="text-base">
                                <a href="{{ route('admin.localidades.show', $pessoa->localidade->id) }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors font-semibold">
                                    {{ $pessoa->localidade->nome }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        @if($pessoa->data_nascimento)
                        <div class="flowbite-form-label">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Nascimento</dt>
                            <dd class="text-base text-gray-900 dark:text-white">{{ $pessoa->data_nascimento->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                        <div class="flowbite-form-label">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Recebe PBF</dt>
                            <dd class="text-base">
                                @if($pessoa->recebe_pbf)
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200 text-xs font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sim
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 text-xs font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span> Não
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Demandas Recentes -->
            @if(isset($demandasRecentes) && $demandasRecentes->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/60 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas Recentes</h3>
                    <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">
                        {{ $demandasRecentes->count() }} registro(s)
                    </span>
                </div>
                <div class="p-6 space-y-3">
                    @foreach($demandasRecentes as $demanda)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/60 hover:border-emerald-200 hover:shadow-sm transition-all">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('admin.demandas.show', $demanda->id) }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800 dark:text-emerald-300 truncate block">
                                #{{ $demanda->codigo }} · {{ $demanda->tipo }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $demanda->created_at->format('d/m/Y') }}</p>
                        </div>
                        @php
                            $status = ['aberta' => 'info', 'em_andamento' => 'warning', 'concluida' => 'success', 'cancelada' => 'danger'];
                        @endphp
                        <x-admin.badge :type="$status[$demanda->status] ?? 'info'" class="text-xs">
                            {{ ucfirst(str_replace('_', ' ', $demanda->status)) }}
                        </x-admin.badge>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/60">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estatísticas</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-4">
                    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-100 dark:border-emerald-800">
                        <p class="text-xs text-emerald-700 dark:text-emerald-200">Total de Demandas</p>
                        <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-50">{{ $estatisticas['total_demandas'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-900/30 border border-amber-100 dark:border-amber-800">
                        <p class="text-xs text-amber-700 dark:text-amber-200">Abertas</p>
                        <p class="text-2xl font-bold text-amber-900 dark:text-amber-50">{{ $estatisticas['demandas_abertas'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800">
                        <p class="text-xs text-blue-700 dark:text-blue-200">Em Andamento</p>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-50">{{ $estatisticas['demandas_em_andamento'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-100 dark:border-emerald-800">
                        <p class="text-xs text-emerald-700 dark:text-emerald-200">Concluídas</p>
                        <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-50">{{ $estatisticas['demandas_concluidas'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/60">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ações Rápidas</h3>
                </div>
                <div class="p-6 space-y-3">
                    @if(Route::has('demandas.create'))
                    <a href="{{ route('demandas.create', ['pessoa_id' => $pessoa->id]) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all font-semibold shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Criar Demanda
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
