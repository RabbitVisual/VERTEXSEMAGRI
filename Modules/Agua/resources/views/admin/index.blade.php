@extends('admin.layouts.admin')

@section('title', 'Água - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="droplet" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Gestão de Água</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium">Água</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" style="duotone" />
                Voltar
            </a>
            <a href="{{ route('agua.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
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

    <!-- Estatísticas de Redes -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Redes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['redes']['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="diagram-project" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['redes']['funcionando'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="circle-check" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Com Vazamento</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['redes']['com_vazamento'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="faucet-drip" class="w-6 h-6 text-amber-600 dark:text-amber-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Interrompidas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['redes']['interrompida'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800/50">
                    <x-icon name="circle-xmark" class="w-6 h-6 text-red-600 dark:text-red-400" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas de Pontos, Demandas e Ordens -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8 border-t border-slate-200 dark:border-slate-700 pt-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Distribuição</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['pontos']['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50">
                    <x-icon name="location-dot" class="w-6 h-6 text-blue-600 dark:text-blue-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['demandas']['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800/50">
                    <x-icon name="clipboard-list" class="w-6 h-6 text-purple-600 dark:text-purple-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Abertas</p>
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
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens S.</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['ordens']['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-teal-50 dark:bg-teal-900/20 rounded-xl border border-teal-100 dark:border-teal-800/50">
                    <x-icon name="screwdriver-wrench" class="w-6 h-6 text-teal-600 dark:text-teal-400" style="duotone" />
                </div>
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
        <form method="GET" action="{{ route('admin.agua.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Código, material..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                <div>
                    <label for="status" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</label>
                    <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="">Todos</option>
                        <option value="funcionando" {{ ($filters['status'] ?? '') == 'funcionando' ? 'selected' : '' }}>Funcionando</option>
                        <option value="com_vazamento" {{ ($filters['status'] ?? '') == 'com_vazamento' ? 'selected' : '' }}>Com Vazamento</option>
                        <option value="interrompida" {{ ($filters['status'] ?? '') == 'interrompida' ? 'selected' : '' }}>Interrompida</option>
                    </select>
                </div>
                <div>
                    <label for="tipo_rede" class="block mb-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Tipo de Rede</label>
                    <select name="tipo_rede" id="tipo_rede" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="">Todos</option>
                        <option value="principal" {{ ($filters['tipo_rede'] ?? '') == 'principal' ? 'selected' : '' }}>Principal</option>
                        <option value="secundaria" {{ ($filters['tipo_rede'] ?? '') == 'secundaria' ? 'selected' : '' }}>Secundária</option>
                        <option value="ramal" {{ ($filters['tipo_rede'] ?? '') == 'ramal' ? 'selected' : '' }}>Ramal</option>
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
                    Filtrar Resultados
                </button>
                <a href="{{ route('admin.agua.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
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
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Localidade</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Tipo / Material</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Diâmetro</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($redes as $rede)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900 dark:text-white">{{ $rede->codigo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <x-icon name="location-dot" class="w-4 h-4 text-slate-300" style="duotone" />
                                <span class="font-medium">{{ $rede->localidade->nome ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-700 dark:text-slate-200">{{ ucfirst($rede->tipo_rede ?? '-') }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $rede->material ?? 'N/D' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-600 dark:text-slate-400">{{ $rede->diametro ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'funcionando' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50',
                                    'com_vazamento' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50',
                                    'interrompida' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50'
                                ];
                                $statusClass = $statusColors[$rede->status] ?? 'bg-slate-50 text-slate-700 border-slate-100 dark:bg-slate-900/20 dark:text-slate-400 dark:border-slate-800/50';
                            @endphp
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border {{ $statusClass }} uppercase">
                                {{ str_replace('_', ' ', $rede->status ?? '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.agua.show', $rede->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 transition-all shadow-sm" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" style="duotone" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-900/50 rounded-2xl flex items-center justify-center mb-4">
                                    <x-icon name="droplet-slash" class="w-8 h-8 text-slate-300" style="duotone" />
                                </div>
                                <h4 class="text-lg font-bold text-slate-800 dark:text-white">Nenhuma rede localizada</h4>
                                <p class="text-sm text-slate-500 mt-1">Tente ajustar seus filtros para encontrar o que procura.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($redes->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $redes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection





