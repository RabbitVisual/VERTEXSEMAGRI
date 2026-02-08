@extends('admin.layouts.admin')

@section('title', 'Ponto de Luz #' . $ponto->codigo . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Iluminacao" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Ponto de Luz #{{ $ponto->codigo }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.iluminacao.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Iluminação</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">#{{ $ponto->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.iluminacao.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </a>
            <a href="{{ route('iluminacao.show', $ponto->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Ver no Painel Padrão
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Estatísticas do Ponto -->
    @if(isset($estatisticasPonto))
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPonto['total_demandas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg dark:bg-indigo-900/30">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h5.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas Abertas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPonto['demandas_abertas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens de Serviço</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPonto['total_ordens'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-lg dark:bg-amber-900/30">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655-5.653a1.125 1.125 0 00-1.591-.027L4.5 15.75m8.128-8.128a2.25 2.25 0 013.182 0l1.5 1.5m-3.182-3.182l-1.5-1.5a2.25 2.25 0 00-3.182 0m3.182 3.182L9.75 9.75" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens Concluídas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPonto['ordens_concluidas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-lg dark:bg-emerald-900/30">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Informações do Ponto de Luz - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Ponto de Luz</h3>
        </div>
        <div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código</label>
            <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $ponto->codigo }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
            @php
                $statusCores = [
                    'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                    'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                    'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
                ];
                $statusMap = ['funcionando' => 'success', 'com_defeito' => 'danger', 'desligado' => 'warning'];
                $statusClass = $statusCores[$statusMap[$ponto->status] ?? 'info'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
            @endphp
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $ponto->status ?? '-')) }}</span>
        </div>
        @if($ponto->localidade)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Localidade</label>
            <a href="{{ route('admin.localidades.show', $ponto->localidade->id) }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                {{ $ponto->localidade->nome }}
            </a>
        </div>
        @endif
        @if($ponto->endereco)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Endereço</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ $ponto->endereco }}</p>
        </div>
        @endif
        @if($ponto->tipo_lampada)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Lâmpada</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst($ponto->tipo_lampada) }}</p>
        </div>
        @endif
        @if($ponto->potencia)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Potência</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ $ponto->potencia }}W</p>
        </div>
        @endif
        @if($ponto->tipo_poste)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Poste</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst($ponto->tipo_poste) }}</p>
        </div>
        @endif
        @if($ponto->altura_poste)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Altura do Poste</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ number_format($ponto->altura_poste, 2, ',', '.') }}m</p>
        </div>
        @endif
        @if($ponto->tipo_fiacao)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Fiação</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst($ponto->tipo_fiacao) }}</p>
        </div>
        @endif
        @if($ponto->data_instalacao)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de Instalação</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ $ponto->data_instalacao->format('d/m/Y') }}</p>
        </div>
        @endif
        @if($ponto->ultima_manutencao)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Última Manutenção</label>
            <p class="text-sm text-gray-900 dark:text-white">{{ $ponto->ultima_manutencao->format('d/m/Y') }}</p>
        </div>
        @endif
        @if($ponto->latitude && $ponto->longitude)
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Localização</label>
            <p class="text-sm text-gray-900 dark:text-white">
                Lat: {{ $ponto->latitude }}, Long: {{ $ponto->longitude }}
                @if($ponto->nome_mapa)
                    <span class="text-gray-500">({{ $ponto->nome_mapa }})</span>
                @endif
            </p>
        </div>
        @endif
        @if($ponto->observacoes)
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $ponto->observacoes }}</p>
        </div>
        @endif
            </div>
        </div>
    </div>

    <!-- Demandas Relacionadas - Flowbite Card -->
    @if(isset($demandasRelacionadas) && $demandasRelacionadas->count() > 0)
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demandas de Iluminação Relacionadas ({{ $demandasRelacionadas->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                <tr>
                        <th scope="col" class="px-6 py-3">Código</th>
                        <th scope="col" class="px-6 py-3">Solicitante</th>
                        <th scope="col" class="px-6 py-3">Motivo</th>
                        <th scope="col" class="px-6 py-3">Prioridade</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Data</th>
                        <th scope="col" class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandasRelacionadas as $demanda)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $demanda->codigo ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $demanda->solicitante_nome }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($demanda->motivo, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $prioridadeCores = [
                                    'secondary' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $prioridadeClass = $prioridadeCores[$demanda->prioridade_cor] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $prioridadeClass }}">{{ $demanda->prioridade_texto }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusCores = [
                                    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'secondary' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                                ];
                                $statusClass = $statusCores[$demanda->status_cor] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ $demanda->status_texto }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            {{ $demanda->data_abertura ? $demanda->data_abertura->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.demandas.show', $demanda->id) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors" title="Ver detalhes">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('admin.demandas.index', ['tipo' => 'luz', 'localidade_id' => $ponto->localidade_id]) }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                Ver todas as demandas de iluminação desta localidade →
            </a>
        </div>
    </div>
    @endif

    <!-- Ordens de Serviço Relacionadas - Flowbite Card -->
    @if(isset($ordensRelacionadas) && $ordensRelacionadas->count() > 0)
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordens de Serviço Relacionadas ({{ $ordensRelacionadas->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                <tr>
                        <th scope="col" class="px-6 py-3">Número</th>
                        <th scope="col" class="px-6 py-3">Tipo de Serviço</th>
                        <th scope="col" class="px-6 py-3">Equipe</th>
                        <th scope="col" class="px-6 py-3">Prioridade</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Data Abertura</th>
                        <th scope="col" class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ordensRelacionadas as $ordem)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->numero }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $ordem->tipo_servico }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            @if($ordem->equipe)
                                <a href="{{ route('admin.equipes.show', $ordem->equipe->id) }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                                    {{ $ordem->equipe->nome }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $prioridadeCores = [
                                    'secondary' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $prioridadeMap = ['baixa' => 'secondary', 'media' => 'info', 'alta' => 'warning', 'urgente' => 'danger'];
                                $prioridadeClass = $prioridadeCores[$prioridadeMap[$ordem->prioridade] ?? 'info'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $prioridadeClass }}">{{ ucfirst($ordem->prioridade) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusCores = [
                                    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'secondary' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                                ];
                                $statusMap = ['pendente' => 'info', 'em_execucao' => 'warning', 'concluida' => 'success', 'cancelada' => 'danger'];
                                $statusClass = $statusCores[$statusMap[$ordem->status] ?? 'info'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $ordem->status)) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            {{ $ordem->data_abertura ? $ordem->data_abertura->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors" title="Ver detalhes">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('admin.ordens.index', ['tipo_servico' => 'Luz']) }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                Ver todas as ordens de serviço de iluminação →
            </a>
        </div>
    </div>
    @endif

    <!-- Dica de Uso - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">💡 Dicas de Uso</h3>
        </div>
        <div class="p-6">
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                <p><strong>Integração Completa:</strong> O módulo Iluminação está totalmente integrado com os demais módulos do sistema.</p>
                <ul class="list-disc list-inside space-y-1 ml-4">
                    <li><strong>Demandas:</strong> Ao cadastrar uma demanda de iluminação (ex: poste quebrado, luz queimada, relé com problema, braço de poste danificado), ela será automaticamente relacionada à localidade e poderá gerar uma ordem de serviço.</li>
                    <li><strong>Ordens de Serviço:</strong> As ordens criadas a partir de demandas de iluminação aparecerão aqui, permitindo acompanhar todo o fluxo de atendimento.</li>
                    <li><strong>Materiais:</strong> Os materiais utilizados nas ordens de serviço de iluminação (lâmpadas, relés, braços de poste, etc.) são rastreados automaticamente.</li>
                    <li><strong>Equipes:</strong> As equipes responsáveis pelas ordens de serviço podem ser visualizadas e gerenciadas.</li>
                    <li><strong>Relatórios:</strong> Todas as informações podem ser exportadas para relatórios completos.</li>
                </ul>
                <p class="mt-3"><strong>Fluxo Recomendado:</strong> Demanda (Poste quebrado/Luz queimada/Relé com problema) → Ordem de Serviço → Execução → Conclusão → Relatório</p>
                <p class="mt-2"><strong>Tipos Comuns de Demanda:</strong> Poste público quebrado, luz queimada, relé com problema, braço de poste danificado, fiação danificada, poste tombado, entre outros.</p>
            </div>
        </div>
    </div>
</div>
@endsection
