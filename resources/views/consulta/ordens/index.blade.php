@extends('consulta.layouts.consulta')

@section('title', 'Ordens de Serviço - Consulta')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                    Filtrar
                </button>
                <a href="{{ route('consulta.ordens.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                    Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de Ordens -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Lista de Ordens de Serviço</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Demanda</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Equipe</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Data</th>
                    <th class="px-4 md:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($ordens as $ordem)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->codigo }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white hidden md:table-cell">
                        @if($ordem->demanda)
                            <a href="{{ route('consulta.demandas.show', $ordem->demanda->id) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ $ordem->demanda->codigo }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 hidden lg:table-cell">{{ $ordem->equipe->nome ?? '-' }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $status = ['aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300', 'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300', 'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300', 'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status[$ordem->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">{{ ucfirst(str_replace('_', ' ', $ordem->status)) }}</span>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">{{ $ordem->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('consulta.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Visualizar">
                            <x-icon name="eye" class="w-5 h-5" />
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-icon name="file-pdf" class="w-5 h-5" />
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma ordem de serviço encontrada.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($ordens->hasPages())
    <div class="px-4 md:px-6 py-4 border-t border-gray-200 dark:border-slate-700">
        {{ $ordens->links() }}
    </div>
    @endif
</div>
@endsection

