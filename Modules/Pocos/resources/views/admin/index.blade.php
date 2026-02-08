@extends('admin.layouts.admin')

@section('title', 'Poços - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Pocos" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Poços</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="magnifying-glass" class="w-5 h-5" />
                    Filtrar
                </button>
                <a href="{{ route('admin.pocos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela de Poços - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lista de Poços</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Código</th>
                        <th scope="col" class="px-6 py-3">Endereço</th>
                        <th scope="col" class="px-6 py-3">Localidade</th>
                        <th scope="col" class="px-6 py-3">Tipo Bomba</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pocos as $poco)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $poco->codigo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $poco->endereco ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $poco->localidade->nome ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ ucfirst($poco->tipo_bomba ?? '-') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'ativo' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'inativo' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'manutencao' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300'
                                ];
                                $statusClass = $statusColors[$poco->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst($poco->status ?? '-') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.pocos.show', $poco->id) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                            Nenhum poço encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pocos->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $pocos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
