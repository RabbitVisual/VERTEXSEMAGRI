@extends('Co-Admin.layouts.app')

@section('title', 'Editar Equipe')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 dark:from-emerald-800 dark:to-emerald-900 rounded-2xl shadow-xl p-6 md:p-8 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-module-icon module="Equipes" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Editar Equipe</h1>
                    <p class="text-emerald-100 dark:text-emerald-200 mt-2 text-sm md:text-base">
                        {{ $equipe->nome }}
                    </p>
                </div>
            </div>
            <x-equipes::button href="{{ route('equipes.show', $equipe) }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                <x-equipes::icon name="arrow-left" class="w-5 h-5 mr-2" />
                Voltar
            </x-equipes::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-equipes::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-equipes::icon name="check-circle" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-equipes::alert>
    @endif

    @if($errors->any())
        <x-equipes::alert type="danger" dismissible>
            <div class="flex items-start gap-2">
                <x-equipes::icon name="exclamation-triangle" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <div>
                    <p class="font-medium mb-2">Por favor, corrija os seguintes erros:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-equipes::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2 space-y-6">
            <x-equipes::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <x-equipes::icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informações da Equipe
                        </h3>
                    </div>
                </x-slot>

                <form action="{{ route('equipes.update', $equipe) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Informações Básicas -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-equipes::icon name="information-circle" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações Básicas
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <x-equipes::form.input
                                    label="Nome"
                                    name="nome"
                                    type="text"
                                    required
                                    value="{{ old('nome', $equipe->nome) }}"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código
                                </label>
                                @if($equipe->codigo)
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value="{{ $equipe->codigo }}"
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
                                    @if($equipe->codigo)
                                        Código já atribuído. Será gerado automaticamente se estiver vazio ao salvar.
                                    @else
                                        Será gerado automaticamente ao salvar
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-equipes::form.select
                                label="Tipo"
                                name="tipo"
                                required
                            >
                                <option value="">Selecione</option>
                                <option value="eletricistas" {{ old('tipo', $equipe->tipo) == 'eletricistas' ? 'selected' : '' }}>Eletricistas</option>
                                <option value="encanadores" {{ old('tipo', $equipe->tipo) == 'encanadores' ? 'selected' : '' }}>Encanadores</option>
                                <option value="operadores" {{ old('tipo', $equipe->tipo) == 'operadores' ? 'selected' : '' }}>Operadores</option>
                                <option value="motoristas" {{ old('tipo', $equipe->tipo) == 'motoristas' ? 'selected' : '' }}>Motoristas</option>
                                <option value="mista" {{ old('tipo', $equipe->tipo) == 'mista' ? 'selected' : '' }}>Mista</option>
                            </x-equipes::form.select>
                            <x-equipes::form.select
                                label="Líder (Usuário do Sistema)"
                                name="lider_id"
                            >
                                <option value="">Nenhum</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('lider_id', $equipe->lider_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </x-equipes::form.select>
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <x-equipes::icon name="document-text" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Descrição
                            </h4>
                        </div>

                        <x-equipes::form.textarea
                            label="Descrição"
                            name="descricao"
                            rows="3"
                            value="{{ old('descricao', $equipe->descricao) }}"
                        />
                    </div>

                    <!-- Funcionários -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <x-equipes::icon name="user-group" class="w-4 h-4 text-green-600 dark:text-green-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Funcionários
                            </h4>
                        </div>

                        @if(count($funcionarios) > 0)
                            <x-equipes::form.select
                                label="Funcionários"
                                name="funcionarios[]"
                                multiple
                                size="8"
                            >
                                @foreach($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}"
                                            {{ in_array($funcionario->id, old('funcionarios', $equipe->funcionarios->pluck('id')->toArray())) ? 'selected' : '' }}
                                            data-funcao="{{ $funcionario->funcao }}">
                                        {{ $funcionario->nome }}
                                        @if($funcionario->codigo)
                                            ({{ $funcionario->codigo }})
                                        @endif
                                        - {{ ucfirst($funcionario->funcao) }}
                                    </option>
                                @endforeach
                            </x-equipes::form.select>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                <x-equipes::icon name="information-circle" class="w-3 h-3 inline" />
                                Segure <kbd class="px-1 py-0.5 bg-gray-200 dark:bg-gray-700 rounded">Ctrl</kbd> (ou <kbd class="px-1 py-0.5 bg-gray-200 dark:bg-gray-700 rounded">Cmd</kbd> no Mac) para selecionar múltiplos funcionários.
                            </p>
                        @else
                            <x-equipes::alert type="warning">
                                Nenhum funcionário cadastrado.
                                <a href="{{ route('funcionarios.create') }}" class="font-medium underline hover:no-underline">Cadastrar funcionário</a>
                            </x-equipes::alert>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', $equipe->ativo) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="ativo" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Equipe ativa
                            </label>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-equipes::button href="{{ route('equipes.show', $equipe) }}" variant="outline">
                            Cancelar
                        </x-equipes::button>
                        <x-equipes::button type="submit" variant="primary">
                            <x-equipes::icon name="check-circle" class="w-4 h-4 mr-2" />
                            Atualizar Equipe
                        </x-equipes::button>
                    </div>
                </form>
            </x-equipes::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1 space-y-6">
            <x-equipes::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <x-equipes::icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informações
                        </h3>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                        <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $equipe->id }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $equipe->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($equipe->updated_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $equipe->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Funcionários na equipe</label>
                        <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $equipe->funcionarios->count() }}</div>
                    </div>
                    @if(Route::has('funcionarios.index'))
                    <x-equipes::button href="{{ route('funcionarios.index') }}" variant="outline" class="w-full">
                        <x-equipes::icon name="users" class="w-4 h-4 mr-2" />
                        Ver Funcionários
                    </x-equipes::button>
                    @endif
                </div>
            </x-equipes::card>
        </div>
    </div>
</div>
@endsection
