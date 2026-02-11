@extends('admin.layouts.admin')

@section('title', 'Demandas - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="clipboard-list" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Gestão de Demandas</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium">Demandas</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" style="duotone" />
                Voltar
            </a>
            <a href="{{ route('demandas.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
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

    <!-- Estatísticas Gerais -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Demandas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="clipboard-list" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Abertas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['abertas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50">
                    <x-icon name="clock" class="w-6 h-6 text-blue-600 dark:text-blue-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Em Andamento</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['em_andamento'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="arrows-rotate" class="w-6 h-6 text-amber-600 dark:text-amber-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Concluídas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['concluidas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="circle-check" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas Críticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8 border-t border-slate-200 dark:border-slate-700 pt-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Urgentes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['urgentes'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800/50">
                    <x-icon name="triangle-exclamation" class="w-6 h-6 text-red-600 dark:text-red-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sem Ordem de Serviço</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['sem_os'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-900/20 rounded-xl border border-gray-100 dark:border-gray-800/50">
                    <x-icon name="file-circle-xmark" class="w-6 h-6 text-gray-600 dark:text-gray-400" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas por Tipo -->
    @if(isset($estatisticas['por_tipo']))
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
            <x-icon name="chart-simple" class="w-5 h-5 text-emerald-500" style="duotone" />
            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Demandas por Módulo</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex flex-col items-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="droplet" class="w-8 h-8 text-emerald-600 dark:text-emerald-400 mb-2" style="duotone" />
                    <span class="text-2xl font-bold text-emerald-900 dark:text-white">{{ $estatisticas['por_tipo']['agua'] ?? 0 }}</span>
                    <span class="text-xs font-bold text-emerald-600/60 uppercase tracking-widest">Água</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-2xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="lightbulb" class="w-8 h-8 text-amber-600 dark:text-amber-400 mb-2" style="duotone" />
                    <span class="text-2xl font-bold text-amber-900 dark:text-white">{{ $estatisticas['por_tipo']['luz'] ?? 0 }}</span>
                    <span class="text-xs font-bold text-amber-600/60 uppercase tracking-widest">Iluminação</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-violet-50 dark:bg-violet-900/20 rounded-2xl border border-violet-100 dark:border-violet-800/50">
                    <x-icon name="road" class="w-8 h-8 text-violet-600 dark:text-violet-400 mb-2" style="duotone" />
                    <span class="text-2xl font-bold text-violet-900 dark:text-white">{{ $estatisticas['por_tipo']['estrada'] ?? 0 }}</span>
                    <span class="text-xs font-bold text-violet-600/60 uppercase tracking-widest">Estradas</span>
                </div>
                <div class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-800/50">
                    <x-icon name="faucet" class="w-8 h-8 text-blue-600 dark:text-blue-400 mb-2" style="duotone" />
                    <span class="text-2xl font-bold text-blue-900 dark:text-white">{{ $estatisticas['por_tipo']['poco'] ?? 0 }}</span>
                    <span class="text-xs font-bold text-blue-600/60 uppercase tracking-widest">Poços</span>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
            <x-icon name="filter" class="w-5 h-5 text-emerald-500" style="duotone" />
            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Filtros de Busca</h3>
        </div>
        <form method="GET" action="{{ route('admin.demandas.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="search" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Código, solicitante..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
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
                <div>
                    <label for="localidade_id" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Localidade</label>
                    <select name="localidade_id" id="localidade_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="">Todas</option>
                        @foreach($localidades as $localidade)
                            <option value="{{ $localidade->id }}" {{ ($filters['localidade_id'] ?? '') == $localidade->id ? 'selected' : '' }}>{{ $localidade->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-500/20">
                    <x-icon name="magnifying-glass" class="w-5 h-5" style="duotone" />
                    Filtrar Demandas
                </button>
                <a href="{{ route('admin.demandas.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
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
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Código</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Solicitante</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Localidade</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-center">Tipo</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-center">Prioridade</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($demandas as $demanda)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900 dark:text-white">{{ $demanda->codigo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-700 dark:text-slate-200">{{ $demanda->solicitante_nome }}</span>
                                @if($demanda->solicitante_apelido)
                                    <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">"{{ $demanda->solicitante_apelido }}"</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $demanda->localidade->nome ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $tipoIcons = [
                                    'agua' => ['icon' => 'droplet', 'color' => 'text-emerald-500'],
                                    'luz' => ['icon' => 'lightbulb', 'color' => 'text-amber-500'],
                                    'estrada' => ['icon' => 'road', 'color' => 'text-violet-500'],
                                    'poco' => ['icon' => 'faucet', 'color' => 'text-blue-500']
                                ];
                                $tipo = $tipoIcons[$demanda->tipo] ?? ['icon' => 'question', 'color' => 'text-slate-400'];
                            @endphp
                            <div class="flex flex-col items-center">
                                <x-icon :name="$tipo['icon']" class="w-5 h-5 {{ $tipo['color'] }}" style="duotone" />
                                <span class="text-[8px] font-bold uppercase mt-1 text-slate-400 tracking-tighter">{{ $demanda->tipo }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $prioColors = [
                                    'baixa' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'media' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'alta' => 'bg-orange-50 text-orange-700 border-orange-100',
                                    'urgente' => 'bg-red-50 text-red-700 border-red-100'
                                ];
                                $prioClass = $prioColors[$demanda->prioridade] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                            @endphp
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg border {{ $prioClass }} uppercase">
                                {{ $demanda->prioridade }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $statusColors = [
                                    'aberta' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'em_andamento' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'concluida' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'cancelada' => 'bg-slate-50 text-slate-700 border-slate-100'
                                ];
                                $statusClass = $statusColors[$demanda->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                            @endphp
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg border {{ $statusClass }} uppercase">
                                {{ str_replace('_', ' ', $demanda->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.demandas.show', $demanda->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 transition-all shadow-sm" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" style="duotone" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 font-medium">Nenhuma demanda localizada com os filtros atuais.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($demandas->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $demandas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
