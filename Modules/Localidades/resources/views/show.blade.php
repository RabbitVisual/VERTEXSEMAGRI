@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Localidade')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Localidades" class="w-6 h-6" />
                {{ $localidade->nome }}
                @if($localidade->codigo)
                    <span class="text-indigo-600 dark:text-indigo-400 text-lg font-normal">({{ $localidade->codigo }})</span>
                @endif
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes completos da localidade</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-localidades::button href="{{ route('localidades.edit', $localidade) }}" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                Editar
            </x-localidades::button>
            <x-localidades::button href="{{ route('localidades.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </x-localidades::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-localidades::alert type="success" dismissible>
            {{ session('success') }}
        </x-localidades::alert>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticasPessoas))
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-localidades::stat-card
            title="Total de Pessoas"
            :value="$estatisticasPessoas['total'] ?? 0"
            icon="users"
            color="primary"
        />
        <x-localidades::stat-card
            title="Beneficiárias PBF"
            :value="$estatisticasPessoas['beneficiarias_pbf'] ?? 0"
            icon="check-circle"
            color="success"
        />
    </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                Detalhes
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                </svg>
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
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    Informações Básicas
                                </h3>
                            </x-slot>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                        <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $localidade->codigo ?? 'N/A' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                        <div>
                                            @if($localidade->ativo)
                                                <x-localidades::badge variant="success">Ativo</x-localidades::badge>
                                            @else
                                                <x-localidades::badge variant="danger">Inativo</x-localidades::badge>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $localidade->nome }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                        <div>
                                            <x-localidades::badge variant="info">
                                                {{ ucfirst(str_replace('_', ' ', $localidade->tipo)) }}
                                            </x-localidades::badge>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cidade</label>
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $localidade->cidade ?? 'N/A' }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $localidade->estado ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </x-localidades::card>

                        <!-- Endereço -->
                        @if($localidade->endereco || $localidade->numero || $localidade->complemento || $localidade->bairro || $localidade->cep)
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    Endereço
                                </h3>
                            </x-slot>

                            <div class="space-y-3">
                                @if($localidade->endereco || $localidade->numero || $localidade->complemento || $localidade->bairro)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Endereço Completo</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-start gap-1">
                                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <div>
                                            @if($localidade->endereco)
                                                {{ $localidade->endereco }}
                                            @endif
                                            @if($localidade->numero)
                                                , {{ $localidade->numero }}
                                            @endif
                                            @if($localidade->complemento)
                                                - {{ $localidade->complemento }}
                                            @endif
                                            @if($localidade->bairro)
                                                <br>{{ $localidade->bairro }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($localidade->cep)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">CEP</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $localidade->cep }}</div>
                                </div>
                                @endif
                            </div>
                        </x-localidades::card>
                        @endif

                        <!-- Liderança Comunitária -->
                        @if($localidade->lider_comunitario)
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    Liderança Comunitária
                                </h3>
                            </x-slot>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Líder Comunitário</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $localidade->lider_comunitario }}</div>
                                </div>
                                @if($localidade->telefone_lider)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Telefone</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                        </svg>
                                        {{ $localidade->telefone_lider }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </x-localidades::card>
                        @endif

                        <!-- Informações Demográficas e Infraestrutura -->
                        @if($localidade->numero_moradores || $localidade->infraestrutura_disponivel || $localidade->problemas_recorrentes)
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    Informações Demográficas e Infraestrutura
                                </h3>
                            </x-slot>

                            <div class="space-y-4">
                                @if($localidade->numero_moradores)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Número de Moradores</label>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                        {{ number_format($localidade->numero_moradores, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endif

                                @if($localidade->infraestrutura_disponivel)
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Infraestrutura Disponível</label>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $localidade->infraestrutura_disponivel }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($localidade->problemas_recorrentes)
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Problemas Recorrentes</label>
                                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                                        <p class="text-sm text-amber-900 dark:text-amber-200 whitespace-pre-line">{{ $localidade->problemas_recorrentes }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </x-localidades::card>
                        @endif

                        <!-- Coordenadas Geográficas -->
                        @if($localidade->latitude && $localidade->longitude)
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                    Coordenadas Geográficas
                                </h3>
                            </x-slot>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Localização</label>
                                <div class="text-sm text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                    <span>Lat: {{ $localidade->latitude }}, Long: {{ $localidade->longitude }}</span>
                                </div>

                                <!-- Mapa Interativo (somente leitura) -->
                                <x-map
                                    latitude-field="latitude"
                                    longitude-field="longitude"
                                    :latitude="$localidade->latitude"
                                    :longitude="$localidade->longitude"
                                    :nome-mapa="$localidade->nome_mapa"
                                    icon-type="localidade"
                                    readonly
                                    height="400px"
                                    center-lat="-12.2336"
                                    center-lng="-38.7454"
                                    zoom="13"
                                />
                            </div>
                        </x-localidades::card>
                        @endif

                        <!-- Observações -->
                        @if($localidade->observacoes)
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    Observações
                                </h3>
                            </x-slot>

                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $localidade->observacoes }}</p>
                            </div>
                        </x-localidades::card>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Ações Rápidas -->
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                    Ações Rápidas
                                </h3>
                            </x-slot>

                            <div class="space-y-3">
                                <x-localidades::button href="{{ route('localidades.edit', $localidade) }}" variant="primary" class="w-full">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    Editar Localidade
                                </x-localidades::button>

                                @if(Route::has('demandas.create'))
                                    <x-localidades::button href="{{ route('demandas.create', ['localidade_id' => $localidade->id]) }}" variant="success" class="w-full">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Criar Demanda
                                    </x-localidades::button>
                                @endif

                                <form action="{{ route('localidades.destroy', $localidade) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar esta localidade?')" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <x-localidades::button type="submit" variant="danger" class="w-full">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Deletar
                                    </x-localidades::button>
                                </form>
                            </div>
                        </x-localidades::card>

                        <!-- Informações do Sistema -->
                        <x-localidades::card>
                            <x-slot name="header">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    Informações
                                </h3>
                            </x-slot>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">ID:</span>
                                    <span class="text-gray-900 dark:text-white font-medium">#{{ $localidade->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Criado em:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $localidade->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @if($localidade->updated_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Atualizado em:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $localidade->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @endif
                            </div>
                        </x-localidades::card>
                    </div>
                </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Demandas -->
                    <x-localidades::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Demandas
                            </h3>
                        </x-slot>

                        <div class="space-y-2">
                            @forelse(($localidade->demandas ?? collect([]))->take(10) as $demanda)
                                <a href="{{ route('demandas.show', $demanda) }}" class="block p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $demanda->codigo ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $demanda->solicitante_nome ?? 'N/A' }}</div>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-sm">Nenhuma demanda vinculada</p>
                                </div>
                            @endforelse
                        </div>
                    </x-localidades::card>

                    <!-- Pessoas -->
                    <x-localidades::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Pessoas
                            </h3>
                        </x-slot>

                        <div class="space-y-2">
                            @forelse(($localidade->pessoas ?? collect([]))->take(10) as $pessoa)
                                <a href="{{ route('pessoas.show', $pessoa) }}" class="block p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $pessoa->nom_pessoa ?? 'N/A' }}</div>
                                            @if($pessoa->num_cpf_pessoa)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $pessoa->cpf_formatado ?? 'N/A' }}</div>
                                            @endif
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <p class="text-sm">Nenhuma pessoa vinculada</p>
                                </div>
                            @endforelse
                        </div>
                    </x-localidades::card>
                </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    function showTab(targetId) {
        // Hide all panels
        tabPanels.forEach(panel => {
            panel.classList.add('hidden');
        });

        // Remove active state from all buttons
        tabButtons.forEach(button => {
            button.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
        });

        // Show target panel
        const targetPanel = document.querySelector(`[data-tab-panel="${targetId}"]`);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        // Activate target button
        const targetButton = document.querySelector(`[data-tab-target="${targetId}"]`);
        if (targetButton) {
            targetButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
            targetButton.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
        }
    }

    // Add click handlers
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-tab-target');
            showTab(targetId);
        });
    });
});
</script>
@endpush
@endsection
