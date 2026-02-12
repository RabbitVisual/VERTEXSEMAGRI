@extends('admin.layouts.admin')

@section('title', 'Editar Equipe - ' . $equipe->nome)

@section('content')
<div class="space-y-6">
    <!-- Premium Header Area -->
    <div class="relative overflow-hidden bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl mb-8">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-blue-500/10 rounded-full blur-[100px]"></div>

        <div class="relative px-8 py-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-5 bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl">
                            <x-icon module="equipes" class="w-10 h-10 text-white" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">Edição</span>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Recursos Humanos</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            Editar <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Equipe</span>
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-equipes::button href="{{ route('equipes.show', $equipe) }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="eye" class="w-5 h-5 mr-2" />
                        Ver Detalhes
                    </x-equipes::button>
                    <x-equipes::button href="{{ route('equipes.index') }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="arrow-left" class="w-5 h-5 mr-2" />
                        Voltar
                    </x-equipes::button>
                </div>
            </div>
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

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden mb-6">
            <!-- Seção 1: Informações Básicas -->
            <div class="p-8 border-b border-gray-100 dark:border-slate-700/50">
                <div class="flex items-center gap-4 mb-1">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center border border-indigo-100 dark:border-indigo-800">
                        <x-icon name="identification" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Dados Principais</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Identificação e configurações básicas</p>
                    </div>
                </div>
            </div>

            <div class="p-8 space-y-8">

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
            <div class="p-8 border-t border-b border-gray-100 dark:border-slate-700/50">
                <div class="flex items-center gap-4 mb-1">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center border border-blue-100 dark:border-blue-800">
                        <x-icon name="user-group" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Membros da Equipe</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Seleção de funcionários vinculados</p>
                    </div>
                </div>
            </div>

            <div class="p-8">

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
            <div class="bg-slate-50 dark:bg-slate-900/50 px-8 py-6 border-t border-gray-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $equipe->ativo) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        <label for="ativo" class="ml-3 text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-tight cursor-pointer">Equipe Ativa</label>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <x-equipes::button href="{{ route('equipes.index') }}" variant="secondary" size="lg" class="w-full sm:w-auto">
                        Cancelar
                    </x-equipes::button>
                    <x-equipes::button type="submit" variant="primary" size="lg" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 border-b-4 border-indigo-800 active:border-b-0 active:translate-y-1 transition-all">
                        <x-icon name="check" class="w-5 h-5 mr-2" />
                        Salvar Alterações
                    </x-equipes::button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
