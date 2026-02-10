@extends('admin.layouts.admin')

@section('title', 'Solicitações de Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="file-invoice" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Expedição & Ofícios
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white font-bold">Histórico de Solicitações</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.solicitar.create') }}" class="inline-flex items-center gap-3 px-6 py-3.5 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/40 transition-all duration-300 active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="plus" style="duotone" class="w-5 h-5" />
                    Gerar Nova Solicitação
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros - Advanced Search -->
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-md">
        <form method="GET" action="{{ route('admin.materiais.solicitacoes.index') }}" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <div class="md:col-span-6 lg:col-span-7">
                    <label for="search" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest pl-1 mb-2 block">Parâmetros de Busca</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="magnifying-glass" style="duotone" class="w-5 h-5" />
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner"
                            placeholder="Pesquisar por Ofício, Cidade, Secretário ou Servidor...">
                    </div>
                </div>

                <div class="md:col-span-3 lg:col-span-2">
                    <label for="ano" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest pl-1 mb-2 block">Ciclo Anual</label>
                    <div class="relative group">
                         <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors z-10">
                            <x-icon name="calendar-days" style="duotone" class="w-4 h-4" />
                        </div>
                        <select name="ano" id="ano"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner appearance-none relative">
                            <option value="">Todos os Anos</option>
                            @foreach($anos as $anoOption)
                                <option value="{{ $anoOption }}" {{ request('ano') == $anoOption ? 'selected' : '' }}>Exercício {{ $anoOption }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                             <x-icon name="chevron-down" class="w-3 h-3" />
                        </div>
                    </div>
                </div>

                <div class="md:col-span-3 lg:col-span-3 flex items-end gap-3">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 text-sm font-black text-white bg-slate-900 dark:bg-emerald-600 rounded-2xl hover:bg-black dark:hover:bg-emerald-700 transition-all shadow-lg active:scale-95">
                        <x-icon name="filter" style="duotone" class="w-4 h-4" />
                        Refinar
                    </button>
                    <a href="{{ route('admin.materiais.solicitacoes.index') }}" title="Limpar Filtros" class="p-4 text-slate-400 hover:text-emerald-600 bg-slate-50 dark:bg-slate-900 rounded-2xl transition-all shadow-inner border border-transparent hover:border-emerald-200 active:rotate-180 duration-500">
                        <x-icon name="rotate-right" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela de Solicitações - Glass Design -->
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        @if($solicitacoes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identificação / Vigência</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Destinação & Autoridade</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Responsável Técnico</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Protocolado por</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-slate-700">
                        @foreach($solicitacoes as $solicitacao)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-all duration-300 shadow-sm">
                                            <x-icon name="file-invoice" style="duotone" class="w-6 h-6" />
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors text-base">
                                                {{ $solicitacao->numero_oficio }}
                                            </div>
                                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">
                                                <x-icon name="calendar-day" class="w-3 h-3 inline mr-1" />
                                                {{ $solicitacao->data->format('d M, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2 mb-1">
                                         <x-icon name="location-dot" style="duotone" class="w-3.5 h-3.5 text-emerald-500" />
                                         <span class="font-bold text-gray-900 dark:text-white">{{ $solicitacao->cidade }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 font-medium pl-5 border-l-2 border-emerald-100 dark:border-emerald-900/30">
                                        {{ $solicitacao->secretario_nome }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-bold text-gray-900 dark:text-white mb-1">
                                        {{ $solicitacao->servidor_nome }}
                                    </div>
                                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-tighter bg-slate-50 dark:bg-slate-900 px-2 py-0.5 rounded-md border border-slate-100 dark:border-slate-700 inline-block">
                                        {{ $solicitacao->servidor_cargo }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-50 dark:bg-slate-900 text-[10px] text-slate-500 dark:text-slate-400 font-black uppercase tracking-widest border border-slate-100 dark:border-slate-700">
                                        <x-icon name="user" style="duotone" class="w-3 h-3 text-emerald-500" />
                                        {{ explode(' ', $solicitacao->usuario->name ?? 'Sistema')[0] }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($solicitacao->verificarIntegridade())
                                            <div title="Documento Digitalmente Íntegro" class="w-10 h-10 flex items-center justify-center text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100/50 dark:border-emerald-800/20 transition-transform hover:scale-110">
                                                <x-icon name="shield-check" style="duotone" class="w-5 h-5" />
                                            </div>
                                        @else
                                            <div title="Violação de Integridade Detectada" class="w-10 h-10 flex items-center justify-center text-red-500 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100/50 dark:border-red-800/20 animate-pulse">
                                                <x-icon name="triangle-exclamation" style="duotone" class="w-5 h-5" />
                                            </div>
                                        @endif

                                        <a href="{{ route('admin.materiais.solicitacoes.show', $solicitacao->id) }}"
                                           target="_blank"
                                           class="w-10 h-10 flex items-center justify-center text-blue-600 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100/50 dark:border-blue-800/20 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                            <x-icon name="file-pdf" style="duotone" class="w-5 h-5" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($solicitacoes->hasPages())
            <div class="px-8 py-6 bg-gray-50/30 dark:bg-slate-900/30 border-t border-gray-100 dark:divide-slate-700">
                {{ $solicitacoes->links() }}
            </div>
            @endif
        @else
            <div class="p-20 text-center">
                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-900/50 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner border-2 border-dashed border-slate-200 dark:border-slate-700">
                    <x-icon name="file-circle-xmark" style="duotone" class="w-12 h-12 text-slate-300" />
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Sem Registros Localizados</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-10 max-w-sm mx-auto font-medium leading-relaxed">Não encontramos nenhuma solicitação que atenda aos critérios da busca. Tente ajustar os filtros ou criar um novo ofício.</p>
                <a href="{{ route('admin.materiais.solicitar.create') }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/40 transition-all active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="plus" style="duotone" class="w-5 h-5" />
                    Emitir Primeira Solicitação
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
