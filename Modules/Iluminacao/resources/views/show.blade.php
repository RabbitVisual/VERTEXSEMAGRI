@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Ponto de Luz')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Iluminacao" class="w-6 h-6" />
                Ponto de Luz: <span class="text-indigo-600 dark:text-indigo-400">{{ $ponto->codigo ?? '#' . $ponto->id }}</span>
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes completos do ponto de iluminação</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-iluminacao::button href="{{ route('iluminacao.edit', $ponto) }}" variant="primary">
                <x-iluminacao::icon name="pencil" class="w-4 h-4 mr-2" />
                Editar
            </x-iluminacao::button>
            <x-iluminacao::button href="{{ route('iluminacao.index') }}" variant="outline">
                <x-iluminacao::icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </x-iluminacao::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-iluminacao::alert type="success" dismissible>
            {{ session('success') }}
        </x-iluminacao::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-iluminacao::icon name="information-circle" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-iluminacao::icon name="link" class="w-4 h-4 inline mr-2" />
                Relacionamentos
            </button>
            <button data-tab-target="historico" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-iluminacao::icon name="clock" class="w-4 h-4 inline mr-2" />
                Histórico
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
                    <x-iluminacao::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-iluminacao::icon name="information-circle" class="w-5 h-5" />
                                Informações do Ponto
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $ponto->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        @php
                                            $statusColors = [
                                                'funcionando' => 'success',
                                                'com_defeito' => 'warning',
                                                'desligado' => 'danger'
                                            ];
                                            $statusIcons = [
                                                'funcionando' => 'check-circle',
                                                'com_defeito' => 'exclamation-triangle',
                                                'desligado' => 'x-circle'
                                            ];
                                        @endphp
                                        <x-iluminacao::badge :variant="$statusColors[$ponto->status] ?? 'secondary'">
                                            <x-iluminacao::icon :name="$statusIcons[$ponto->status] ?? 'question-mark-circle'" class="w-3 h-3 mr-1" />
                                            {{ ucfirst(str_replace('_', ' ', $ponto->status)) }}
                                        </x-iluminacao::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                                    <div>
                                        @if($ponto->localidade)
                                            <a href="{{ route('localidades.show', $ponto->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1">
                                                <x-iluminacao::icon name="map-pin" class="w-4 h-4" />
                                                <strong>{{ $ponto->localidade->nome }}</strong>
                                                @if($ponto->localidade->codigo)
                                                    <span class="text-gray-500">({{ $ponto->localidade->codigo }})</span>
                                                @endif
                                            </a>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Endereço</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-start gap-1">
                                        <x-iluminacao::icon name="map-pin" class="w-4 h-4 mt-0.5 flex-shrink-0" />
                                        <span>{{ $ponto->endereco }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($ponto->latitude && $ponto->longitude)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Coordenadas</label>
                                <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1 mb-4">
                                    <x-iluminacao::icon name="globe-alt" class="w-4 h-4" />
                                    <span>{{ $ponto->latitude }}, {{ $ponto->longitude }}</span>
                                </div>

                                <!-- Mapa Interativo (somente leitura) -->
                                <x-map
                                    latitude-field="latitude"
                                    longitude-field="longitude"
                                    :latitude="$ponto->latitude"
                                    :longitude="$ponto->longitude"
                                    :nome-mapa="$ponto->nome_mapa"
                                    icon-type="ponto_luz"
                                    readonly
                                    height="400px"
                                    center-lat="-12.2336"
                                    center-lng="-38.7454"
                                    zoom="13"
                                />
                            </div>
                            @endif
                        
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Barramento</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->barramento ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Trafo</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->trafo ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Quantidade</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->quantidade ?? 1 }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Horas Diárias</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->horas_diarias ?? 'N/A' }}</div>
                                </div>
                            </div>
