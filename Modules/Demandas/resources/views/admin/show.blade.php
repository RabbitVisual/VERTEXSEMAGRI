@extends('admin.layouts.admin')

@section('title', 'Demanda #' . $demanda->codigo . ' - Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon module="demandas" class="w-8 h-8 text-emerald-600 dark:text-emerald-500" />
                Demanda #{{ $demanda->codigo }}
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.demandas.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Demandas</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">#{{ $demanda->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.demandas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('demandas.show', $demanda->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                <x-icon name="eye" class="w-5 h-5" />
                Ver no Painel Padrão
            </a>
        </div>
    </div>
</div>

<!-- Informações da Demanda -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Dados Principais -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
                <x-icon name="circle-info" class="w-5 h-5 text-emerald-500" style="duotone" />
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Informações da Demanda</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Código</label>
                        <p class="text-base text-gray-900 dark:text-white font-semibold">{{ $demanda->codigo }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Status</label>
                        @php
                            $status = ['aberta' => 'info', 'em_andamento' => 'warning', 'concluida' => 'success', 'cancelada' => 'danger'];
                        @endphp
                        <x-admin.badge :type="$status[$demanda->status] ?? 'info'">{{ ucfirst(str_replace('_', ' ', $demanda->status)) }}</x-admin.badge>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Tipo</label>
                        @php
                            $tipos = ['agua' => 'Água', 'luz' => 'Luz', 'estrada' => 'Estrada', 'poco' => 'Poço'];
                        @endphp
                        <p class="text-base text-gray-900 dark:text-white">{{ $tipos[$demanda->tipo] ?? $demanda->tipo }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Prioridade</label>
                        @php
                            $prioridades = ['baixa' => 'info', 'media' => 'warning', 'alta' => 'danger', 'urgente' => 'danger'];
                        @endphp
                        <x-admin.badge :type="$prioridades[$demanda->prioridade] ?? 'info'">{{ ucfirst($demanda->prioridade) }}</x-admin.badge>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Solicitante</label>
                        <p class="text-base text-gray-900 dark:text-white font-medium">
                            {{ $demanda->solicitante_nome }}
                            @if($demanda->solicitante_apelido)
                                <span class="text-emerald-600 dark:text-emerald-400 text-sm">({{ $demanda->solicitante_apelido }})</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Localidade</label>
                        <p class="text-base text-gray-900 dark:text-white">{{ $demanda->localidade->nome ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Data de Abertura</label>
                        <p class="text-base text-gray-900 dark:text-white">{{ $demanda->data_abertura->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($demanda->data_conclusao)
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Data de Conclusão</label>
                        <p class="text-base text-gray-900 dark:text-white">{{ $demanda->data_conclusao->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Motivo</label>
                        <p class="text-base text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700/50 p-3 rounded-xl border border-gray-100 dark:border-slate-700">{{ $demanda->motivo }}</p>
                    </div>
                    @if($demanda->descricao)
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Descrição</label>
                        <p class="text-base text-gray-900 dark:text-white whitespace-pre-wrap bg-gray-50 dark:bg-slate-700/50 p-3 rounded-xl border border-gray-100 dark:border-slate-700">{{ $demanda->descricao }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ordem de Serviço Relacionada -->
        @if($demanda->ordemServico)
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
                <x-icon name="clipboard-check" class="w-5 h-5 text-emerald-500" style="duotone" />
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Ordem de Serviço Relacionada</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/30 rounded-2xl border border-gray-100 dark:border-slate-700">
                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código da OS:</span>
                        <a href="{{ route('admin.ordens.show', $demanda->ordemServico->id) }}" class="text-base font-bold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 hover:underline">
                            {{ $demanda->ordemServico->codigo }}
                        </a>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/30 rounded-2xl border border-gray-100 dark:border-slate-700">
                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status:</span>
                        @php
                            $statusOS = ['aberta' => 'info', 'em_andamento' => 'warning', 'concluida' => 'success', 'cancelada' => 'danger'];
                        @endphp
                        <x-admin.badge :type="$statusOS[$demanda->ordemServico->status] ?? 'info'">{{ ucfirst(str_replace('_', ' ', $demanda->ordemServico->status)) }}</x-admin.badge>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Estatísticas -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
                <x-icon name="chart-simple" class="w-5 h-5 text-emerald-500" style="duotone" />
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Estatísticas</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/50 text-center">
                    <label class="block text-xs font-bold text-emerald-600/70 dark:text-emerald-400/70 uppercase tracking-widest mb-1">Dias Aberta</label>
                    <p class="text-3xl font-black text-emerald-900 dark:text-white">{{ $estatisticas['dias_aberta'] }}</p>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/30 rounded-2xl border border-gray-100 dark:border-slate-700">
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tem OS</label>
                    <x-admin.badge :type="$estatisticas['tem_os'] ? 'success' : 'secondary'">
                        {{ $estatisticas['tem_os'] ? 'Sim' : 'Não' }}
                    </x-admin.badge>
                </div>
            </div>
        </div>

        <!-- Usuário Responsável -->
        @if($demanda->usuario)
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
                <x-icon name="user-shield" class="w-5 h-5 text-emerald-500" style="duotone" />
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Responsável</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-700 dark:text-emerald-300 font-bold text-lg">
                        {{ substr($demanda->usuario->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $demanda->usuario->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $demanda->usuario->email }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
