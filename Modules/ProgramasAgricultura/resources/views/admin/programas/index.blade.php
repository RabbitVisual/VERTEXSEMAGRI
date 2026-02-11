@extends('admin.layouts.admin')

@section('title', 'Programas - Agricultura')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="leaf" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Gestão de Programas</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors italic">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px]">Agricultura</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" style="duotone" />
                Voltar
            </a>
            <a href="{{ route('admin.programas-agricultura.programas.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800 transition-all shadow-lg shadow-amber-500/20 uppercase tracking-widest text-[10px]">
                <x-icon name="plus" class="w-5 h-5" style="duotone" />
                Novo Programa
            </a>
        </div>
    </div>

    <!-- Estatísticas Gerais -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6">
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total de Programas</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white mt-1 italic tracking-tighter">{{ $estatisticas['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="layer-group" class="w-6 h-6 text-amber-600 dark:text-amber-400" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow uppercase tracking-widest">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ativos / Em Vigor</p>
                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 italic tracking-tighter">{{ $estatisticas['ativos'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50 font-sans">
                    <x-icon name="circle-check" class="w-6 h-6 text-emerald-600 dark:text-emerald-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total de Atendidos</p>
                    <p class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1 italic tracking-tighter">{{ $programas->sum('beneficiarios_count') }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50 font-sans">
                    <x-icon name="users" class="w-6 h-6 text-blue-600 dark:text-blue-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Visíveis no Portal</p>
                    <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['publicos'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800/50">
                    <x-icon name="star-shooting" class="w-6 h-6 text-purple-600 dark:text-purple-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-2">
            <x-icon name="filter" class="w-4 h-4 text-amber-500" style="duotone" />
            <h3 class="text-[10px] font-black text-gray-400 dark:text-white uppercase tracking-widest italic">Filtros de Inteligência</h3>
        </div>
        <form method="GET" action="{{ route('admin.programas-agricultura.programas.index') }}" class="p-6 font-sans">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-sans">
                <div>
                    <label for="search" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Pesquisar Programa</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-icon name="magnifying-glass" class="w-4 h-4 text-gray-400 font-sans" />
                        </div>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nome, código, descrição..." class="block w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 transition-all font-sans">
                    </div>
                </div>
                <div>
                    <label for="status" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest italic font-sans">Estado Atual</label>
                    <select name="status" id="status" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans">
                        <option value="">Todos os Status</option>
                        <option value="ativo" {{ ($filters['status'] ?? '') == 'ativo' ? 'selected' : '' }}>Ativos</option>
                        <option value="suspenso" {{ ($filters['status'] ?? '') == 'suspenso' ? 'selected' : '' }}>Suspensos</option>
                        <option value="encerrado" {{ ($filters['status'] ?? '') == 'encerrado' ? 'selected' : '' }}>Encerrados</option>
                    </select>
                </div>
                <div class="flex items-end gap-2 font-sans">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 text-[10px] font-black text-white bg-slate-900 dark:bg-amber-600 rounded-xl hover:bg-slate-800 dark:hover:bg-amber-700 transition-all uppercase tracking-widest shadow-lg shadow-amber-500/10 font-sans">
                        <x-icon name="magnifying-glass" class="w-4 h-4 font-sans" style="duotone" />
                        Refinar Busca
                    </button>
                    <a href="{{ route('admin.programas-agricultura.programas.index') }}" class="inline-flex items-center justify-center p-3 text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors dark:bg-slate-700 dark:text-slate-300">
                        <x-icon name="rotate-right" class="w-5 h-5 font-sans" style="duotone" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans">
        <div class="overflow-x-auto font-sans">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 font-sans">
                <thead class="text-[10px] font-black text-slate-400 uppercase bg-gray-50/50 dark:bg-slate-900/50 tracking-widest font-sans">
                    <tr>
                        <th scope="col" class="px-6 py-5">Programa / Identificação</th>
                        <th scope="col" class="px-6 py-5">Responsável / Tipo</th>
                        <th scope="col" class="px-6 py-5 text-center">Abrangência</th>
                        <th scope="col" class="px-6 py-5 text-center">Status</th>
                        <th scope="col" class="px-6 py-5 text-right font-sans">Ações de Gestão</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 font-sans">
                    @forelse($programas as $programa)
                    <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/10 transition-colors group">
                        <td class="px-6 py-5 font-sans">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white dark:bg-slate-900 rounded-2xl flex items-center justify-center text-amber-500 shadow-sm border border-gray-100 dark:border-slate-800 group-hover:scale-110 transition-transform">
                                    <x-icon name="leaf" class="w-6 h-6 font-sans" style="duotone" />
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-amber-600 transition-colors font-sans">
                                        {{ $programa->nome }}
                                    </div>
                                    <div class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest mt-1">
                                        {{ $programa->codigo }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 font-sans">
                            <div class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">
                                {{ $programa->tipo_texto }}
                            </div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 italic mt-1 uppercase font-black">
                                {{ $programa->orgao_responsavel ?: 'MUNICIPAL' }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center font-sans">
                            <div class="inline-flex flex-col items-center">
                                <span class="text-lg font-black text-gray-900 dark:text-white italic tracking-tighter">{{ $programa->beneficiarios_count }}</span>
                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Beneficiados</span>
                                @if($programa->vagas_disponiveis > 0)
                                    <div class="w-16 h-1 bg-gray-100 dark:bg-slate-700 rounded-full mt-2 overflow-hidden shadow-inner">
                                        @php
                                            $perc = ($programa->beneficiarios_count / $programa->vagas_disponiveis) * 100;
                                            $perc = min(100, $perc);
                                        @endphp
                                        <div class="bg-amber-500 h-full" style="width: {{ $perc }}%"></div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center font-sans">
                            @php
                                $statusColors = [
                                    'ativo' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800',
                                    'suspenso' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                                    'encerrado' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800'
                                ];
                                $statusClass = $statusColors[$programa->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                            @endphp
                            <span class="px-3 py-1 text-[9px] font-black rounded-lg border {{ $statusClass }} uppercase tracking-widest">
                                {{ $programa->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right font-sans">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all font-sans">
                                <a href="{{ route('admin.programas-agricultura.programas.show', $programa->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-amber-600 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-xl hover:bg-amber-100 transition-all shadow-sm font-sans" title="Ver Detalhes">
                                    <x-icon name="eye" class="w-5 h-5 font-sans" style="duotone" />
                                </a>
                                <a href="{{ route('admin.programas-agricultura.programas.edit', $programa->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl hover:bg-blue-100 transition-all shadow-sm font-sans" title="Editar">
                                    <x-icon name="pencil-square" class="w-5 h-5 font-sans" style="duotone" />
                                </a>
                                <form action="{{ route('admin.programas-agricultura.programas.destroy', $programa->id) }}" method="POST" onsubmit="return confirm('ATENÇÃO: Deseja realmente excluir este programa?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-10 h-10 text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl hover:bg-red-100 transition-all shadow-sm font-sans">
                                        <x-icon name="trash" class="w-5 h-5 font-sans" style="duotone" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium italic">Nenhum programa localizado nesta gestão.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($programas->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $programas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
