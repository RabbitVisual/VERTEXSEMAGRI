@extends('admin.layouts.admin')

@section('title', 'Cadastrar Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="user-plus" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Novo Líder</span>
            </h1>
            <nav class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-blue-600 transition-colors">Líderes</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <span class="text-blue-600">Cadastro de Gestão</span>
            </nav>
        </div>
        <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:text-white">
            <x-icon name="arrow-left" class="w-4 h-4" />
            Voltar à Lista
        </a>
    </div>

    <form action="{{ route('admin.lideres-comunidade.store') }}" method="POST" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                <!-- Busca de Pessoa do CadÚnico (MOVED TO TOP) -->
                <div class="premium-card overflow-visible relative z-30">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-blue-50/50 dark:bg-blue-900/10 flex items-center justify-between">
                        <h2 class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="magnifying-glass" style="duotone" class="w-5" />
                            Integração CadÚnico
                        </h2>
                    </div>
                    <div class="p-8">
                        <div class="mb-4">
                            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-tight">Pesquise uma pessoa para preencher os dados automaticamente.</p>
                        </div>
                        <div class="relative">
                            <label for="pessoa_search" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                Pesquisar Pessoa (Nome, NIS ou CPF)
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <x-icon name="magnifying-glass" class="w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors" />
                                </div>
                                <input type="text" id="pessoa_search" name="pessoa_search"
                                    placeholder="Digite nome, CPF ou NIS..."
                                    autocomplete="off"
                                    class="w-full pl-12 pr-10 py-4 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white shadow-sm">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer hidden" id="clear_search" onclick="limparBusca()">
                                    <x-icon name="x-mark" class="w-4 h-4 text-slate-400 hover:text-red-500 transition-colors" />
                                </div>
                            </div>

                            <!-- Search Results Dropdown -->
                            <div id="pessoa_results" class="hidden absolute left-0 right-0 top-full mt-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-2xl max-h-80 overflow-y-auto z-50 divide-y divide-gray-100 dark:divide-slate-700">
                                <!-- Results will be populated here -->
                            </div>
                        </div>

                        <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ old('pessoa_id') }}">

                        <!-- Pessoa Selecionada Card -->
                        <div id="pessoa_selecionada" class="{{ old('pessoa_id') ? '' : 'hidden' }} mt-6 p-5 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/30 rounded-2xl relative animate-scale-in">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-white dark:bg-slate-900 rounded-xl flex items-center justify-center text-emerald-600 shadow-sm">
                                    <x-icon name="user-check" style="duotone" class="w-6 h-6" />
                                </div>
                                <div class="flex-1">
                                    <p class="text-[11px] font-black text-emerald-900 dark:text-emerald-300 uppercase tracking-widest" id="pessoa_nome_selecionada">{{ old('nome') }}</p>
                                    <p class="text-[10px] text-emerald-600 dark:text-emerald-500 mt-1 font-bold uppercase tracking-tight leading-relaxed" id="pessoa_info_selecionada">Pessoa vinculada do CadÚnico</p>
                                </div>
                                <button type="button" onclick="removerPessoa()" class="p-2 text-emerald-400 hover:text-red-500 transition-colors" title="Remover vínculo">
                                    <x-icon name="x-mark" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                        @error('pessoa_id')
                            <p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informações do Líder -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="user-tie" style="duotone" class="w-5 text-blue-500" />
                            Informações de Identidade
                        </h2>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="nome" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                    Nome Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white @error('nome') border-red-500 @enderror"
                                    placeholder="Digite o nome completo">
                                @error('nome')
                                    <p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cpf" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">CPF</label>
                                <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}"
                                    class="cpf-mask w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                                    placeholder="000.000.000-00">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="telefone" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Telefone</label>
                                <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}"
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                                    placeholder="(00) 00000-0000">
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                                    placeholder="email@exemplo.com">
                            </div>
                        </div>

                        <div>
                            <label for="endereco" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                Endereço de Atuação <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" required
                                class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-tight focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
                                placeholder="Sincronizado automaticamente, mas pode ser editado se necessário">
                            <p class="mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-loose px-1">Sugerido com base na localidade selecionada.</p>
                        </div>
                    </div>
                </div>

                <!-- Vinculação Estrutural -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="link" style="duotone" class="w-5 text-indigo-500" />
                            Ambiente de Atuação
                        </h2>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="localidade_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                    Localidade Atendida <span class="text-red-500">*</span>
                                </label>
                                <select id="localidade_id" name="localidade_id" required
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                    <option value="">Selecione...</option>
                                    @foreach($localidades as $localidade)
                                        <option value="{{ $localidade->id }}" {{ old('localidade_id') == $localidade->id ? 'selected' : '' }}>
                                            {{ $localidade->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="poco_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                    Poço Gerenciado <span class="text-red-500">*</span>
                                </label>
                                <select id="poco_id" name="poco_id" required
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                    <option value="">Selecione...</option>
                                    @foreach($pocos as $poco)
                                        <option value="{{ $poco->id }}" {{ old('poco_id') == $poco->id ? 'selected' : '' }}>
                                            {{ $poco->nome_mapa ?? $poco->codigo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestão de Credenciais -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="key" style="duotone" class="w-5 text-amber-500" />
                            Acesso ao Sistema
                        </h2>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="flex flex-wrap gap-6">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="criar_usuario" value="1" {{ old('criar_usuario', '1') == '1' && !old('pessoa_id') ? 'checked' : '' }}
                                    onchange="toggleVinculacao('usuario-novo')"
                                    class="w-5 h-5 text-blue-600 bg-slate-100 border-slate-300 focus:ring-blue-500 focus:ring-offset-0 dark:bg-slate-900 dark:border-slate-700">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-900 transition-colors">Criar Novo Acesso</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="criar_usuario" value="0" {{ old('criar_usuario') == '0' && !old('pessoa_id') ? 'checked' : '' }}
                                    onchange="toggleVinculacao('usuario-existente')"
                                    class="w-5 h-5 text-blue-600 bg-slate-100 border-slate-300 focus:ring-blue-500 focus:ring-offset-0 dark:bg-slate-900 dark:border-slate-700">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-900 transition-colors">Vincular Existente</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="criar_usuario" value="pessoa" {{ old('pessoa_id') ? 'checked' : '' }}
                                    onchange="toggleVinculacao('pessoa')"
                                    class="w-5 h-5 text-blue-600 bg-slate-100 border-slate-300 focus:ring-blue-500 focus:ring-offset-0 dark:bg-slate-900 dark:border-slate-700">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-900 transition-colors">Sem Usuário</span>
                            </label>
                        </div>

                        <!-- Formulário para criar novo usuário -->
                        <div id="new-user-form" class="space-y-8 animate-fade-in">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="user_name" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nome de Exibição <span class="text-red-500">*</span></label>
                                    <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>

                                <div>
                                    <label for="user_email" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">E-mail de Login <span class="text-red-500">*</span></label>
                                    <input type="email" id="user_email" name="user_email" value="{{ old('user_email') }}"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="user_password" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Senha de Acesso <span class="text-red-500">*</span></label>
                                    <input type="password" id="user_password" name="user_password"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>

                                <div>
                                    <label for="user_password_confirmation" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Repetir Senha <span class="text-red-500">*</span></label>
                                    <input type="password" id="user_password_confirmation" name="user_password_confirmation"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Seleção de usuário existente -->
                        <div id="existing-user-form" class="hidden animate-fade-in">
                            <label for="user_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Escolher Usuário do Banco <span class="text-red-500">*</span></label>
                            <select id="user_id" name="user_id"
                                class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                <option value="">Selecione um acesso...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Status e Controle -->
                <div class="premium-card p-8 space-y-8">
                    <div>
                         <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <x-icon name="shield-halved" style="duotone" class="w-5 text-emerald-500" />
                            Controle Administrativo
                        </h2>
                        <label for="status" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Situação Inicial <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required
                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                            <option value="ativo" {{ old('status', 'ativo') === 'ativo' ? 'selected' : '' }}>Ativo / Operacional</option>
                            <option value="inativo" {{ old('status') === 'inativo' ? 'selected' : '' }}>Inativo / Bloqueado</option>
                        </select>
                    </div>

                    <div>
                        <label for="observacoes" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Notas e Observações</label>
                        <textarea id="observacoes" name="observacoes" rows="5"
                            class="w-full px-5 py-4 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-3xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed"
                            placeholder="Informações relevantes sobre este perfil...">{{ old('observacoes') }}</textarea>
                    </div>

                    <div class="pt-4 space-y-3">
                         <button type="submit" class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 text-xs font-black uppercase tracking-widest text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 group">
                            <x-icon name="user-check" style="duotone" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                            Confirmar Cadastro
                        </button>
                        <a href="{{ route('admin.lideres-comunidade.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 transition-colors">
                            Cancelar Operação
                        </a>
                    </div>
                </div>

                <!-- Info Help -->
                <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-3xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-blue-500">
                            <x-icon name="circle-question" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-blue-900 dark:text-blue-300 uppercase tracking-widest mb-1">Ajuda Rápida</h4>
                            <p class="text-[11px] text-blue-700 dark:text-blue-400/80 leading-relaxed font-bold uppercase tracking-tight">O líder de comunidade é responsável por validar pagamentos e gerenciar o poço vinculado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
let pessoaSearchTimeout;

function toggleVinculacao(tipo) {
    const newUserForm = document.getElementById('new-user-form');
    const existingUserForm = document.getElementById('existing-user-form');

    if (!newUserForm || !existingUserForm) return;

    newUserForm.classList.add('hidden');
    existingUserForm.classList.add('hidden');

    const newUserInputs = newUserForm.querySelectorAll('input, select');
    const existingUserInputs = existingUserForm.querySelectorAll('input, select');

    [...newUserInputs, ...existingUserInputs].forEach(i => i.required = false);

    if (tipo === 'usuario-novo') {
        newUserForm.classList.remove('hidden');
        newUserInputs.forEach(i => { if (i.name !== 'user_password_confirmation') i.required = true; });
    } else if (tipo === 'usuario-existente') {
        existingUserForm.classList.remove('hidden');
        existingUserInputs.forEach(i => i.required = true);
    }
}

function limparBusca() {
    document.getElementById('pessoa_search').value = '';
    document.getElementById('pessoa_results').classList.add('hidden');
    document.getElementById('clear_search').classList.add('hidden');
}

function buscarPessoas() {
    const search = document.getElementById('pessoa_search').value;
    const localidadeId = document.getElementById('localidade_id').value;
    const resultsDiv = document.getElementById('pessoa_results');
    const clearBtn = document.getElementById('clear_search');

    if (search.length > 0) {
        clearBtn.classList.remove('hidden');
    } else {
        clearBtn.classList.add('hidden');
    }

    if (search.length < 3) {
        resultsDiv.classList.add('hidden');
        return;
    }

    clearTimeout(pessoaSearchTimeout);

    // Show loading state could go here but simple text is fine

    pessoaSearchTimeout = setTimeout(() => {
        resultsDiv.innerHTML = '<div class="p-4 text-[10px] font-black uppercase text-slate-400 text-center">Buscando...</div>';
        resultsDiv.classList.remove('hidden');

        fetch(`{{ route('admin.lideres-comunidade.pessoas.buscar') }}?search=${encodeURIComponent(search)}&localidade_id=${localidadeId}`)
            .then(response => response.json())
            .then(pessoas => {
                if (pessoas.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-4 text-[10px] font-black uppercase text-slate-400 text-center">Nenhum resultado encontrado</div>';
                } else {
                    resultsDiv.innerHTML = pessoas.map(p => `
                        <div class="p-4 hover:bg-blue-50 dark:hover:bg-slate-700/50 cursor-pointer border-b border-gray-100 dark:border-slate-700 last:border-0 group transition-colors"
                             onclick='selecionarPessoa(${JSON.stringify(p)})'>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tight group-hover:text-blue-600 transition-colors">${p.nome}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">
                                        NIS: <span class="text-slate-600 dark:text-slate-300">${p.nis || '---'}</span> •
                                        CPF: <span class="text-slate-600 dark:text-slate-300">${p.cpf || '---'}</span>
                                    </p>
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    <x-icon name="arrow-right" class="w-4 h-4 text-blue-500" />
                                </div>
                            </div>
                        </div>
                    `).join('');
                }
                resultsDiv.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erro na busca:', error);
                resultsDiv.innerHTML = '<div class="p-4 text-[10px] font-black uppercase text-red-400 text-center">Erro ao buscar dados</div>';
            });
    }, 400); // Increased delay slightly for better UX
}

function selecionarPessoa(pessoa) {
    // Fill hidden ID
    document.getElementById('pessoa_id').value = pessoa.id;

    // Fill Form Fields
    const nomeInput = document.getElementById('nome');
    const cpfInput = document.getElementById('cpf');

    nomeInput.value = pessoa.nome;
    if (pessoa.cpf) {
        // Use formatted CPF if available, otherwise raw
        cpfInput.value = pessoa.cpf; // You might want to format this if it's raw
    }

    // Auto-select Localidade if match found
    if (pessoa.localidade_id) { // Assuming result has localidade_id
        const localSelect = document.getElementById('localidade_id');
        // Check if option exists before selecting
        if (localSelect.querySelector(`option[value="${pessoa.localidade_id}"]`)) {
            localSelect.value = pessoa.localidade_id;
            // Trigger change event to fetch address
            localSelect.dispatchEvent(new Event('change'));
        }
    }

    // Update User Name/Email suggestions if in "New User" mode
    document.getElementById('user_name').value = pessoa.nome;

    // Display Selected Card
    document.getElementById('pessoa_nome_selecionada').textContent = pessoa.nome;
    document.getElementById('pessoa_info_selecionada').textContent = `NIS: ${pessoa.nis || '---'} • LOCALIDADE: ${pessoa.localidade || '---'}`;

    document.getElementById('pessoa_selecionada').classList.remove('hidden');
    document.getElementById('pessoa_results').classList.add('hidden');
    document.getElementById('pessoa_search').value = ''; // Clear search field
    document.getElementById('clear_search').classList.add('hidden');

    // Highlight inputs slightly to show they were autofilled
    nomeInput.classList.add('ring-2', 'ring-emerald-500/20', 'border-emerald-500');
    setTimeout(() => {
        nomeInput.classList.remove('ring-2', 'ring-emerald-500/20', 'border-emerald-500');
    }, 2000);
}

function removerPessoa() {
    document.getElementById('pessoa_id').value = '';
    document.getElementById('pessoa_selecionada').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('pessoa_search').addEventListener('input', buscarPessoas);

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#pessoa_search') && !e.target.closest('#pessoa_results')) {
            document.getElementById('pessoa_results').classList.add('hidden');
        }
    });

    document.getElementById('localidade_id').addEventListener('change', function() {
        if (this.value) {
            // Add visual loading indicator for address
            const enderecoInput = document.getElementById('endereco');
            const originalPlaceholder = enderecoInput.placeholder;
            enderecoInput.placeholder = "Buscando endereço...";

            fetch(`/localidades/${this.value}/dados`)
                .then(r => r.json())
                .then(d => {
                    let end = d.endereco || '';
                    if (d.numero) end += `, ${d.numero}`;
                    if (d.bairro) end += ` - ${d.bairro}`;

                    if (!end && d.nome) end = d.nome; // Fallback to name if address empty

                    enderecoInput.value = end || '';
                    enderecoInput.placeholder = originalPlaceholder;
                })
                .catch(() => {
                    enderecoInput.placeholder = originalPlaceholder;
                });
        }
    });
});
</script>
@endpush
@endsection
