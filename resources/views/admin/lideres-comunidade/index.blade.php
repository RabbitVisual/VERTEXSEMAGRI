@extends('admin.layouts.admin')

@section('title', 'Gestão de Líderes Comunitários')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">

    <!-- Page Header Premium -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 dark:bg-blue-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="users" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Líderes de <span class="text-blue-600 dark:text-blue-400">Comunidade</span>
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <span class="text-gray-900 dark:text-white font-bold">Corpo de Agentes</span>
                    </nav>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.lideres-comunidade.create') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95">
                    <x-icon name="plus" class="w-5 h-5 text-white" />
                    Novo Agente
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros Panorâmicos -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/30 dark:bg-slate-900/30 flex items-center gap-2">
            <x-icon name="filter" class="w-5 h-5 text-blue-500" style="duotone" />
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">Filtros de Pesquisa</h3>
        </div>
        <form action="{{ route('admin.lideres-comunidade.index') }}" method="GET" class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <!-- Search -->
                <div class="relative group">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Busca Avançada</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-icon name="magnifying-glass" class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" />
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm font-medium text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                            placeholder="Nome, CPF, Código ou Localidade...">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-col md:flex-row gap-3">
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-3 text-sm font-black text-white bg-slate-900 dark:bg-slate-700 rounded-xl hover:bg-slate-800 dark:hover:bg-slate-600 focus:ring-4 focus:ring-slate-500/20 transition-all shadow-lg active:scale-95">
                    <x-icon name="magnifying-glass" class="w-5 h-5" style="duotone" />
                    Filtrar Resultados
                </button>
                @if(request()->has('search'))
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                    <x-icon name="arrow-rotate-left" class="w-5 h-5" style="duotone" />
                    Limpar
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabela Premium -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                <x-icon name="list" class="w-4 h-4 text-blue-500" style="duotone" />
                Listagem Detalhada
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-50/50 dark:bg-slate-900/50 font-black border-b border-gray-100 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-5">Identidade & Código</th>
                        <th class="px-6 py-5">Jurisdição / Ativo</th>
                        <th class="px-6 py-5 text-center">Contatos</th>
                        <th class="px-6 py-5 text-center">Status</th>
                        <th class="px-6 py-5 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50 font-medium">
                    @forelse($lideres as $lider)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/5 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-sm font-black shadow-sm group-hover:scale-105 transition-transform">
                                    {{ strtoupper(substr($lider->nome, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900 dark:text-white text-base group-hover:text-blue-600 transition-colors">
                                        {{ $lider->nome }}
                                    </span>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter mt-0.5 flex items-center gap-1">
                                        <x-icon name="hashtag" class="w-3 h-3" />
                                        REF: {{ $lider->codigo }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                             <div class="flex flex-col gap-1.5">
                                @if($lider->localidade)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold border border-blue-100 dark:border-blue-800/30 uppercase text-[10px] w-fit">
                                    <x-icon name="map-pin" class="w-3 h-3" />
                                    {{ $lider->localidade->nome }}
                                </span>
                                @else
                                <span class="text-gray-400 text-xs italic">Sem Localidade</span>
                                @endif

                                <span class="text-xs text-slate-500 flex items-center gap-1.5 pl-1">
                                    <x-icon name="droplet" style="duotone" class="w-3.5 h-3.5 text-blue-400" />
                                    {{ $lider->poco->nome_mapa ?? $lider->poco->codigo ?? 'N/D' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                             <div class="flex items-center justify-center gap-2">
                                @if($lider->email || ($lider->user && $lider->user->email))
                                <div class="group/icon relative">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-blue-500 transition-colors">
                                        <x-icon name="envelope" class="w-4 h-4" />
                                    </div>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 text-white text-[10px] rounded opacity-0 group-hover/icon:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                        {{ $lider->email ?? $lider->user->email }}
                                    </span>
                                </div>
                                @endif

                                @if($lider->telefone)
                                <div class="group/icon relative">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-colors">
                                        <x-icon name="phone" class="w-4 h-4" />
                                    </div>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 text-white text-[10px] rounded opacity-0 group-hover/icon:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                        {{ $lider->telefone }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($lider->status === 'ativo')
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full text-[10px] font-black uppercase tracking-wider">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                    Ativo
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 rounded-full text-[10px] font-black uppercase tracking-wider">
                                    <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                    Inativo
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.lideres-comunidade.show', $lider) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm active:scale-95" title="Ver Detalhes">
                                    <x-icon name="eye" class="w-4 h-4" style="duotone" />
                                </a>
                                <a href="{{ route('admin.lideres-comunidade.edit', $lider) }}" class="inline-flex items-center justify-center w-8 h-8 text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm active:scale-95" title="Editar">
                                    <x-icon name="pencil-square" class="w-4 h-4" style="duotone" />
                                </a>
                                <form action="{{ route('admin.lideres-comunidade.destroy', $lider) }}" method="POST" class="inline-block" onsubmit="return confirm('ATENÇÃO: Desativar este líder pode interromper os ciclos de cobrança da localidade. Confirmar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 text-rose-600 bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800 rounded-lg hover:bg-rose-600 hover:text-white transition-all shadow-sm active:scale-95" title="Remover">
                                        <x-icon name="trash" class="w-4 h-4" style="duotone" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center shadow-inner">
                                    <x-icon name="users-slash" class="w-10 h-10 text-slate-200" style="duotone" />
                                </div>
                                <div class="text-center">
                                    <h4 class="text-lg font-bold text-gray-400 uppercase tracking-widest">Nenhum Líder Encontrado</h4>
                                    <p class="text-sm text-gray-400 font-medium">Tente ajustar os filtros de pesquisa.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lideres->hasPages())
        <div class="px-6 py-6 bg-slate-50/50 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-700/50 mx-4 my-4 rounded-2xl">
            {{ $lideres->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
