@extends('admin.layouts.admin')

@section('title', 'Solicitar Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 max-w-full overflow-x-hidden">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <span>Solicitar Materiais</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mt-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Solicitar</span>
            </nav>
        </div>
        <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>

    <!-- Flash Messages -->
    @if(isset($solicitacaoCampo) && $solicitacaoCampo)
        <div id="alert-info" class="flex items-center p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800" role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3 text-sm font-medium flex-1">
                <strong>Processando Solicitação do Campo:</strong> Você está processando uma solicitação feita por <strong>{{ $solicitacaoCampo->user->name }}</strong>. Os dados do material foram pré-preenchidos abaixo. Complete o formulário e gere a solicitação oficial.
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex h-8 w-8 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30" data-dismiss-target="#alert-info" aria-label="Close">
                <span class="sr-only">Fechar</span>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Formulário -->
    <form id="formSolicitacao" method="POST" action="{{ route('admin.materiais.solicitar.gerar-pdf') }}" class="space-y-6 max-w-full overflow-x-hidden">
        @csrf
        @if(isset($solicitacaoCampo) && $solicitacaoCampo)
            <input type="hidden" name="solicitacao_campo_id" value="{{ $solicitacaoCampo->id }}">
        @endif

        <!-- Informações do Ofício - Flowbite Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Ofício</h3>
            </div>
            <div class="p-6">
                <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-1">Informação Importante</p>
                            <p class="text-sm text-blue-700 dark:text-blue-400">
                                O número do ofício será gerado automaticamente pelo sistema após a geração do PDF, garantindo numeração única e sequencial.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="cidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cidade <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="cidade"
                               name="cidade"
                               value="{{ old('cidade', 'Coração de Maria - BA') }}"
                               required
                               readonly
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:placeholder-gray-400 dark:text-gray-400 cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Campo padrão do sistema</p>
                    </div>
                    <div>
                        <label for="data" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Data <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               id="data"
                               name="data"
                               value="{{ old('data', date('Y-m-d')) }}"
                               required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Secretário - Flowbite Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Secretário(a)</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="secretario_nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="secretario_nome"
                               name="secretario_nome"
                               value="{{ old('secretario_nome', '') }}"
                               required
                               placeholder="Nome completo do(a) Secretário(a)"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    </div>
                    <div>
                        <label for="secretario_cargo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cargo <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="secretario_cargo"
                               name="secretario_cargo"
                               value="{{ old('secretario_cargo', 'Secretário(a) Municipal de Agricultura') }}"
                               required
                               readonly
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-800 dark:border-slate-600 dark:placeholder-gray-400 dark:text-gray-400 cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Campo padrão do sistema</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Servidor - Flowbite Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Servidor Responsável</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="servidor_nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="servidor_nome"
                               name="servidor_nome"
                               value="{{ old('servidor_nome', auth()->user()->name) }}"
                               required
                               placeholder="Nome completo do servidor"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    </div>
                    <div>
                        <label for="servidor_cargo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cargo <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="servidor_cargo"
                               name="servidor_cargo"
                               value="{{ old('servidor_cargo', 'Servidor Responsável pelo Setor de Infraestrutura') }}"
                               required
                               placeholder="Ex: Servidor Responsável pelo Setor de Infraestrutura"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    </div>
                    <div>
                        <label for="servidor_telefone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Telefone
                        </label>
                        <input type="text"
                               id="servidor_telefone"
                               name="servidor_telefone"
                               value="{{ old('servidor_telefone', '') }}"
                               placeholder="Ex: (11) 99999-9999"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    </div>
                    <div>
                        <label for="servidor_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            E-mail
                        </label>
                        <input type="email"
                               id="servidor_email"
                               name="servidor_email"
                               value="{{ old('servidor_email', auth()->user()->email) }}"
                               placeholder="Ex: servidor@exemplo.com"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Seleção de Materiais - Flowbite Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Materiais Solicitados</h3>
            </div>
            <div class="p-6">
                <div class="mb-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                        Filtrar Materiais
                    </label>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                            <input type="checkbox"
                                   id="filtro_baixo_estoque"
                                   class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                            <span>Mostrar apenas com estoque baixo</span>
                        </label>
                        <button type="button"
                                id="btnAdicionarCustomizado"
                                class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Adicionar Material Não Cadastrado
                        </button>
                    </div>
                </div>
                <input type="text"
                       id="buscar_material"
                       placeholder="Buscar material por nome, código ou categoria..."
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
            </div>

            <!-- Materiais Customizados (Não Cadastrados) -->
            <div id="materiais_customizados" class="mb-4 space-y-3"></div>

            <div id="lista_materiais" class="space-y-3 max-h-96 overflow-y-auto overflow-x-hidden">
                @forelse($materiais as $material)
                    <div class="material-item p-4 border border-gray-200 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors"
                         data-nome="{{ strtolower($material->nome) }}"
                         data-codigo="{{ strtolower($material->codigo ?? '') }}"
                         data-categoria="{{ strtolower($material->categoria_formatada) }}"
                         data-estoque-baixo="{{ $material->estaComEstoqueBaixo() ? 'true' : 'false' }}">
                        <div class="flex items-start gap-3">
                            <input type="checkbox"
                                   name="materiais[{{ $loop->index }}][material_id]"
                                   value="{{ $material->id }}"
                                   class="material-checkbox mt-1 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                   data-material-id="{{ $material->id }}">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $material->nome }}</h4>
                                    @if($material->codigo)
                                        <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-slate-700 rounded text-gray-600 dark:text-gray-400">
                                            {{ $material->codigo }}
                                        </span>
                                    @endif
                                    @if($material->estaComEstoqueBaixo())
                                        <span class="text-xs px-2 py-1 bg-red-100 dark:bg-red-900/30 rounded text-red-600 dark:text-red-400">
                                            Estoque Baixo
                                        </span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <p><strong>Categoria:</strong> {{ $material->categoria_formatada }}</p>
                                    <p><strong>Estoque Atual:</strong> {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }} {{ $material->unidade_medida }}</p>
                                    @if($material->quantidade_minima > 0)
                                        <p><strong>Mínimo:</strong> {{ formatar_quantidade($material->quantidade_minima, $material->unidade_medida) }} {{ $material->unidade_medida }}</p>
                                    @endif
                                    @if($material->valor_unitario)
                                        <p><strong>Valor Unitário:</strong> R$ {{ number_format($material->valor_unitario, 2, ',', '.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="material-form mt-3 hidden grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                                    Quantidade Solicitada <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       name="materiais[{{ $loop->index }}][quantidade]"
                                       step="0.01"
                                       min="0.01"
                                       data-required="true"
                                       disabled
                                       placeholder="0.00"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                                    Justificativa <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="materiais[{{ $loop->index }}][justificativa]"
                                       data-required="true"
                                       disabled
                                       placeholder="Ex: Reposição de estoque"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8">
                        Nenhum material encontrado.
                    </p>
                @endforelse
                </div>
            </div>
        </div>

        <!-- Observações - Flowbite Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Observações Adicionais</h3>
            </div>
            <div class="p-6">
                <textarea name="observacoes"
                          id="observacoes"
                          rows="4"
                          placeholder="Observações adicionais sobre a solicitação..."
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">{{ old('observacoes') }}</textarea>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t-2 border-gray-200 dark:border-slate-700">
            <button type="button"
                    id="btnVisualizar"
                    class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Visualizar PDF
            </button>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Gerar e Baixar PDF
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.material-checkbox');
    const buscarInput = document.getElementById('buscar_material');
    const filtroBaixoEstoque = document.getElementById('filtro_baixo_estoque');
    const btnVisualizar = document.getElementById('btnVisualizar');
    const btnAdicionarCustomizado = document.getElementById('btnAdicionarCustomizado');
    const materiaisCustomizados = document.getElementById('materiais_customizados');
    const formSolicitacao = document.getElementById('formSolicitacao');
    let customizadoIndex = 0;

    // Mostrar/ocultar formulário ao selecionar material
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const form = this.closest('.material-item').querySelector('.material-form');
            const inputs = form.querySelectorAll('input:not([type="checkbox"])');

            if (this.checked) {
                form.classList.remove('hidden');
                // Habilitar e tornar required os campos
                inputs.forEach(input => {
                    input.removeAttribute('disabled');
                    if (input.hasAttribute('data-required')) {
                        input.setAttribute('required', 'required');
                    }
                });
            } else {
                form.classList.add('hidden');
                // Remover required e desabilitar os campos
                inputs.forEach(input => {
                    input.removeAttribute('required');
                    input.setAttribute('disabled', 'disabled');
                });
            }
        });
    });

    // Buscar materiais
    buscarInput.addEventListener('input', function() {
        const termo = this.value.toLowerCase();
        document.querySelectorAll('.material-item').forEach(item => {
            const nome = item.dataset.nome;
            const codigo = item.dataset.codigo;
            const categoria = item.dataset.categoria;

            if (nome.includes(termo) || codigo.includes(termo) || categoria.includes(termo)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Filtrar por estoque baixo
    filtroBaixoEstoque.addEventListener('change', function() {
        document.querySelectorAll('.material-item').forEach(item => {
            if (this.checked && item.dataset.estoqueBaixo === 'false') {
                item.style.display = 'none';
            } else {
                item.style.display = '';
            }
        });
    });

    // Adicionar material customizado (não cadastrado)
    btnAdicionarCustomizado.addEventListener('click', function() {
        const index = customizadoIndex++;
        const materialCustomizado = document.createElement('div');
        materialCustomizado.className = 'material-customizado p-4 border-2 border-dashed border-emerald-300 dark:border-emerald-700 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-lg';
        materialCustomizado.dataset.index = index;

        materialCustomizado.innerHTML = `
            <div class="flex items-start justify-between mb-3">
                <h4 class="font-semibold text-emerald-700 dark:text-emerald-400 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Material Não Cadastrado
                </h4>
                <button type="button" class="btn-remover-customizado text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300" title="Remover">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nome do Material <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="materiais_customizados[${index}][nome]"
                           required
                           placeholder="Ex: Parafuso 6mm"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Especificação Técnica
                    </label>
                    <input type="text"
                           name="materiais_customizados[${index}][especificacao]"
                           placeholder="Ex: Aço inox, 6mm x 20mm"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Quantidade <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="materiais_customizados[${index}][quantidade]"
                           step="0.01"
                           min="0.01"
                           required
                           placeholder="0.00"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Unidade de Medida <span class="text-red-500">*</span>
                    </label>
                    <select name="materiais_customizados[${index}][unidade_medida]"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                        <option value="unidade">Unidade</option>
                        <option value="metro">Metro</option>
                        <option value="litro">Litro</option>
                        <option value="kg">Quilograma</option>
                        <option value="caixa">Caixa</option>
                        <option value="pacote">Pacote</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Justificativa <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="materiais_customizados[${index}][justificativa]"
                           required
                           placeholder="Ex: Material necessário para manutenção de equipamentos"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
            </div>
        `;

        materiaisCustomizados.appendChild(materialCustomizado);

        // Adicionar evento de remoção
        materialCustomizado.querySelector('.btn-remover-customizado').addEventListener('click', function() {
            materialCustomizado.remove();
        });
    });

    // Função para preparar dados do formulário antes da validação
    function prepararDadosFormulario() {
        // Garantir que apenas campos selecionados tenham required
        checkboxes.forEach(checkbox => {
            const form = checkbox.closest('.material-item')?.querySelector('.material-form');
            if (form) {
                const inputs = form.querySelectorAll('input:not([type="checkbox"])');
                if (checkbox.checked) {
                    // Se está marcado, garantir que está habilitado e required
                    inputs.forEach(input => {
                        input.removeAttribute('disabled');
                        if (input.hasAttribute('data-required')) {
                            input.setAttribute('required', 'required');
                        }
                    });
                } else {
                    // Se não está marcado, remover required e desabilitar
                    inputs.forEach(input => {
                        input.removeAttribute('required');
                        input.setAttribute('disabled', 'disabled');
                    });
                }
            }
        });

        // Materiais customizados sempre devem estar habilitados e com required
        document.querySelectorAll('.material-customizado input[required], .material-customizado select[required]').forEach(input => {
            input.removeAttribute('disabled');
        });
    }

    // Visualizar PDF
    btnVisualizar.addEventListener('click', function(e) {
        e.preventDefault();

        // Preparar dados antes de validar
        prepararDadosFormulario();

        // Validar formulário
        if (!formSolicitacao.checkValidity()) {
            formSolicitacao.reportValidity();
            return;
        }

        // Criar formulário temporário para visualização
        const formData = new FormData(formSolicitacao);
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.materiais.solicitar.visualizar-pdf') }}';
        form.target = '_blank';

        // Adicionar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Adicionar apenas campos válidos (não desabilitados)
        formData.forEach((value, key) => {
            // Ignorar campos desabilitados
            const input = formSolicitacao.querySelector(`[name="${key}"]`);
            if (input && !input.disabled) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = key;
                hiddenInput.value = value;
                form.appendChild(hiddenInput);
            }
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    // Reindexar materiais ao remover
    formSolicitacao.addEventListener('submit', function(e) {
        // Preparar dados antes de validar - remover required de campos não selecionados
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                const form = checkbox.closest('.material-item')?.querySelector('.material-form');
                if (form) {
                    form.querySelectorAll('input[required]').forEach(input => {
                        input.removeAttribute('required');
                        input.setAttribute('disabled', 'disabled');
                    });
                }
            }
        });

        // Validar antes de reindexar
        if (!formSolicitacao.checkValidity()) {
            e.preventDefault();
            formSolicitacao.reportValidity();
            return false;
        }

        // Reindexar apenas materiais selecionados
        let index = 0;
        const selectedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);

        selectedCheckboxes.forEach(checkbox => {
            const item = checkbox.closest('.material-item');
            const form = item.querySelector('.material-form');

            // Atualizar índices
            checkbox.name = `materiais[${index}][material_id]`;
            form.querySelectorAll('input').forEach(input => {
                if (input.name.includes('[quantidade]')) {
                    input.name = `materiais[${index}][quantidade]`;
                } else if (input.name.includes('[justificativa]')) {
                    input.name = `materiais[${index}][justificativa]`;
                }
            });

            index++;
        });

        // Reindexar materiais customizados
        let customIndex = 0;
        document.querySelectorAll('.material-customizado').forEach(item => {
            const inputs = item.querySelectorAll('input, select');
            inputs.forEach(input => {
                const name = input.name;
                if (name.includes('materiais_customizados[')) {
                    input.name = name.replace(/materiais_customizados\[\d+\]/, `materiais_customizados[${customIndex}]`);
                }
            });
            customIndex++;
        });

        // Remover campos não selecionados do formulário antes de enviar
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                const form = checkbox.closest('.material-item')?.querySelector('.material-form');
                if (form) {
                    form.querySelectorAll('input').forEach(input => {
                        input.remove();
                    });
                }
            }
        });
        });
    });

    @if(isset($solicitacaoCampo) && $solicitacaoCampo)
    // Pré-preencher material customizado quando vier de solicitação do campo
    document.addEventListener('DOMContentLoaded', function() {
        const btnAdicionar = document.getElementById('btnAdicionarCustomizado');
        if (btnAdicionar) {
            btnAdicionar.click();

            setTimeout(function() {
                const container = document.getElementById('materiais_customizados');
                const ultimoItem = container.querySelector('.material-customizado:last-child');

                if (ultimoItem) {
                    const nomeInput = ultimoItem.querySelector('input[name*="[nome]"]');
                    const especificacaoInput = ultimoItem.querySelector('input[name*="[especificacao]"]');
                    const quantidadeInput = ultimoItem.querySelector('input[name*="[quantidade]"]');
                    const unidadeSelect = ultimoItem.querySelector('select[name*="[unidade_medida]"]');
                    const justificativaInput = ultimoItem.querySelector('input[name*="[justificativa]"]');

                    if (nomeInput) nomeInput.value = '{{ $solicitacaoCampo->material_nome }}';
                    if (especificacaoInput && '{{ $solicitacaoCampo->material_codigo }}') {
                        especificacaoInput.value = 'Código: {{ $solicitacaoCampo->material_codigo }}';
                    }
                    if (quantidadeInput) quantidadeInput.value = '{{ $solicitacaoCampo->quantidade }}';
                    if (unidadeSelect) unidadeSelect.value = '{{ $solicitacaoCampo->unidade_medida }}';
                    if (justificativaInput) justificativaInput.value = '{{ $solicitacaoCampo->justificativa }}';
                }
            }, 100);
        }
    });
    @endif
</script>
@endpush
@endsection

