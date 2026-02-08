@extends('admin.layouts.admin')

@section('title', 'Solicitações de Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="file-invoice" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Solicitações de Materiais</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Solicitações</span>
            </nav>
        </div>
        <a href="{{ route('admin.materiais.solicitar.create') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all">
            <x-icon name="plus" class="w-5 h-5" />
            Nova Solicitação
        </a>
    </div>

    <!-- Filtros - Modern Panel -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <form method="GET" action="{{ route('admin.materiais.solicitacoes.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">Buscar Solicitação</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <x-icon name="magnifying-glass" class="w-4 h-4" />
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 p-3 dark:bg-slate-900 dark:border-slate-700 dark:placeholder-gray-500 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all font-medium"
                            placeholder="Número, secretário, servidor ou cidade...">
                    </div>
                </div>
                <div>
                    <label for="ano" class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">Ano</label>
                    <select name="ano" id="ano"
                        class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all font-medium">
                        <option value="">Todos os anos</option>
                        @foreach($anos as $anoOption)
                            <option value="{{ $anoOption }}" {{ request('ano') == $anoOption ? 'selected' : '' }}>{{ $anoOption }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.materiais.solicitacoes.index') }}" class="p-3 text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 bg-gray-50 dark:bg-slate-900/50 rounded-xl transition-colors border border-transparent hover:border-emerald-200">
                        <x-icon name="rotate-right" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela de Solicitações -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        @if($solicitacoes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 dark:bg-slate-900/50 text-[10px] uppercase tracking-widest font-bold text-gray-400">
                        <tr>
                            <th class="px-6 py-4">Ofício / Data</th>
                            <th class="px-6 py-4">Local / Secretário</th>
                            <th class="px-6 py-4">Responsável</th>
                            <th class="px-6 py-4">Gerado por</th>
                            <th class="px-6 py-4 text-right pr-10">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($solicitacoes as $solicitacao)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-900/40 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">
                                        {{ $solicitacao->numero_oficio }}
                                    </div>
                                    <div class="text-[10px] text-gray-500 uppercase tracking-tighter">
                                        {{ $solicitacao->data->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $solicitacao->cidade }}
                                    </div>
                                    <div class="text-xs text-gray-500 italic">
                                        {{ $solicitacao->secretario_nome }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $solicitacao->servidor_nome }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 uppercase font-bold">
                                        {{ $solicitacao->servidor_cargo }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center gap-2 px-2 py-1 rounded-lg bg-gray-50 dark:bg-slate-900 text-xs text-gray-600 dark:text-gray-400 font-medium">
                                        <x-icon name="user" class="w-3 h-3" />
                                        {{ $solicitacao->usuario->name ?? 'Sistema' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right pr-10">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.materiais.solicitacoes.show', $solicitacao->id) }}"
                                           target="_blank" title="Visualizar Ofício"
                                           class="p-2 text-emerald-600 hover:text-white bg-emerald-50 hover:bg-emerald-600 dark:bg-emerald-900/20 dark:hover:bg-emerald-600 rounded-lg transition-all shadow-sm">
                                            <x-icon name="file-pdf" class="w-5 h-5" />
                                        </a>

                                        @if($solicitacao->verificarIntegridade())
                                            <div title="Documento íntegro" class="p-2 text-emerald-500 bg-emerald-50 dark:bg-emerald-900/10 rounded-lg">
                                                <x-icon name="shield-check" class="w-5 h-5" />
                                            </div>
                                        @else
                                            <div title="Falha na integridade" class="p-2 text-red-500 bg-red-50 dark:bg-red-900/10 rounded-lg animate-pulse">
                                                <x-icon name="triangle-exclamation" class="w-5 h-5" />
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($solicitacoes->hasPages())
            <div class="px-6 py-4 bg-gray-50/30 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-700">
                {{ $solicitacoes->links() }}
            </div>
            @endif
        @else
            <div class="p-16 text-center">
                <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900/50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <x-icon name="file-circle-xmark" class="w-10 h-10 text-gray-300" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sem solicitações</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">Nenhuma solicitação de material foi encontrada para os filtros aplicados.</p>
                <a href="{{ route('admin.materiais.solicitar.create') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all">
                    <x-icon name="plus" class="w-5 h-5" />
                    Criar Minha Primeira Solicitação
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
