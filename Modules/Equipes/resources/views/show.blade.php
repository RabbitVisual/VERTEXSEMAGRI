@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Equipe')

@section('content')
<div class="space-y-6 md:space-y-8">
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
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">Detalhes</span>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Recursos Humanos</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            {{ $equipe->nome }}
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-equipes::button href="{{ route('equipes.index') }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="arrow-left" class="w-5 h-5 mr-2" />
                        Voltar
                    </x-equipes::button>
                    <x-equipes::button href="{{ route('equipes.edit', $equipe->id) }}" variant="primary" size="lg" class="shadow-xl bg-indigo-600 hover:bg-indigo-700 border-b-4 border-indigo-800 active:border-b-0 active:translate-y-1 transition-all">
                        <x-icon name="pencil" class="w-5 h-5 mr-2" />
                        Editar Equipe
                    </x-equipes::button>
                </div>
            </div>
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
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden mb-6">
                <div class="p-8 border-b border-gray-100 dark:border-slate-700/50">
                    <div class="flex items-center gap-4 mb-1">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center border border-indigo-100 dark:border-indigo-800">
                            <x-icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Informações da Equipe</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Dados cadastrais e operacionais</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nome</label>
                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $equipe->nome }}</div>
                    </div>
                    <div>
                         <div class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-700 text-sm font-black text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 inline-block">
                            {{ $equipe->codigo ?? 'NÃO DEFINIDO' }}
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
                            <x-equipes::badge variant="success" class="shadow-sm">Equipe Ativa</x-equipes::badge>
                        @else
                            <x-equipes::badge variant="secondary">Equipe Inativa</x-equipes::badge>
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
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-gray-100 dark:border-slate-700/50 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center border border-blue-100 dark:border-blue-800">
                            <x-icon name="user-group" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Membros da Equipe</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Funcionários vinculados à unidade</p>
                        </div>
                    </div>
                    <div class="px-3 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-[10px] font-black text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800 uppercase tracking-widest">
                        {{ $equipe->funcionarios->count() }} Colaboradores
                    </div>
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
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center border border-purple-100 dark:border-purple-800">
                            <x-icon name="star" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Líder Responsável</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Gestão e Contato</p>
                        </div>
                    </div>
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
             <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center border border-amber-100 dark:border-amber-800">
                            <x-icon name="chart-bar" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Produtividade</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Indicadores de Atuação</p>
                        </div>
                    </div>
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
                    <x-equipes::button href="{{ route('ordens.create', ['equipe_id' => $equipe->id]) }}" variant="primary" size="lg" class="bg-emerald-600 hover:bg-emerald-700 border-b-4 border-emerald-800 shadow-lg">
                        <x-icon name="clipboard-document-list" class="w-5 h-5 mr-2" />
                        Atribuir Nova OS
                    </x-equipes::button>
                @endif
             </div>
        </div>
    </div>
</div>
@endsection
