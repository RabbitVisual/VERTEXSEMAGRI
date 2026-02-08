@extends('admin.layouts.admin')

@section('title', 'Cadastrar Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Líderes de Comunidade</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Cadastrar</span>
            </nav>
        </div>
        <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.lideres-comunidade.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Informações do Líder -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Líder</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nome') border-red-500 dark:border-red-600 @enderror"
                            placeholder="Digite o nome completo">
                        @error('nome')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cpf" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}"
                            class="cpf-mask bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cpf') border-red-500 dark:border-red-600 @enderror"
                            placeholder="000.000.000-00">
                        @error('cpf')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telefone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                        <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('telefone') border-red-500 dark:border-red-600 @enderror"
                            placeholder="(00) 00000-0000">
                        @error('telefone')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') border-red-500 dark:border-red-600 @enderror"
                            placeholder="email@exemplo.com">
                        @error('email')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="endereco" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Endereço Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" required readonly
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full px-4 py-2.5 dark:bg-slate-600 dark:border-slate-600 dark:text-gray-300 dark:placeholder-gray-400 cursor-not-allowed @error('endereco') border-red-500 dark:border-red-600 @enderror"
                        placeholder="Será preenchido automaticamente ao selecionar a localidade"
                        data-required="true">
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">O endereço será preenchido automaticamente com base na localidade selecionada</p>
                    @error('endereco')
                        <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Busca de Pessoa do CadÚnico -->
                <div class="pt-4 border-t border-gray-200 dark:border-slate-700">
                    <div class="mb-4">
                        <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-2">Vincular a Pessoa do CadÚnico</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Busque e selecione uma pessoa do CadÚnico para vincular como líder (opcional)</p>
                    </div>
                    <div>
                        <label for="pessoa_search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Buscar Pessoa do CadÚnico
                        </label>
                        <div class="relative">
                            <input type="text" id="pessoa_search" name="pessoa_search"
                                placeholder="Digite nome, NIS ou CPF para buscar..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <div id="pessoa_results" class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
                        </div>
                        <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ old('pessoa_id') }}">
                        <div id="pessoa_selecionada" class="hidden mt-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-emerald-900 dark:text-emerald-300" id="pessoa_nome_selecionada"></p>
                                    <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-1" id="pessoa_info_selecionada"></p>
                                </div>
                                <button type="button" onclick="removerPessoa()" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('pessoa_id')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Ao selecionar uma pessoa, os dados serão preenchidos automaticamente</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vinculação -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Vinculação</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="localidade_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Localidade <span class="text-red-500">*</span>
                        </label>
                        <select id="localidade_id" name="localidade_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('localidade_id') border-red-500 dark:border-red-600 @enderror">
                            <option value="">Selecione uma localidade...</option>
                            @foreach($localidades as $localidade)
                                <option value="{{ $localidade->id }}" {{ old('localidade_id') == $localidade->id ? 'selected' : '' }}>
                                    {{ $localidade->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('localidade_id')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="poco_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Poço Artesiano <span class="text-red-500">*</span>
                        </label>
                        <select id="poco_id" name="poco_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('poco_id') border-red-500 dark:border-red-600 @enderror">
                            <option value="">Selecione um poço...</option>
                            @foreach($pocos as $poco)
                                <option value="{{ $poco->id }}" {{ old('poco_id') == $poco->id ? 'selected' : '' }}>
                                    {{ $poco->nome_mapa ?? $poco->codigo }} - {{ $poco->localidade->nome ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('poco_id')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">O líder será responsável por gerenciar este poço</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vinculação: Usuário do Sistema -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Usuário do Sistema</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Crie um novo usuário ou vincule a um existente (opcional se já vinculou uma pessoa do CadÚnico)</p>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="block mb-4">
                        <input type="radio" name="criar_usuario" value="1" {{ old('criar_usuario', '1') == '1' && !old('pessoa_id') ? 'checked' : '' }}
                            onchange="toggleVinculacao('usuario-novo')"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Criar novo usuário do sistema</span>
                    </label>
                    <label class="block mb-4">
                        <input type="radio" name="criar_usuario" value="0" {{ old('criar_usuario') == '0' && !old('pessoa_id') ? 'checked' : '' }}
                            onchange="toggleVinculacao('usuario-existente')"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Vincular a usuário existente</span>
                    </label>
                    <label class="block">
                        <input type="radio" name="criar_usuario" value="pessoa" {{ old('pessoa_id') ? 'checked' : '' }}
                            onchange="toggleVinculacao('pessoa')"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Não criar usuário do sistema</span>
                    </label>
                    <p class="ml-6 mt-1 text-xs text-gray-500 dark:text-gray-400">Use esta opção se você já vinculou uma pessoa do CadÚnico acima e não precisa criar um usuário do sistema para login</p>
                </div>

                <!-- Formulário para criar novo usuário -->
                <div id="new-user-form" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="user_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nome do Usuário <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('user_name') border-red-500 dark:border-red-600 @enderror"
                                placeholder="Nome para login">
                            @error('user_name')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="user_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email do Usuário <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="user_email" name="user_email" value="{{ old('user_email') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('user_email') border-red-500 dark:border-red-600 @enderror"
                                placeholder="usuario@exemplo.com">
                            @error('user_email')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="user_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Senha <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="user_password" name="user_password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('user_password') border-red-500 dark:border-red-600 @enderror"
                                placeholder="Mínimo 8 caracteres">
                            @error('user_password')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="user_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Confirmar Senha <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="user_password_confirmation" name="user_password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Digite a senha novamente">
                        </div>
                    </div>
                </div>

                <!-- Seleção de usuário existente -->
                <div id="existing-user-form" class="hidden">
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Selecionar Usuário <span class="text-red-500">*</span>
                        </label>
                        <select id="user_id" name="user_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('user_id') border-red-500 dark:border-red-600 @enderror">
                            <option value="">Selecione um usuário...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Apenas usuários que ainda não são líderes de comunidade</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status e Observações -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Status e Observações</h2>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('status') border-red-500 dark:border-red-600 @enderror">
                        <option value="ativo" {{ old('status', 'ativo') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ old('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="observacoes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observações</label>
                    <textarea id="observacoes" name="observacoes" rows="3"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('observacoes') border-red-500 dark:border-red-600 @enderror"
                        placeholder="Observações adicionais sobre o líder...">{{ old('observacoes') }}</textarea>
                    @error('observacoes')
                        <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('admin.lideres-comunidade.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Cadastrar Líder
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
let pessoaSearchTimeout;

function toggleVinculacao(tipo) {
    const newUserForm = document.getElementById('new-user-form');
    const existingUserForm = document.getElementById('existing-user-form');
    const pessoaIdInput = document.getElementById('pessoa_id');

    // Verificar se os elementos existem antes de usar
    if (!newUserForm || !existingUserForm || !pessoaIdInput) {
        console.error('Elementos do formulário não encontrados');
        return;
    }

    const newUserInputs = newUserForm.querySelectorAll('input, select');
    const existingUserInputs = existingUserForm.querySelectorAll('input, select');

    // Esconder todos os formulários
    newUserForm.classList.add('hidden');
    existingUserForm.classList.add('hidden');

    // Limpar required de todos os campos de usuário
    [...newUserInputs, ...existingUserInputs].forEach(input => {
        if (input.name !== 'criar_usuario') {
            input.required = false;
            if (input.type === 'password') {
                input.value = '';
            }
        }
    });

    if (tipo === 'usuario-novo') {
        newUserForm.classList.remove('hidden');
        newUserInputs.forEach(input => {
            if (input.name !== 'criar_usuario' && input.name !== 'user_password_confirmation') {
                input.required = true;
            }
        });
        // Não limpar pessoa_id aqui, pois a pessoa pode ser selecionada independentemente
    } else if (tipo === 'usuario-existente') {
        existingUserForm.classList.remove('hidden');
        existingUserInputs.forEach(input => {
            if (input.name === 'user_id') {
                input.required = true;
            }
        });
        // Não limpar pessoa_id aqui, pois a pessoa pode ser selecionada independentemente
    } else if (tipo === 'pessoa') {
        // Quando seleciona "apenas pessoa", esconder formulários de usuário
        // Limpar campos de usuário
        newUserInputs.forEach(input => {
            if (input.type === 'password') input.value = '';
            if (input.name === 'user_name' || input.name === 'user_email') input.value = '';
        });
        existingUserInputs.forEach(input => {
            if (input.name === 'user_id') input.value = '';
        });
        // pessoaIdInput não precisa ser required aqui, pois a busca é opcional
    }
}

function buscarPessoas() {
    const search = document.getElementById('pessoa_search').value;
    const localidadeId = document.getElementById('localidade_id').value;
    const resultsDiv = document.getElementById('pessoa_results');

    if (search.length < 3) {
        resultsDiv.classList.add('hidden');
        return;
    }

    clearTimeout(pessoaSearchTimeout);
    pessoaSearchTimeout = setTimeout(() => {
        fetch(`{{ route('admin.lideres-comunidade.pessoas.buscar') }}?search=${encodeURIComponent(search)}&localidade_id=${localidadeId}`)
            .then(response => response.json())
            .then(pessoas => {
                if (pessoas.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-4 text-sm text-gray-500 dark:text-gray-400">Nenhuma pessoa encontrada</div>';
                    resultsDiv.classList.remove('hidden');
                    return;
                }

                resultsDiv.innerHTML = pessoas.map(pessoa => `
                    <div class="p-3 hover:bg-gray-100 dark:hover:bg-slate-700 cursor-pointer border-b border-gray-200 dark:border-slate-700 last:border-0"
                         onclick="selecionarPessoa(${pessoa.id})">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${pessoa.nome}${pessoa.apelido ? ' (' + pessoa.apelido + ')' : ''}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            ${pessoa.nis ? 'NIS: ' + pessoa.nis + ' • ' : ''}
                            ${pessoa.cpf ? 'CPF: ' + pessoa.cpf + ' • ' : ''}
                            ${pessoa.localidade || ''}
                        </p>
                    </div>
                `).join('');
                resultsDiv.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erro ao buscar pessoas:', error);
            });
    }, 300);
}

function selecionarPessoa(pessoaId) {
    const urlBase = '{{ url("/admin/lideres-comunidade/pessoa") }}';
    fetch(`${urlBase}/${pessoaId}`)
        .then(response => response.json())
        .then(pessoa => {
            document.getElementById('pessoa_id').value = pessoa.id;
            document.getElementById('pessoa_search').value = pessoa.nome;
            document.getElementById('pessoa_results').classList.add('hidden');

            // Preencher campos do formulário
            if (!document.getElementById('nome').value) {
                document.getElementById('nome').value = pessoa.nome;
            }
            if (!document.getElementById('cpf').value && pessoa.cpf) {
                document.getElementById('cpf').value = pessoa.cpf_formatado || pessoa.cpf;
            }
            if (!document.getElementById('localidade_id').value && pessoa.localidade_id) {
                document.getElementById('localidade_id').value = pessoa.localidade_id;
                // Disparar evento change para preencher endereço automaticamente
                document.getElementById('localidade_id').dispatchEvent(new Event('change'));
            }

            // Mostrar informações da pessoa selecionada
            document.getElementById('pessoa_nome_selecionada').textContent = pessoa.nome;
            let info = [];
            if (pessoa.nis_formatado) info.push(`NIS: ${pessoa.nis_formatado}`);
            if (pessoa.cpf_formatado) info.push(`CPF: ${pessoa.cpf_formatado}`);
            if (pessoa.localidade_nome) info.push(`Localidade: ${pessoa.localidade_nome}`);
            if (pessoa.idade) info.push(`Idade: ${pessoa.idade} anos`);
            if (pessoa.recebe_pbf) info.push(`Beneficiária PBF`);
            document.getElementById('pessoa_info_selecionada').innerHTML = info.join(' • ');
            document.getElementById('pessoa_selecionada').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erro ao buscar pessoa:', error);
            alert('Erro ao carregar dados da pessoa');
        });
}

function removerPessoa() {
    document.getElementById('pessoa_id').value = '';
    document.getElementById('pessoa_search').value = '';
    document.getElementById('pessoa_selecionada').classList.add('hidden');
    document.getElementById('pessoa_results').classList.add('hidden');
}

// Inicializar estado
document.addEventListener('DOMContentLoaded', function() {
    const pessoaIdInput = document.getElementById('pessoa_id');
    const pessoaId = pessoaIdInput ? pessoaIdInput.value : '';

    // Se já tem pessoa selecionada, marcar o radio correspondente
    if (pessoaId) {
        const radioPessoa = document.querySelector('input[name="criar_usuario"][value="pessoa"]');
        if (radioPessoa) {
            radioPessoa.checked = true;
            toggleVinculacao('pessoa');
            selecionarPessoa(pessoaId);
        }
    } else {
        // Inicializar com o padrão (criar novo usuário)
        const criarUsuario = document.querySelector('input[name="criar_usuario"][value="1"]');
        if (criarUsuario) {
            criarUsuario.checked = true;
            toggleVinculacao('usuario-novo');
        }
    }

    // Event listeners para busca de pessoa
    const pessoaSearchInput = document.getElementById('pessoa_search');
    if (pessoaSearchInput) {
        pessoaSearchInput.addEventListener('input', buscarPessoas);
    }

    const localidadeSelect = document.getElementById('localidade_id');
    const enderecoInput = document.getElementById('endereco');

    if (localidadeSelect) {
        localidadeSelect.addEventListener('change', function() {
            const localidadeId = this.value;

            // Buscar dados da localidade e preencher endereço
            if (localidadeId) {
                fetch(`/localidades/${localidadeId}/dados`, {
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
                    // Montar endereço completo
                    let enderecoCompleto = data.endereco || '';
                    if (data.numero) {
                        enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.numero;
                    }
                    if (data.complemento) {
                        enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.complemento;
                    }
                    if (data.bairro) {
                        enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.bairro;
                    }
                    if (data.cidade) {
                        enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.cidade;
                        if (data.estado) {
                            enderecoCompleto += '/' + data.estado;
                        }
                    }
                    if (data.cep) {
                        enderecoCompleto += (enderecoCompleto ? ' - CEP: ' : '') + data.cep;
                    }

                    if (enderecoInput) {
                        if (enderecoCompleto) {
                            enderecoInput.value = enderecoCompleto;
                        } else if (data.nome) {
                            // Se não tem endereço, usar pelo menos o nome da localidade
                            enderecoInput.value = data.nome;
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar dados da localidade:', error);
                });
            } else {
                // Limpar endereço se nenhuma localidade foi selecionada
                if (enderecoInput) {
                    enderecoInput.value = '';
                }
            }

            // Buscar pessoas se já tinha busca ativa
            if (pessoaSearchInput && pessoaSearchInput.value.length >= 3) {
                buscarPessoas();
            }
        });
    }

    // Fechar resultados ao clicar fora
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#pessoa_search') && !e.target.closest('#pessoa_results')) {
            const resultsDiv = document.getElementById('pessoa_results');
            if (resultsDiv) {
                resultsDiv.classList.add('hidden');
            }
        }
    });
});
</script>
@endpush
@endsection