</div>
                    </x-iluminacao::card>

                    <!-- Especificações Técnicas -->
                    <x-iluminacao::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-iluminacao::icon name="cog-6-tooth" class="w-5 h-5" />
                                Especificações Técnicas
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Lâmpada</label>
                                    <div>
                                        <x-iluminacao::badge variant="info">
                                            {{ ucfirst(str_replace('_', ' ', $ponto->tipo_lampada ?? 'N/A')) }}
                                        </x-iluminacao::badge>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Potência</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">
                                        @if($ponto->potencia)
                                            {{ $ponto->potencia }}W
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Poste</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->tipo_poste ?? 'N/A' }}</div>
                                </div>
                            </div>

                            @if($ponto->altura_poste || $ponto->tipo_fiacao)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                @if($ponto->altura_poste)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Altura do Poste</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-iluminacao::icon name="ruler" class="w-4 h-4" />
                                        <span>{{ number_format($ponto->altura_poste, 2, ',', '.') }} m</span>
                                    </div>
                                </div>
                                @endif
                                @if($ponto->tipo_fiacao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Fiação</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->tipo_fiacao }}</div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </x-iluminacao::card>

                    <!-- Datas e Observações -->
                    @if($ponto->data_instalacao || $ponto->ultima_manutencao || $ponto->observacoes)
                    <x-iluminacao::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-iluminacao::icon name="calendar" class="w-5 h-5" />
                                Datas e Observações
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            @if($ponto->data_instalacao || $ponto->ultima_manutencao)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($ponto->data_instalacao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Instalação</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-iluminacao::icon name="calendar" class="w-4 h-4" />
                                        <span>{{ $ponto->data_instalacao->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                @endif
                                @if($ponto->ultima_manutencao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Última Manutenção</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-iluminacao::icon name="wrench-screwdriver" class="w-4 h-4" />
                                        <span>{{ $ponto->ultima_manutencao->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($ponto->observacoes)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $ponto->observacoes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-iluminacao::card>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Ações Rápidas -->
                    <x-iluminacao::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-iluminacao::icon name="bolt" class="w-5 h-5" />
                                Ações Rápidas
                            </h3>
                        </x-slot>

                        <div class="space-y-3">
                            <x-iluminacao::button href="{{ route('iluminacao.edit', $ponto) }}" variant="primary" class="w-full">
                                <x-iluminacao::icon name="pencil" class="w-4 h-4 mr-2" />
                                Editar Ponto
                            </x-iluminacao::button>
                            @if(Route::has('demandas.create'))
                            <x-iluminacao::button href="{{ route('demandas.create', ['tipo' => 'luz', 'localidade_id' => $ponto->localidade_id]) }}" variant="success" class="w-full">
                                <x-iluminacao::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                Criar Demanda
                            </x-iluminacao::button>
                            @endif
                            <form action="{{ route('iluminacao.destroy', $ponto) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar este ponto?')">
                                @csrf
                                @method('DELETE')
                                <x-iluminacao::button type="submit" variant="danger" class="w-full">
                                    <x-iluminacao::icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-iluminacao::button>
                            </form>
                        </div>
                    </x-iluminacao::card>

                    <!-- Informações -->
                    <x-iluminacao::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-iluminacao::icon name="information-circle" class="w-5 h-5" />
                                Informações
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $ponto->id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($ponto->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </x-iluminacao::card>
                </div>
            </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Localidade -->
                <x-iluminacao::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-iluminacao::icon name="map-pin" class="w-5 h-5" />
                            Localidade
                        </h3>
                    </x-slot>

                    <div class="space-y-4">
                        @if($ponto->localidade)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $ponto->localidade->nome }}</div>
                                @if($ponto->localidade->codigo)
                                    <x-iluminacao::badge variant="secondary" class="mt-1">{{ $ponto->localidade->codigo }}</x-iluminacao::badge>
                                @endif
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                <div>
                                    <x-iluminacao::badge variant="info">
                                        {{ ucfirst(str_replace('_', ' ', $ponto->localidade->tipo ?? 'N/A')) }}
                                    </x-iluminacao::badge>
                                </div>
                            </div>
                            @if($ponto->localidade->cidade)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cidade</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $ponto->localidade->cidade }}, {{ $ponto->localidade->estado ?? '' }}</div>
                            </div>
                            @endif
                            <x-iluminacao::button href="{{ route('localidades.show', $ponto->localidade->id) }}" variant="outline" class="w-full">
                                Ver Localidade
                                <x-iluminacao::icon name="arrow-right" class="w-4 h-4 ml-2" />
                            </x-iluminacao::button>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Nenhuma localidade vinculada</p>
                        @endif
                    </div>
                </x-iluminacao::card>

                <!-- Histórico de Manutenções -->
                @if(isset($ponto->historicoManutencoes) && $ponto->historicoManutencoes->count() > 0)
                <x-iluminacao::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-iluminacao::icon name="wrench-screwdriver" class="w-5 h-5" />
                            Histórico de Manutenções
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @foreach($ponto->historicoManutencoes->take(5) as $manutencao)
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
                </x-iluminacao::card>
                @endif
            </div>
        </div>
    </div>
</div>


        <!-- Tab Histórico -->
        <div data-tab-panel="historico" class="hidden">
            <x-iluminacao::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-iluminacao::icon name="clock" class="w-5 h-5" />
                        Linha do Tempo
                    </h3>
                </x-slot>

                <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                    @forelse($ponto->historico as $evento)
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-emerald-500 text-slate-500 group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <x-iluminacao::icon name="check-circle" class="w-5 h-5" />
                        </div>
                        <!-- Card -->
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded border border-slate-200 shadow">
                            <div class="flex items-center justify-between space-x-2 mb-1">
                                <div class="font-bold text-slate-900">{{ $evento->tipo_evento }}</div>
                                <time class="font-caveat font-medium text-indigo-500">{{ $evento->data_evento ? $evento->data_evento->format('d/m/Y H:i') : '' }}</time>
                            </div>
                            <div class="text-slate-500">{{ $evento->descricao }}</div>
                            @if($evento->material)
                                <div class="mt-2 text-sm text-slate-600 bg-slate-50 p-2 rounded">
                                    <span class="font-semibold">Material:</span> {{ $evento->material->nome ?? 'N/A' }} 
                                    @if($evento->quantidade_material)
                                        (Qty: {{ $evento->quantidade_material }})
                                    @endif
                                </div>
                            @endif
                            @if($evento->demanda)
                                 <div class="mt-1 text-sm text-indigo-600">
                                    <a href="{{ route('demandas.show', $evento->demanda->id) }}" class="hover:underline">
                                        Via Demanda #{{ $evento->demanda->codigo ?? $evento->demanda->id }}
                                    </a>
                                 </div>
                            @endif
                             @if($evento->user_id)
                                 <div class="mt-1 text-xs text-gray-400">
                                    Por: {{ $evento->usuario->name ?? 'Sistema' }}
                                 </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">Nenhum histórico registrado.</div>
                    @endforelse
                </div>
            </x-iluminacao::card>
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
