@extends('Co-Admin.layouts.app')

@section('title', 'Editar Localidade')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="localidades" class="w-6 h-6" />
                Editar Localidade
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $localidade->nome ?? 'Localidade' }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-localidades::button href="{{ route('localidades.show', $localidade) }}" variant="outline">
                <x-icon name="arrow-left" class="w-5 h-5" />
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

    @if($errors->any())
        <x-localidades::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-localidades::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-localidades::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        Informações da Localidade
                    </h3>
                </x-slot>

                <form action="{{ route('localidades.update', $localidade) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Informações Básicas -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            Informações Básicas
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <x-localidades::form.input
                                    label="Nome"
                                    name="nome"
                                    type="text"
                                    required
                                    value="{{ old('nome', $localidade->nome) }}"
                                    placeholder="Nome da localidade"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código
                                </label>
                                @if($localidade->codigo)
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value="{{ $localidade->codigo }}"
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
                                    @if($localidade->codigo)
                                        Código já atribuído. Será gerado automaticamente se estiver vazio ao salvar.
                                    @else
                                        Será gerado automaticamente ao salvar
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-localidades::form.select
                                    label="Tipo"
                                    name="tipo"
                                    required
                                >
                                    <option value="">Selecione</option>
                                    <option value="comunidade" {{ old('tipo', $localidade->tipo) == 'comunidade' ? 'selected' : '' }}>Comunidade</option>
                                    <option value="bairro" {{ old('tipo', $localidade->tipo) == 'bairro' ? 'selected' : '' }}>Bairro</option>
                                    <option value="distrito" {{ old('tipo', $localidade->tipo) == 'distrito' ? 'selected' : '' }}>Distrito</option>
                                    <option value="zona_rural" {{ old('tipo', $localidade->tipo) == 'zona_rural' ? 'selected' : '' }}>Zona Rural</option>
                                    <option value="outro" {{ old('tipo', $localidade->tipo) == 'outro' ? 'selected' : '' }}>Outro</option>
                                </x-localidades::form.select>
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="Estado"
                                    name="estado"
                                    type="text"
                                    value="{{ old('estado', $localidade->estado ?? 'BA') }}"
                                    placeholder="BA"
                                    maxlength="2"
                                />
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="CEP"
                                    name="cep"
                                    type="text"
                                    value="{{ old('cep', $localidade->cep ?? '44250-000') }}"
                                    placeholder="44250-000"
                                    maxlength="10"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            Endereço
                        </h4>

                        <x-localidades::form.input
                            label="Endereço"
                            name="endereco"
                            type="text"
                            value="{{ old('endereco', $localidade->endereco) }}"
                            placeholder="Rua, Avenida, etc."
                        />

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-localidades::form.input
                                    label="Número"
                                    name="numero"
                                    type="text"
                                    value="{{ old('numero', $localidade->numero) }}"
                                    placeholder="S/N"
                                />
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="Complemento"
                                    name="complemento"
                                    type="text"
                                    value="{{ old('complemento', $localidade->complemento) }}"
                                    placeholder="Apto, Bloco, etc."
                                />
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="Bairro"
                                    name="bairro"
                                    type="text"
                                    value="{{ old('bairro', $localidade->bairro) }}"
                                />
                            </div>
                        </div>

                        <x-localidades::form.input
                            label="Cidade"
                            name="cidade"
                            type="text"
                            value="{{ old('cidade', $localidade->cidade) }}"
                        />
                    </div>

                    <!-- Coordenadas Geográficas -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            Coordenadas Geográficas
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-localidades::form.input
                                label="Latitude"
                                name="latitude"
                                type="number"
                                step="any"
                                value="{{ old('latitude', $localidade->latitude) }}"
                                placeholder="-12.2336"
                                help="Exemplo: -12.2336"
                            />
                            <x-localidades::form.input
                                label="Longitude"
                                name="longitude"
                                type="number"
                                step="any"
                                value="{{ old('longitude', $localidade->longitude) }}"
                                placeholder="-38.7454"
                                help="Exemplo: -38.7454"
                            />
                        </div>

                        <!-- Mapa Interativo -->
                        <div class="mt-6">
                            <x-map
                                latitude-field="latitude"
                                longitude-field="longitude"
                                nome-mapa-field="nome_mapa"
                                :latitude="old('latitude', $localidade->latitude)"
                                :longitude="old('longitude', $localidade->longitude)"
                                :nome-mapa="old('nome_mapa', $localidade->nome_mapa)"
                                icon-type="localidade"
                                height="500px"
                                center-lat="-12.2336"
                                center-lng="-38.7454"
                                zoom="13"
                            />
                        </div>
                    </div>

                    <!-- Liderança Comunitária -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            Liderança Comunitária
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-localidades::form.input
                                label="Líder Comunitário"
                                name="lider_comunitario"
                                type="text"
                                value="{{ old('lider_comunitario', $localidade->lider_comunitario) }}"
                                placeholder="Nome do líder"
                            />
                            <x-localidades::form.input
                                label="Telefone do Líder"
                                name="telefone_lider"
                                type="text"
                                value="{{ old('telefone_lider', $localidade->telefone_lider) }}"
                                placeholder="(75) 99999-9999"
                            />
                        </div>
                    </div>

                    <!-- Informações Demográficas -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Informações Demográficas
                        </h4>

                        <x-localidades::form.input
                            label="Número de Moradores"
                            name="numero_moradores"
                            type="number"
                            value="{{ old('numero_moradores', $localidade->numero_moradores ?? 0) }}"
                            min="0"
                        />
                    </div>

                    <!-- Infraestrutura e Problemas -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655-5.653a2.548 2.548 0 00-4.655 5.653l4.655 5.653c.9 1.09 2.328 1.09 3.228 0z" />
                            </svg>
                            Infraestrutura e Problemas
                        </h4>

                        <x-localidades::form.textarea
                            label="Infraestrutura Disponível"
                            name="infraestrutura_disponivel"
                            rows="3"
                            value="{{ old('infraestrutura_disponivel', $localidade->infraestrutura_disponivel) }}"
                            placeholder="Ex: Água encanada, Energia elétrica, Internet, etc."
                        />

                        <x-localidades::form.textarea
                            label="Problemas Recorrentes"
                            name="problemas_recorrentes"
                            rows="3"
                            value="{{ old('problemas_recorrentes', $localidade->problemas_recorrentes) }}"
                            placeholder="Ex: Falta de água, Estradas ruins, Iluminação precária, etc."
                        />
                    </div>

                    <!-- Observações -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                            Observações
                        </h4>

                        <x-localidades::form.textarea
                            label="Observações"
                            name="observacoes"
                            rows="3"
                            value="{{ old('observacoes', $localidade->observacoes) }}"
                            placeholder="Informações adicionais sobre a localidade"
                        />
                    </div>

                    <!-- Status -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', $localidade->ativo) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="ativo" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Localidade ativa
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Localidades ativas aparecem nas listagens e podem ser vinculadas a demandas
                        </p>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-localidades::button href="{{ route('localidades.show', $localidade) }}" variant="outline">
                            Cancelar
                        </x-localidades::button>
                        <x-localidades::button type="submit" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Atualizar Localidade
                        </x-localidades::button>
                    </div>
                </form>
            </x-localidades::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1">
            <x-localidades::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Informações
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Informações Rápidas</h4>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">ID:</span>
                                <span class="text-gray-900 dark:text-white font-medium">#{{ $localidade->id }}</span>
                            </div>
                            @if($localidade->codigo)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Código:</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $localidade->codigo }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                @if($localidade->ativo)
                                    <x-localidades::badge variant="success" size="sm">Ativo</x-localidades::badge>
                                @else
                                    <x-localidades::badge variant="danger" size="sm">Inativo</x-localidades::badge>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Dica:</h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            Mantenha as informações atualizadas para melhor gestão das localidades e demandas relacionadas.
                        </p>
                    </div>
                </div>
            </x-localidades::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CEP
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            e.target.value = value;
        });
    }

    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone_lider');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                }
            }
            e.target.value = value;
        });
    }
});
</script>
@endpush
@endsection
