@extends('Co-Admin.layouts.app')

@section('title', 'Demandas')

@section('content')
<div x-data="offlineManager" @click.capture="handleLinkClick($event)">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow gap-4">
        <div class="flex items-center gap-3">
            <div :class="online ? 'bg-green-500' : 'bg-orange-500'" class="w-3 h-3 rounded-full"></div>
            <div class="flex flex-col">
                <span x-text="online ? 'Online' : 'Offline Mode'" class="font-semibold text-gray-700 dark:text-gray-200"></span>
                <span x-show="lastSync" class="text-xs" :class="{
                    'text-green-600': syncColor === 'green',
                    'text-amber-600': syncColor === 'amber',
                    'text-red-600': syncColor === 'red',
                    'text-gray-500': syncColor === 'gray'
                }" x-text="'Último Sync: ' + lastSync"></span>
            </div>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button @click="$dispatch('open-outbox')" class="flex-1 sm:flex-none px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded transition flex items-center justify-center gap-2 relative">
                <x-demandas::icon name="paper-airplane" class="w-4 h-4" />
                <span>Pendências</span>
                <span x-show="queueCount > 0" x-text="queueCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center"></span>
            </button>
            <button @click="sync()" :disabled="syncing || !online" class="flex-1 sm:flex-none px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded transition disabled:opacity-50 flex items-center justify-center gap-2">
                <x-demandas::icon name="arrow-path" class="w-4 h-4" ::class="{'animate-spin': syncing}" />
                <span x-text="syncStatus"></span>
            </button>
        </div>
    </div>

    <div x-show="online">
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 dark:from-indigo-800 dark:via-indigo-900 dark:to-indigo-950 rounded-2xl shadow-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-sm shadow-lg">
                    <x-module-icon module="Demandas" class="w-10 h-10 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-2">
                        Gestão de Demandas
                    </h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Controle completo das demandas da população
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-demandas::button href="{{ route('demandas.relatorio.abertas.pdf') }}" target="_blank" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                    <x-demandas::icon name="document-arrow-down" class="w-5 h-5 mr-2" />
                    Relatório PDF
                </x-demandas::button>
                <x-demandas::button href="{{ route('demandas.create') }}" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                    <x-demandas::icon name="plus-circle" class="w-5 h-5 mr-2" />
                    Nova Demanda
                </x-demandas::button>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('warning'))
        <x-demandas::alert type="warning" dismissible>
            <div class="flex items-center gap-2">
                <x-demandas::icon name="exclamation-triangle" class="w-5 h-5" />
                <span class="font-medium">{!! session('warning') !!}</span>
            </div>
        </x-demandas::alert>
    @endif

    @if(session('success'))
        <x-demandas::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-demandas::icon name="check-circle" class="w-5 h-5" />
                <span class="font-medium">{!! session('success') !!}</span>
            </div>
        </x-demandas::alert>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 items-stretch">
        <x-demandas::stat-card
            title="Total"
            :value="$estatisticas['total'] ?? 0"
            icon="clipboard-check"
            color="primary"
            subtitle="Todas as demandas"
        />
        <x-demandas::stat-card
            title="Abertas"
            :value="$estatisticas['abertas'] ?? 0"
            icon="folder-open"
            color="info"
            subtitle="Aguardando atendimento"
        />
        <x-demandas::stat-card
            title="Em Andamento"
            :value="$estatisticas['em_andamento'] ?? 0"
            icon="clock-history"
            color="warning"
            subtitle="Sendo atendidas"
        />
        <x-demandas::stat-card
            title="Concluídas"
            :value="$estatisticas['concluidas'] ?? 0"
            icon="check-circle"
            color="success"
            subtitle="Finalizadas"
        />
        <x-demandas::stat-card
            title="Urgentes"
            :value="$estatisticas['urgentes'] ?? 0"
            icon="exclamation-triangle"
            color="danger"
            subtitle="Prioridade máxima"
        />
        <x-demandas::stat-card
            title="Sem OS"
            :value="$estatisticas['sem_os'] ?? 0"
            icon="document-x"
            color="secondary"
            subtitle="Sem ordem de serviço"
        />
    </div>

    <!-- Estatísticas por Tipo -->
    @if(isset($estatisticas['por_tipo']))
    <x-demandas::card class="rounded-xl shadow-lg">
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                    <x-module-icon module="Demandas" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Demandas por Tipo
                </h3>
            </div>
        </x-slot>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Água -->
            <div class="flex items-center gap-4 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900/40 rounded-lg flex-shrink-0">
                    <x-module-icon module="Agua" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['agua'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Água</div>
                </div>
            </div>

            <!-- Iluminação -->
            <div class="flex items-center gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-amber-100 dark:bg-amber-900/40 rounded-lg flex-shrink-0">
                    <x-module-icon module="Iluminacao" class="w-8 h-8 text-amber-600 dark:text-amber-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['luz'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Iluminação</div>
                </div>
            </div>

            <!-- Estrada -->
            <div class="flex items-center gap-4 p-4 bg-violet-50 dark:bg-violet-900/20 rounded-lg border border-violet-200 dark:border-violet-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-violet-100 dark:bg-violet-900/40 rounded-lg flex-shrink-0">
                    <x-module-icon module="Estradas" class="w-8 h-8 text-violet-600 dark:text-violet-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['estrada'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Estrada</div>
                </div>
            </div>

            <!-- Poço -->
            <div class="flex items-center gap-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex-shrink-0">
                    <x-module-icon module="Pocos" class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['poco'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Poço</div>
                </div>
            </div>
        </div>
    </x-demandas::card>
    @endif
    @endif

    <!-- Filtros -->
    @include('demandas::components.filter-bar', [
        'action' => route('demandas.index'),
        'filters' => [
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['' => 'Todos', 'aberta' => 'Aberta', 'em_andamento' => 'Em Andamento', 'concluida' => 'Concluída', 'cancelada' => 'Cancelada']],
            ['name' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['' => 'Todos', 'agua' => 'Água', 'luz' => 'Luz', 'estrada' => 'Estrada', 'poco' => 'Poço']],
            ['name' => 'prioridade', 'label' => 'Prioridade', 'type' => 'select', 'options' => ['' => 'Todas', 'baixa' => 'Baixa', 'media' => 'Média', 'alta' => 'Alta', 'urgente' => 'Urgente']],
            ['name' => 'localidade_id', 'label' => 'Localidade', 'type' => 'select', 'options' => $localidades->pluck('nome', 'id')->toArray() + ['' => 'Todas']],
        ],
        'searchPlaceholder' => 'Buscar por solicitante, apelido, código ou motivo...'
    ])

    <!-- Informações de Resultados e Paginação Superior -->
    @if($demandas->total() > 0)
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl px-6 py-4 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                    <x-demandas::icon name="information-circle" class="w-5 h-5 text-blue-700 dark:text-blue-300" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">
                        <span class="text-lg text-indigo-600 dark:text-indigo-400">{{ $demandas->total() }}</span>
                        {{ $demandas->total() == 1 ? 'demanda encontrada' : 'demandas encontradas' }}
                    </p>
                    @if(request()->hasAny(['search', 'status', 'tipo', 'prioridade', 'localidade_id']))
                        <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                            Com os filtros aplicados
                        </p>
                    @endif
                </div>
            </div>
            @if($demandas->hasPages())
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm">
                <x-demandas::icon name="document-text" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                <span class="text-sm font-medium text-blue-900 dark:text-blue-200">
                    Página <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $demandas->currentPage() }}</span> de <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $demandas->lastPage() }}</span>
                </span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tabela de Demandas -->
    <x-demandas::data-table
        :headers="['Código', 'Solicitante', 'Localidade', 'Tipo', 'Prioridade', 'Status', 'Afetados', 'Data Abertura', 'OS']"
        :data="$demandas"
        export-route="{{ route('demandas.index') }}"
    >
        @forelse($demandas as $demanda)
            @php
                $isHighSimilarity = ($demanda->score_similaridade_max ?? 0) > 80;
                $rowClass = $isHighSimilarity ? 'bg-amber-50 dark:bg-amber-900/10 hover:bg-amber-100 dark:hover:bg-amber-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-800/50';
            @endphp
            <tr class="{{ $rowClass }} transition-all duration-200">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-xl shadow-sm">
                            <x-module-icon module="Demandas" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $demanda->codigo ?? 'N/A' }}</span>
                            @if($isHighSimilarity)
                                <div class="flex items-center gap-1 mt-1 text-xs text-amber-600 dark:text-amber-400" title="Geographic Similarity: {{ $demanda->score_similaridade_max }}% - Nearby Demand detected">
                                    <x-icon name="triangle-exclamation" class="w-3 h-3" />
                                    <span>Duplicata Provável</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-xl shadow-sm">
                            <x-demandas::icon name="user" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                {{ $demanda->solicitante_nome }}
                                @if($demanda->solicitante_apelido)
                                    <span class="text-indigo-600 dark:text-indigo-400 font-normal text-xs">({{ $demanda->solicitante_apelido }})</span>
                                @endif
                            </div>
                            @if($demanda->solicitante_telefone)
                                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                    <x-demandas::icon name="phone" class="w-4 h-4" />
                                    {{ $demanda->solicitante_telefone }}
                                </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($demanda->localidade)
                        <a href="{{ route('localidades.show', $demanda->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center gap-1">
                            <x-demandas::icon name="map-pin" class="w-4 h-4" />
                            {{ $demanda->localidade->nome }}
                        </a>
                    @else
                        <span class="text-gray-500 dark:text-gray-400">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $tipoModules = [
                            'agua' => 'Agua',
                            'luz' => 'Iluminacao',
                            'estrada' => 'Estradas',
                            'poco' => 'Pocos'
                        ];
                        $tipoModule = $tipoModules[$demanda->tipo] ?? 'Demandas';
                    @endphp
                    <div class="flex items-center gap-2">
                        <x-module-icon module="{{ $tipoModule }}" class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                        <span class="text-gray-900 dark:text-white">{{ $demanda->tipo_texto }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $prioridadeVariants = ['baixa' => 'secondary', 'media' => 'info', 'alta' => 'warning', 'urgente' => 'danger'];
                        $prioridadeVariant = $prioridadeVariants[$demanda->prioridade] ?? 'default';
                    @endphp
                    <x-demandas::badge :variant="$prioridadeVariant">
                        {{ $demanda->prioridade_texto }}
                    </x-demandas::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = ['aberta' => 'info', 'em_andamento' => 'warning', 'concluida' => 'success', 'cancelada' => 'danger'];
                        $statusVariant = $statusVariants[$demanda->status] ?? 'default';
                    @endphp
                    <x-demandas::badge :variant="$statusVariant">
                        {{ $demanda->status_texto }}
                    </x-demandas::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @php
                        $totalInteressados = $demanda->total_interessados ?? 1;
                        $badgeColor = $totalInteressados >= 10 ? 'danger' : ($totalInteressados >= 5 ? 'warning' : ($totalInteressados >= 2 ? 'info' : 'secondary'));
                    @endphp
                    @if($totalInteressados > 1)
                        <a href="{{ route('demandas.interessados', $demanda->id) }}" class="inline-flex items-center gap-1 group" title="Ver pessoas afetadas">
                            <x-demandas::badge :variant="$badgeColor" class="group-hover:scale-110 transition-transform">
                                <x-demandas::icon name="users" class="w-3.5 h-3.5 mr-1" />
                                {{ $totalInteressados }}
                            </x-demandas::badge>
                        </a>
                    @else
                        <span class="text-gray-400 dark:text-gray-500 text-sm">1</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    @if($demanda->data_abertura)
                        <div class="flex items-center gap-1">
                            <x-demandas::icon name="calendar" class="w-4 h-4" />
                            {{ $demanda->data_abertura->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $demanda->data_abertura->format('H:i') }}</div>
                        @if($demanda->diasAberta() !== null)
                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                <x-demandas::icon name="clock" class="w-3 h-3" />
                                {{ $demanda->diasAberta() }} dias
                            </div>
                        @endif
                    @else
                        <span class="text-gray-500 dark:text-gray-400">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($demanda->ordemServico)
                        <a href="{{ route('ordens.show', $demanda->ordemServico->id) }}" class="inline-flex">
                            <x-demandas::badge variant="success">
                                {{ $demanda->ordemServico->numero }}
                            </x-demandas::badge>
                        </a>
                    @else
                        <x-demandas::badge variant="secondary">
                            Sem OS
                        </x-demandas::badge>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('demandas.show', $demanda) }}"
                           class="p-2.5 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-all hover:scale-110"
                           title="Ver detalhes">
                            <x-demandas::icon name="eye" class="w-5 h-5" />
                        </a>
                        @if($demanda->solicitante_email)
                            <form action="{{ route('demandas.reenviar-email', $demanda) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Deseja reenviar o email de confirmação para {{ $demanda->solicitante_email }}?')">
                                @csrf
                                <button type="submit"
                                        class="p-2.5 text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-all hover:scale-110"
                                        title="Reenviar Email">
                                    <x-demandas::icon name="envelope" class="w-5 h-5" />
                                </button>
                            </form>
                        @endif
                        @if($demanda->podeCriarOS() && Route::has('ordens.create'))
                            <a href="{{ route('ordens.create', ['demanda_id' => $demanda->id]) }}"
                               class="p-2.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-all hover:scale-110"
                               title="Criar OS">
                                <x-demandas::icon name="document-plus" class="w-5 h-5" />
                            </a>
                        @endif
                        <a href="{{ route('demandas.edit', $demanda) }}"
                           class="p-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all hover:scale-110"
                           title="Editar">
                            <x-demandas::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('demandas.print', $demanda) }}" target="_blank"
                           class="p-2.5 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-lg transition-all hover:scale-110"
                           title="Imprimir">
                            <x-demandas::icon name="printer" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('demandas.destroy', $demanda) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja deletar esta demanda? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all hover:scale-110"
                                    title="Deletar">
                                <x-demandas::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center justify-center max-w-md mx-auto">
                        <div class="p-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg">
                            <x-module-icon module="Demandas" class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Nenhuma demanda encontrada
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 text-center leading-relaxed">
                            @if(request()->hasAny(['search', 'status', 'tipo', 'prioridade', 'localidade_id']))
                                Não encontramos demandas com os filtros aplicados. Tente ajustar os filtros ou limpar a busca para ver todas as demandas disponíveis.
                            @else
                                Comece cadastrando sua primeira demanda no sistema para gerenciar as solicitações da população de forma eficiente.
                            @endif
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if(request()->hasAny(['search', 'status', 'tipo', 'prioridade', 'localidade_id']))
                                <x-demandas::button href="{{ route('demandas.index') }}" variant="outline" class="border-2">
                                    <x-demandas::icon name="arrow-path" class="w-4 h-4 mr-2" />
                                    Limpar Filtros
                                </x-demandas::button>
                            @endif
                            <x-demandas::button href="{{ route('demandas.create') }}" variant="primary" class="shadow-lg hover:shadow-xl transition-all">
                                <x-demandas::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                Criar Primeira Demanda
                            </x-demandas::button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-demandas::data-table>
