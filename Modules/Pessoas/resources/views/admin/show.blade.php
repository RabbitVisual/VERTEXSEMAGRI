@extends('admin.layouts.admin')

@section('title', $pessoa->nom_pessoa . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50/50 dark:bg-indigo-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon module="pessoas" style="duotone" class="w-8 h-8 md:w-10 md:h-10" />
                </div>
                <div class="min-w-0">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1 truncate">
                        {{ $pessoa->nom_pessoa }}
                    </h1>
                    <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400 font-medium flex-wrap">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <a href="{{ route('admin.pessoas.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pessoas</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <span class="text-gray-900 dark:text-white font-bold">Detalhes do Beneficiário</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.pessoas.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-all duration-300 shadow-sm">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-6 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50 flex items-center gap-3 animate-slide-in">
        <x-icon name="circle-check" class="w-5 h-5" style="duotone" />
        <span class="font-bold tracking-tight">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 md:gap-8">
        <!-- Coluna Principal -->
        <div class="xl:col-span-2 space-y-6 md:space-y-8">
            <!-- Card de Informações Pessoais -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
                    <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="id-card" class="w-4 h-4 text-indigo-500" style="duotone" />
                        Dados Cadastrais
                    </h3>
                    @if($pessoa->recebe_pbf)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 font-bold border border-emerald-100 dark:border-emerald-800/30 uppercase text-[10px] tracking-wider">
                            <x-icon name="check" class="w-3 h-3" />
                            PBF Ativo
                        </span>
                    @endif
                </div>
                <div class="p-6 md:p-8">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="space-y-1">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nome Completo</dt>
                            <dd class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                {{ $pessoa->nom_pessoa }}
                            </dd>
                        </div>

                        @if($pessoa->nom_apelido_pessoa)
                        <div class="space-y-1">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Apelido Social</dt>
                            <dd class="text-base font-medium text-gray-700 dark:text-gray-300">
                                {{ $pessoa->nom_apelido_pessoa }}
                            </dd>
                        </div>
                        @endif

                        <div class="space-y-1">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Número NIS</dt>
                            <dd class="text-base font-mono font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-slate-900/50 px-3 py-1.5 rounded-lg inline-block border border-gray-100 dark:border-slate-700">
                                {{ $pessoa->num_nis_pessoa_atual ?? 'Não Informado' }}
                            </dd>
                        </div>

                        <div class="space-y-1">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">CPF</dt>
                            <dd class="text-base font-mono font-medium text-gray-700 dark:text-gray-300">
                                {{ $pessoa->num_cpf_pessoa ?? 'Não Informado' }}
                            </dd>
                        </div>

                        <div class="space-y-1 md:col-span-2">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Localidade de Residência</dt>
                            <dd class="mt-1">
                                @if($pessoa->localidade)
                                <a href="{{ route('admin.localidades.show', $pessoa->localidade->id) }}" class="group flex items-center gap-3 p-3 rounded-xl bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30 hover:bg-blue-50 hover:border-blue-200 transition-all">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                        <x-icon name="map-location-dot" class="w-5 h-5" style="duotone" />
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-blue-900 dark:text-blue-100 group-hover:text-blue-700">{{ $pessoa->localidade->nome }}</span>
                                        <span class="block text-xs text-blue-500 dark:text-blue-400">Ver detalhes da localidade</span>
                                    </div>
                                    <x-icon name="arrow-right" class="w-4 h-4 text-blue-300 ml-auto group-hover:translate-x-1 transition-transform" />
                                </a>
                                @else
                                <span class="text-sm text-gray-500 italic flex items-center gap-2">
                                    <x-icon name="circle-xmark" class="w-4 h-4" />
                                    Localidade não vinculada
                                </span>
                                @endif
                            </dd>
                        </div>

                        @if($pessoa->data_nascimento)
                        <div class="space-y-1">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Data de Nascimento</dt>
                            <dd class="text-base font-medium text-gray-700 dark:text-gray-300">
                                {{ $pessoa->data_nascimento->format('d/m/Y') }}
                            </dd>
                        </div>
                        @endif

                        <div class="space-y-1">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status do Benefício (PBF)</dt>
                            <dd class="mt-1">
                                @if($pessoa->recebe_pbf)
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200 text-sm font-bold">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                        Recebe Benefício
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 text-sm font-bold">
                                        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                        Não Recebe
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Demandas Recentes -->
            @if(isset($demandasRecentes) && $demandasRecentes->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
                    <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="clipboard-list" class="w-4 h-4 text-indigo-500" style="duotone" />
                        Histórico de Demandas Recentes
                    </h3>
                    <a href="{{ route('admin.demandas.index', ['pessoa_id' => $pessoa->id]) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 hover:underline">Ver todas</a>
                </div>
                <div class="divide-y divide-gray-50 dark:divide-slate-700/50">
                    @foreach($demandasRecentes as $demanda)
                    <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-900/20 transition-colors flex items-center justify-between group">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                <span class="text-xs font-black">#{{ $demanda->codigo }}</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                                    {{ $demanda->tipo }}
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-0.5">
                                    <x-icon name="calendar" class="w-3 h-3" />
                                    {{ $demanda->created_at->format('d/m/Y \à\s H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            @php
                                $statusColors = [
                                    'aberta' => 'text-blue-600 bg-blue-50 border-blue-100 dark:bg-blue-900/20 dark:text-blue-400',
                                    'em_andamento' => 'text-amber-600 bg-amber-50 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400',
                                    'concluida' => 'text-emerald-600 bg-emerald-50 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400',
                                    'cancelada' => 'text-red-600 bg-red-50 border-red-100 dark:bg-red-900/20 dark:text-red-400'
                                ];
                                $colorClass = $statusColors[$demanda->status] ?? 'text-gray-600 bg-gray-50 border-gray-100';
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $colorClass }}">
                                {{ ucfirst(str_replace('_', ' ', $demanda->status)) }}
                            </span>
                            <a href="{{ route('admin.demandas.show', $demanda->id) }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                <x-icon name="chevron-right" class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estatísticas Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30">
                    <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="chart-pie" class="w-4 h-4 text-indigo-500" style="duotone" />
                        Resumo de Atividades
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-4 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/30 text-center">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-2xl font-black text-indigo-700 dark:text-indigo-300">{{ $estatisticas['total_demandas'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/30 text-center">
                            <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Concluídas</p>
                            <p class="text-2xl font-black text-emerald-700 dark:text-emerald-300">{{ $estatisticas['demandas_concluidas'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/30 text-center">
                            <p class="text-[10px] font-bold text-amber-400 uppercase tracking-widest mb-1">Em Andamento</p>
                            <p class="text-2xl font-black text-amber-700 dark:text-amber-300">{{ $estatisticas['demandas_em_andamento'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 text-center">
                            <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Abertas</p>
                            <p class="text-2xl font-black text-blue-700 dark:text-blue-300">{{ $estatisticas['demandas_abertas'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30">
                    <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="bolt" class="w-4 h-4 text-amber-500" style="duotone" />
                        Ações Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    @if(Route::has('demandas.create'))
                    <a href="{{ route('demandas.create', ['pessoa_id' => $pessoa->id]) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-xl hover:from-indigo-700 hover:to-blue-700 focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition-all font-bold shadow-lg shadow-indigo-500/20 group">
                        <x-icon name="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform" />
                        Nova Demanda
                    </a>
                    @endif

                    <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 font-bold transition-all shadow-sm hover:text-indigo-600 dark:bg-slate-800 dark:border-slate-700 dark:text-gray-300 dark:hover:bg-slate-700">
                        <x-icon name="print" class="w-5 h-5" style="duotone" />
                        Imprimir Ficha
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
