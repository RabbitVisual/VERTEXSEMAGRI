@extends('Co-Admin.layouts.app')

@section('title', 'Nova Demanda')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-800 dark:to-indigo-900 rounded-2xl shadow-xl p-6 md:p-8 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-module-icon module="Demandas" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Cadastrar Nova Demanda</h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Preencha as informações abaixo para criar uma nova demanda
                    </p>
                </div>
            </div>
            <x-demandas::button href="{{ route('demandas.index') }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                <x-demandas::icon name="arrow-left" class="w-5 h-5 mr-2" />
                Voltar
            </x-demandas::button>
        </div>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <x-demandas::alert type="danger" dismissible>
            <div class="flex items-start gap-2">
                <x-demandas::icon name="exclamation-triangle" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <div>
                    <p class="font-medium mb-2">Por favor, corrija os seguintes erros:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-demandas::alert>
    @endif

    {{-- Modal de Demandas Similares --}}
    @if(session('warning_similaridade'))
        @include('demandas::components.modal-demandas-similares', [
            'demanda' => session('demanda_similar'),
            'score' => session('score_similaridade', 0),
            'confianca' => session('confianca_similaridade', 'baixa'),
        ])
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2 space-y-6">
            <x-demandas::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <x-demandas::icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informações da Demanda
                        </h3>
                    </div>
                </x-slot>

                <form action="{{ route('demandas.store') }}" method="POST" id="demandaForm" class="space-y-6">
                    @csrf
                    <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ old('pessoa_id') }}">

                    <!-- Busca de Pessoa -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-demandas::icon name="user" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Buscar Solicitante no CadÚnico
                            </h4>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Buscar por nome, NIS ou CPF
                                <span class="text-gray-500 dark:text-gray-400 text-xs font-normal">(Opcional)</span>
                            </label>
                            <div class="flex gap-2">
                                <div class="flex-1 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-demandas::icon name="search" class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <input type="text"
                                           id="buscar_pessoa"
                                           placeholder="Digite o nome, NIS ou CPF para buscar..."
                                           autocomplete="off"
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 sm:text-sm">
                                </div>
                                <button type="button" id="limpar_busca" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                    <x-demandas::icon name="x-mark" class="w-5 h-5" />
                                </button>
                            </div>
                            <div id="resultados_busca" class="mt-2 hidden"></div>
                            <div id="pessoa_selecionada" class="mt-3 hidden">
                                <div class="rounded-lg border border-emerald-200 bg-emerald-50 dark:bg-emerald-900/20 dark:border-emerald-800 p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <x-demandas::icon name="check-circle" class="h-5 w-5 text-emerald-400" />
                                                <strong id="pessoa_nome_selecionada" class="text-emerald-800 dark:text-emerald-200"></strong>
                                            </div>
                                            <small id="pessoa_info_selecionada" class="text-emerald-700 dark:text-emerald-300 text-sm"></small>
                                        </div>
                                        <button type="button" id="remover_pessoa" class="ml-4 p-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <x-demandas::icon name="x-mark" class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                                <div id="pessoa_alertas"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Solicitante -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                <x-demandas::icon name="user-circle" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações do Solicitante
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-demandas::form.input
                                    label="Nome do Solicitante"
                                    name="solicitante_nome"
                                    type="text"
                                    required
                                    value="{{ old('solicitante_nome') }}"
                                    readonly
                                    class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed"
                                    placeholder="Selecione uma pessoa acima para preencher automaticamente"
                                />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <x-demandas::icon name="information-circle" class="w-4 h-4 inline mr-1" />
                                    Este campo é preenchido automaticamente ao selecionar uma pessoa. Se a pessoa não estiver cadastrada, <a href="{{ route('pessoas.create') }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">cadastre-a primeiro</a>.
                                </p>
                                @error('solicitante_nome')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-demandas::form.input
                                    label="Apelido/Nome Social"
                                    name="solicitante_apelido"
                                    type="text"
                                    value="{{ old('solicitante_apelido') }}"
                                    maxlength="100"
                                    placeholder="Ex: Zé, Maria, João da Silva"
                                />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <x-demandas::icon name="information-circle" class="w-4 h-4 inline mr-1" />
                                    Informe o apelido ou nome social do solicitante. Este campo facilita a identificação e localização da pessoa na comunidade.
                                </p>
                                @error('solicitante_apelido')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="solicitante_telefone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Telefone/WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="text"
                                           id="solicitante_telefone"
                                           name="solicitante_telefone"
                                           value="{{ old('solicitante_telefone') }}"
                                           required
                                           placeholder="(00) 00000-0000"
                                           class="flex-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('solicitante_telefone') border-red-500 @enderror">
                                    <button type="button" id="abrir_whatsapp" class="hidden px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600" title="Abrir WhatsApp">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <x-demandas::icon name="information-circle" class="w-4 h-4 inline mr-1" />
                                    Informe o telefone ou WhatsApp para contato. O formato será aplicado automaticamente.
                                </p>
                                @error('solicitante_telefone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-demandas::form.input
                                    label="Email"
                                    name="solicitante_email"
                                    type="email"
                                    value="{{ old('solicitante_email') }}"
                                    placeholder="email@exemplo.com"
                                    required
                                    help="Obrigatório. Você receberá um email de confirmação com o código/protocolo da demanda."
                                />
                                <div id="email_info_box" class="mt-2 hidden p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex items-start gap-2">
                                        <x-demandas::icon name="envelope" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" />
                                        <div class="flex-1">
                                            <p class="text-sm text-emerald-800 dark:text-emerald-200">
                                                <strong>📧 Email de Confirmação:</strong> Um email será enviado automaticamente para este endereço com o código/protocolo da demanda e instruções para acompanhamento.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @error('solicitante_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informações da Demanda -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <x-demandas::icon name="document-text" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações da Demanda
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="localidade_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Localidade <span class="text-red-500">*</span>
                                </label>
                                <select id="localidade_id"
                                        name="localidade_id"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('localidade_id') border-red-500 @enderror">
                                    <option value="">Selecione uma localidade</option>
                                    @foreach($localidades as $localidade)
                                        <option value="{{ $localidade->id }}" {{ old('localidade_id') == $localidade->id ? 'selected' : '' }}>
                                            {{ $localidade->nome }}@if(isset($localidade->codigo)) ({{ $localidade->codigo }})@endif
                                        </option>
                                    @endforeach
                                </select>
                                @if(empty($localidades))
                                    <x-demandas::alert type="warning" class="mt-2">
                                        <strong>Atenção!</strong> Nenhuma localidade cadastrada.
                                        <a href="{{ route('localidades.create') }}" class="underline font-medium">Cadastre uma localidade primeiro</a>.
                                    </x-demandas::alert>
                                @endif
                                @error('localidade_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tipo <span class="text-red-500">*</span>
                                </label>
                                <select id="tipo"
                                        name="tipo"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('tipo') border-red-500 @enderror">
                                    <option value="">Selecione o tipo</option>
                                    <option value="agua" {{ old('tipo') == 'agua' ? 'selected' : '' }}>Água</option>
                                    <option value="luz" {{ old('tipo') == 'luz' ? 'selected' : '' }}>Luz</option>
                                    <option value="estrada" {{ old('tipo') == 'estrada' ? 'selected' : '' }}>Estrada</option>
                                    <option value="poco" {{ old('tipo') == 'poco' ? 'selected' : '' }}>Poço</option>
                                </select>
                                @error('tipo')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="prioridade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Prioridade <span class="text-red-500">*</span>
                                </label>
                                <select id="prioridade"
                                        name="prioridade"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('prioridade') border-red-500 @enderror">
                                    <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                    <option value="media" {{ old('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                                    <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('prioridade') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('prioridade')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-demandas::form.input
                                    label="Motivo"
                                    name="motivo"
                                    type="text"
                                    required
                                    value="{{ old('motivo') }}"
                                    placeholder="Motivo da demanda"
                                />
                                @error('motivo')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                <x-demandas::icon name="document-text" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Descrição Detalhada
                            </h4>
                        </div>

                        <div>
                            <x-demandas::form.textarea
                                label="Descrição"
                                name="descricao"
                                rows="6"
                                required
                                minlength="20"
                                value="{{ old('descricao') }}"
                                placeholder="Descreva detalhadamente a demanda, incluindo localização precisa, características do problema, e qualquer informação relevante para facilitar a identificação e resolução..."
                            />

                            <!-- Dicas de Preenchimento -->
                            <div class="mt-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="flex items-start gap-3">
                                    <x-demandas::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-2">Como preencher a descrição de forma precisa:</h4>
                                        <ul class="text-xs text-blue-800 dark:text-blue-300 space-y-1 list-disc list-inside">
                                            <li><strong>Localização:</strong> Informe o endereço completo, pontos de referência, número da casa (se houver), rua, bairro, ou coordenadas aproximadas.</li>
                                            <li><strong>Características do problema:</strong> Descreva detalhadamente o que está acontecendo, quando começou, frequência, intensidade, e qualquer sintoma visível.</li>
                                            <li><strong>Contexto:</strong> Mencione se há outros problemas relacionados, condições climáticas que podem ter influenciado, ou situações especiais.</li>
                                            <li><strong>Impacto:</strong> Explique como o problema afeta a comunidade ou o solicitante, e a urgência da situação.</li>
                                            <li><strong>Informações adicionais:</strong> Inclua horários de funcionamento, restrições de acesso, ou qualquer informação que possa ajudar na resolução.</li>
                                        </ul>
                                        <p class="mt-2 text-xs text-blue-700 dark:text-blue-400 font-medium">
                                            <strong>Mínimo de 20 caracteres.</strong> Quanto mais detalhada a descrição, mais fácil será localizar e resolver o problema.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @error('descricao')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <x-demandas::icon name="document-text" class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações Adicionais
                            </h4>
                        </div>

                        <div>
                            <x-demandas::form.textarea
                                label="Observações"
                                name="observacoes"
                                rows="4"
                                value="{{ old('observacoes') }}"
                                placeholder="Informe observações adicionais, notas internas, ou qualquer informação relevante que não se encaixe nos campos anteriores..."
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <x-demandas::icon name="information-circle" class="w-4 h-4 inline mr-1" />
                                Este campo é opcional e pode ser usado para anotações internas, informações complementares ou observações relevantes sobre a demanda.
                            </p>
                            @error('observacoes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 -mx-6 -mb-6 px-6 py-4 rounded-b-xl">
                        <x-demandas::button href="{{ route('demandas.index') }}" variant="outline" class="border-2">
                            <x-demandas::icon name="x-mark" class="w-4 h-4 mr-2" />
                            Cancelar
                        </x-demandas::button>
                        <x-demandas::button type="submit" id="submitBtn" variant="primary" class="shadow-lg hover:shadow-xl transition-shadow">
                            <x-demandas::icon name="check-circle" class="w-4 h-4 mr-2" />
                            <span id="submitText">Salvar Demanda</span>
                            <span id="submitLoading" class="hidden">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Salvando...
                            </span>
                        </x-demandas::button>
                    </div>
                </form>
            </x-demandas::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1 space-y-6">
            <x-demandas::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                            <x-demandas::icon name="light-bulb" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Dicas e Informações
                        </h3>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <x-demandas::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Código</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Será gerado automaticamente no formato DEM-TIPO-ANO-MES-XXXX.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-start gap-3">
                            <x-demandas::icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-emerald-900 dark:text-emerald-200 mb-1">Buscar Pessoa</h4>
                                <p class="text-xs text-emerald-800 dark:text-emerald-300">
                                    Use a busca para encontrar pessoas cadastradas no CadÚnico e vincular automaticamente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                        <div class="flex items-start gap-3">
                            <x-demandas::icon name="exclamation-triangle" class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-1">Localidade</h4>
                                <p class="text-xs text-amber-800 dark:text-amber-300">
                                    Se uma pessoa for selecionada, a localidade será preenchida automaticamente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-start gap-3">
                            <x-demandas::icon name="envelope" class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-200 mb-1">Notificação por Email</h4>
                                <p class="text-xs text-indigo-800 dark:text-indigo-300">
                                    Se um email for informado, o solicitante receberá automaticamente um email com o código/protocolo da demanda e link para acompanhamento.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-demandas::card>

            <!-- Card Cadastrar Nova Pessoa -->
            <x-demandas::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <x-demandas::icon name="user-plus" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Cadastrar Nova Pessoa
                        </h3>
                    </div>
                </x-slot>

                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Se a pessoa não estiver cadastrada no sistema, você pode cadastrá-la primeiro e depois criar a demanda.
                    </p>
                    <x-demandas::button href="{{ route('pessoas.create') }}" target="_blank" variant="primary" class="w-full">
                        <x-demandas::icon name="user-plus" class="w-4 h-4 mr-2" />
                        Cadastrar Nova Pessoa
                    </x-demandas::button>
                </div>
            </x-demandas::card>
        </div>
    </div>
</div>

<!-- Modal para Localidade Obrigatória -->
<div id="localidadeRequiredModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-amber-50 dark:bg-amber-900/20 px-6 py-4 border-b border-amber-200 dark:border-amber-800">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-100 flex items-center gap-2">
                        <x-demandas::icon name="exclamation-triangle" class="w-5 h-5" />
                        Localidade Obrigatória
                    </h3>
                    <button type="button" onclick="closeModal()" class="text-amber-400 hover:text-amber-500">
                        <x-demandas::icon name="x-mark" class="w-6 h-6" />
                    </button>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 px-6 py-4">
                <p class="text-gray-900 dark:text-white mb-2">Para criar uma demanda, é necessário selecionar uma localidade.</p>
                <p class="text-gray-600 dark:text-gray-400">Se não houver localidades cadastradas, cadastre uma primeiro.</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 flex justify-end gap-3">
                <x-demandas::button onclick="closeModal()" variant="outline">
                    Cancelar
                </x-demandas::button>
                <x-demandas::button href="{{ route('localidades.create') }}" variant="primary">
                    <x-demandas::icon name="plus-circle" class="w-4 h-4 mr-2" />
                    Cadastrar Localidade
                </x-demandas::button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara de telefone
    const telefoneInput = document.getElementById('solicitante_telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
                } else {
                    value = value.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
                }
                e.target.value = value;
            }
        });
    }

    let buscaTimeout;
    const buscarPessoaInput = document.getElementById('buscar_pessoa');
    const resultadosBusca = document.getElementById('resultados_busca');
    const pessoaSelecionada = document.getElementById('pessoa_selecionada');
    const pessoaIdInput = document.getElementById('pessoa_id');
    const solicitanteNomeInput = document.getElementById('solicitante_nome');
    const solicitanteApelidoInput = document.getElementById('solicitante_apelido');
    const localidadeSelect = document.getElementById('localidade_id');
    const solicitanteTelefoneInput = document.getElementById('solicitante_telefone');
    const abrirWhatsappBtn = document.getElementById('abrir_whatsapp');

    // Buscar pessoas
    buscarPessoaInput.addEventListener('input', function() {
        const query = this.value.trim();
        clearTimeout(buscaTimeout);

        if (query.length < 2) {
            resultadosBusca.classList.add('hidden');
            return;
        }

        buscaTimeout = setTimeout(() => {
            fetch(`{{ route('demandas.buscar-pessoa') }}?q=${encodeURIComponent(query)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.length === 0) {
                        resultadosBusca.innerHTML = `
                            <div class="rounded-lg border border-blue-200 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800 p-3">
                                <div class="flex items-center gap-2 text-blue-800 dark:text-blue-200">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    Nenhuma pessoa encontrada.
                                    <a href="{{ route('pessoas.create') }}" target="_blank" class="underline font-medium">Cadastrar nova pessoa</a>
                                </div>
                            </div>
                        `;
                        resultadosBusca.classList.remove('hidden');
                        return;
                    }

                    let html = '<div class="space-y-2">';
                    data.forEach(pessoa => {
                        let info = [];
                        if (pessoa.nis_formatado) info.push(`NIS: ${pessoa.nis_formatado}`);
                        if (pessoa.cpf_formatado) info.push(`CPF: ${pessoa.cpf_formatado}`);
                        if (pessoa.localidade_nome) info.push(`Localidade: ${pessoa.localidade_nome}`);
                        if (pessoa.idade) info.push(`Idade: ${pessoa.idade} anos`);

                        html += `
                            <a href="#" class="block p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 pessoa-item transition-colors"
                               data-pessoa-id="${pessoa.id}"
                               data-pessoa-nome="${pessoa.nome}"
                               data-pessoa-apelido="${pessoa.apelido || ''}"
                               data-pessoa-localidade-id="${pessoa.localidade_id || ''}"
                               data-pessoa-localidade-nome="${pessoa.localidade_nome || ''}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900 dark:text-white">${pessoa.nome}${pessoa.apelido ? ` <span class="text-indigo-600 dark:text-indigo-400">(${pessoa.apelido})</span>` : ''}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">${info.join(' • ')}</div>
                                    </div>
                                    ${pessoa.recebe_pbf ? '<span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">PBF</span>' : ''}
                                </div>
                            </a>
                        `;
                    });
                    html += '</div>';
                    resultadosBusca.innerHTML = html;
                    resultadosBusca.classList.remove('hidden');

                    document.querySelectorAll('.pessoa-item').forEach(item => {
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            selecionarPessoa(this);
                        });
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar pessoa:', error);
                    resultadosBusca.innerHTML = '<div class="rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-800 p-3 text-red-800 dark:text-red-200">Erro ao buscar pessoa. Tente novamente.</div>';
                    resultadosBusca.classList.remove('hidden');
                });
        }, 300);
    });

    function selecionarPessoa(element) {
        const pessoaId = element.getAttribute('data-pessoa-id');
        const urlBase = '{{ url("/demandas/pessoa") }}';
        fetch(`${urlBase}/${pessoaId}`)
            .then(response => response.json())
            .then(pessoa => {
                pessoaIdInput.value = pessoa.id;
                solicitanteNomeInput.value = pessoa.nome;

                // Preencher apelido se disponível
                if (pessoa.apelido) {
                    solicitanteApelidoInput.value = pessoa.apelido;
                }

                if (pessoa.telefone) {
                    solicitanteTelefoneInput.value = pessoa.telefone;
                    const telefone = pessoa.telefone.replace(/\D/g, '');
                    if (telefone.length >= 10) {
                        abrirWhatsappBtn.classList.remove('hidden');
                        abrirWhatsappBtn.onclick = function() {
                            window.open(`https://wa.me/55${telefone}`, '_blank');
                        };
                    }
                }

                if (pessoa.email) {
                    document.getElementById('solicitante_email').value = pessoa.email;
                    mostrarAvisoEmail();
                }

                if (pessoa.localidade_id) {
                    localidadeSelect.value = pessoa.localidade_id;
                }

                // Exibir nome com apelido se disponível
                const nomeCompleto = pessoa.apelido ? `${pessoa.nome} (${pessoa.apelido})` : pessoa.nome;
                document.getElementById('pessoa_nome_selecionada').textContent = nomeCompleto;
                let info = [];
                if (pessoa.nis_formatado) info.push(`NIS: ${pessoa.nis_formatado}`);
                if (pessoa.cpf_formatado) info.push(`CPF: ${pessoa.cpf_formatado}`);
                if (pessoa.localidade_nome) {
                    info.push(`Localidade: ${pessoa.localidade_nome}`);
                } else {
                    info.push(`Localidade: Será vinculada ao criar a demanda`);
                }
                if (pessoa.idade) info.push(`Idade: ${pessoa.idade} anos`);
                if (pessoa.recebe_pbf) info.push(`Beneficiária PBF`);
                document.getElementById('pessoa_info_selecionada').innerHTML = info.join(' • ');

                pessoaSelecionada.classList.remove('hidden');
                resultadosBusca.classList.add('hidden');
                buscarPessoaInput.value = '';

                const alertasDiv = document.getElementById('pessoa_alertas');
                alertasDiv.innerHTML = '';
                if (!pessoa.localidade_id) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'mt-2 rounded-lg border border-blue-200 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800 p-3';
                    alertDiv.innerHTML = '<div class="flex items-center gap-2 text-blue-800 dark:text-blue-200"><svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg><strong>Importante:</strong> Esta pessoa não possui localidade vinculada. A localidade selecionada será automaticamente vinculada à pessoa ao criar a demanda.</div>';
                    alertasDiv.appendChild(alertDiv);
                }
            })
            .catch(error => {
                console.error('Erro ao obter dados da pessoa:', error);
                const pessoaNome = element.getAttribute('data-pessoa-nome');
                const pessoaApelido = element.getAttribute('data-pessoa-apelido') || '';
                const localidadeId = element.getAttribute('data-pessoa-localidade-id');

                pessoaIdInput.value = pessoaId;
                solicitanteNomeInput.value = pessoaNome;
                if (pessoaApelido) {
                    solicitanteApelidoInput.value = pessoaApelido;
                }

                if (localidadeId) {
                    localidadeSelect.value = localidadeId;
                }

                const nomeCompleto = pessoaApelido ? `${pessoaNome} (${pessoaApelido})` : pessoaNome;
                document.getElementById('pessoa_nome_selecionada').textContent = nomeCompleto;
                pessoaSelecionada.classList.remove('hidden');
                resultadosBusca.classList.add('hidden');
                buscarPessoaInput.value = '';
            });
    }

    document.getElementById('remover_pessoa').addEventListener('click', function() {
        pessoaIdInput.value = '';
        pessoaSelecionada.classList.add('hidden');
        solicitanteNomeInput.value = '';
        solicitanteApelidoInput.value = '';
        solicitanteTelefoneInput.value = '';
        document.getElementById('solicitante_email').value = '';
        localidadeSelect.value = '';
        abrirWhatsappBtn.classList.add('hidden');
        document.getElementById('pessoa_alertas').innerHTML = '';
    });

    document.getElementById('limpar_busca').addEventListener('click', function() {
        buscarPessoaInput.value = '';
        resultadosBusca.classList.add('hidden');
    });

    solicitanteTelefoneInput.addEventListener('input', function() {
        const telefone = this.value.replace(/\D/g, '');
        if (telefone.length >= 10) {
            abrirWhatsappBtn.classList.remove('hidden');
            abrirWhatsappBtn.onclick = function() {
                window.open(`https://wa.me/55${telefone}`, '_blank');
            };
        } else {
            abrirWhatsappBtn.classList.add('hidden');
        }
    });

    // Mostrar/ocultar aviso de email
    const emailInput = document.getElementById('solicitante_email');
    const emailInfoBox = document.getElementById('email_info_box');

    function mostrarAvisoEmail() {
        if (emailInput && emailInput.value.trim() !== '') {
            emailInfoBox.classList.remove('hidden');
        } else {
            emailInfoBox.classList.add('hidden');
        }
    }

    if (emailInput) {
        emailInput.addEventListener('input', mostrarAvisoEmail);
        emailInput.addEventListener('blur', mostrarAvisoEmail);
        // Verificar se já tem valor ao carregar
        if (emailInput.value.trim() !== '') {
            mostrarAvisoEmail();
        }
    }

    const form = document.getElementById('demandaForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitLoading = document.getElementById('submitLoading');
    let isSubmitting = false;

    if (form && localidadeSelect) {
        form.addEventListener('submit', function(e) {
            if (!localidadeSelect.value) {
                e.preventDefault();
                document.getElementById('localidadeRequiredModal').classList.remove('hidden');
                return;
            }

            // Proteção contra duplo clique
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            isSubmitting = true;
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
        });
    }
});

function closeModal() {
    document.getElementById('localidadeRequiredModal').classList.add('hidden');
}
</script>
@endpush
@endsection
