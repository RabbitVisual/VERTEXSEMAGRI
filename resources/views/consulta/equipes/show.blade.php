@extends('consulta.layouts.consulta')

@section('title', 'Detalhes da Equipe - Consulta')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="users" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>{{ $equipe->nome }}</span>
                @if($equipe->codigo)
                <span class="text-violet-600 dark:text-violet-400 text-lg font-normal">({{ $equipe->codigo }})</span>
                @endif
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('consulta.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Consulta</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('consulta.equipes.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Equipes</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Detalhes</span>
            </nav>
        </div>
        <a href="{{ route('consulta.equipes.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-300">
            <x-icon name="arrow-left" class="w-5 h-5" />
            <span>Voltar</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informações Principais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card Informações -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="circle-info" class="w-5 h-5 text-violet-500" />
                        Informações da Equipe
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                            <p class="text-lg font-semibold text-violet-600 dark:text-violet-400">{{ $equipe->codigo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                            @if($equipe->ativo)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <x-icon name="circle-check" class="w-4 h-4 mr-1.5" />
                                    Ativo
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <x-icon name="circle-xmark" class="w-4 h-4 mr-1.5" />
                                    Inativo
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $equipe->nome }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ ucfirst($equipe->tipo ?? 'N/A') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Líder</label>
                            <p class="text-sm text-gray-900 dark:text-white flex items-center gap-2">
                                @if($equipe->lider)
                                    <x-icon name="user-tie" class="w-4 h-4 text-gray-400" />
                                    <strong>{{ $equipe->lider->name }}</strong>
                                @else
                                    <span class="text-gray-400">Não definido</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Funcionários</label>
                            <p class="text-sm text-gray-900 dark:text-white flex items-center gap-2">
                                <x-icon name="users" class="w-4 h-4 text-gray-400" />
                                <strong>{{ $equipe->funcionarios->count() ?? 0 }} funcionário(s)</strong>
                            </p>
                        </div>
                    </div>

                    @if($equipe->descricao)
                    <div class="pt-4 border-t border-gray-200 dark:border-slate-700">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Descrição</label>
                        <div class="p-4 bg-gray-50 dark:bg-slate-900/50 rounded-lg border border-gray-200 dark:border-slate-700">
                            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $equipe->descricao }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Funcionários -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="users" class="w-5 h-5 text-blue-500" />
                        Funcionários da Equipe
                    </h3>
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm font-medium rounded-full">
                        {{ $equipe->funcionarios->count() ?? 0 }} funcionário(s)
                    </span>
                </div>
                <div class="overflow-x-auto">
                    @if($equipe->funcionarios && $equipe->funcionarios->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase hidden md:table-cell">Função</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase hidden sm:table-cell">Telefone</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($equipe->funcionarios as $funcionario)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-semibold">
                                            {{ strtoupper(substr($funcionario->nome ?? 'F', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $funcionario->nome }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                        {{ ucfirst($funcionario->funcao ?? 'N/A') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell text-sm text-gray-900 dark:text-white">
                                    {{ $funcionario->telefone ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('consulta.funcionarios.show', $funcionario->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors" title="Ver detalhes">
                                        <x-icon name="eye" class="w-4 h-4" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-icon name="user-group" class="w-8 h-8 text-gray-400" />
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Nenhum funcionário cadastrado nesta equipe</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Informações Adicionais -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="circle-info" class="w-5 h-5 text-gray-500" />
                        Informações
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">#{{ $equipe->id }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                        <p class="text-sm text-gray-900 dark:text-white">
                            @if($equipe->created_at)
                                {{ is_string($equipe->created_at) ? \Carbon\Carbon::parse($equipe->created_at)->format('d/m/Y H:i') : $equipe->created_at->format('d/m/Y H:i') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    @if($equipe->updated_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ is_string($equipe->updated_at) ? \Carbon\Carbon::parse($equipe->updated_at)->format('d/m/Y H:i') : $equipe->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    @endif
                    <div class="pt-4 border-t border-gray-200 dark:border-slate-700">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Funcionários</label>
                        <p class="text-2xl font-bold text-violet-600 dark:text-violet-400">{{ $equipe->funcionarios->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Badge Modo Consulta -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-4 text-center">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                    <x-icon name="eye" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <h4 class="font-semibold text-blue-800 dark:text-blue-300 mb-1">Modo Consulta</h4>
                <p class="text-sm text-blue-600 dark:text-blue-400">Somente visualização</p>
            </div>
        </div>
    </div>
</div>
@endsection
