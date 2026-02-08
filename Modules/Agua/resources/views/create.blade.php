@extends('Co-Admin.layouts.app')

@section('title', 'Nova Rede de Água')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Agua" class="w-6 h-6" />
                Nova Rede de Água
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cadastre uma nova rede de água no sistema</p>
        </div>
        <x-agua::button href="{{ route('agua.index') }}" variant="outline">
            <x-agua::icon name="arrow-left" class="w-4 h-4 mr-2" />
            Voltar
        </x-agua::button>
    </div>

    <!-- Alertas -->
    @if(session('warning'))
        <x-agua::alert type="warning" dismissible>
            {!! session('warning') !!}
        </x-agua::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-agua::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-agua::icon name="information-circle" class="w-5 h-5" />
                        Informações da Rede
                    </h3>
                </x-slot>

                <form action="{{ route('agua.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Informações Básicas -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-agua::icon name="information-circle" class="w-4 h-4" />
                            Informações Básicas
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-agua::form.select
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
                            </x-agua::form.select>
                        </div>
                        @if(empty($localidades))
                            <x-agua::alert type="warning" class="mt-4">
                                <x-agua::icon name="exclamation-triangle" class="w-4 h-4 mr-2" />
                                <strong>Atenção!</strong> Nenhuma localidade cadastrada.
                                <a href="{{ route('localidades.create') }}" class="underline font-medium">Cadastre uma localidade primeiro</a>.
                            </x-agua::alert>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <x-agua::form.select
                                name="tipo_rede"
                                label="Tipo de Rede"
                                :value="old('tipo_rede')"
                                required
                            >
                                <option value="principal" {{ old('tipo_rede') == 'principal' ? 'selected' : '' }}>Principal</option>
                                <option value="secundaria" {{ old('tipo_rede') == 'secundaria' ? 'selected' : '' }}>Secundária</option>
                                <option value="ramal" {{ old('tipo_rede') == 'ramal' ? 'selected' : '' }}>Ramal</option>
                            </x-agua::form.select>
                            <x-agua::form.select
                                name="status"
                                label="Status"
                                :value="old('status', 'funcionando')"
                                required
                            >
                                <option value="funcionando">Funcionando</option>
                                <option value="com_vazamento">Com Vazamento</option>
                                <option value="interrompida">Interrompida</option>
                            </x-agua::form.select>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-agua::icon name="cog-6-tooth" class="w-4 h-4" />
                            Especificações Técnicas
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-agua::form.input
                                name="diametro"
                                label="Diâmetro"
                                :value="old('diametro')"
                                placeholder="Ex: 100mm, 4 polegadas"
                            />
                            <x-agua::form.input
                                name="material"
                                label="Material"
                                :value="old('material')"
                                placeholder="Ex: PVC, Ferro, Polietileno"
                            />
                            <x-agua::form.input
                                name="extensao_metros"
                                label="Extensão (m)"
                                type="number"
                                step="0.01"
                                :value="old('extensao_metros')"
                            />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-agua::icon name="calendar" class="w-4 h-4" />
                            Data de Instalação
                        </h4>
                        <x-agua::form.input
                            name="data_instalacao"
                            label="Data de Instalação"
                            type="date"
                            :value="old('data_instalacao')"
                        />
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <x-agua::icon name="document-text" class="w-4 h-4" />
                            Observações
                        </h4>
                        <x-agua::form.textarea
                            name="observacoes"
                            label="Observações"
                            :value="old('observacoes')"
                            rows="3"
                            placeholder="Informações adicionais sobre a rede..."
                        />
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <x-agua::button href="{{ route('agua.index') }}" variant="outline">
                            Cancelar
                        </x-agua::button>
                        <x-agua::button type="submit" variant="primary">
                            <x-agua::icon name="check" class="w-4 h-4 mr-2" />
                            Salvar Rede
                        </x-agua::button>
                    </div>
                </form>
            </x-agua::card>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <x-agua::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-agua::icon name="light-bulb" class="w-5 h-5" />
                        Dicas
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <x-agua::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Localidade:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">É obrigatória para criar uma rede de água.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-agua::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Código:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Será gerado automaticamente no formato RED-TIPO-ANO-MES-0001.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-agua::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Status:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Mantenha atualizado para controle adequado.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-agua::icon name="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <strong class="text-sm text-gray-900 dark:text-white">Extensão:</strong>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Informe em metros para cálculos precisos.</p>
                        </div>
                    </div>
                </div>
            </x-agua::card>
        </div>
    </div>
</div>
@endsection
