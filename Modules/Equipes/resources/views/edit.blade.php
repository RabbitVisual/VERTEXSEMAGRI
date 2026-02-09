@extends('admin.layouts.admin')

@section('title', 'Editar Equipe - ' . $equipe->nome)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                    <x-module-icon module="Equipes" class="w-6 h-6" />
                </div>
                Editar Equipe
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Atualize as informações da equipe {{ $equipe->nome }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.equipes.show', $equipe) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                <x-icon name="eye" class="w-4 h-4 mr-2" />
                Ver Detalhes
            </a>
            <a href="{{ route('admin.equipes.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300">
            <div class="flex items-start gap-3">
                <x-icon name="exclamation-triangle" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <div>
                    <h3 class="font-semibold text-sm">Problemas encontrados:</h3>
                    <ul class="list-disc list-inside text-sm mt-1 space-y-1 opacity-90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('equipes.update', $equipe) }}" method="POST" class="max-w-4xl">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <!-- Seção 1: Informações Básicas -->
            <div class="p-6 space-y-6">
                <div class="flex items-center gap-2 mb-2">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold ring-4 ring-white dark:ring-slate-800">1</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Dados Principais</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-8">
                    <div class="md:col-span-2">
                        <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome da Equipe <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" id="nome" required value="{{ old('nome', $equipe->nome) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código</label>
                        <input type="text" value="{{ $equipe->codigo }}" disabled readonly class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-gray-400 font-mono cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500">O código é gerado automaticamente e não pode ser alterado.</p>
                    </div>

                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Equipe <span class="text-red-500">*</span></label>
                        <select name="tipo" id="tipo" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Selecione o tipo...</option>
                            <option value="eletricistas" {{ old('tipo', $equipe->tipo) == 'eletricistas' ? 'selected' : '' }}>Eletricistas</option>
                            <option value="encanadores" {{ old('tipo', $equipe->tipo) == 'encanadores' ? 'selected' : '' }}>Encanadores</option>
                            <option value="operadores" {{ old('tipo', $equipe->tipo) == 'operadores' ? 'selected' : '' }}>Operadores</option>
                            <option value="motoristas" {{ old('tipo', $equipe->tipo) == 'motoristas' ? 'selected' : '' }}>Motoristas</option>
                            <option value="mista" {{ old('tipo', $equipe->tipo) == 'mista' ? 'selected' : '' }}>Mista</option>
                        </select>
                    </div>

                    <div>
                        <label for="lider_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Líder Responsável</label>
                        <select name="lider_id" id="lider_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Selecione um usuário...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('lider_id', $equipe->lider_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Opcional. Deve ser um usuário do sistema.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-colors">{{ old('descricao', $equipe->descricao) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-slate-700"></div>

            <!-- Seção 2: Membros -->
            <div class="p-6 space-y-6">
                 <div class="flex items-center gap-2 mb-2">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold ring-4 ring-white dark:ring-slate-800">2</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Membros da Equipe</h3>
                </div>

                <div class="pl-8">
                    <label for="funcionarios" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Selecione os Funcionários</label>
                    <div class="relative">
                        <select name="funcionarios[]" id="funcionarios" multiple size="8" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 transition-colors font-mono text-sm">
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->id }}" {{ in_array($funcionario->id, old('funcionarios', $equipe->funcionarios->pluck('id')->toArray())) ? 'selected' : '' }} class="p-2 border-b border-gray-100 dark:border-slate-600 last:border-0 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded">
                                    [{{ $funcionario->codigo ?? 'N/A' }}] {{ $funcionario->nome }} - {{ ucfirst($funcionario->funcao) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <x-icon name="information-circle" class="w-3 h-3" />
                        Segure Ctrl (Windows) ou Cmd (Mac) para selecionar múltiplos funcionários.
                    </p>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="bg-gray-50 dark:bg-slate-700/50 px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $equipe->ativo) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500 dark:bg-slate-700 dark:border-slate-600">
                    <label for="ativo" class="text-sm font-medium text-gray-700 dark:text-gray-300">Equipe Ativa</label>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.equipes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-800 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-700 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:focus:ring-emerald-800 transition-all shadow-md hover:shadow-lg">
                        <x-icon name="check" class="w-4 h-4" />
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
