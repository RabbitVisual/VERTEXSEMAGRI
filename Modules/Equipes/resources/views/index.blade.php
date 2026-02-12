@extends('Co-Admin.layouts.app')

@section('title', 'Equipes')

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
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">Gestão</span>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Recursos Humanos</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            Controle de <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Equipes</span>
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-equipes::button href="{{ route('equipes.create') }}" variant="primary" size="lg" class="shadow-xl bg-indigo-600 hover:bg-indigo-700 border-b-4 border-indigo-800 active:border-b-0 active:translate-y-1 transition-all">
                        <x-icon name="plus" class="w-5 h-5 mr-2" />
                        Nova Equipe
                    </x-equipes::button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-equipes::stat-card
            title="Total de Equipes"
            value="{{ $stats['total'] }}"
            icon="users"
            variant="indigo"
        />
        <x-equipes::stat-card
            title="Equipes Ativas"
            value="{{ $stats['ativas'] }}"
            icon="circle-check"
            variant="success"
        />
        <x-equipes::stat-card
            title="Com Membros"
            value="{{ $stats['com_funcionarios'] }}"
            icon="user-group"
            variant="blue"
        />
        <x-equipes::stat-card
            title="Aguardando Membros"
            value="{{ $stats['sem_funcionarios'] }}"
            icon="user-minus"
            variant="amber"
        />
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 p-4 shadow-sm">
        <form action="{{ route('equipes.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1 w-full">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <x-icon name="magnifying-glass" class="w-5 h-5 text-gray-400" />
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Buscar por nome ou código...">
                </div>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                    <option value="">Status: Todos</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativa</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativa</option>
                </select>
                <div class="flex items-center gap-2">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        <x-icon name="funnel" class="w-4 h-4" />
                        Filtrar
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('equipes.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:hover:bg-slate-600 transition-colors">
                            <x-icon name="x-mark" class="w-4 h-4" />
                            Limpar
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Identificação da Equipe</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Líder Responsável</th>
                        <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Membros</th>
                        <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status Operacional</th>
                        <th class="px-6 py-4 text-right text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($equipes as $equipe)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-all duration-300">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500/10 to-blue-500/10 flex items-center justify-center border border-indigo-500/20 group-hover:scale-110 transition-transform duration-500">
                                        <x-icon module="equipes" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    @if($equipe->ativo)
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white dark:border-slate-800 shadow-sm"></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ $equipe->nome }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $equipe->codigo ?? 'SEM CÓDIGO' }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">{{ ucfirst($equipe->tipo) }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($equipe->lider)
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-700 dark:text-slate-200 text-xs font-black border border-slate-200 dark:border-slate-600">
                                        {{ substr($equipe->lider->name, 0, 1) }}
                                    </div>
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-200">{{ $equipe->lider->name }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-slate-400">
                                    <x-icon name="circle-minus" class="w-4 h-4" />
                                    <span class="text-[10px] font-bold uppercase">Não Definido</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                {{ $equipe->funcionarios->count() }} Membros
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($equipe->ativo)
                                <x-equipes::badge variant="success" class="shadow-sm">Ativa</x-equipes::badge>
                            @else
                                <x-equipes::badge variant="secondary">Inativa</x-equipes::badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                                <x-equipes::button href="{{ route('equipes.show', $equipe->id) }}" variant="secondary" size="sm" class="hover:bg-indigo-600 hover:text-white border-none shadow-none">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </x-equipes::button>
                                <x-equipes::button href="{{ route('equipes.edit', $equipe->id) }}" variant="secondary" size="sm" class="hover:bg-amber-500 hover:text-white border-none shadow-none">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </x-equipes::button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                <div class="relative mb-6">
                                    <div class="absolute inset-0 bg-indigo-500/20 rounded-full blur-2xl animate-pulse"></div>
                                    <div class="relative w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-3xl flex items-center justify-center border border-slate-200 dark:border-slate-700 shadow-xl">
                                        <x-icon module="equipes" class="w-10 h-10 text-slate-400 dark:text-slate-500" />
                                    </div>
                                </div>
                                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">Nenhuma Equipe Encontrada</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-8">
                                    Não existem registros que correspondam aos seus critérios de busca ou ainda não foram cadastradas equipes.
                                </p>
                                <x-equipes::button href="{{ route('equipes.create') }}" variant="primary" size="lg">
                                    <x-icon name="plus" class="w-4 h-4 mr-2" />
                                    Cadastrar Primeira Equipe
                                </x-equipes::button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($equipes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            {{ $equipes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
