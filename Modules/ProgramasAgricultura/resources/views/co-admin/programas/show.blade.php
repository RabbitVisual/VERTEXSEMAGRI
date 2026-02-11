@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Programa - Agricultura')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="leaf" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                {{ $programa->nome }}
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('co-admin.programas.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Programas</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Detalhes</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('co-admin.programas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors font-semibold">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('co-admin.programas.edit', $programa->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-none font-bold">
                <x-icon name="pencil" class="w-5 h-5" />
                Editar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Coluna Principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Card de Informações -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="circle-info" class="w-5 h-5 text-indigo-500" />
                    Informações Gerais
                </h3>
            </div>
            <div class="p-6">
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-gray-700 dark:text-slate-300">{{ $programa->descricao ?: 'Sem descrição detalhada.' }}</p>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Código</p>
                        <p class="text-lg font-mono text-indigo-600 dark:text-indigo-400 font-bold tracking-tight">{{ $programa->codigo }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tipo</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold">{{ $programa->tipo_texto }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Período</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold flex items-center gap-2">
                            <x-icon name="calendar" class="w-5 h-5 text-gray-400" />
                            {{ $programa->data_inicio ? $programa->data_inicio->format('d/m/Y') : 'Início imediato' }}
                            @if($programa->data_fim)
                                <x-icon name="arrow-right" class="w-4 h-4 text-gray-400" />
                                {{ $programa->data_fim->format('d/m/Y') }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Visibilidade</p>
                        <p class="text-lg text-gray-900 dark:text-white font-semibold flex items-center gap-2">
                            <x-icon name="{{ $programa->publico ? 'eye' : 'eye-slash' }}" class="w-5 h-5 text-gray-400" />
                            {{ $programa->publico_texto }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas Rápidas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                        <x-icon name="users" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Beneficiários</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white leading-none">
                    {{ $programa->beneficiarios_count }}
                </div>
                <p class="text-sm text-gray-500 mt-2 italic">Total de inscritos e ativos</p>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <x-icon name="chart-simple" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Vagas</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white leading-none">
                    {{ $programa->vagas_preenchidas }}/{{ $programa->vagas_disponiveis ?: '∞' }}
                </div>
                <div class="mt-2 w-full bg-gray-200 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                    @php
                        $perc = $programa->vagas_disponiveis > 0 ? ($programa->vagas_preenchidas / $programa->vagas_disponiveis) * 100 : 0;
                        $perc = min(100, $perc);
                    @endphp
                    <div class="bg-indigo-600 h-full transition-all duration-500" style="width: {{ $perc }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coluna Lateral -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Status do Programa</p>
                @php
                    $statusColors = [
                        'ativo' => 'bg-emerald-500',
                        'suspenso' => 'bg-amber-500',
                        'encerrado' => 'bg-red-500',
                    ];
                    $dotColor = $statusColors[$programa->status] ?? 'bg-gray-500';
                @endphp
                <div class="flex items-center gap-3">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $dotColor }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 {{ $dotColor }}"></span>
                    </span>
                    <span class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-wider">{{ $programa->status }}</span>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-slate-400 leading-relaxed italic">
                    Última atualização: <span class="font-semibold text-gray-700 dark:text-slate-300">{{ $programa->updated_at->format('d/m/Y H:i') }}</span>
                </p>
            </div>
        </div>

        <!-- Ações do Co-Admin -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase mb-4 border-b border-gray-100 dark:border-slate-700 pb-2 flex items-center gap-2">
                <x-icon name="bolt" class="w-4 h-4 text-amber-500" />
                Ações Administrativas
            </h4>
            <div class="space-y-3">
                <a href="{{ route('co-admin.beneficiarios.create', ['programa_id' => $programa->id]) }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-bold shadow-sm">
                    <x-icon name="user-plus" class="w-5 h-5" />
                    Adicionar Beneficiário
                </a>
                <button onclick="window.print()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors font-bold">
                    <x-icon name="print" class="w-5 h-5" />
                    Imprimir Relatório
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
