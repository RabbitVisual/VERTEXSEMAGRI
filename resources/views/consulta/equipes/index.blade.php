@extends('consulta.layouts.consulta')

@section('title', 'Equipes - Consulta')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                </button>
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-900/50">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Nome</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Código</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Membros</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 md:px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($equipes as $equipe)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $equipe->nome }}</div>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                            <span class="text-violet-600 dark:text-violet-400 font-medium text-sm">{{ $equipe->codigo ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ ucfirst($equipe->tipo ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            <span class="inline-flex items-center gap-1 text-sm text-gray-900 dark:text-white">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Nenhuma equipe encontrada</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Não há equipes cadastradas no momento.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($equipes, 'links') && $equipes->hasPages())
        <div class="px-4 md:px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $equipes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

