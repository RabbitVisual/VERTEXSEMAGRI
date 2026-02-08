@extends('Co-Admin.layouts.app')

@section('title', 'Novo Poço Artesiano')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Pocos" class="w-6 h-6" />
                Novo Poço Artesiano
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cadastre um novo poço artesiano no sistema</p>
        </div>
        <x-pocos::button href="{{ route('pocos.index') }}" variant="outline">
            <x-pocos::icon name="arrow-left" class="w-4 h-4 mr-2" />
            Voltar
        </x-pocos::button>
    </div>

    <!-- Alertas -->
    @if(session('warning'))
        <x-pocos::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-pocos::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-pocos::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-pocos::icon name="information-circle" class="w-5 h-5" />
                        Informações do Poço
                    </h3>
                </x-slot>

                <form action="{{ route('pocos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Informações Básicas -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-pocos::icon name="information-circle" class="w-4 h-4" />
                            Informações Básicas
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-pocos::form.select
                                name="localidade_id"
                                label="Localidade"
                                :value="old('localidade_id')"
                                required
                            >
                                <option value="">Selecione uma localidade</option>
                                @foreach($localidades as $loc)
                                    <option value="{{ $loc->id }}" {{ old('localidade_id') == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->nome }}@if($loc->codigo) ({{ $loc->codigo }})@endif
                                    </option>
                                @endforeach
                            </x-pocos::form.select>
                        </div>
                        @if(empty($localidades))
                            <x-pocos::alert type="warning" class="mt-4">
                                <x-pocos::icon name="exclamation-triangle" class="w-4 h-4 mr-2" />
                                <strong>Atenção!</strong> Nenhuma localidade cadastrada.
                                <a href="{{ route('localidades.create') }}" class="underline font-medium">Cadastre uma localidade primeiro</a>.
                            </x-pocos::alert>
                        @endif

                        <div class="mt-4">
                            <x-pocos::form.input
                                name="endereco"
                                label="Endereço"
                                :value="old('endereco')"
                                placeholder="Endereço completo do poço"
                                required
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <x-pocos::form.input
                                name="latitude"
                                label="Latitude"
                                type="text"
                                :value="old('latitude')"
                                placeholder="-12.2336"
                            />
                            <x-pocos::form.input
                                name="longitude"
                                label="Longitude"
                                type="text"
                                :value="old('longitude')"
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
                                icon-type="poco"
                                height="500px"
                                center-lat="-12.2336"
                                center-lng="-38.7454"
                                zoom="13"
                            />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-pocos::icon name="water" class="w-4 h-4" />
                            Características Técnicas
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-pocos::form.input
                                name="profundidade_metros"
                                label="Profundidade (metros)"
                                type="number"
                                step="0.01"
                                :value="old('profundidade_metros')"
                                required
                            />
                            <x-pocos::form.input
                                name="vazao_litros_hora"
                                label="Vazão (litros/hora)"
                                type="number"
                                step="0.01"
                                :value="old('vazao_litros_hora')"
                            />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <x-pocos::form.input
                                name="diametro"
                                label="Diâmetro"
                                :value="old('diametro')"
                                placeholder="Ex: 4 polegadas, 100mm"
                            />
                            <x-pocos::form.input
                                name="data_perfuracao"
                                label="Data de Perfuração"
                                type="date"
                                :value="old('data_perfuracao')"
                            />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-pocos::icon name="bolt" class="w-4 h-4" />
                            Informações da Bomba
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-pocos::form.input
                                name="tipo_bomba"
                                label="Tipo de Bomba"
                                :value="old('tipo_bomba')"
                                placeholder="Ex: Submersa, Centrífuga"
                            />
                            <x-pocos::form.input
                                name="potencia_bomba"
                                label="Potência da Bomba (HP ou Watts)"
                                type="number"
                                :value="old('potencia_bomba')"
                                placeholder="Ex: 5 HP"
                            />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-pocos::icon name="wrench-screwdriver" class="w-4 h-4" />
                            Manutenção e Responsabilidade
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-pocos::form.select
                                name="equipe_responsavel_id"
                                label="Equipe Responsável"
                                :value="old('equipe_responsavel_id')"
                            >
                                <option value="">Nenhuma</option>
                                @foreach($equipes as $equipe)
                                    <option value="{{ $equipe->id }}" {{ old('equipe_responsavel_id') == $equipe->id ? 'selected' : '' }}>
                                        {{ $equipe->nome }}@if($equipe->codigo) ({{ $equipe->codigo }})@endif
                                    </option>
                                @endforeach
                            </x-pocos::form.select>
                            <x-pocos::form.select
                                name="status"
                                label="Status"
                                :value="old('status', 'ativo')"
                                required
                            >
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                                <option value="manutencao">Em Manutenção</option>
                                <option value="bomba_queimada">Bomba Queimada</option>
                            </x-pocos::form.select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <x-pocos::form.input
                                name="ultima_manutencao"
                                label="Última Manutenção"
                                type="date"
                                :value="old('ultima_manutencao')"
                            />
                            <x-pocos::form.input
                                name="proxima_manutencao"
                                label="Próxima Manutenção"
                                type="date"
                                :value="old('proxima_manutencao')"
                            />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-pocos::icon name="document-text" class="w-4 h-4" />
                            Observações
                        </h4>
                        <x-pocos::form.textarea
                            name="observacoes"
                            label="Observações"
                            :value="old('observacoes')"
                            rows="4"
                            placeholder="Informações adicionais sobre o poço..."
                        />
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <x-pocos::button href="{{ route('pocos.index') }}" variant="outline">
                            Cancelar
                        </x-pocos::button>
                        <x-pocos::button type="submit" variant="primary">
                            <x-pocos::icon name="check" class="w-4 h-4 mr-2" />
                            Salvar Poço
                        </x-pocos::button>
                    </div>
                </form>
            </x-pocos::card>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <x-pocos::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-pocos::icon name="light-bulb" class="w-5 h-5" />
                        Dicas
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <x-pocos::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Código:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Será gerado automaticamente no formato POC-STATUS-ANO-MES-0001.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-pocos::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Localidade:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">É necessário cadastrar localidades antes de criar poços.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-pocos::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Coordenadas:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Adicione latitude e longitude para visualização em mapas.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-pocos::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Manutenção:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Defina a próxima manutenção para receber alertas.</p>
                        </div>
                    </div>
                </div>
            </x-pocos::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preencher campos automaticamente ao selecionar localidade
    const localidadeSelect = document.getElementById('localidade_id');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const enderecoInput = document.getElementById('endereco');

    if (localidadeSelect) {
        localidadeSelect.addEventListener('change', function() {
            const localidadeId = this.value;

            if (localidadeId) {
                // Buscar dados da localidade via AJAX
                const urlBase = '{{ url("/localidades") }}';
                fetch(`${urlBase}/${localidadeId}/dados`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Preencher latitude se disponível
                    if (data.latitude && latitudeInput && !latitudeInput.value) {
                        latitudeInput.value = data.latitude;
                    }

                    // Preencher longitude se disponível
                    if (data.longitude && longitudeInput && !longitudeInput.value) {
                        longitudeInput.value = data.longitude;
                    }

                    // Preencher endereço se disponível
                    if (data.endereco && enderecoInput && !enderecoInput.value) {
                        let enderecoCompleto = data.endereco;

                        if (data.numero) {
                            enderecoCompleto += ', ' + data.numero;
                        }

                        if (data.complemento) {
                            enderecoCompleto += ' - ' + data.complemento;
                        }

                        if (data.bairro) {
                            enderecoCompleto += ', ' + data.bairro;
                        }

                        if (data.cidade) {
                            enderecoCompleto += ' - ' + data.cidade;
                            if (data.estado) {
                                enderecoCompleto += '/' + data.estado;
                            }
                        }

                        if (data.cep) {
                            enderecoCompleto += ' - CEP: ' + data.cep;
                        }

                        enderecoInput.value = enderecoCompleto;
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar dados da localidade:', error);
                });
            }
        });
    }
});
</script>
@endpush
@endsection
