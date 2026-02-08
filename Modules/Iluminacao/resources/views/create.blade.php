@extends('Co-Admin.layouts.app')

@section('title', 'Novo Ponto de Luz')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Iluminacao" class="w-6 h-6" />
                Novo Ponto de Luz
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cadastre um novo ponto de iluminação pública</p>
        </div>
        <x-iluminacao::button href="{{ route('iluminacao.index') }}" variant="outline">
            <x-iluminacao::icon name="arrow-left" class="w-4 h-4 mr-2" />
            Voltar
        </x-iluminacao::button>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <x-iluminacao::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-iluminacao::alert>
    @endif

    @if(!$hasLocalidades)
        <x-iluminacao::alert type="warning" dismissible>
            É necessário cadastrar pelo menos uma localidade antes de criar um ponto de luz.
            <a href="{{ route('localidades.create') }}" class="font-medium underline hover:no-underline inline-flex items-center gap-1 ml-1">
                Cadastrar localidade
                <x-iluminacao::icon name="arrow-right" class="w-4 h-4" />
            </a>
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

                <form action="{{ route('iluminacao.store') }}" method="POST" class="space-y-6">
                    @csrf

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
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Será gerado automaticamente ao salvar
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
                                        <option value="{{ $loc->id }}" {{ old('localidade_id') == $loc->id ? 'selected' : '' }}>
                                            {{ $loc->nome }}@if($loc->codigo) ({{ $loc->codigo }})@endif
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
                            value="{{ old('endereco') }}"
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
                                    value="{{ old('tipo_lampada') }}"
                                    placeholder="Ex: LED, Fluorescente, etc."
                                />
                            </div>
                            <div>
                                <x-iluminacao::form.input
                                    label="Potência (W)"
                                    name="potencia"
                                    type="number"
                                    value="{{ old('potencia') }}"
                                    placeholder="Watts"
                                />
                            </div>
                            <div>
                                <x-iluminacao::form.select
                                    label="Status"
                                    name="status"
                                    required
                                >
                                    <option value="funcionando" {{ old('status', 'funcionando') == 'funcionando' ? 'selected' : '' }}>Funcionando</option>
                                    <option value="com_defeito" {{ old('status') == 'com_defeito' ? 'selected' : '' }}>Com Defeito</option>
                                    <option value="desligado" {{ old('status') == 'desligado' ? 'selected' : '' }}>Desligado</option>
                                </x-iluminacao::form.select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-iluminacao::form.input
                                    label="Tipo de Poste"
                                    name="tipo_poste"
                                    type="text"
                                    value="{{ old('tipo_poste') }}"
                                    placeholder="Ex: Concreto, Metálico, etc."
                                />
                            </div>
                            <div>
                                <x-iluminacao::form.input
                                    label="Altura do Poste (m)"
                                    name="altura_poste"
                                    type="number"
                                    step="0.01"
                                    value="{{ old('altura_poste') }}"
                                    placeholder="Metros"
                                />
                            </div>
                        </div>

                        <x-iluminacao::form.input
                            label="Tipo de Fiação"
                            name="tipo_fiacao"
                            type="text"
                            value="{{ old('tipo_fiacao') }}"
                            placeholder="Tipo de fiação utilizada"
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
                                value="{{ old('latitude') }}"
                                placeholder="-12.2336"
                            />
                            <x-iluminacao::form.input
                                label="Longitude"
                                name="longitude"
                                type="number"
                                step="any"
                                value="{{ old('longitude') }}"
                                placeholder="-38.7454"
                            />
                        </div>

                        <!-- Mapa Interativo -->
                        <div class="mt-6">
                            <x-map
                                latitude-field="latitude"
                                longitude-field="longitude"
                                nome-mapa-field="nome_mapa"
                                :latitude="old('latitude')"
                                :longitude="old('longitude')"
                                :nome-mapa="old('nome_mapa')"
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
                                value="{{ old('data_instalacao') }}"
                            />
                            <x-iluminacao::form.input
                                label="Última Manutenção"
                                name="ultima_manutencao"
                                type="date"
                                value="{{ old('ultima_manutencao') }}"
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
                            value="{{ old('observacoes') }}"
                            placeholder="Informações adicionais sobre o ponto"
                        />
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-iluminacao::button href="{{ route('iluminacao.index') }}" variant="outline">
                            Cancelar
                        </x-iluminacao::button>
                        <x-iluminacao::button type="submit" variant="primary">
                            <x-iluminacao::icon name="check-circle" class="w-4 h-4 mr-2" />
                            Salvar Ponto
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
                        Dicas
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <x-iluminacao::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Código</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Será gerado automaticamente no formato PL-YYYYMMDD-XXXX se deixado em branco.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                        <div class="flex items-start gap-3">
                            <x-iluminacao::icon name="exclamation-triangle" class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-1">Status</h4>
                                <p class="text-xs text-amber-800 dark:text-amber-300">
                                    Atualize o status conforme o estado atual do ponto de iluminação.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-iluminacao::card>
        </div>
    </div>
</div>
@endsection
