@extends('admin.layouts.admin')

@section('title', 'Gestão de Postes - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="utility-pole" style="duotone" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Postes de Iluminação</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.iluminacao.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Iluminação</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Gestão de Postes</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.iluminacao.postes.export') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all shadow-sm">
                <x-icon name="file-export" style="duotone" class="w-5 h-5 text-gray-500" />
                Exportar (Neoenergia)
            </a>
            <a href="{{ route('admin.iluminacao.postes.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition-all shadow-md">
                <x-icon name="plus" style="duotone" class="w-5 h-5" />
                Novo Poste
            </a>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <form action="{{ route('admin.iluminacao.postes.index') }}" method="GET" class="flex gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="pl-10 w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="Buscar por código, logradouro ou bairro...">
            </div>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-all shadow-md">
                Buscar
            </button>
        </form>
    </div>

    <!-- Tabela de Resultados -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Código</th>
                        <th class="px-6 py-4">Logradouro & Bairro</th>
                        <th class="px-6 py-4">Tipo Lâmpada</th>
                        <th class="px-6 py-4">Potência</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($postes as $poste)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all group">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                            {{ $poste->codigo }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-gray-900 dark:text-white font-medium">{{ $poste->logradouro }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $poste->bairro ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-600 dark:text-gray-400 italic text-xs">{{ ucfirst($poste->tipo_lampada ?? 'Não informado') }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $poste->potencia ? $poste->potencia . 'W' : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                             <a href="{{ route('admin.iluminacao.postes.show', $poste->id) }}" class="inline-flex items-center p-2 text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <x-icon name="eye" style="duotone" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <x-icon name="utility-pole" style="duotone" class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" />
                                <p class="text-gray-500 dark:text-gray-400 font-medium">Nenhum poste cadastrado ou encontrado.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900/20 border-t border-gray-200 dark:border-slate-700">
            {{ $postes->links() }}
        </div>
    </div>
</div>
@endsection
