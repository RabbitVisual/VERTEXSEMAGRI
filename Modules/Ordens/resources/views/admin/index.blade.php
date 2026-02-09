@extends('admin.layouts.admin')

@section('title', 'Ordens de Serviço - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="screwdriver-wrench" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Ordens de Serviço</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium">Ordens de Serviço</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" style="duotone" />
                Voltar
            </a>
            <a href="{{ route('ordens.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <x-icon name="eye" class="w-5 h-5" style="duotone" />
                Ver Painel Padrão
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <x-icon name="circle-check" class="w-4 h-4 me-3" style="duotone" />
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 md:gap-6 border-b border-gray-200 dark:border-slate-700 pb-8 mb-8">
        <div class="p-4 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $estatisticas['total'] ?? 0 }}</p>
                <x-icon name="files" class="w-6 h-6 text-indigo-500 opacity-20" style="duotone" />
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-1">Abertas</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-black text-blue-600 dark:text-blue-400 leading-none">{{ $estatisticas['abertas'] ?? 0 }}</p>
                <x-icon name="file-circle-plus" class="w-6 h-6 text-blue-500 opacity-20" style="duotone" />
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <p class="text-xs font-bold text-amber-400 uppercase tracking-widest mb-1">Andamento</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 leading-none">{{ $estatisticas['em_andamento'] ?? 0 }}</p>
                <x-icon name="arrows-rotate" class="w-6 h-6 text-amber-500 opacity-20" style="duotone" />
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <p class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-1">Concluídas</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 leading-none">{{ $estatisticas['concluidas'] ?? 0 }}</p>
                <x-icon name="file-circle-check" class="w-6 h-6 text-emerald-500 opacity-20" style="duotone" />
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <p class="text-xs font-bold text-red-400 uppercase tracking-widest mb-1">Canceladas</p>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-black text-red-600 dark:text-red-400 leading-none">{{ $estatisticas['canceladas'] ?? 0 }}</p>
                <x-icon name="file-circle-xmark" class="w-6 h-6 text-red-500 opacity-20" style="duotone" />
            </div>
        </div>
    </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
            <x-icon name="filter" class="w-5 h-5 text-emerald-500" style="duotone" />
            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Filtros de Busca</h3>
        </div>
        <form method="GET" action="{{ route('admin.ordens.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Código, descrição..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>
                <div>
                    <label for="status" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</label>
                    <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="">Todos</option>
                        <option value="aberta" {{ ($filters['status'] ?? '') == 'aberta' ? 'selected' : '' }}>Aberta</option>
                        <option value="em_andamento" {{ ($filters['status'] ?? '') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="concluida" {{ ($filters['status'] ?? '') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                        <option value="cancelada" {{ ($filters['status'] ?? '') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div>
                    <label for="tipo" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Tipo</label>
                    <select name="tipo" id="tipo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="">Todos</option>
                        <option value="agua" {{ ($filters['tipo'] ?? '') == 'agua' ? 'selected' : '' }}>Água</option>
                        <option value="luz" {{ ($filters['tipo'] ?? '') == 'luz' ? 'selected' : '' }}>Iluminação</option>
                        <option value="estrada" {{ ($filters['tipo'] ?? '') == 'estrada' ? 'selected' : '' }}>Estrada</option>
                        <option value="poco" {{ ($filters['tipo'] ?? '') == 'poco' ? 'selected' : '' }}>Poço</option>
                    </select>
                </div>
                <div>
                    <label for="prioridade" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Prioridade</label>
                    <select name="prioridade" id="prioridade" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="">Todas</option>
                        <option value="baixa" {{ ($filters['prioridade'] ?? '') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ ($filters['prioridade'] ?? '') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta" {{ ($filters['prioridade'] ?? '') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="urgente" {{ ($filters['prioridade'] ?? '') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-500/20">
                    <x-icon name="magnifying-glass" class="w-5 h-5" style="duotone" />
                    Filtrar Ordens
                </button>
                <a href="{{ route('admin.ordens.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
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
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Nº Ordem</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Demanda Ref.</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Equipe Responsável</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-center">Data Abertura</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($ordens as $ordem)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap font-black text-slate-900 dark:text-white">{{ $ordem->numero }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($ordem->demanda)
                                <div class="flex items-center gap-2">
                                    <x-icon name="clipboard-list" class="w-4 h-4 text-emerald-500" style="duotone" />
                                    <a href="{{ route('admin.demandas.show', $ordem->demanda->id) }}" class="font-bold text-emerald-600 hover:underline">
                                        {{ $ordem->demanda->codigo }}
                                    </a>
                                </div>
                            @else
                                <span class="text-slate-300 font-medium italic">Sem vínculo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center border border-slate-200 dark:border-slate-600">
                                    <x-icon name="users-gear" class="w-4 h-4 text-slate-500" style="duotone" />
                                </div>
                                <span class="font-bold text-slate-700 dark:text-slate-200">{{ $ordem->equipe->nome ?? 'Pendente' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $statusColors = [
                                    'aberta' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'em_andamento' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'concluida' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'cancelada' => 'bg-red-50 text-red-700 border-red-100'
                                ];
                                $statusClass = $statusColors[$ordem->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                            @endphp
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border {{ $statusClass }} uppercase">
                                {{ str_replace('_', ' ', $ordem->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-slate-500 font-medium italic">
                            {{ $ordem->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 transition-all shadow-sm" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" style="duotone" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-bold italic">Nenhuma ordem de serviço registrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ordens->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $ordens->links() }}
        </div>
        @endif
    </div>
</div>
@endsection





