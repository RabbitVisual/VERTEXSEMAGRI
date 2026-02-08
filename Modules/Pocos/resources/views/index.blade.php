@extends('Co-Admin.layouts.app')

@section('title', 'Poços Artesianos')

@push('styles')
<style>
    /* Garantir altura consistente dos cards de estatísticas */
    .stats-grid > div {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .stats-grid > div > div {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .stats-card-content {
        flex: 1;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pocos" class="w-6 h-6" />
                Poços Artesianos
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de poços artesianos e sistemas de abastecimento</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-pocos::button href="{{ route('pocos.create') }}" variant="primary">
                <x-pocos::icon name="plus-circle" class="w-4 h-4 mr-2" />
                Novo Poço
            </x-pocos::button>
        </div>
    </div>

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="stats-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total de Poços -->
        <div class="relative flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="flex-1 bg-blue-600 dark:bg-blue-500 text-blue-50 p-5 rounded-t-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 opacity-10">
                    <div class="w-full h-full rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="stats-card-content flex items-start justify-between relative z-10">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium opacity-90 mb-1.5">Total de Poços</p>
                        <p class="text-2xl font-bold leading-tight whitespace-nowrap">{{ number_format((int)($estatisticas['total'] ?? 0), 0, ',', '.') }}</p>
                    </div>
                    <div class="ml-3 flex-shrink-0 opacity-75">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.601a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Poços Ativos -->
        <div class="relative flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="flex-1 bg-emerald-600 dark:bg-emerald-500 text-emerald-50 p-5 rounded-t-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 opacity-10">
                    <div class="w-full h-full rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="stats-card-content flex items-start justify-between relative z-10">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium opacity-90 mb-1.5">Poços Ativos</p>
                        <p class="text-2xl font-bold leading-tight whitespace-nowrap">{{ number_format((int)($estatisticas['ativos'] ?? 0), 0, ',', '.') }}</p>
                    </div>
                    <div class="ml-3 flex-shrink-0 opacity-75">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Em Manutenção -->
        <div class="relative flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="flex-1 bg-amber-500 dark:bg-amber-500 text-amber-50 p-5 rounded-t-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 opacity-10">
                    <div class="w-full h-full rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="stats-card-content flex items-start justify-between relative z-10">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium opacity-90 mb-1.5">Em Manutenção</p>
                        <p class="text-2xl font-bold leading-tight whitespace-nowrap">{{ number_format((int)($estatisticas['em_manutencao'] ?? 0), 0, ',', '.') }}</p>
                    </div>
                    <div class="ml-3 flex-shrink-0 opacity-75">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655-5.653a2.548 2.548 0 00-4.655 5.653l4.655 5.653c.274.333.65.583 1.068.747M17.25 21l-2.25-2.25m0 0l-4.5-4.5m4.5 4.5l-2.25-2.25m0 0l-4.5-4.5m4.5 4.5l2.25-2.25" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Com Problemas -->
        <div class="relative flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="flex-1 bg-red-600 dark:bg-red-500 text-red-50 p-5 rounded-t-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 opacity-10">
                    <div class="w-full h-full rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);"></div>
                </div>
                <div class="stats-card-content flex items-start justify-between relative z-10">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium opacity-90 mb-1.5">Com Problemas</p>
                        <p class="text-2xl font-bold leading-tight whitespace-nowrap">{{ number_format((int)($estatisticas['com_problemas'] ?? 0), 0, ',', '.') }}</p>
                        @if(isset($estatisticas['precisam_manutencao']) && $estatisticas['precisam_manutencao'] > 0)
                        <p class="text-xs opacity-80 mt-1">Precisam Manutenção: {{ number_format((int)$estatisticas['precisam_manutencao'], 0, ',', '.') }}</p>
                        @endif
                    </div>
                    <div class="ml-3 flex-shrink-0 opacity-75">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Alertas -->
    @if(session('warning'))
        <x-pocos::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-pocos::alert>
    @endif

    @if(session('success'))
        <x-pocos::alert type="success" dismissible>
            {{ session('success') }}
        </x-pocos::alert>
    @endif

    <!-- Filtros -->
    <x-pocos::filter-bar
        action="{{ route('pocos.index') }}"
        :filters="[
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'ativo' => 'Ativo',
                    'inativo' => 'Inativo',
                    'manutencao' => 'Manutenção',
                    'bomba_queimada' => 'Bomba Queimada'
                ],
                'col' => 3
            ],
            [
                'name' => 'localidade_id',
                'label' => 'Localidade',
                'type' => 'select',
                'options' => $localidades->pluck('nome', 'id')->toArray() + ['' => 'Todas'],
                'col' => 3
            ],
            [
                'name' => 'equipe_responsavel_id',
                'label' => 'Equipe',
                'type' => 'select',
                'options' => $equipes->pluck('nome', 'id')->toArray() + ['' => 'Todas'],
                'col' => 3
            ]
        ]"
        search-placeholder="Buscar por código, endereço ou tipo de bomba..."
    />

    <!-- Tabela de Poços -->
    <x-pocos::data-table
        :headers="['Código', 'Localidade', 'Endereço', 'Profundidade', 'Vazão', 'Equipe', 'Status']"
        :data="$pocos"
        export-route="{{ route('pocos.index') }}"
    >
        @forelse($pocos as $poco)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <strong class="text-indigo-600 dark:text-indigo-400">{{ $poco->codigo ?? 'N/A' }}</strong>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($poco->localidade)
                        <a href="{{ route('localidades.show', $poco->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 flex items-center gap-1">
                            <x-pocos::icon name="map-pin" class="w-4 h-4" />
                            {{ $poco->localidade->nome }}
                        </a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-1">
                        <x-pocos::icon name="map" class="w-4 h-4 text-gray-400" />
                        <span>{{ $poco->endereco }}</span>
                    </div>
                    @if($poco->precisaManutencao())
                        <div class="mt-1">
                            <x-pocos::badge variant="warning" size="sm">
                                <x-pocos::icon name="exclamation-triangle" class="w-3 h-3 mr-1" />
                                Precisa manutenção
                            </x-pocos::badge>
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($poco->profundidade_metros)
                        <strong>{{ number_format($poco->profundidade_metros, 2, ',', '.') }} m</strong>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($poco->vazao_litros_hora)
                        <strong>{{ number_format($poco->vazao_litros_hora, 2, ',', '.') }} L/h</strong>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($poco->equipeResponsavel)
                        <a href="{{ route('equipes.show', $poco->equipeResponsavel->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 flex items-center gap-1">
                            <x-pocos::icon name="user-group" class="w-4 h-4" />
                            {{ $poco->equipeResponsavel->nome }}
                        </a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-pocos::badge :variant="$poco->status_cor">
                        <x-pocos::icon :name="$poco->status == 'ativo' ? 'check-circle' : ($poco->status == 'manutencao' ? 'wrench-screwdriver' : ($poco->status == 'bomba_queimada' ? 'exclamation-triangle' : 'x-circle'))" class="w-3 h-3 mr-1" />
                        {{ $poco->status_texto }}
                    </x-pocos::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('pocos.show', $poco) }}"
                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                           title="Ver detalhes">
                            <x-pocos::icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('pocos.edit', $poco) }}"
                           class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300"
                           title="Editar">
                            <x-pocos::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('pocos.destroy', $poco) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Deseja realmente deletar este poço?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                    title="Deletar">
                                <x-pocos::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-12 text-center">
                    <x-pocos::icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhum poço encontrado</p>
                    <x-pocos::button href="{{ route('pocos.create') }}" variant="primary">
                        <x-pocos::icon name="plus-circle" class="w-4 h-4 mr-2" />
                        Criar Primeiro Poço
                    </x-pocos::button>
                </td>
            </tr>
        @endforelse
    </x-pocos::data-table>
</div>
@endsection
