@extends('admin.layouts.admin')

@section('title', 'Localidades - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="map-location-dot" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Gestão de Localidades</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium">Localidades</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" style="duotone" />
                Voltar
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
            <x-icon name="filter" class="w-5 h-5 text-emerald-500" style="duotone" />
            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Filtros de Busca</h3>
        </div>
        <form method="GET" action="{{ route('admin.localidades.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Nome ou Código</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Buscar localidade..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-500/20">
                    <x-icon name="magnifying-glass" class="w-5 h-5" style="duotone" />
                    Filtrar Resultados
                </button>
                <a href="{{ route('admin.localidades.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                    <x-icon name="rotate-right" class="w-5 h-5" style="duotone" />
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Nome da Localidade</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Código</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-center">Tipo</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($localidades as $localidade)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center border border-emerald-100 dark:border-emerald-800/50">
                                    <x-icon name="location-dot" class="w-4 h-4 text-emerald-600" style="duotone" />
                                </div>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $localidade->nome }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-black text-slate-400">{{ $localidade->codigo ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg border bg-slate-50 text-slate-600 border-slate-100 uppercase">
                                {{ $localidade->tipo ?? 'N/D' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($localidade->ativo)
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg border bg-emerald-50 text-emerald-700 border-emerald-100 uppercase">Ativo</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg border bg-red-50 text-red-700 border-red-100 uppercase">Inativo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.localidades.show', $localidade->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 transition-all shadow-sm" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" style="duotone" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-bold italic">Nenhuma localidade localizada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($localidades->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $localidades->links() }}
        </div>
        @endif
    </div>
</div>
@endsection





