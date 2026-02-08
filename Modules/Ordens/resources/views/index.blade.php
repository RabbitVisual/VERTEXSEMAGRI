@extends('Co-Admin.layouts.app')

@section('title', 'Ordens de Serviço')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Ordens" class="w-6 h-6" />
                Ordens de Serviço
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de ordens de serviço</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('ordens.relatorio.demandas-dia.pdf') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-500 dark:hover:bg-green-600 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Relatório Demandas do Dia
            </a>
            <x-ordens::button href="{{ route('ordens.create') }}" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Nova OS
            </x-ordens::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-ordens::alert type="success" dismissible>
            {{ session('success') }}
        </x-ordens::alert>
    @endif

    @if(session('warning'))
        <x-ordens::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-ordens::alert>
    @endif

    @if(session('error'))
        <x-ordens::alert type="danger" dismissible>
            {{ session('error') }}
        </x-ordens::alert>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <x-ordens::stat-card
            title="Total"
            :value="$estatisticas['total'] ?? 0"
            icon="document-text"
            color="primary"
        />
        <x-ordens::stat-card
            title="Pendentes"
            :value="$estatisticas['pendentes'] ?? 0"
            icon="clock"
            color="warning"
        />
        <x-ordens::stat-card
            title="Em Execução"
            :value="$estatisticas['em_execucao'] ?? 0"
            icon="play-circle"
            color="info"
        />
        <x-ordens::stat-card
            title="Concluídas"
            :value="$estatisticas['concluidas'] ?? 0"
            icon="check-circle"
            color="success"
        />
        <x-ordens::stat-card
            title="Urgentes"
            :value="$estatisticas['urgentes'] ?? 0"
            icon="exclamation-triangle"
            color="danger"
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
                'name' => 'equipe_id',
                'label' => 'Equipe',
                'type' => 'select',
                'options' => $equipes->pluck('nome', 'id')->toArray() + ['' => 'Todas'],
            ],
            [
                'name' => 'demanda_id',
                'label' => 'Demanda',
                'type' => 'select',
                'options' => $demandas->pluck('codigo', 'id')->toArray() + ['' => 'Todas'],
            ]
        ]"
        search-placeholder="Buscar por número, tipo ou descrição..."
    />

    <!-- Tabela de OS -->
    <x-ordens::data-table
        :headers="['Número', 'Demanda', 'Equipe', 'Tipo Serviço', 'Prioridade', 'Status', 'Data Abertura']"
        :data="$ordens"
        :export-route="route('ordens.index')"
    >
        @forelse($ordens as $ordem)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $ordem->numero }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($ordem->demanda)
                        <a href="{{ route('demandas.show', $ordem->demanda->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            {{ $ordem->demanda->codigo ?? '#' . $ordem->demanda->id }}
                        </a>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($ordem->equipe)
                        <a href="{{ route('equipes.show', $ordem->equipe->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            {{ $ordem->equipe->nome }}
                        </a>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 dark:text-white">{{ $ordem->tipo_servico }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $prioridadeVariants = [
                            'baixa' => 'gray',
                            'media' => 'info',
                            'alta' => 'warning',
                            'urgente' => 'danger'
                        ];
                        $prioridadeVariant = $prioridadeVariants[$ordem->prioridade] ?? 'default';
                    @endphp
                    <x-ordens::badge :variant="$prioridadeVariant">
                        {{ $ordem->prioridade_texto }}
                    </x-ordens::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = [
                            'pendente' => 'warning',
                            'em_execucao' => 'info',
                            'concluida' => 'success',
                            'cancelada' => 'danger'
                        ];
                        $statusVariant = $statusVariants[$ordem->status] ?? 'default';
                    @endphp
                    <x-ordens::badge :variant="$statusVariant">
                        {{ $ordem->status_texto }}
                    </x-ordens::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($ordem->data_abertura)
                        <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            {{ $ordem->data_abertura->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ordem->data_abertura->format('H:i') }}</div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <x-ordens::button href="{{ route('ordens.show', $ordem) }}" variant="outline" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </x-ordens::button>
                        <x-ordens::button href="{{ route('ordens.print', $ordem) }}" target="_blank" variant="outline" size="sm">
                            <x-ordens::icon name="printer" class="w-4 h-4" />
                        </x-ordens::button>
                        <x-ordens::button href="{{ route('ordens.edit', $ordem) }}" variant="outline" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                        </x-ordens::button>
                        <form action="{{ route('ordens.destroy', $ordem) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente deletar esta OS?')">
                            @csrf
                            @method('DELETE')
                            <x-ordens::button type="submit" variant="danger" size="sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </x-ordens::button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhuma ordem de serviço encontrada</p>
                    <x-ordens::button href="{{ route('ordens.create') }}" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Criar Primeira OS
                    </x-ordens::button>
                </td>
            </tr>
        @endforelse
    </x-ordens::data-table>
</div>
@endsection
