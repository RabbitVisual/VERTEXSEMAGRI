@extends('admin.layouts.admin')

@section('title', 'Iluminação - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="lightbulb" style="duotone" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Iluminação</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Iluminação</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.iluminacao.export') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-all shadow-sm">
                <x-icon name="file-export" style="duotone" class="w-5 h-5 text-gray-500" />
                Exportar Auditoria
            </a>
            <a href="{{ route('admin.iluminacao.postes.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800 transition-all shadow-md">
                <x-icon name="utility-pole" style="duotone" class="w-5 h-5" />
                Gerenciar Postes
            </a>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de Pontos</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['pontos']['total'] ?? 0 }}</p>
                </div>
                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-2xl flex items-center justify-center border border-yellow-100 dark:border-yellow-800/50 group-hover:scale-110 transition-transform">
                    <x-icon name="lightbulb" style="duotone" class="w-7 h-7 text-yellow-600 dark:text-yellow-400" />
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $estatisticas['pontos']['funcionando'] ?? 0 }} funcionando</span>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Com Defeito</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $estatisticas['pontos']['com_defeito'] ?? 0 }}</p>
                </div>
                <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center border border-red-100 dark:border-red-800/50 group-hover:scale-110 transition-transform">
                    <x-icon name="triangle-exclamation" style="duotone" class="w-7 h-7 text-red-600 dark:text-red-400" />
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Demandas Abertas</p>
                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $estatisticas['demandas']['abertas'] ?? 0 }}</p>
                </div>
                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center border border-amber-100 dark:border-amber-800/50 group-hover:scale-110 transition-transform">
                    <x-icon name="clipboard-list" style="duotone" class="w-7 h-7 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">O.S. Pendentes</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $estatisticas['ordens']['pendentes'] ?? 0 }}</p>
                </div>
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center border border-blue-100 dark:border-blue-800/50 group-hover:scale-110 transition-transform">
                    <x-icon name="toolbox" style="duotone" class="w-7 h-7 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <form action="{{ route('admin.iluminacao.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Busca</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <x-icon name="magnifying-glass" class="w-5 h-5" />
                        </div>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="pl-10 w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-yellow-500 focus:border-yellow-500 transition-all" placeholder="Código, endereço ou localidade...">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                        <option value="">Todos</option>
                        <option value="funcionando" {{ ($filters['status'] ?? '') == 'funcionando' ? 'selected' : '' }}>Funcionando</option>
                        <option value="com_defeito" {{ ($filters['status'] ?? '') == 'com_defeito' ? 'selected' : '' }}>Com Defeito</option>
                        <option value="desligado" {{ ($filters['status'] ?? '') == 'desligado' ? 'selected' : '' }}>Desligado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Localidade</label>
                    <select name="localidade_id" class="w-full rounded-xl border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                        <option value="">Todas</option>
                        @foreach($localidades as $loc)
                        <option value="{{ $loc->id }}" {{ ($filters['localidade_id'] ?? '') == $loc->id ? 'selected' : '' }}>{{ $loc->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.iluminacao.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:hover:bg-slate-600 transition-all">
                    Limpar
                </a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 transition-all shadow-md">
                    Filtrar Resultados
                </button>
            </div>
        </form>
    </div>

    <!-- Grid de Resultados -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Código</th>
                        <th class="px-6 py-4">Localização & Endereço</th>
                        <th class="px-6 py-4">Potência & Lâmpada</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($pontos as $ponto)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all group">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                            #{{ $ponto->codigo }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-gray-900 dark:text-white font-medium">{{ $ponto->localidade->nome ?? 'N/A' }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $ponto->endereco }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-[10px] font-bold uppercase tracking-wider">{{ $ponto->potencia }}W</span>
                                <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($ponto->tipo_lampada) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = [
                                    'funcionando' => ['label' => 'Operacional', 'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'],
                                    'com_defeito' => ['label' => 'Com Defeito', 'color' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
                                    'desligado' => ['label' => 'Desativado', 'color' => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400'],
                                ];
                                $st = $statusMap[$ponto->status] ?? ['label' => 'Desconhecido', 'color' => 'bg-slate-100 text-slate-700'];
                            @endphp
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $st['color'] }}">
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                             <a href="{{ route('admin.iluminacao.show', $ponto->id) }}" class="inline-flex items-center p-2 text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-600 hover:text-white transition-all">
                                <x-icon name="eye" style="duotone" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <x-icon name="lightbulb-slash" style="duotone" class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" />
                                <p class="text-gray-500 dark:text-gray-400">Nenhum ponto de luz encontrado com os filtros selecionados.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900/20 border-t border-gray-200 dark:border-slate-700">
            {{ $pontos->links() }}
        </div>
    </div>
</div>
@endsection
