@extends('Co-Admin.layouts.app')

@section('title', 'Nova Ordem de Serviço')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Ordens" class="w-6 h-6" />
                Nova Ordem de Serviço
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Criar uma nova ordem de serviço</p>
        </div>
        <x-ordens::button href="{{ route('ordens.index') }}" variant="outline">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </x-ordens::button>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <x-ordens::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ordens::alert>
    @endif

    @if(session('warning'))
        <x-ordens::alert type="warning" dismissible>
            <div class="space-y-2">
                <p class="font-semibold">{{ session('warning') }}</p>
                @if(session('materiais_indisponiveis'))
                    <div class="mt-3 space-y-2">
                        <p class="text-sm font-medium">Materiais com estoque insuficiente:</p>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach(session('materiais_indisponiveis') as $material)
                                <li>
                                    <strong>{{ $material['nome'] }}</strong> -
                                    Solicitado: {{ formatar_quantidade($material['quantidade_solicitada'], $material['unidade'] ?? null) }} {{ $material['unidade'] }},
                                    Disponível: {{ formatar_quantidade($material['quantidade_disponivel'], $material['unidade'] ?? null) }} {{ $material['unidade'] }}
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-3 pt-3 border-t border-amber-200 dark:border-amber-800">
                            <a href="{{ route('admin.materiais.solicitar.create') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-amber-800 dark:text-amber-200 bg-amber-100 dark:bg-amber-900/30 border border-amber-300 dark:border-amber-700 rounded-lg hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Solicitar Materiais
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </x-ordens::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-ordens::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Informações da OS
                    </h3>
                </x-slot>

                <form action="{{ route('ordens.store') }}" method="POST" id="osForm" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-ordens::form.select
                                label="Demanda (Opcional)"
                                name="demanda_id"
                                help="Vincule esta OS a uma demanda existente para rastreabilidade"
                            >
                                <option value="">Nenhuma</option>
                                @foreach($demandas as $demanda)
                                    <option value="{{ $demanda->id }}"
                                            {{ (old('demanda_id') == $demanda->id || ($demandaSelecionada && $demandaSelecionada->id == $demanda->id)) ? 'selected' : '' }}
                                            data-tipo="{{ $demanda->tipo }}">
                                        {{ $demanda->codigo ?? '#' . $demanda->id }} - {{ $demanda->solicitante_nome }} ({{ ucfirst($demanda->tipo) }})
                                    </option>
                                @endforeach
                            </x-ordens::form.select>
                            @if($demandaSelecionada ?? null)
                                <x-ordens::alert type="info" class="mt-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    <strong>Demanda pré-selecionada:</strong> {{ $demandaSelecionada->codigo ?? '#' . $demandaSelecionada->id }}
                                </x-ordens::alert>
                            @endif
                        </div>
                        <div>
                            <x-ordens::form.select
                                label="Equipe"
                                name="equipe_id"
                                required
                                help="Selecione a equipe responsável pela execução"
                            >
                                <option value="">Selecione uma equipe</option>
                                @foreach($equipes as $equipe)
                                    <option value="{{ $equipe->id }}" {{ old('equipe_id') == $equipe->id ? 'selected' : '' }}>
                                        {{ $equipe->nome }}@if(isset($equipe->codigo)) ({{ $equipe->codigo }})@endif
                                    </option>
                                @endforeach
                            </x-ordens::form.select>
                            @if($equipes->isEmpty())
                                <x-ordens::alert type="warning" class="mt-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    Nenhuma equipe ativa cadastrada.
                                    <a href="{{ route('equipes.create') }}" class="font-medium underline">Cadastrar equipe</a>
                                </x-ordens::alert>
                            @endif
                        </div>
                    </div>

                    <x-ordens::form.input
                        label="Tipo de Serviço"
                        name="tipo_servico"
                        type="text"
                        required
                        value="{{ old('tipo_servico', ($demandaSelecionada ?? null) ? ucfirst($demandaSelecionada->tipo) : '') }}"
                        placeholder="Ex: Reparo de rede de água, Troca de lâmpada, etc."
                        help="Descreva o tipo de serviço a ser executado"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ordens::form.select
                            label="Prioridade"
                            name="prioridade"
                            required
                        >
                            <option value="baixa" {{ old('prioridade', ($demandaSelecionada ?? null) ? $demandaSelecionada->prioridade : 'media') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="media" {{ old('prioridade', ($demandaSelecionada ?? null) ? $demandaSelecionada->prioridade : 'media') == 'media' ? 'selected' : '' }}>Média</option>
                            <option value="alta" {{ old('prioridade', ($demandaSelecionada ?? null) ? $demandaSelecionada->prioridade : 'media') == 'alta' ? 'selected' : '' }}>Alta</option>
                            <option value="urgente" {{ old('prioridade', ($demandaSelecionada ?? null) ? $demandaSelecionada->prioridade : 'media') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                        </x-ordens::form.select>
                    </div>

                    <div class="relative">
                        <x-ordens::form.textarea
                            label="Descrição"
                            name="descricao"
                            id="descricao"
                            rows="5"
                            required
                            maxlength="500"
                            value="{{ old('descricao', ($demandaSelecionada ?? null) ? $demandaSelecionada->descricao : '') }}"
                            placeholder="Descreva detalhadamente o serviço a ser executado..."
                            help="O número da OS será gerado automaticamente após o cadastro"
                        />
                        <div class="absolute top-0 right-0 pt-1 pr-1">
                            <span id="char-count-descricao" class="text-[9px] font-medium text-gray-400 bg-gray-50 dark:bg-gray-800 px-1 rounded">0/500</span>
                        </div>
                    </div>
                </form>
            </x-ordens::card>

            <!-- Seção de Materiais Previstos -->
            @if(isset($materiais) && $materiais->count() > 0)
            <x-ordens::card class="mt-6">
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        Materiais Previstos
                        <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Selecione os materiais que serão necessários para este serviço.
                        Os materiais serão reservados do estoque quando a OS for criada.
                    </p>

                    <!-- Lista de materiais selecionados -->
                    <div id="materiais-selecionados" class="space-y-2">
                        <!-- Materiais serão adicionados aqui via JS -->
                    </div>

                    <!-- Adicionar material -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                            <div class="md:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Material</label>
                                <select id="material-select" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    <option value="">Selecione um material</option>
                                    @foreach($materiais as $material)
                                        <option value="{{ $material->id }}"
                                                data-nome="{{ $material->nome }}"
                                                data-codigo="{{ $material->codigo }}"
                                                data-estoque="{{ $material->quantidade_estoque }}"
                                                data-minimo="{{ $material->quantidade_minima }}">
                                            {{ $material->nome }}
                                            @if($material->codigo)({{ $material->codigo }})@endif
                                            - Estoque: {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }}
                                            @if($material->quantidade_estoque <= $material->quantidade_minima)
                                                ⚠️ Baixo
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quantidade</label>
                                <input type="number"
                                       id="material-quantidade"
                                       min="1"
                                       step="1"
                                       value="1"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            </div>
                            <div class="md:col-span-3 flex items-end">
                                <button type="button"
                                        onclick="adicionarMaterialPrevisto()"
                                        class="w-full px-4 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Resumo -->
                    <div id="materiais-resumo" class="hidden p-4 bg-orange-50 dark:bg-orange-900/20 rounded-xl border border-orange-200 dark:border-orange-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-orange-800 dark:text-orange-200">
                                    <span id="materiais-count">0</span> material(is) selecionado(s)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-ordens::card>
            @endif

            <!-- Continuar formulário para submit -->
            <div class="mt-6">
                <form id="osFormSubmit" action="{{ route('ordens.store') }}" method="POST">
                    @csrf
                    <!-- Campos ocultos que serão preenchidos do formulário principal -->
                    <input type="hidden" name="demanda_id" id="hidden-demanda">
                    <input type="hidden" name="equipe_id" id="hidden-equipe">
                    <input type="hidden" name="tipo_servico" id="hidden-tipo">
                    <input type="hidden" name="prioridade" id="hidden-prioridade">
                    <input type="hidden" name="descricao" id="hidden-descricao">
                    <div id="hidden-materiais"></div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ordens::button href="{{ route('ordens.index') }}" variant="outline">
                            Cancelar
                        </x-ordens::button>
                        <button type="button" onclick="submeterOS()" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Criar OS
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <x-ordens::card>
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Demanda</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Vincule a uma demanda existente para rastreabilidade.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-emerald-900 dark:text-emerald-200 mb-1">Equipe</h4>
                                <p class="text-xs text-emerald-800 dark:text-emerald-300">
                                    Selecione a equipe responsável pela execução.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-200 mb-1">Número</h4>
                                <p class="text-xs text-indigo-800 dark:text-indigo-300">
                                    Será gerado automaticamente no formato OS-YYYYMMDD-XXXX.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-1">Status</h4>
                                <p class="text-xs text-amber-800 dark:text-amber-300">
                                    A OS será criada com status "Pendente".
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Notificação por Email</h4>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Quando a ordem for atribuída a um funcionário ou usuário, será enviado automaticamente um email com os detalhes da ordem e link para visualização.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-ordens::card>

            @if($demandaSelecionada ?? null)
            <x-ordens::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Demanda Vinculada
                    </h3>
                </x-slot>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                        <div class="text-base font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ $demandaSelecionada->codigo ?? '#' . $demandaSelecionada->id }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Solicitante</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $demandaSelecionada->solicitante_nome }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ ucfirst($demandaSelecionada->tipo) }}</div>
                    </div>
                    <x-ordens::button href="{{ route('demandas.show', $demandaSelecionada->id) }}" variant="outline" class="w-full">
                        Ver Demanda
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </x-ordens::button>
                </div>
            </x-ordens::card>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Armazenar materiais selecionados
let materiaisPrevistos = [];

document.addEventListener('DOMContentLoaded', function() {
    // Contador de caracteres para descrição
    const descField = document.getElementById('descricao');
    const descCount = document.getElementById('char-count-descricao');

    if (descField && descCount) {
        const updateCount = () => {
            const length = descField.value.length;
            descCount.textContent = `${length}/500`;
            if (length >= 450) descCount.classList.replace('text-gray-400', 'text-amber-500');
            else descCount.classList.replace('text-amber-500', 'text-gray-400');
            if (length >= 500) descCount.classList.replace('text-amber-500', 'text-red-500');
            else descCount.classList.remove('text-red-500');
        };
        descField.addEventListener('input', updateCount);
        updateCount();
    }

    // Preencher tipo de serviço baseado na demanda selecionada
    const demandaSelect = document.getElementById('demanda_id');
    const tipoServicoInput = document.getElementById('tipo_servico');

    if (demandaSelect && tipoServicoInput) {
        demandaSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value && selectedOption.dataset.tipo) {
                const tipos = {
                    'agua': 'Reparo de Rede de Água',
                    'luz': 'Manutenção de Iluminação',
                    'estrada': 'Manutenção de Estrada',
                    'poco': 'Manutenção de Poço'
                };
                tipoServicoInput.value = tipos[selectedOption.dataset.tipo] || '';
            }
        });
    }
});