</div>

    <!-- Outbox Modal -->
    <div x-data="{ open: false }" @open-outbox.window="open = true" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-lg w-full p-6 relative shadow-xl h-[80vh] flex flex-col" @click.outside="open = false">
             <div class="flex justify-between items-center mb-4">
                 <h2 class="text-xl font-bold dark:text-white flex items-center gap-2">
                     <x-demandas::icon name="paper-airplane" class="w-5 h-5" />
                     Fila de Envio
                 </h2>
                 <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
             </div>

             <div class="flex-1 overflow-y-auto space-y-3">
                <template x-for="item in queueItems" :key="item.id">
                    <div class="p-3 border rounded bg-gray-50 dark:bg-gray-700/50 flex items-start gap-3">
                        <div class="mt-1">
                            <x-demandas::icon name="clock" class="w-4 h-4 text-gray-400" />
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <strong class="text-sm text-gray-800 dark:text-gray-200" x-text="item.action === 'upload_photo' ? 'Envio de Foto' : 'Atualização de Status'"></strong>
                                <span class="text-xs text-gray-500" x-text="new Date(item.timestamp).toLocaleTimeString()"></span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="'ID: ' + (item.payload.demand_id || item.payload.demandId || 'N/A')"></p>
                        </div>
                    </div>
                </template>
                <div x-show="queueItems.length === 0" class="text-center py-8 text-gray-500">
                    Nenhuma pendência na fila.
                </div>
             </div>

             <div class="mt-4 pt-4 border-t dark:border-gray-700">
                 <button @click="processQueue()" :disabled="!online || queueCount === 0" class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white py-3 rounded-lg font-semibold flex items-center justify-center gap-2">
                     <x-demandas::icon name="arrow-path" class="w-5 h-5" />
                     Sincronizar Agora
                 </button>
             </div>
        </div>
    </div>

