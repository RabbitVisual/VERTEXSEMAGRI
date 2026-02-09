@extends('Co-Admin.layouts.app')

@section('title', 'Equipes')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon module="equipes" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Equipes</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                <span class="text-gray-900 dark:text-white font-medium">Equipes</span>
            </nav>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('equipes.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors shadow-sm">
                <x-icon name="plus-circle" class="w-5 h-5" />
                Nova Equipe
            </a>
        </div>
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
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4">Equipe</th>
                        <th scope="col" class="px-6 py-4">Líder</th>
                        <th scope="col" class="px-6 py-4 text-center">Membros</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($equipes as $equipe)
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs shadow-sm">
                                    {{ substr($equipe->codigo ?? 'N/A', 0, 3) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $equipe->nome }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($equipe->tipo) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($equipe->lider)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 text-xs font-bold">
                                        {{ substr($equipe->lider->name, 0, 1) }}
                                    </div>
                                    <span class="text-gray-900 dark:text-white text-sm">{{ $equipe->lider->name }}</span>
                                </div>
                            @else
                                <span class="text-gray-400 dark:text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ $equipe->funcionarios->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($equipe->ativo)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Ativa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Inativa
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('equipes.show', $equipe->id) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg dark:text-gray-400 dark:hover:text-indigo-400 dark:hover:bg-indigo-900/20 transition-all" title="Ver Detalhes">
                                    <x-icon name="eye" class="w-5 h-5" />
                                </a>
                                <a href="{{ route('equipes.edit', $equipe->id) }}" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 transition-all" title="Editar">
                                    <x-icon name="pencil" class="w-5 h-5" />
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                    <x-icon name="magnifying-glass" class="w-8 h-8 text-gray-400 dark:text-gray-500" />
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Nenhuma equipe encontrada</h3>
                                <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                                    Não encontramos equipes com os filtros atuais. Tente limpar os filtros ou criar uma nova equipe.
                                </p>
                                <a href="{{ route('equipes.create') }}" class="mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors text-sm font-medium inline-flex items-center gap-2">
                                    <x-icon name="plus" class="w-4 h-4" />
                                    Criar Equipe
                                </a>
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
