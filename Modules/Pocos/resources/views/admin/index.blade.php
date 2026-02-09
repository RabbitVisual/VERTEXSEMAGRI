@extends('admin.layouts.admin')

@section('title', 'Poços - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="bore-hole" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Poços</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium">Poços</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" style="duotone" />
                Voltar
            </a>
            <a href="{{ route('pocos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
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
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Poços</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['pocos']['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="bore-hole" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['pocos']['ativos'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="circle-check" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Em Manutenção</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['pocos']['em_manutencao'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="screwdriver-wrench" class="w-6 h-6 text-amber-600 dark:text-amber-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Com Problemas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['pocos']['com_problemas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800/50">
                    <x-icon name="circle-xmark" class="w-6 h-6 text-red-600 dark:text-red-400" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas de Demandas e Ordens -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8 border-t border-slate-200 dark:border-slate-700 pt-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['demandas']['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50">
                    <x-icon name="clipboard-list" class="w-6 h-6 text-blue-600 dark:text-blue-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas Abertas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['demandas']['abertas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-100 dark:border-yellow-800/50">
                    <x-icon name="clock" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens de Serviço</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['ordens']['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800/50">
                    <x-icon name="toolbox" class="w-6 h-6 text-purple-600 dark:text-purple-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens Concluídas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['ordens']['concluidas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="circle-check" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" style="duotone" />
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
            <x-icon name="filter" class="w-5 h-5 text-blue-500" style="duotone" />
            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Filtros de Busca</h3>
        </div>
        <form method="GET" action="{{ route('admin.pocos.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="space-y-1">
                    <label for="search" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Buscar</label>
                    <div class="relative">
                        <x-icon name="magnifying-glass" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" style="duotone" />
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Código, endereço..." class="bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>
                <div class="space-y-1">
                    <label for="status" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</label>
                    <select name="status" id="status" class="bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">Todos</option>
                        <option value="ativo" {{ ($filters['status'] ?? '') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ ($filters['status'] ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                        <option value="manutencao" {{ ($filters['status'] ?? '') == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="localidade_id" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Localidade</label>
                    <select name="localidade_id" id="localidade_id" class="bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">Todas</option>
                        @foreach($localidades as $localidade)
                            <option value="{{ $localidade->id }}" {{ ($filters['localidade_id'] ?? '') == $localidade->id ? 'selected' : '' }}>{{ $localidade->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="equipe_responsavel_id" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Equipe Responsável</label>
                    <select name="equipe_responsavel_id" id="equipe_responsavel_id" class="bg-slate-50 border border-slate-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">Todas</option>
                        @foreach($equipes as $equipe)
                            <option value="{{ $equipe->id }}" {{ ($filters['equipe_responsavel_id'] ?? '') == $equipe->id ? 'selected' : '' }}>{{ $equipe->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all shadow-lg shadow-blue-500/20">
                    <x-icon name="magnifying-glass" class="w-5 h-5" style="duotone" />
                    Filtrar Resultados
                </button>
                <a href="{{ route('admin.pocos.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 focus:ring-4 focus:ring-slate-100 transition-all">
                    <x-icon name="rotate-right" class="w-5 h-5" style="duotone" />
                    Limpar Filtros
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela de Poços -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                <x-icon name="list-ul" class="w-4 h-4 text-blue-500" style="duotone" />
                Lista de Registros de Poços
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-slate-400 uppercase bg-slate-50/30 dark:bg-slate-900/30">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-widest">Código</th>
                        <th class="px-6 py-4 font-bold tracking-widest">Endereço</th>
                        <th class="px-6 py-4 font-bold tracking-widest">Localidade</th>
                        <th class="px-6 py-4 font-bold tracking-widest">Tipo Bomba</th>
                        <th class="px-6 py-4 font-bold tracking-widest">Status</th>
                        <th class="px-6 py-4 font-bold tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($pocos as $poco)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">{{ $poco->codigo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 font-medium">{{ $poco->endereco ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold">
                                {{ $poco->localidade->nome ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500 uppercase text-[11px] font-black tracking-wider">
                            {{ $poco->tipo_bomba ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'ativo' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50',
                                    'inativo' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800/50',
                                    'manutencao' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50'
                                ];
                                $statusClass = $statusColors[$poco->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                            @endphp
                            <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-lg border {{ $statusClass }}">
                                {{ $poco->status ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.pocos.show', $poco->id) }}" class="inline-flex items-center justify-center w-9 h-9 text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl hover:bg-blue-100 transition-all shadow-sm" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" style="duotone" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-900 rounded-full flex items-center justify-center text-slate-300">
                                    <x-icon name="bore-hole" class="w-8 h-8 opacity-20" style="duotone" />
                                </div>
                                <p class="text-sm font-medium text-slate-400 uppercase tracking-widest">Nenhum poço encontrado</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pocos->hasPages())
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-slate-900/50 border-t border-gray-200 dark:border-slate-700/50">
            {{ $pocos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection





