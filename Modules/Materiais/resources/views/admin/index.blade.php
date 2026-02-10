@extends('admin.layouts.admin')

@section('title', 'Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="boxes-stacked" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Materiais
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <span class="text-gray-900 dark:text-white font-bold">Catálogo de Materiais</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-all duration-300 shadow-sm">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Voltar
                </a>
                <a href="{{ route('materiais.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all duration-300">
                    <x-icon name="eye" style="duotone" class="w-5 h-5" />
                    Ver Painel Público
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-6 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50 flex items-center gap-3 animate-slide-in">
        <x-icon name="circle-check" class="w-5 h-5" style="duotone" />
        <span class="font-bold tracking-tight">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total de Itens', 'value' => $estatisticas['total'] ?? 0, 'icon' => 'boxes-stacked', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-indigo-600'],
            ['label' => 'Ativos no Sistema', 'value' => $estatisticas['ativos'] ?? 0, 'icon' => 'circle-check', 'color' => 'emerald', 'gradient' => 'from-emerald-500 to-emerald-600'],
            ['label' => 'Baixo Estoque', 'value' => $estatisticas['baixo_estoque'] ?? 0, 'icon' => 'triangle-exclamation', 'color' => 'amber', 'gradient' => 'from-amber-500 to-amber-600'],
            ['label' => 'Sem Estoque', 'value' => $estatisticas['sem_estoque'] ?? 0, 'icon' => 'circle-xmark', 'color' => 'red', 'gradient' => 'from-red-500 to-red-600']
        ] as $stat)
        <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br {{ $stat['gradient'] }} rounded-xl flex items-center justify-center text-white shadow-lg shadow-{{ $stat['color'] }}-200 dark:shadow-none transition-transform group-hover:scale-110">
                    <x-icon name="{{ $stat['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">{{ number_format($stat['value'], 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r {{ $stat['gradient'] }} opacity-0 group-hover:opacity-100 transition-opacity rounded-b-2xl"></div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Filtros Panorâmicos -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/30 dark:bg-slate-900/30 flex items-center gap-2">
            <x-icon name="filter" class="w-5 h-5 text-emerald-500" style="duotone" />
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">Filtros de Pesquisa</h3>
        </div>
        <form method="GET" action="{{ route('admin.materiais.index') }}" class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label for="search" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Buscar Material</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="magnifying-glass" class="w-4 h-4" />
                        </div>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Código ou nome..." class="w-full bg-slate-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 block pl-11 p-3 transition-all">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="categoria" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Categoria</label>
                    <select name="categoria" id="categoria" class="w-full bg-slate-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 block p-3 transition-all appearance-none cursor-pointer">
                        <option value="">Todas as Categorias</option>
                        <option value="eletrico" {{ ($filters['categoria'] ?? '') == 'eletrico' ? 'selected' : '' }}>Elétrico</option>
                        <option value="hidraulico" {{ ($filters['categoria'] ?? '') == 'hidraulico' ? 'selected' : '' }}>Hidráulico</option>
                        <option value="ferramentas" {{ ($filters['categoria'] ?? '') == 'ferramentas' ? 'selected' : '' }}>Ferramentas</option>
                        <option value="outros" {{ ($filters['categoria'] ?? '') == 'outros' ? 'selected' : '' }}>Outros</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label for="ativo" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Status de Inventário</label>
                    <select name="ativo" id="ativo" class="w-full bg-slate-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 block p-3 transition-all appearance-none cursor-pointer">
                        <option value="">Status Geral</option>
                        <option value="1" {{ ($filters['ativo'] ?? '') == '1' ? 'selected' : '' }}>Ativos</option>
                        <option value="0" {{ ($filters['ativo'] ?? '') == '0' ? 'selected' : '' }}>Inativos</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label for="baixo_estoque" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Alertas de Estoque</label>
                    <select name="baixo_estoque" id="baixo_estoque" class="w-full bg-slate-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 block p-3 transition-all appearance-none cursor-pointer">
                        <option value="">Todos os Níveis</option>
                        <option value="1" {{ ($filters['baixo_estoque'] ?? '') == '1' ? 'selected' : '' }}>Baixo Estoque</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-black text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/20 transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                    <x-icon name="magnifying-glass" class="w-5 h-5" style="duotone" />
                    Filtrar Catálogo
                </button>
                <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-emerald-600 transition-all active:scale-95 shadow-sm">
                    <x-icon name="rotate-right" class="w-5 h-5" style="duotone" />
                    Restaurar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela Premium de Inventário -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                <x-icon name="list-ul" class="w-4 h-4 text-emerald-500" style="duotone" />
                Listagem Detalhada
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-50/50 dark:bg-slate-900/50 font-black border-b border-gray-100 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-5">Identificação / Código</th>
                        <th class="px-6 py-5">Segmento / Categoria</th>
                        <th class="px-6 py-5">Disponibilidade Real</th>
                        <th class="px-6 py-5">Estado</th>
                        <th class="px-6 py-5 text-right">Controle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50 font-medium">
                    @forelse($materiais as $material)
                    <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/5 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 dark:text-white text-base group-hover:text-emerald-600 transition-colors">
                                    {{ $material->nome }}
                                </span>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter mt-0.5">
                                    SKU: {{ $material->codigo }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-400 font-bold border border-indigo-100 dark:border-indigo-800/30 uppercase text-[10px]">
                                <x-icon name="tag" class="w-3 h-3" />
                                {{ $material->categoria ?? 'Insumos' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $baixoEstoque = $material->quantidade_minima && $material->quantidade_estoque <= $material->quantidade_minima;
                            @endphp
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="text-base font-black {{ $baixoEstoque ? 'text-red-500' : 'text-gray-900 dark:text-white' }}">
                                        {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }}
                                    </span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $material->unidade_medida }}</span>
                                </div>
                                @if($baixoEstoque)
                                    <span class="flex items-center gap-1 text-[10px] font-black text-red-500 uppercase tracking-tighter mt-1 animate-pulse">
                                        <x-icon name="warning" class="w-3 h-3" />
                                        Aprovisionar Urgente
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($material->ativo)
                                <div class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-bold text-[11px] uppercase tracking-wider">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div>
                                    Em Uso
                                </div>
                            @else
                                <div class="flex items-center gap-1.5 text-gray-400 dark:text-gray-500 font-bold text-[11px] uppercase tracking-wider">
                                    <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                    Retirado
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.materiais.show', $material->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm active:scale-95" title="Detalhes do Ativo">
                                    <x-icon name="eye" class="w-5 h-5" style="duotone" />
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center shadow-inner">
                                    <x-icon name="boxes-stacked" class="w-10 h-10 text-slate-200" style="duotone" />
                                </div>
                                <div class="text-center">
                                    <h4 class="text-lg font-bold text-gray-400 uppercase tracking-widest">Nenhum Ativo Encontrado</h4>
                                    <p class="text-sm text-gray-400 font-medium">Refine seus filtros ou adicione novos materiais ao catálogo.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($materiais->hasPages())
        <div class="px-6 py-6 bg-slate-50/50 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-700/50 mx-4 my-4 rounded-2xl">
            {{ $materiais->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
