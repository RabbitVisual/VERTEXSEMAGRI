@extends('admin.layouts.admin')

@section('title', 'Água - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Agua" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Água</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="magnifying-glass" class="w-5 h-5" />
                    Filtrar
                </button>
                <a href="{{ route('admin.agua.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela de Redes de Água - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Redes de Água</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Código</th>
                        <th scope="col" class="px-6 py-3">Localidade</th>
                        <th scope="col" class="px-6 py-3">Tipo</th>
                        <th scope="col" class="px-6 py-3">Material</th>
                        <th scope="col" class="px-6 py-3">Diâmetro</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Demandas</th>
                        <th scope="col" class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($redes as $rede)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $rede->codigo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            @if($rede->localidade)
                                <a href="{{ route('admin.localidades.show', $rede->localidade->id) }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                                    {{ $rede->localidade->nome }}
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ ucfirst($rede->tipo_rede ?? '-') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $rede->material ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $rede->diametro ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'funcionando' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'com_vazamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'interrompida' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $statusClass = $statusColors[$rede->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $rede->status ?? '-')) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            @php
                                $totalDemandas = $rede->demandas()->count();
                            @endphp
                            @if($totalDemandas > 0)
                                <a href="{{ route('admin.demandas.index', ['tipo' => 'agua', 'localidade_id' => $rede->localidade_id]) }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                                    {{ $totalDemandas }} demanda(s)
                                </a>
                            @else
                                <span class="text-gray-400">0</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.agua.show', $rede->id) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nenhuma rede de água encontrada</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tente ajustar os filtros de busca</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($redes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $redes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
