@extends('Co-Admin.layouts.app')

@section('title', 'Nova Localidade')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="localidades" class="w-6 h-6" />
                Nova Localidade
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cadastre uma nova localidade no sistema</p>
        </div>
        <x-localidades::button href="{{ route('localidades.index') }}" variant="outline">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </x-localidades::button>
    </div>

    <!-- Alertas -->
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

                <form action="{{ route('localidades.store') }}" method="POST" class="space-y-6">
                    @csrf

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
                                    value="{{ old('nome') }}"
                                    placeholder="Nome da localidade"
                                />
                            </div>
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
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-localidades::form.select
                                    label="Tipo"
                                    name="tipo"
                                    required
                                >
                                    <option value="">Selecione</option>
                                    <option value="comunidade" {{ old('tipo') == 'comunidade' ? 'selected' : '' }}>Comunidade</option>
                                    <option value="bairro" {{ old('tipo') == 'bairro' ? 'selected' : '' }}>Bairro</option>
                                    <option value="distrito" {{ old('tipo') == 'distrito' ? 'selected' : '' }}>Distrito</option>
                                    <option value="zona_rural" {{ old('tipo') == 'zona_rural' ? 'selected' : '' }}>Zona Rural</option>
                                    <option value="outro" {{ old('tipo') == 'outro' ? 'selected' : '' }}>Outro</option>
                                </x-localidades::form.select>
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="Estado"
                                    name="estado"
                                    type="text"
                                    value="{{ old('estado', 'BA') }}"
                                    placeholder="BA"
                                    maxlength="2"
                                />
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="CEP"
                                    name="cep"
                                    type="text"
                                    value="{{ old('cep', '44250-000') }}"
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
                            value="{{ old('endereco') }}"
                            placeholder="Rua, Avenida, etc."
                        />

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-localidades::form.input
                                    label="Número"
                                    name="numero"
                                    type="text"
                                    value="{{ old('numero') }}"
                                    placeholder="S/N"
                                />
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="Complemento"
                                    name="complemento"
                                    type="text"
                                    value="{{ old('complemento') }}"
                                    placeholder="Apto, Bloco, etc."
                                />
                            </div>
                            <div>
                                <x-localidades::form.input
                                    label="Bairro"
                                    name="bairro"
                                    type="text"
                                    value="{{ old('bairro') }}"
                                />
                            </div>
                        </div>

                        <x-localidades::form.input
                            label="Cidade"
                            name="cidade"
                            type="text"
                            value="{{ old('cidade', 'Coração de Maria') }}"
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
                                value="{{ old('latitude') }}"
                                placeholder="-12.2336"
                                help="Exemplo: -12.2336"
                            />
                            <x-localidades::form.input
                                label="Longitude"
                                name="longitude"
                                type="number"
                                step="any"
                                value="{{ old('longitude') }}"
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
                                :latitude="old('latitude')"
                                :longitude="old('longitude')"
                                :nome-mapa="old('nome_mapa')"
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
                                value="{{ old('lider_comunitario') }}"
                                placeholder="Nome do líder"
                            />
                            <x-localidades::form.input
                                label="Telefone do Líder"
                                name="telefone_lider"
                                type="text"
                                value="{{ old('telefone_lider') }}"
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
                            value="{{ old('numero_moradores', 0) }}"
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
                            value="{{ old('infraestrutura_disponivel') }}"
                            placeholder="Ex: Água encanada, Energia elétrica, Internet, etc."
                        />

                        <x-localidades::form.textarea
                            label="Problemas Recorrentes"
                            name="problemas_recorrentes"
                            rows="3"
                            value="{{ old('problemas_recorrentes') }}"
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
                            value="{{ old('observacoes') }}"
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
                                   {{ old('ativo', true) ? 'checked' : '' }}
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
                        <x-localidades::button href="{{ route('localidades.index') }}" variant="outline">
                            Cancelar
                        </x-localidades::button>
                        <x-localidades::button type="submit" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Salvar Localidade
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
                        Dicas
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Código</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Será gerado automaticamente no formato LOC-TIPO-ANO-MES-0001 se deixado em branco.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-emerald-900 dark:text-emerald-200 mb-1">CEP</h4>
                                <p class="text-xs text-emerald-800 dark:text-emerald-300">
                                    O CEP padrão de Coração de Maria é 44250-000.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-200 mb-1">Coordenadas</h4>
                                <p class="text-xs text-indigo-800 dark:text-indigo-300">
                                    Adicione latitude e longitude para visualização em mapas.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Campos Obrigatórios:</h4>
                        <ul class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <span>Nome</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <span>Tipo</span>
                            </li>
                        </ul>
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