@push('scripts')
<script>
function toggleDropdown(button) {
    const dropdown = button.closest('.relative');
    const menu = dropdown.querySelector('[id^="dropdown-menu-"]');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative[id^="export-dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-menu-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>
@endpush
    <!-- Demand Details Modal (Offline Actions) -->
    <div x-show="selectedDemand" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6 relative" @click.outside="selectedDemand = null">

            <template x-if="selectedDemand">
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Ação na Demanda #<span x-text="selectedDemand.codigo"></span>
                        </h3>
                        <button @click="selectedDemand = null" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Fechar</span>
                            <x-demandas::icon name="x-mark" class="w-6 h-6" />
                        </button>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="selectedDemand.descricao"></p>

                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" x-model="imageConsent" class="form-checkbox h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            <span class="text-sm text-gray-700 dark:text-gray-200 font-medium">Cidadão autorizou uso de imagem?</span>
                        </label>
                        <p x-show="!imageConsent" class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center">
                            <x-demandas::icon name="lock-closed" class="w-3 h-3 mr-1" />
                            Foto será marcada como Uso Interno (LGPD)
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex flex-col items-center justify-center p-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition">
                            <x-demandas::icon name="camera" class="w-6 h-6 text-gray-400 mb-1" />
                            <span class="text-xs text-gray-500">Adicionar Foto</span>
                            <input type="file" accept="image/*" capture="environment" class="hidden" @change="capturePhoto($event)">
                        </label>

                        <button @click="toggleRadar()" class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition" :class="{'bg-indigo-50 border-indigo-200 dark:bg-indigo-900/30': radarActive}">
                            <x-demandas::icon name="map-pin" class="w-6 h-6 mb-1" x-bind:class="radarActive ? 'text-indigo-600' : 'text-gray-400'" />
                            <span class="text-xs" x-bind:class="radarActive ? 'text-indigo-700 font-semibold' : 'text-gray-500'" x-text="radarActive ? 'Parar Radar' : 'Ativar Radar'"></span>
                        </button>
                    </div>

                    <div x-show="radarActive" class="p-4 bg-gray-900 rounded-lg text-center text-white relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle,_var(--tw-gradient-stops))] from-green-500 to-transparent animate-pulse"></div>
                        <div class="relative z-10">
                            <div class="text-3xl font-bold mb-1" x-text="targetDistance ? targetDistance + 'm' : 'Calculando...'"></div>
                            <div class="text-xs text-gray-400 uppercase tracking-widest">Distância do Alvo</div>

                            <div class="mt-4 flex justify-center">
                                <div class="w-16 h-16 rounded-full border-2 border-green-500 flex items-center justify-center" :style="'transform: rotate(' + getRelativeBearing() + 'deg)'">
                                    <x-demandas::icon name="arrow-up" class="w-8 h-8 text-green-500" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
                        <textarea x-model="selectedDemand.observacoes_temp" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" rows="3" placeholder="Adicione observações sobre a execução..."></textarea>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium shadow-sm transition-colors" @click="saveStatus()">
                            Concluir Atendimento
                        </button>
                        <button class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white py-2 rounded-lg font-medium transition-colors" @click="selectedDemand = null">
                            Cancelar
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
@endsection
