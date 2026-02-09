@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Equipe')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Equipes" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>{{ $equipe->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                <a href="{{ route('equipes.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Equipes</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                <span class="text-gray-900 dark:text-white font-medium">Detalhes</span>
            </nav>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('equipes.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </a>
            <a href="{{ route('equipes.edit', $equipe->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors shadow-sm">
                <x-icon name="pencil" class="w-4 h-4" />
                Editar
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 shadow-sm">
            <x-icon name="check-circle" class="w-5 h-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" />
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Details Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <x-icon name="information-circle" class="w-5 h-5" />
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Informações da Equipe</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nome</label>
                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $equipe->nome }}</div>
                    </div>
                    <div>
                         <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Código</label>
                         <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 font-mono">
                            {{ $equipe->codigo ?? 'N/A' }}
                        </div>
                    </div>
                     <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tipo</label>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                            <x-icon name="tag" class="w-3 h-3" />
                            {{ ucfirst($equipe->tipo) }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status</label>
                         @if($equipe->ativo)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Ativa
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Inativa
                            </div>
                        @endif
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Descrição</label>
                        <div class="p-4 bg-gray-50 dark:bg-slate-900/50 rounded-xl text-sm text-gray-600 dark:text-gray-300 leading-relaxed border border-gray-100 dark:border-slate-800">
                            {{ $equipe->descricao ?: 'Nenhuma descrição informada.' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Members Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                            <x-icon name="users" class="w-5 h-5" />
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Membros da Equipe</h3>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        {{ $equipe->funcionarios->count() }} Membros
                    </span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700/50">
                    @forelse($equipe->funcionarios as $funcionario)
                        <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold text-sm">
                                    {{ substr($funcionario->nome, 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $funcionario->nome }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($funcionario->funcao) }} • {{ $funcionario->codigo ?? 'S/C' }}</div>
                                </div>
                            </div>
                            <a href="{{ route('funcionarios.show', $funcionario->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:text-indigo-400 dark:hover:bg-indigo-900/30 rounded-lg transition-colors">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <x-icon name="users" class="w-6 h-6 text-gray-400" />
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">Nenhum membro nesta equipe.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Leader Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center gap-3">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400">
                        <x-icon name="star" class="w-5 h-5" />
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Líder Responsável</h3>
                </div>
                <div class="p-6">
                    @if($equipe->lider)
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 font-bold text-lg">
                                {{ substr($equipe->lider->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 dark:text-white">{{ $equipe->lider->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Usuário do Sistema</div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                            <div class="flex items-center gap-2">
                                <x-icon name="envelope" class="w-4 h-4 text-gray-400" />
                                <span>{{ $equipe->lider->email }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Nenhum líder atribuído.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats/Relationships Card -->
             <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center gap-3">
                    <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg text-amber-600 dark:text-amber-400">
                        <x-icon name="chart-bar" class="w-5 h-5" />
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Estatísticas</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/30 rounded-xl">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Ordens de Serviço</span>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $equipe->ordensServico->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer -->
             <div class="flex flex-col gap-3">
                 @if(Route::has('ordens.create'))
                    <a href="{{ route('ordens.create', ['equipe_id' => $equipe->id]) }}" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:focus:ring-emerald-800 transition-colors shadow-sm">
                        <x-icon name="clipboard-document-list" class="w-5 h-5" />
                        Atribuir Nova OS
                    </a>
                @endif
             </div>
        </div>
    </div>
</div>
@endsection