// Adicionar material previsto
function adicionarMaterialPrevisto() {
    const select = document.getElementById('material-select');
    const quantidade = document.getElementById('material-quantidade');

    if (!select.value || !quantidade.value || parseInt(quantidade.value) <= 0) {
        alert('Selecione um material e informe a quantidade.');
        return;
    }

    const option = select.options[select.selectedIndex];
    const materialId = parseInt(select.value);
    const materialNome = option.dataset.nome;
    const materialCodigo = option.dataset.codigo;
    const estoque = parseInt(option.dataset.estoque);
    const qtd = parseInt(quantidade.value);

    // Verificar se já foi adicionado
    const existente = materiaisPrevistos.find(m => m.id === materialId);
    if (existente) {
        alert('Este material já foi adicionado. Remova-o primeiro para alterar a quantidade.');
        return;
    }

    // Verificar estoque
    if (qtd > estoque) {
        alert(`Quantidade excede o estoque disponível (${estoque} unidades).`);
        return;
    }

    // Adicionar ao array
    materiaisPrevistos.push({
        id: materialId,
        nome: materialNome,
        codigo: materialCodigo,
        quantidade: qtd,
        estoque: estoque
    });

    // Atualizar UI
    atualizarListaMateriais();

    // Limpar seleção
    select.value = '';
    quantidade.value = '1';
}

