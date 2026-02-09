@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Rede de Água')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="agua" class="w-6 h-6" />
                Rede de Água: <span class="text-indigo-600 dark:text-indigo-400">{{ $rede->codigo ?? '#' . $rede->id }}</span>
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes completos da rede de água</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-agua::button href="{{ route('agua.edit', $rede) }}" variant="primary">
                <x-agua::icon name="pencil" class="w-4 h-4 mr-2" />
                Editar
            </x-agua::button>
            <x-agua::button href="{{ route('agua.index') }}" variant="outline">
                <x-agua::icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </x-agua::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-agua::alert type="success" dismissible>
            {{ session('success') }}
        </x-agua::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-agua::icon name="information-circle" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-agua::icon name="link" class="w-4 h-4 inline mr-2" />
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
                    <x-agua::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-agua::icon name="information-circle" class="w-5 h-5" />
                                Informações da Rede
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">{{ $rede->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        @php
                                            $statusVariants = [
                                                'funcionando' => 'success',
                                                'com_vazamento' => 'warning',
                                                'interrompida' => 'danger'
                                            ];
                                            $statusVariant = $statusVariants[$rede->status] ?? 'secondary';
                                        @endphp
                                        <x-agua::badge :variant="$statusVariant" size="lg">
                                            <x-agua::icon :name="$rede->status == 'funcionando' ? 'check-circle' : ($rede->status == 'com_vazamento' ? 'exclamation-triangle' : 'x-circle')" class="w-4 h-4 mr-1" />
                                            {{ ucfirst(str_replace('_', ' ', $rede->status)) }}
                                        </x-agua::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                                        <div>
                                            @if($rede->localidade)
                                                <a href="{{ route('localidades.show', $rede->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 flex items-center gap-1">
                                                    <x-agua::icon name="map-pin" class="w-4 h-4" />
                                                    <strong>{{ $rede->localidade->nome }}</strong>
                                                    @if($rede->localidade->codigo)
                                                        <span class="text-gray-500">({{ $rede->localidade->codigo }})</span>
                                                    @endif
                                                </a>
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Rede</label>
                                        <div>
                                            <x-agua::badge variant="info" size="lg">
                                                <x-agua::icon name="link" class="w-4 h-4 mr-1" />
                                                {{ ucfirst(str_replace('_', ' ', $rede->tipo_rede)) }}
                                            </x-agua::badge>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Especificações Técnicas</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Diâmetro</label>
                                        <div class="text-base text-gray-900 dark:text-white">
                                            @if($rede->diametro)
                                                <x-agua::icon name="ruler" class="w-4 h-4 inline mr-1" />
                                                {{ $rede->diametro }}
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Material</label>
                                        <div>
                                            <x-agua::badge variant="secondary">
                                                {{ ucfirst($rede->material ?? 'N/A') }}
                                            </x-agua::badge>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Extensão</label>
                                        <div class="text-base text-gray-900 dark:text-white">
                                            @if($rede->extensao_metros)
                                                <x-agua::icon name="ruler" class="w-4 h-4 inline mr-1" />
                                                {{ number_format($rede->extensao_metros, 2, ',', '.') }} m
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($rede->data_instalacao)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Instalação</label>
                                <div class="text-base text-gray-900 dark:text-white flex items-center gap-1">
                                    <x-agua::icon name="calendar" class="w-4 h-4" />
                                    {{ $rede->data_instalacao->format('d/m/Y') }}
                                </div>
                            </div>
                            @endif

                            @if($rede->observacoes)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $rede->observacoes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-agua::card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Ações Rápidas -->
                    <x-agua::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-agua::icon name="bolt" class="w-5 h-5" />
                                Ações Rápidas
                            </h3>
                        </x-slot>

                        <div class="space-y-3">
                            <x-agua::button href="{{ route('agua.edit', $rede) }}" variant="primary" class="w-full">
                                <x-agua::icon name="pencil" class="w-4 h-4 mr-2" />
                                Editar Rede
                            </x-agua::button>
                            @if(Route::has('demandas.create'))
                                <x-agua::button href="{{ route('demandas.create', ['tipo' => 'agua', 'localidade_id' => $rede->localidade_id]) }}" variant="success" class="w-full">
                                    <x-agua::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                    Criar Demanda
                                </x-agua::button>
                            @endif
                            <form action="{{ route('agua.destroy', $rede) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar esta rede?')">
                                @csrf
                                @method('DELETE')
                                <x-agua::button type="submit" variant="danger" class="w-full">
                                    <x-agua::icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-agua::button>
                            </form>
                        </div>
                    </x-agua::card>

                    <!-- Informações -->
                    <x-agua::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-agua::icon name="information-circle" class="w-5 h-5" />
                                Informações
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $rede->id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $rede->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($rede->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $rede->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </x-agua::card>
                </div>
            </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Localidade -->
                <x-agua::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-agua::icon name="map-pin" class="w-5 h-5" />
                            Localidade
                        </h3>
                    </x-slot>

                    @if($rede->localidade)
                        <div class="space-y-3">
                            <div>
                                <strong class="text-base text-gray-900 dark:text-white">{{ $rede->localidade->nome }}</strong>
                                @if($rede->localidade->codigo)
                                    <x-agua::badge variant="secondary" class="ml-2">{{ $rede->localidade->codigo }}</x-agua::badge>
                                @endif
                            </div>
                            @if($rede->localidade->tipo)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ ucfirst($rede->localidade->tipo ?? 'N/A') }}</div>
                            </div>
                            @endif
                            @if($rede->localidade->cidade)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cidade</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $rede->localidade->cidade }}, {{ $rede->localidade->estado ?? '' }}</div>
                            </div>
                            @endif
                            <x-agua::button href="{{ route('localidades.show', $rede->localidade->id) }}" variant="outline" class="w-full">
                                Ver Localidade
                                <x-agua::icon name="arrow-right" class="w-4 h-4 ml-2" />
                            </x-agua::button>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Nenhuma localidade vinculada</p>
                    @endif
                </x-agua::card>

                @if(isset($rede->pontosDistribuicao) && $rede->pontosDistribuicao->count() > 0)
                <!-- Pontos de Distribuição -->
                <x-agua::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-agua::icon name="water" class="w-5 h-5" />
                            Pontos de Distribuição
                            <x-agua::badge variant="secondary" class="ml-2">{{ $rede->pontosDistribuicao->count() }}</x-agua::badge>
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @foreach($rede->pontosDistribuicao->take(5) as $ponto)
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <strong class="text-sm text-gray-900 dark:text-white">{{ $ponto->codigo ?? 'Ponto #' . $ponto->id }}</strong>
                                        @if($ponto->endereco)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <x-agua::icon name="map-pin" class="w-3 h-3 inline mr-1" />
                                                {{ $ponto->endereco }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($rede->pontosDistribuicao->count() > 5)
                            <div class="text-center mt-3">
                                <x-agua::button href="#" variant="outline" size="sm">
                                    Ver todos os pontos
                                    <x-agua::icon name="arrow-right" class="w-4 h-4 ml-2" />
                                </x-agua::button>
                            </div>
                        @endif
                    </div>
                </x-agua::card>
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
