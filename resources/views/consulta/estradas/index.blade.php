@extends('consulta.layouts.consulta')

@section('title', 'Estradas - Consulta')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>
                </div>
                <span>Estradas</span>
                <span class="text-sm md:text-base bg-blue-500/20 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full border border-blue-300 dark:border-blue-700">Somente Leitura</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('consulta.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Consulta</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Estradas</span>
            </nav>
        </div>
        <a href="{{ route('consulta.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-300">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Voltar</span>
        </a>
    </div>

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total de Trechos</h3>
            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['total'] ?? 0 }}</p>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Bom Estado</h3>
            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['bom'] ?? 0 }}</p>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Regular</h3>
            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['regular'] ?? 0 }}</p>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Ruim</h3>
            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['ruim'] ?? 0 }}</p>
        </div>
    </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-4 md:p-6">
        <form action="{{ route('consulta.estradas.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou localidade..." class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            <div class="flex flex-wrap gap-2">
                <select name="estado" class="px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Todos os Estados</option>
                    <option value="bom" {{ request('estado') == 'bom' ? 'selected' : '' }}>Bom</option>
                    <option value="regular" {{ request('estado') == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="ruim" {{ request('estado') == 'ruim' ? 'selected' : '' }}>Ruim</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
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
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Localidade</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Extensão</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-4 md:px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($trechos as $trecho)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $trecho->nome }}</div>
                            @if($trecho->codigo)
                            <div class="text-xs text-orange-600 dark:text-orange-400">{{ $trecho->codigo }}</div>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                            <span class="text-sm text-gray-900 dark:text-white">{{ $trecho->localidade->nome ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            <span class="text-sm text-gray-900 dark:text-white">{{ $trecho->extensao ?? 'N/A' }} km</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                            @php
                                $estadoClasses = [
                                    'bom' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                    'regular' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                    'ruim' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                ];
                                $estado = strtolower($trecho->estado ?? 'regular');
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoClasses[$estado] ?? $estadoClasses['regular'] }}">
                                {{ ucfirst($trecho->estado ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('consulta.estradas.show', $trecho->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors" title="Ver detalhes">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                                </svg>
                            </div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Nenhuma estrada encontrada</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Não há trechos cadastrados no momento.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($trechos, 'links') && $trechos->hasPages())
        <div class="px-4 md:px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $trechos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

