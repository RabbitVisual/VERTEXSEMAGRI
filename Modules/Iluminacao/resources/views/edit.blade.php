@extends('Co-Admin.layouts.app')

@section('title', 'Editar Ponto de Luz')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Iluminacao" class="w-6 h-6" />
                Editar Ponto #{{ $ponto->id }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $ponto->codigo ?? 'Ponto de Luz' }}</p>
        </div>
        <x-iluminacao::button href="{{ route('iluminacao.show', $ponto) }}" variant="outline">
            <x-iluminacao::icon name="arrow-left" class="w-4 h-4 mr-2" />
            Voltar
        </x-iluminacao::button>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-iluminacao::alert type="success" dismissible>
            {{ session('success') }}
        </x-iluminacao::alert>
    @endif

    @if($errors->any())
        <x-iluminacao::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-iluminacao::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-iluminacao::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-iluminacao::icon name="information-circle" class="w-5 h-5" />
                        Informações do Ponto
                    </h3>
                </x-slot>

                <form action="{{ route('iluminacao.update', $ponto) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Informações Básicas -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-iluminacao::icon name="information-circle" class="w-4 h-4" />
                            Informações Básicas
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código
                                </label>
                                @if($ponto->codigo)
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value="{{ $ponto->codigo }}"
                                            disabled
                                            readonly
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-white font-mono cursor-not-allowed"
                                        />
                                        <div class="absolute inset-0 flex items-center justify-end pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value=""
                                            placeholder="Será gerado automaticamente"
                                            disabled
                                            readonly
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 cursor-not-allowed"
                                        />
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @if($ponto->codigo)
                                        Código já atribuído. Será gerado automaticamente se estiver vazio ao salvar.
                                    @else
                                        Será gerado automaticamente ao salvar
                                    @endif
                                </p>
                            </div>
                            <div>
                                <x-iluminacao::form.select
                                    label="Localidade"
                                    name="localidade_id"
                                    required
                                >
                                    <option value="">Selecione</option>
                                    @foreach($localidades as $loc)
                                        <option value="{{ $loc->id }}" {{ old('localidade_id', $ponto->localidade_id) == $loc->id ? 'selected' : '' }}>
                                            {{ $loc->nome }}
                                        </option>
                                    @endforeach
                                </x-iluminacao::form.select>
                            </div>
                        </div>

                        <x-iluminacao::form.input
                            label="Endereço"
                            name="endereco"
                            type="text"
                            required
                            value="{{ old('endereco', $ponto->endereco) }}"
                            placeholder="Endereço completo do ponto"
                        />
                    </div>

                    <!-- Especificações Técnicas -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-iluminacao::icon name="cog-6-tooth" class="w-4 h-4" />
                            Especificações Técnicas
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-iluminacao::form.input
                                    label="Tipo de Lâmpada"
                                    name="tipo_lampada"
                                    type="text"
                                    value="{{ old('tipo_lampada', $ponto->tipo_lampada) }}"
                                />
                            </div>
                            <div>
                                <x-iluminacao::form.input
                                    label="Potência (W)"
                                    name="potencia"
                                    type="number"
                                    value="{{ old('potencia', $ponto->potencia) }}"
                                />
                            </div>
                            <div>
                                <x-iluminacao::form.select
                                    label="Status"
                                    name="status"
                                    required
                                >
                                    <option value="funcionando" {{ old('status', $ponto->status) == 'funcionando' ? 'selected' : '' }}>Funcionando</option>
                                    <option value="com_defeito" {{ old('status', $ponto->status) == 'com_defeito' ? 'selected' : '' }}>Com Defeito</option>
                                    <option value="desligado" {{ old('status', $ponto->status) == 'desligado' ? 'selected' : '' }}>Desligado</option>
                                </x-iluminacao::form.select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-iluminacao::form.input
                                    label="Tipo de Poste"
                                    name="tipo_poste"
                                    type="text"
                                    value="{{ old('tipo_poste', $ponto->tipo_poste) }}"
                                />
                            </div>
                            <div>
                                <x-iluminacao::form.input
                                    label="Altura do Poste (m)"
                                    name="altura_poste"
                                    type="number"
                                    step="0.01"
                                    value="{{ old('altura_poste', $ponto->altura_poste) }}"
                                />
                            </div>
                        </div>

                        <x-iluminacao::form.input
                            label="Tipo de Fiação"
                            name="tipo_fiacao"
                            type="text"
                            value="{{ old('tipo_fiacao', $ponto->tipo_fiacao) }}"
                        />
                    </div>

                    <!-- Coordenadas e Datas -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-iluminacao::icon name="map-pin" class="w-4 h-4" />
                            Localização e Datas
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-iluminacao::form.input
                                label="Latitude"
                                name="latitude"
                                type="number"
                                step="any"
                                value="{{ old('latitude', $ponto->latitude) }}"
                                placeholder="-12.2336"
                            />
                            <x-iluminacao::form.input
                                label="Longitude"
                                name="longitude"
                                type="number"
                                step="any"
                                value="{{ old('longitude', $ponto->longitude) }}"
                                placeholder="-38.7454"
                            />
                        </div>

                        <!-- Mapa Interativo -->
                        <div class="mt-6">
                            <x-map
                                latitude-field="latitude"
                                longitude-field="longitude"
                                nome-mapa-field="nome_mapa"
                                :latitude="old('latitude', $ponto->latitude)"
                                :longitude="old('longitude', $ponto->longitude)"
                                :nome-mapa="old('nome_mapa', $ponto->nome_mapa)"
                                icon-type="ponto_luz"
                                height="500px"
                                center-lat="-12.2336"
                                center-lng="-38.7454"
                                zoom="13"
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-iluminacao::form.input
                                label="Data de Instalação"
                                name="data_instalacao"
                                type="date"
                                value="{{ old('data_instalacao', $ponto->data_instalacao?->format('Y-m-d')) }}"
                            />
                            <x-iluminacao::form.input
                                label="Última Manutenção"
                                name="ultima_manutencao"
                                type="date"
                                value="{{ old('ultima_manutencao', $ponto->ultima_manutencao?->format('Y-m-d')) }}"
                            />
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-iluminacao::icon name="document-text" class="w-4 h-4" />
                            Observações
                        </h4>

                        <x-iluminacao::form.textarea
                            label="Observações"
                            name="observacoes"
                            rows="3"
                            value="{{ old('observacoes', $ponto->observacoes) }}"
                        />
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-iluminacao::button href="{{ route('iluminacao.show', $ponto) }}" variant="outline">
                            Cancelar
                        </x-iluminacao::button>
                        <x-iluminacao::button type="submit" variant="primary">
                            <x-iluminacao::icon name="check-circle" class="w-4 h-4 mr-2" />
                            Atualizar Ponto
                        </x-iluminacao::button>
                    </div>
                </form>
            </x-iluminacao::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1">
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
@endsection
