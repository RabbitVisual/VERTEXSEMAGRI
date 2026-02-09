@extends('Co-Admin.layouts.app')

@section('title', 'Ordens de Serviço')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 dark:from-blue-800 dark:via-blue-900 dark:to-blue-950 rounded-2xl shadow-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-sm shadow-lg">
                    <x-icon module="Ordens" class="w-10 h-10 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-2">
                        Ordens de Serviço
                    </h1>
                    <p class="text-blue-100 dark:text-blue-200 mt-2 text-sm md:text-base">
                        Gerenciamento e execução de serviços em campo
                    </p>
                </div>
            </div>
            <x-ordens::button href="{{ route('ordens.create') }}" variant="outline-primary" class="!bg-white !text-blue-600 hover:!bg-blue-50 !border-blue-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                <x-icon name="circle-plus" class="w-5 h-5 mr-2" />
                Nova Ordem
            </x-ordens::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-ordens::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-icon name="circle-check" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-ordens::alert>
    @endif

    @if(session('error'))
        <x-ordens::alert type="danger" dismissible>
            <div class="flex items-center gap-2">
                <x-icon name="triangle-exclamation" class="w-5 h-5" />
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </x-ordens::alert>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-stretch">
        <x-ordens::stat-card
            title="Total de Ordens"
            :value="$estatisticas['total'] ?? 0"
            icon="clipboard-list"
            color="primary"
            subtitle="Todas as ordens registradas"
        />
        <x-ordens::stat-card
            title="Pendentes"
            :value="$estatisticas['pendentes'] ?? 0"
            icon="clock"
            color="warning"
            subtitle="Aguardando início"
        />
        <x-ordens::stat-card
            title="Em Execução"
            :value="$estatisticas['em_execucao'] ?? 0"
            icon="screwdriver-wrench"
            color="info"
            subtitle="Sendo realizadas agora"
        />
        <x-ordens::stat-card
            title="Concluídas"
            :value="$estatisticas['concluidas'] ?? 0"
            icon="circle-check"
            color="success"
            subtitle="Serviços finalizados"
        />
        <x-ordens::stat-card
            title="Urgentes"
            :value="$estatisticas['urgentes'] ?? 0"
            icon="triangle-exclamation"
            color="danger"
            subtitle="Alta prioridade"
        />
    </div>
    @endif

    <!-- Filtros -->
    <x-ordens::filter-bar
        action="{{ route('ordens.index') }}"
        :filters="[
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'pendente' => 'Pendente',
                    'em_execucao' => 'Em Execução',
                    'concluida' => 'Concluída',
                    'cancelada' => 'Cancelada'
                ],
            ],
            [
                'name' => 'prioridade',
                'label' => 'Prioridade',
                'type' => 'select',
                'options' => [
                    '' => 'Todas',
                    'baixa' => 'Baixa',
                    'media' => 'Média',
                    'alta' => 'Alta',
                    'urgente' => 'Urgente'
                ],
            ],
            [
                'name' => 'tipo_servico',
                'label' => 'Tipo de Serviço',
                'type' => 'text',
                'placeholder' => 'Ex: Instalação...'
            ]
        ]"
        search-placeholder="Buscar por número, descrição ou solicitante..."
    />

    <!-- Informações de Resultados e Paginação -->
    @if($ordens->total() > 0)
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl px-6 py-4 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                    <x-icon name="circle-info" class="w-5 h-5 text-blue-700 dark:text-blue-300" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">
                        <span class="text-lg text-blue-600 dark:text-blue-400">{{ $ordens->total() }}</span>
                        {{ $ordens->total() == 1 ? 'ordem encontrada' : 'ordens encontradas' }}
                    </p>
                </div>
            </div>
            @if($ordens->hasPages())
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm">
                <x-icon name="file-lines" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                <span class="text-sm font-medium text-blue-900 dark:text-blue-200">
                    Página <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $ordens->currentPage() }}</span> de <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $ordens->lastPage() }}</span>
                </span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tabela de Ordens -->
    <x-ordens::data-table
        :headers="['Número', 'Demanda/Solicitante', 'Tipo Serviço', 'Prioridade', 'Equipe', 'Status', 'Ações']"
        :data="$ordens"
    >
        @forelse($ordens as $ordem)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl shadow-sm">
                            <x-icon name="clipboard-list" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $ordem->numero }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-col">
                        @if($ordem->demanda)
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->demanda->codigo }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $ordem->demanda->solicitante_nome }}</span>
                        @else
                            <span class="text-sm text-gray-500 dark:text-gray-400 italic">Sem demanda vinculada</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $ordem->tipo_servico }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $prioridadeColors = [
                            'baixa' => 'info',
                            'media' => 'primary',
                            'alta' => 'warning',
                            'urgente' => 'danger',
                        ];
                    @endphp
                    <x-ordens::badge :variant="$prioridadeColors[$ordem->prioridade] ?? 'secondary'">
                        {{ ucfirst($ordem->prioridade) }}
                    </x-ordens::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $ordem->equipe->nome ?? 'Não atribuída' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusColors = [
                            'pendente' => 'warning',
                            'em_execucao' => 'info',
                            'concluida' => 'success',
                            'cancelada' => 'danger',
                        ];
                    @endphp
                    <x-ordens::badge :variant="$statusColors[$ordem->status] ?? 'secondary'">
                        {{ ucfirst(str_replace('_', ' ', $ordem->status)) }}
                    </x-ordens::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('ordens.show', $ordem) }}"
                           class="p-2.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-all hover:scale-110"
                           title="Ver detalhes">
                            <x-icon name="eye" class="w-5 h-5" />
                        </a>

                        @if($ordem->podeIniciar() || $ordem->podeConcluir())
                            <a href="{{ route('ordens.edit', $ordem) }}"
                               class="p-2.5 text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition-all hover:scale-110"
                               title="Executar/Editar">
                                <x-icon name="screwdriver-wrench" class="w-5 h-5" />
                            </a>
                        @endif

                        <a href="{{ route('ordens.print', $ordem) }}" target="_blank"
                           class="p-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all hover:scale-110"
                           title="Imprimir">
                            <x-icon name="printer" class="w-5 h-5" />
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center justify-center max-w-md mx-auto">
                        <div class="p-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg">
                            <x-icon name="clipboard-list" class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Nenhuma ordem de serviço encontrada
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 text-center leading-relaxed">
                            Não encontramos ordens de serviço com os filtros aplicados ou ainda não há ordens registradas no sistema.
                        </p>
                        <x-ordens::button href="{{ route('ordens.create') }}" variant="primary" class="shadow-lg hover:shadow-xl transition-all">
                            <x-icon name="circle-plus" class="w-4 h-4 mr-2" />
                            Criar Nova Ordem
                        </x-ordens::button>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-ordens::data-table>

    <!-- Paginação -->
    @if($ordens->hasPages())
        <div class="mt-4">
            {{ $ordens->links() }}
        </div>
    @endif
</div>
@endsection
