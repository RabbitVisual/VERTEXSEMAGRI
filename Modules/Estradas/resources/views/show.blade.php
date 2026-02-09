@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Trecho')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="estradas" class="w-6 h-6" />
                {{ $trecho->nome }}
                @if($trecho->codigo)
                    <span class="text-indigo-600 dark:text-indigo-400 text-lg font-normal">({{ $trecho->codigo }})</span>
                @endif
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes completos do trecho de estrada</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-estradas::button href="{{ route('estradas.edit', $trecho) }}" variant="primary">
                <x-estradas::icon name="pencil" class="w-4 h-4 mr-2" />
                Editar
            </x-estradas::button>
            <x-estradas::button href="{{ route('estradas.index') }}" variant="outline">
                <x-estradas::icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </x-estradas::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-estradas::alert type="success" dismissible>
            {{ session('success') }}
        </x-estradas::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-estradas::icon name="information-circle" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-estradas::icon name="link" class="w-4 h-4 inline mr-2" />
                Relacionamentos
            </button>
        </nav>
    </div>

    <!-- Tabs Content -->
    <div>
        <!-- Tab Detalhes -->
        <div data-tab-panel="detalhes">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informações Principais -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informações Básicas -->
                    <x-estradas::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-estradas::icon name="information-circle" class="w-5 h-5" />
                                Informações do Trecho
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $trecho->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Condição</label>
                                    <div>
                                        @php
                                            $condicaoColors = [
                                                'boa' => 'success',
                                                'regular' => 'info',
                                                'ruim' => 'warning',
                                                'pessima' => 'danger'
                                            ];
                                            $condicaoIcons = [
                                                'boa' => 'check-circle',
                                                'regular' => 'information-circle',
                                                'ruim' => 'exclamation-triangle',
                                                'pessima' => 'x-circle'
                                            ];
                                        @endphp
                                        <x-estradas::badge :variant="$condicaoColors[$trecho->condicao] ?? 'secondary'">
                                            <x-estradas::icon :name="$condicaoIcons[$trecho->condicao] ?? 'question-mark-circle'" class="w-3 h-3 mr-1" />
                                            {{ ucfirst($trecho->condicao) }}
                                        </x-estradas::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $trecho->nome }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                    <div>
                                        <x-estradas::badge variant="info">
                                            {{ ucfirst($trecho->tipo) }}
                                        </x-estradas::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                                <div>
                                    @if($trecho->localidade)
                                        <a href="{{ route('localidades.show', $trecho->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1">
                                            <x-estradas::icon name="map-pin" class="w-4 h-4" />
                                            <strong>{{ $trecho->localidade->nome }}</strong>
                                            @if($trecho->localidade->codigo)
                                                <span class="text-gray-500">({{ $trecho->localidade->codigo }})</span>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </x-estradas::card>

                    <!-- Características Físicas -->
                    @if($trecho->extensao_km || $trecho->largura_metros || $trecho->tipo_pavimento || $trecho->tem_ponte)
                    <x-estradas::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-estradas::icon name="ruler" class="w-5 h-5" />
                                Características Físicas
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($trecho->extensao_km)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Extensão</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-estradas::icon name="ruler" class="w-4 h-4" />
                                        {{ number_format($trecho->extensao_km, 2, ',', '.') }} km
                                    </div>
                                </div>
                                @endif
                                @if($trecho->largura_metros)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Largura</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ number_format($trecho->largura_metros, 2, ',', '.') }} m</div>
                                </div>
                                @endif
                                @if($trecho->tipo_pavimento)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Pavimento</label>
                                    <div>
                                        <x-estradas::badge variant="secondary">
                                            {{ ucfirst($trecho->tipo_pavimento) }}
                                        </x-estradas::badge>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($trecho->tem_ponte)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pontes</label>
                                <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                    <x-estradas::icon name="bridge" class="w-4 h-4" />
                                    <strong>{{ $trecho->numero_pontes ?? 0 }} ponte(s)</strong>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-estradas::card>
                    @endif

                    <!-- Manutenção e Observações -->
                    @if($trecho->ultima_manutencao || $trecho->proxima_manutencao || $trecho->observacoes)
                    <x-estradas::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-estradas::icon name="wrench-screwdriver" class="w-5 h-5" />
                                Manutenção e Observações
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            @if($trecho->ultima_manutencao || $trecho->proxima_manutencao)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($trecho->ultima_manutencao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Última Manutenção</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-estradas::icon name="calendar" class="w-4 h-4" />
                                        {{ $trecho->ultima_manutencao->format('d/m/Y') }}
                                    </div>
                                </div>
                                @endif
                                @if($trecho->proxima_manutencao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Próxima Manutenção</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-estradas::icon name="calendar-days" class="w-4 h-4" />
                                        {{ $trecho->proxima_manutencao->format('d/m/Y') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($trecho->observacoes)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $trecho->observacoes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-estradas::card>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Estatísticas -->
                    @if(isset($estatisticas))
                    <x-estradas::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-estradas::icon name="chart-bar" class="w-5 h-5" />
                                Estatísticas
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <div class="text-2xl font-bold text-blue-900 dark:text-blue-200">{{ $estatisticas['total_demandas'] ?? 0 }}</div>
                                    <div class="text-xs text-blue-700 dark:text-blue-300">Demandas</div>
                                </div>
                                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                                    <div class="text-2xl font-bold text-indigo-900 dark:text-indigo-200">{{ $estatisticas['total_ordens'] ?? 0 }}</div>
                                    <div class="text-xs text-indigo-700 dark:text-indigo-300">Ordens</div>
                                </div>
                            </div>
                            @if(isset($estatisticas['dias_sem_manutencao']) && $estatisticas['dias_sem_manutencao'] !== null)
                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Dias sem Manutenção</label>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $estatisticas['dias_sem_manutencao'] }} dias</div>
                            </div>
                            @endif
                            @if(isset($estatisticas['precisa_manutencao']) && $estatisticas['precisa_manutencao'])
                            <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                                <div class="flex items-center gap-2">
                                    <x-estradas::icon name="exclamation-triangle" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                    <span class="text-sm font-semibold text-amber-900 dark:text-amber-200">Precisa de Manutenção</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-estradas::card>
                    @endif

                    <!-- Ações Rápidas -->
                    <x-estradas::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-estradas::icon name="bolt" class="w-5 h-5" />
                                Ações Rápidas
                            </h3>
                        </x-slot>

                        <div class="space-y-3">
                            <x-estradas::button href="{{ route('estradas.edit', $trecho) }}" variant="primary" class="w-full">
                                <x-estradas::icon name="pencil" class="w-4 h-4 mr-2" />
                                Editar Trecho
                            </x-estradas::button>
                            @if(Route::has('demandas.create'))
                            <x-estradas::button href="{{ route('demandas.create', ['tipo' => 'estrada', 'localidade_id' => $trecho->localidade_id]) }}" variant="success" class="w-full">
                                <x-estradas::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                Criar Demanda
                            </x-estradas::button>
                            @endif
                            <form action="{{ route('estradas.destroy', $trecho) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar este trecho?')">
                                @csrf
                                @method('DELETE')
                                <x-estradas::button type="submit" variant="danger" class="w-full">
                                    <x-estradas::icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-estradas::button>
                            </form>
                        </div>
                    </x-estradas::card>

                    <!-- Informações -->
                    <x-estradas::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-estradas::icon name="information-circle" class="w-5 h-5" />
                                Informações
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $trecho->id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $trecho->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($trecho->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $trecho->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </x-estradas::card>
                </div>
            </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Localidade -->
                <x-estradas::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-estradas::icon name="map-pin" class="w-5 h-5" />
                            Localidade
                        </h3>
                    </x-slot>

                    <div class="space-y-4">
                        @if($trecho->localidade)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $trecho->localidade->nome }}</div>
                                @if($trecho->localidade->codigo)
                                    <x-estradas::badge variant="secondary" class="mt-1">{{ $trecho->localidade->codigo }}</x-estradas::badge>
                                @endif
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                <div>
                                    <x-estradas::badge variant="info">
                                        {{ ucfirst(str_replace('_', ' ', $trecho->localidade->tipo ?? 'N/A')) }}
                                    </x-estradas::badge>
                                </div>
                            </div>
                            @if($trecho->localidade->cidade)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cidade</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $trecho->localidade->cidade }}, {{ $trecho->localidade->estado ?? '' }}</div>
                            </div>
                            @endif
                            <x-estradas::button href="{{ route('localidades.show', $trecho->localidade->id) }}" variant="outline" class="w-full">
                                Ver Localidade
                                <x-estradas::icon name="arrow-right" class="w-4 h-4 ml-2" />
                            </x-estradas::button>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Nenhuma localidade vinculada</p>
                        @endif
                    </div>
                </x-estradas::card>

                <!-- Demandas Relacionadas -->
                @if(isset($trecho->demandas) && $trecho->demandas->count() > 0)
                <x-estradas::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-estradas::icon name="document-text" class="w-5 h-5" />
                            Demandas Relacionadas
                            <x-estradas::badge variant="info">{{ $trecho->demandas->count() }}</x-estradas::badge>
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @foreach($trecho->demandas->take(5) as $demanda)
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $demanda->solicitante_nome }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $demanda->motivo }}</div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <x-estradas::badge :variant="$demanda->status === 'aberta' ? 'warning' : ($demanda->status === 'concluida' ? 'success' : 'info')">
                                                {{ ucfirst($demanda->status) }}
                                            </x-estradas::badge>
                                            @if(Route::has('demandas.show'))
                                            <a href="{{ route('demandas.show', $demanda->id) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                                Ver detalhes
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($trecho->demandas->count() > 5)
                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                                E mais {{ $trecho->demandas->count() - 5 }} demanda(s)...
                            </p>
                        @endif
                    </div>
                </x-estradas::card>
                @endif

                <!-- Ordens de Serviço Relacionadas -->
                @if(isset($trecho->ordensServico) && $trecho->ordensServico->count() > 0)
                <x-estradas::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-estradas::icon name="clipboard-document-check" class="w-5 h-5" />
                            Ordens de Serviço
                            <x-estradas::badge variant="info">{{ $trecho->ordensServico->count() }}</x-estradas::badge>
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @foreach($trecho->ordensServico->take(5) as $ordem)
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $ordem->numero }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $ordem->tipo_servico }}</div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <x-estradas::badge :variant="$ordem->status === 'concluida' ? 'success' : ($ordem->status === 'em_execucao' ? 'warning' : 'info')">
                                                {{ $ordem->status_texto }}
                                            </x-estradas::badge>
                                            @if(Route::has('ordens.show'))
                                            <a href="{{ route('ordens.show', $ordem->id) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                                Ver OS
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($trecho->ordensServico->count() > 5)
                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                                E mais {{ $trecho->ordensServico->count() - 5 }} ordem(ns) de serviço...
                            </p>
                        @endif
                    </div>
                </x-estradas::card>
                @endif

                <!-- Histórico de Manutenções -->
                @if(isset($trecho->historicoManutencoes) && $trecho->historicoManutencoes->count() > 0)
                <x-estradas::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-estradas::icon name="wrench-screwdriver" class="w-5 h-5" />
                            Histórico de Manutenções
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @foreach($trecho->historicoManutencoes->take(5) as $manutencao)
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $manutencao->tipo ?? 'Manutenção' }}</div>
                                        @if($manutencao->data)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $manutencao->data->format('d/m/Y') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-estradas::card>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab-target');

            // Remove active state from all buttons and panels
            tabButtons.forEach(btn => {
                btn.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            tabPanels.forEach(panel => {
                panel.classList.add('hidden');
            });

            // Add active state to clicked button and corresponding panel
            button.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            button.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            document.querySelector(`[data-tab-panel="${targetTab}"]`).classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection
