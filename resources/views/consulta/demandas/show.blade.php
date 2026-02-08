@extends('consulta.layouts.consulta')

@php
use App\Helpers\LgpdHelper;
@endphp

@section('title', 'Demanda #' . $demanda->codigo . ' - Consulta')

@section('content')
<!-- Alerta LGPD -->
<div class="mb-6 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-4">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-200">Proteção de Dados (LGPD)</h3>
            <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">Dados pessoais sensíveis estão mascarados para proteção conforme Lei nº 13.709/2018.</p>
        </div>
    </div>
</div>

<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <span>Demanda #{{ $demanda->codigo }}</span>
                <span class="text-sm bg-blue-500/20 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full border border-blue-300 dark:border-blue-700">Somente Leitura</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('consulta.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Consulta</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('consulta.demandas.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Demandas</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white">#{{ $demanda->codigo }}</span>
            </nav>
        </div>
        <a href="{{ route('consulta.demandas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Informações da Demanda -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Dados Principais -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Informações da Demanda (Dados Protegidos - LGPD)
                </h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código</label>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $demanda->codigo }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        @php
                            $status = ['aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300', 'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status[$demanda->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst(str_replace('_', ' ', $demanda->status)) }}</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                        @php
                            $tipos = ['agua' => 'Água', 'luz' => 'Luz', 'estrada' => 'Estrada', 'poco' => 'Poço'];
                        @endphp
                        <p class="text-sm text-gray-900 dark:text-white">{{ $tipos[$demanda->tipo] ?? $demanda->tipo }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prioridade</label>
                        @php
                            $prioridades = ['baixa' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'media' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'alta' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300', 'urgente' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $prioridades[$demanda->prioridade] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst($demanda->prioridade) }}</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Solicitante</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <p class="text-sm text-gray-900 dark:text-white">{{ LgpdHelper::maskName($demanda->solicitante_nome) }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <code class="px-2 py-1 bg-gray-100 dark:bg-slate-700 rounded text-sm text-gray-900 dark:text-white">{{ LgpdHelper::maskPhone($demanda->solicitante_telefone) }}</code>
                        </div>
                    </div>
                    @if($demanda->solicitante_email)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <code class="px-2 py-1 bg-gray-100 dark:bg-slate-700 rounded text-sm text-gray-900 dark:text-white">{{ LgpdHelper::maskEmail($demanda->solicitante_email) }}</code>
                        </div>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Localidade</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $demanda->localidade->nome ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Abertura</label>
                        <p class="text-sm text-gray-900 dark:text-white">
                            @if($demanda->data_abertura instanceof \Carbon\Carbon)
                                {{ $demanda->data_abertura->format('d/m/Y H:i') }}
                            @elseif(is_string($demanda->data_abertura))
                                {{ \Carbon\Carbon::parse($demanda->data_abertura)->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    @if($demanda->data_conclusao)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Conclusão</label>
                        <p class="text-sm text-gray-900 dark:text-white">
                            @if($demanda->data_conclusao instanceof \Carbon\Carbon)
                                {{ $demanda->data_conclusao->format('d/m/Y H:i') }}
                            @elseif(is_string($demanda->data_conclusao))
                                {{ \Carbon\Carbon::parse($demanda->data_conclusao)->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    @endif
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $demanda->motivo }}</p>
                    </div>
                    @if($demanda->descricao)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $demanda->descricao }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ordem de Serviço Relacionada -->
        @if($demanda->ordemServico)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Ordem de Serviço Relacionada</h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Código da OS:</span>
                        <a href="{{ route('consulta.ordens.show', $demanda->ordemServico->id) }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ $demanda->ordemServico->codigo ?? $demanda->ordemServico->numero }}
                        </a>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status:</span>
                        @php
                            $statusOS = ['aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300', 'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusOS[$demanda->ordemServico->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst(str_replace('_', ' ', $demanda->ordemServico->status)) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Estatísticas -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Estatísticas</h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dias Aberta</label>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['dias_aberta'] ?? 0 }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tem OS</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($estatisticas['tem_os'] ?? false) ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ ($estatisticas['tem_os'] ?? false) ? 'Sim' : 'Não' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Badge LGPD -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl border border-amber-200 dark:border-amber-800 p-4 text-center">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <h4 class="font-semibold text-amber-800 dark:text-amber-300 mb-1">Dados Protegidos</h4>
            <p class="text-sm text-amber-600 dark:text-amber-400">Lei nº 13.709/2018 (LGPD)</p>
        </div>
    </div>
</div>
@endsection
