@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Poço')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pocos" class="w-6 h-6" />
                Poço: <span class="text-indigo-600 dark:text-indigo-400">{{ $poco->codigo ?? '#' . $poco->id }}</span>
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes completos do poço artesiano</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-pocos::button href="{{ route('pocos.print', $poco) }}" target="_blank" variant="success">
                <x-pocos::icon name="printer" class="w-4 h-4 mr-2" />
                Imprimir
            </x-pocos::button>
            <x-pocos::button href="{{ route('pocos.edit', $poco) }}" variant="primary">
                <x-pocos::icon name="pencil" class="w-4 h-4 mr-2" />
                Editar
            </x-pocos::button>
            <x-pocos::button href="{{ route('pocos.index') }}" variant="outline">
                <x-pocos::icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </x-pocos::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-pocos::alert type="success" dismissible>
            {{ session('success') }}
        </x-pocos::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-pocos::icon name="information-circle" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="demandas" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-pocos::icon name="document-text" class="w-4 h-4 inline mr-2" />
                Demandas ({{ isset($demandas) ? $demandas->count() : 0 }})
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-pocos::icon name="link" class="w-4 h-4 inline mr-2" />
                Relacionamentos
            </button>
            @if(isset($historicoManutencoes) && $historicoManutencoes->count() > 0)
            <button data-tab-target="historico" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-pocos::icon name="clock" class="w-4 h-4 inline mr-2" />
                Histórico
            </button>
            @endif
        </nav>
    </div>

    <!-- Tabs Content -->
    <div>
        <!-- Tab Detalhes -->
        <div data-tab-panel="detalhes">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informações Principais -->
                <div class="lg:col-span-2 space-y-6">
                    <x-pocos::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-pocos::icon name="information-circle" class="w-5 h-5" />
                                Informações do Poço
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">{{ $poco->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        <x-pocos::badge :variant="$poco->status_cor" size="lg">
                                            <x-pocos::icon :name="$poco->status == 'ativo' ? 'check-circle' : ($poco->status == 'manutencao' ? 'wrench-screwdriver' : ($poco->status == 'bomba_queimada' ? 'exclamation-triangle' : 'x-circle'))" class="w-4 h-4 mr-1" />
                                            {{ $poco->status_texto }}
                                        </x-pocos::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                                        <div>
                                            @if($poco->localidade)
                                                <a href="{{ route('localidades.show', $poco->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 flex items-center gap-1">
                                                    <x-pocos::icon name="map-pin" class="w-4 h-4" />
                                                    <strong>{{ $poco->localidade->nome }}</strong>
                                                    @if($poco->localidade->codigo)
                                                        <span class="text-gray-500">({{ $poco->localidade->codigo }})</span>
                                                    @endif
                                                </a>
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Endereço</label>
                                        <div class="flex items-center gap-1 text-gray-900 dark:text-white">
                                            <x-pocos::icon name="map" class="w-4 h-4 text-gray-400" />
                                            {{ $poco->endereco }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($poco->latitude && $poco->longitude)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Coordenadas</label>
                                <div class="flex items-center gap-1 text-gray-900 dark:text-white mb-4">
                                    <x-pocos::icon name="map-pin" class="w-4 h-4 text-gray-400" />
                                    {{ $poco->latitude }}, {{ $poco->longitude }}
                                </div>

                                <!-- Mapa Interativo (somente leitura) -->
                                <x-map
                                    latitude-field="latitude"
                                    longitude-field="longitude"
                                    :latitude="$poco->latitude"
                                    :longitude="$poco->longitude"
                                    :nome-mapa="$poco->nome_mapa"
                                    icon-type="poco"
                                    readonly
                                    height="400px"
                                    center-lat="-12.2336"
                                    center-lng="-38.7454"
                                    zoom="13"
                                />
                            </div>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Características Técnicas</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Profundidade</label>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-1">
                                            <x-pocos::icon name="arrow-down" class="w-4 h-4" />
                                            {{ number_format($poco->profundidade_metros, 2, ',', '.') }} m
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Vazão</label>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            @if($poco->vazao_litros_hora)
                                                <x-pocos::icon name="water" class="w-4 h-4 inline mr-1" />
                                                {{ number_format($poco->vazao_litros_hora, 2, ',', '.') }} L/h
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Diâmetro</label>
                                        <div class="text-base text-gray-900 dark:text-white">{{ $poco->diametro ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            @if($poco->tipo_bomba || $poco->potencia_bomba)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Informações da Bomba</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($poco->tipo_bomba)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Bomba</label>
                                        <div class="text-base text-gray-900 dark:text-white">{{ $poco->tipo_bomba }}</div>
                                    </div>
                                    @endif
                                    @if($poco->potencia_bomba)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Potência da Bomba</label>
                                        <div class="text-base text-gray-900 dark:text-white flex items-center gap-1">
                                            <x-pocos::icon name="bolt" class="w-4 h-4" />
                                            {{ $poco->potencia_bomba }} HP
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Manutenção</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @if($poco->data_perfuracao)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Perfuração</label>
                                        <div class="text-base text-gray-900 dark:text-white flex items-center gap-1">
                                            <x-pocos::icon name="calendar" class="w-4 h-4" />
                                            {{ $poco->data_perfuracao->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    @endif
                                    @if($poco->ultima_manutencao)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Última Manutenção</label>
                                        <div class="text-base text-gray-900 dark:text-white flex items-center gap-1">
                                            <x-pocos::icon name="wrench-screwdriver" class="w-4 h-4" />
                                            {{ $poco->ultima_manutencao->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    @endif
                                    @if($poco->proxima_manutencao)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Próxima Manutenção</label>
                                        <div class="text-base text-gray-900 dark:text-white flex items-center gap-1">
                                            <x-pocos::icon name="calendar-days" class="w-4 h-4" />
                                            {{ $poco->proxima_manutencao->format('d/m/Y') }}
                                            @if($poco->precisaManutencao())
                                                <x-pocos::badge variant="warning" size="sm" class="ml-2">
                                                    <x-pocos::icon name="exclamation-triangle" class="w-3 h-3 mr-1" />
                                                    Precisa manutenção
                                                </x-pocos::badge>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if($poco->observacoes)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $poco->observacoes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-pocos::card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Ações Rápidas -->
                    <x-pocos::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-pocos::icon name="bolt" class="w-5 h-5" />
                                Ações Rápidas
                            </h3>
                        </x-slot>

                        <div class="space-y-3">
                            <x-pocos::button href="{{ route('pocos.print', $poco) }}" target="_blank" variant="success" class="w-full">
                                <x-pocos::icon name="printer" class="w-4 h-4 mr-2" />
                                Imprimir
                            </x-pocos::button>
                            <x-pocos::button href="{{ route('pocos.edit', $poco) }}" variant="primary" class="w-full">
                                <x-pocos::icon name="pencil" class="w-4 h-4 mr-2" />
                                Editar Poço
                            </x-pocos::button>
                            <button type="button" onclick="abrirModalReportarProblema()" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:bg-amber-500 dark:hover:bg-amber-600 transition-all duration-200">
                                <x-pocos::icon name="exclamation-triangle" class="w-4 h-4 mr-2" />
                                Reportar Problema
                            </button>
                            @if(Route::has('demandas.create'))
                                <x-pocos::button href="{{ route('demandas.create', ['tipo' => 'poco', 'localidade_id' => $poco->localidade_id, 'poco_id' => $poco->id]) }}" variant="info" class="w-full">
                                    <x-pocos::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                    Criar Demanda
                                </x-pocos::button>
                            @endif
                            <form action="{{ route('pocos.destroy', $poco) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar este poço?')">
                                @csrf
                                @method('DELETE')
                                <x-pocos::button type="submit" variant="danger" class="w-full">
                                    <x-pocos::icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-pocos::button>
                            </form>
                        </div>
                    </x-pocos::card>

                    <!-- Informações -->
                    <x-pocos::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-pocos::icon name="information-circle" class="w-5 h-5" />
                                Informações
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $poco->id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $poco->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($poco->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $poco->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </x-pocos::card>

                    @if($poco->equipeResponsavel)
                    <!-- Equipe Responsável -->
                    <x-pocos::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-pocos::icon name="user-group" class="w-5 h-5" />
                                Equipe Responsável
                            </h3>
                        </x-slot>

                        <div class="space-y-3">
                            <div>
                                <strong class="text-base text-gray-900 dark:text-white">{{ $poco->equipeResponsavel->nome }}</strong>
                                @if($poco->equipeResponsavel->codigo)
                                    <x-pocos::badge variant="secondary" class="ml-2">{{ $poco->equipeResponsavel->codigo }}</x-pocos::badge>
                                @endif
                            </div>
                            @if(Route::has('equipes.show'))
                                <x-pocos::button href="{{ route('equipes.show', $poco->equipeResponsavel->id) }}" variant="outline" class="w-full">
                                    Ver Equipe
                                    <x-pocos::icon name="arrow-right" class="w-4 h-4 ml-2" />
                                </x-pocos::button>
                            @endif
                        </div>
                    </x-pocos::card>
                    @endif

                    <!-- Estatísticas -->
                    @if(isset($estatisticas))
                    <x-pocos::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-pocos::icon name="chart-bar" class="w-5 h-5" />
                                Estatísticas
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Demandas</label>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total_demandas'] ?? 0 }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Demandas Abertas</label>
                                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $estatisticas['demandas_abertas'] ?? 0 }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ordens de Serviço</label>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total_ordens'] ?? 0 }}</div>
                            </div>
                            @if($estatisticas['dias_sem_manutencao'] !== null)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Dias sem Manutenção</label>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['dias_sem_manutencao'] }} dias</div>
                            </div>
                            @endif
                            @if($estatisticas['precisa_manutencao'])
                            <x-pocos::alert type="warning">
                                <x-pocos::icon name="exclamation-triangle" class="w-4 h-4 mr-2" />
                                Este poço precisa de manutenção.
                            </x-pocos::alert>
                            @endif
                        </div>
                    </x-pocos::card>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Demandas -->
        <div data-tab-panel="demandas" class="hidden">
            <div class="space-y-6">
                <!-- Cabeçalho da aba -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-pocos::icon name="document-text" class="w-5 h-5" />
                            Demandas Relacionadas ao Poço
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Histórico de demandas e problemas reportados para este poço
                        </p>
                    </div>
                    <button type="button" onclick="abrirModalReportarProblema()" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:bg-amber-500 dark:hover:bg-amber-600 transition-all duration-200">
                        <x-pocos::icon name="exclamation-triangle" class="w-4 h-4 mr-2" />
                        Reportar Problema
                    </button>
                </div>

                @if(isset($demandas) && $demandas->count() > 0)
                <x-pocos::card>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Motivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prioridade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data Abertura</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">OS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($demandas as $demanda)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ $demanda->codigo }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ Str::limit($demanda->motivo, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-pocos::badge :variant="$demanda->status_cor" size="sm">
                                            {{ $demanda->status_texto }}
                                        </x-pocos::badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-pocos::badge :variant="$demanda->prioridade_cor" size="sm">
                                            {{ $demanda->prioridade_texto }}
                                        </x-pocos::badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $demanda->data_abertura ? $demanda->data_abertura->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($demanda->ordemServico)
                                            <a href="{{ route('ordens.show', $demanda->ordemServico->id) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                {{ $demanda->ordemServico->numero }}
                                            </a>
                                        @else
                                            <span class="text-sm text-gray-400">Sem OS</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('demandas.show', $demanda->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-pocos::card>
                @else
                <x-pocos::card>
                    <div class="text-center py-12">
                        <x-pocos::icon name="document-text" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhuma demanda encontrada</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            Este poço ainda não possui demandas relacionadas.
                        </p>
                        <button type="button" onclick="abrirModalReportarProblema()" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700">
                            <x-pocos::icon name="exclamation-triangle" class="w-4 h-4 mr-2" />
                            Reportar Primeiro Problema
                        </button>
                    </div>
                </x-pocos::card>
                @endif
            </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Localidade -->
                <x-pocos::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-pocos::icon name="map-pin" class="w-5 h-5" />
                            Localidade
                        </h3>
                    </x-slot>

                    @if($poco->localidade)
                        <div class="space-y-3">
                            <div>
                                <strong class="text-base text-gray-900 dark:text-white">{{ $poco->localidade->nome }}</strong>
                                @if($poco->localidade->codigo)
                                    <x-pocos::badge variant="secondary" class="ml-2">{{ $poco->localidade->codigo }}</x-pocos::badge>
                                @endif
                            </div>
                            @if($poco->localidade->tipo)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ ucfirst($poco->localidade->tipo ?? 'N/A') }}</div>
                            </div>
                            @endif
                            @if($poco->localidade->cidade)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cidade</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $poco->localidade->cidade }}, {{ $poco->localidade->estado ?? '' }}</div>
                            </div>
                            @endif
                            <x-pocos::button href="{{ route('localidades.show', $poco->localidade->id) }}" variant="outline" class="w-full">
                                Ver Localidade
                                <x-pocos::icon name="arrow-right" class="w-4 h-4 ml-2" />
                            </x-pocos::button>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Nenhuma localidade vinculada</p>
                    @endif
                </x-pocos::card>

                @if($poco->equipeResponsavel)
                <!-- Equipe Responsável -->
                <x-pocos::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-pocos::icon name="user-group" class="w-5 h-5" />
                            Equipe Responsável
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        <div>
                            <strong class="text-base text-gray-900 dark:text-white">{{ $poco->equipeResponsavel->nome }}</strong>
                            @if($poco->equipeResponsavel->codigo)
                                <x-pocos::badge variant="secondary" class="ml-2">{{ $poco->equipeResponsavel->codigo }}</x-pocos::badge>
                            @endif
                        </div>
                        @if($poco->equipeResponsavel->tipo)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                            <div>
                                <x-pocos::badge variant="info">{{ ucfirst($poco->equipeResponsavel->tipo) }}</x-pocos::badge>
                            </div>
                        </div>
                        @endif
                        @if(Route::has('equipes.show'))
                            <x-pocos::button href="{{ route('equipes.show', $poco->equipeResponsavel->id) }}" variant="outline" class="w-full">
                                Ver Equipe
                                <x-pocos::icon name="arrow-right" class="w-4 h-4 ml-2" />
                            </x-pocos::button>
                        @endif
                    </div>
                </x-pocos::card>
                @endif

                @if(isset($historicoManutencoes) && $historicoManutencoes->count() > 0)
                <!-- Histórico de Manutenções -->
                <x-pocos::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-pocos::icon name="wrench-screwdriver" class="w-5 h-5" />
                            Histórico de Manutenções
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @foreach($historicoManutencoes->take(5) as $os)
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <strong class="text-sm text-gray-900 dark:text-white">{{ $os->tipo_servico ?? 'Manutenção' }}</strong>
                                        @if($os->numero)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <x-pocos::icon name="document-text" class="w-3 h-3 inline mr-1" />
                                                {{ $os->numero }}
                                            </div>
                                        @endif
                                        @if($os->data_conclusao)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <x-pocos::icon name="calendar" class="w-3 h-3 inline mr-1" />
                                                {{ $os->data_conclusao->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </div>
                                    @if(Route::has('ordens.show'))
                                        <a href="{{ route('ordens.show', $os->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">
                                            <x-pocos::icon name="arrow-right" class="w-4 h-4" />
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-pocos::card>
                @endif
            </div>
        </div>

        <!-- Tab Histórico -->
        @if(isset($poco->historicoManutencoes) && $poco->historicoManutencoes->count() > 0)
        <div data-tab-panel="historico" class="hidden">
            <x-pocos::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-pocos::icon name="clock" class="w-5 h-5" />
                        Histórico de Manutenções
                    </h3>
                </x-slot>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Descrição</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($historicoManutencoes->sortByDesc('data_conclusao') as $os)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $os->tipo_servico ?? 'Manutenção' }}</div>
                                        @if($os->numero)
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $os->numero }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        @if($os->data_conclusao)
                                            {{ $os->data_conclusao->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ \Illuminate\Support\Str::limit($os->relatorio_execucao ?? $os->descricao ?? 'N/A', 100) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-pocos::card>
        </div>
        @endif
    </div>
</div>

<!-- Modal Reportar Problema -->
<div id="modalReportarProblema" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Reportar Problema no Poço</h3>
                <button type="button" onclick="fecharModalReportarProblema()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <x-pocos::icon name="x-mark" class="w-5 h-5" />
                </button>
            </div>
            <form action="{{ route('pocos.reportar-problema', $poco->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Motivo do Problema <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="motivo" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Ex: Bomba queimada, Água não sobe, Fiação com problema">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Descrição Detalhada
                        </label>
                        <textarea name="descricao" rows="3"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Descreva o problema em detalhes..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Prioridade <span class="text-red-500">*</span>
                        </label>
                        <select name="prioridade" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="baixa">Baixa</option>
                            <option value="media" selected>Média</option>
                            <option value="alta">Alta</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Atualizar Status do Poço
                        </label>
                        <select name="status_poco"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Manter status atual</option>
                            <option value="manutencao">Em Manutenção</option>
                            <option value="bomba_queimada">Bomba Queimada</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="fecharModalReportarProblema()"
                            class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 dark:bg-amber-500 dark:hover:bg-amber-600">
                            Reportar Problema
                        </button>
                    </div>
                </div>
            </form>
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

function abrirModalReportarProblema() {
    document.getElementById('modalReportarProblema').classList.remove('hidden');
}

function fecharModalReportarProblema() {
    document.getElementById('modalReportarProblema').classList.add('hidden');
}
</script>
@endpush
@endsection