// Remover material previsto
function removerMaterialPrevisto(materialId) {
    materiaisPrevistos = materiaisPrevistos.filter(m => m.id !== materialId);
    atualizarListaMateriais();
}

// Atualizar lista de materiais na UI
function atualizarListaMateriais() {
    const container = document.getElementById('materiais-selecionados');
    const resumo = document.getElementById('materiais-resumo');
    const count = document.getElementById('materiais-count');

    if (!container) return;

    container.innerHTML = '';

    if (materiaisPrevistos.length === 0) {
        resumo.classList.add('hidden');
        return;
    }

    resumo.classList.remove('hidden');
    count.textContent = materiaisPrevistos.length;

    materiaisPrevistos.forEach(material => {
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600';
        div.innerHTML = `
            <div class="flex-1">
                <p class="font-medium text-gray-900 dark:text-white">${material.nome}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    ${material.codigo ? `Código: ${material.codigo} • ` : ''}
                    Quantidade: ${material.quantidade} • Estoque: ${material.estoque}
                </p>
            </div>
            <button type="button"
                    onclick="removerMaterialPrevisto(${material.id})"
                    class="ml-3 p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        `;
        container.appendChild(div);
    });
}

// Submeter formulário com materiais
function submeterOS() {
    const demanda = document.getElementById('demanda_id');
    const equipe = document.getElementById('equipe_id');
    const tipo = document.getElementById('tipo_servico');
    const prioridade = document.getElementById('prioridade');
    const descricao = document.getElementById('descricao');

    // Validações
    if (!equipe || !equipe.value) {
        alert('Por favor, selecione uma equipe antes de criar a OS.');
        return;
    }

    if (!tipo || !tipo.value) {
        alert('Por favor, informe o tipo de serviço.');
        return;
    }

    if (!descricao || !descricao.value) {
        alert('Por favor, preencha a descrição do serviço.');
        return;
    }

    // Preencher campos ocultos
    document.getElementById('hidden-demanda').value = demanda?.value || '';
    document.getElementById('hidden-equipe').value = equipe.value;
    document.getElementById('hidden-tipo').value = tipo.value;
    document.getElementById('hidden-prioridade').value = prioridade?.value || 'media';
    document.getElementById('hidden-descricao').value = descricao.value;

    // Adicionar materiais ao formulário
    const materiaisContainer = document.getElementById('hidden-materiais');
    materiaisContainer.innerHTML = '';

    materiaisPrevistos.forEach((material, index) => {
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `materiais[${index}][material_id]`;
        inputId.value = material.id;

        const inputQtd = document.createElement('input');
        inputQtd.type = 'hidden';
        inputQtd.name = `materiais[${index}][quantidade]`;
        inputQtd.value = material.quantidade;

        materiaisContainer.appendChild(inputId);
        materiaisContainer.appendChild(inputQtd);
    });

    // Submeter formulário
    document.getElementById('osFormSubmit').submit();
}
</script>
@endpush
@endsection
