@extends('Co-Admin.layouts.app')

@section('title', 'Novo Trecho')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="estradas" class="w-6 h-6" />
                Novo Trecho
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cadastre um novo trecho de estrada ou vicinal</p>
        </div>
        <x-estradas::button href="{{ route('estradas.index') }}" variant="outline">
            <x-estradas::icon name="arrow-left" class="w-4 h-4 mr-2" />
            Voltar
        </x-estradas::button>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <x-estradas::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-estradas::alert>
    @endif

    @if(!$hasLocalidades)
        <x-estradas::alert type="warning" dismissible>
            É necessário cadastrar pelo menos uma localidade antes de criar um trecho.
            <a href="{{ route('localidades.create') }}" class="font-medium underline hover:no-underline inline-flex items-center gap-1 ml-1">
                Cadastrar localidade
                <x-estradas::icon name="arrow-right" class="w-4 h-4" />
            </a>
        </x-estradas::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-estradas::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-estradas::icon name="information-circle" class="w-5 h-5" />
                        Informações do Trecho
                    </h3>
                </x-slot>

                <form action="{{ route('estradas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Informações Básicas -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-estradas::icon name="information-circle" class="w-4 h-4" />
                            Informações Básicas
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <x-estradas::form.input
                                    label="Nome"
                                    name="nome"
                                    type="text"
                                    required
                                    value="{{ old('nome') }}"
                                    placeholder="Nome do trecho"
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-estradas::form.select
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
                            </x-estradas::form.select>
                            <x-estradas::form.select
                                label="Tipo"
                                name="tipo"
                                required
                            >
                                <option value="vicinal" {{ old('tipo', 'vicinal') == 'vicinal' ? 'selected' : '' }}>Vicinal</option>
                                <option value="principal" {{ old('tipo') == 'principal' ? 'selected' : '' }}>Principal</option>
                                <option value="secundaria" {{ old('tipo') == 'secundaria' ? 'selected' : '' }}>Secundária</option>
                            </x-estradas::form.select>
                        </div>
                    </div>

                    <!-- Características Físicas -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-estradas::icon name="ruler" class="w-4 h-4" />
                            Características Físicas
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-estradas::form.input
                                label="Extensão (km)"
                                name="extensao_km"
                                type="number"
                                step="0.01"
                                value="{{ old('extensao_km') }}"
                                placeholder="Ex: 5.5"
                            />
                            <x-estradas::form.input
                                label="Largura (metros)"
                                name="largura_metros"
                                type="number"
                                step="0.01"
                                value="{{ old('largura_metros') }}"
                                placeholder="Ex: 6.0"
                            />
                            <x-estradas::form.select
                                label="Tipo de Pavimento"
                                name="tipo_pavimento"
                            >
                                <option value="">Selecione</option>
                                <option value="asfalto" {{ old('tipo_pavimento') == 'asfalto' ? 'selected' : '' }}>Asfalto</option>
                                <option value="cascalho" {{ old('tipo_pavimento') == 'cascalho' ? 'selected' : '' }}>Cascalho</option>
                                <option value="terra" {{ old('tipo_pavimento') == 'terra' ? 'selected' : '' }}>Terra</option>
                            </x-estradas::form.select>
                        </div>
                    </div>

                    <!-- Condição e Manutenção -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-estradas::icon name="wrench-screwdriver" class="w-4 h-4" />
                            Condição e Manutenção
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-estradas::form.select
                                label="Condição"
                                name="condicao"
                                required
                            >
                                <option value="boa" {{ old('condicao', 'boa') == 'boa' ? 'selected' : '' }}>Boa</option>
                                <option value="regular" {{ old('condicao') == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="ruim" {{ old('condicao') == 'ruim' ? 'selected' : '' }}>Ruim</option>
                                <option value="pessima" {{ old('condicao') == 'pessima' ? 'selected' : '' }}>Péssima</option>
                            </x-estradas::form.select>
                            <div>
                                <div class="flex items-center mb-2">
                                    <input type="checkbox"
                                           id="tem_ponte"
                                           name="tem_ponte"
                                           value="1"
                                           {{ old('tem_ponte') ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                    <label for="tem_ponte" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                        Possui ponte(s)
                                    </label>
                                </div>
                                @if(old('tem_ponte'))
                                <x-estradas::form.input
                                    label="Número de Pontes"
                                    name="numero_pontes"
                                    type="number"
                                    value="{{ old('numero_pontes', 1) }}"
                                    min="1"
                                />
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-estradas::form.input
                                label="Última Manutenção"
                                name="ultima_manutencao"
                                type="date"
                                value="{{ old('ultima_manutencao') }}"
                            />
                            <x-estradas::form.input
                                label="Próxima Manutenção"
                                name="proxima_manutencao"
                                type="date"
                                value="{{ old('proxima_manutencao') }}"
                            />
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                            <x-estradas::icon name="document-text" class="w-4 h-4" />
                            Observações
                        </h4>

                        <x-estradas::form.textarea
                            label="Observações"
                            name="observacoes"
                            rows="3"
                            value="{{ old('observacoes') }}"
                            placeholder="Informações adicionais sobre o trecho"
                        />
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-estradas::button href="{{ route('estradas.index') }}" variant="outline">
                            Cancelar
                        </x-estradas::button>
                        <x-estradas::button type="submit" variant="primary">
                            <x-estradas::icon name="check-circle" class="w-4 h-4 mr-2" />
                            Salvar Trecho
                        </x-estradas::button>
                    </div>
                </form>
            </x-estradas::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1">
            <x-estradas::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-estradas::icon name="information-circle" class="w-5 h-5" />
                        Dicas
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <x-estradas::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Código</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Será gerado automaticamente no formato TRECHO-YYYYMMDD-XXXX se deixado em branco.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                        <div class="flex items-start gap-3">
                            <x-estradas::icon name="exclamation-triangle" class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-1">Condição</h4>
                                <p class="text-xs text-amber-800 dark:text-amber-300">
                                    Atualize a condição conforme o estado atual do trecho para facilitar o planejamento de manutenções.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-estradas::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar campo de número de pontes
    const temPonteCheckbox = document.getElementById('tem_ponte');
    const numeroPontesContainer = document.querySelector('[name="numero_pontes"]')?.closest('div');

    if (temPonteCheckbox && numeroPontesContainer) {
        function toggleNumeroPontes() {
            if (temPonteCheckbox.checked) {
                numeroPontesContainer.style.display = 'block';
            } else {
                numeroPontesContainer.style.display = 'none';
                document.querySelector('[name="numero_pontes"]').value = '';
            }
        }

        temPonteCheckbox.addEventListener('change', toggleNumeroPontes);
        toggleNumeroPontes(); // Inicializar estado
    }
});
</script>
@endpush
@endsection
