@extends('Co-Admin.layouts.app')

@section('title', 'Gestão de Poços Artesianos')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="faucet-drip" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Poços Artesianos</span>
            </h1>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <span class="text-blue-600">Patrimônio Hídrico</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-3">
             <a href="{{ route('pocos.create') }}" class="group inline-flex items-center justify-center gap-2 px-8 py-3.5 text-xs font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 active:scale-95 transition-all uppercase tracking-widest">
                <x-icon name="plus" class="w-4 h-4 group-hover:rotate-90 transition-transform" />
                Cadastrar Poço
            </a>
        </div>
    </div>

    <!-- Painel de Performance Operacional -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total -->
        <div class="premium-card p-6 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/10 rounded-2xl text-blue-600 dark:text-blue-400 group-hover:rotate-6 transition-all border border-blue-50 dark:border-blue-900/20">
                    <x-icon name="faucet" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ativos Mapeados</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ number_format($estatisticas['total'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-[9px] font-bold text-emerald-500 uppercase tracking-widest">
                <x-icon name="arrow-up-right" class="w-3 h-3" />
                <span>Base Patrimonial</span>
            </div>
        </div>

        <!-- Card 2: Ativos -->
        <div class="premium-card p-6 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-4 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl text-emerald-600 dark:text-emerald-400 group-hover:rotate-6 transition-all border border-emerald-50 dark:border-emerald-900/20">
                    <x-icon name="circle-check" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Operação 100%</p>
                    <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tighter">{{ number_format($estatisticas['ativos'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-[9px] font-bold text-emerald-500 uppercase tracking-widest">
                <x-icon name="check" class="w-3 h-3" />
                <span>Sem Ocorrências</span>
            </div>
        </div>

        <!-- Card 3: Manutenção -->
        <div class="premium-card p-6 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-4 bg-amber-50 dark:bg-amber-900/10 rounded-2xl text-amber-600 dark:text-amber-400 group-hover:rotate-6 transition-all border border-amber-50 dark:border-amber-900/20">
                    <x-icon name="wrench-screwdriver" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Intervenção</p>
                    <p class="text-3xl font-black text-amber-600 dark:text-amber-400 tracking-tighter">{{ number_format($estatisticas['em_manutencao'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-[9px] font-bold text-amber-500 uppercase tracking-widest">
                <x-icon name="clock" class="w-3 h-3" />
                <span>Em Manutenção</span>
            </div>
        </div>

        <!-- Card 4: Críticos -->
        <div class="premium-card p-6 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-4 bg-rose-50 dark:bg-rose-900/10 rounded-2xl text-rose-600 dark:text-rose-400 group-hover:rotate-6 transition-all border border-rose-50 dark:border-rose-900/20">
                    <x-icon name="circle-exclamation" style="duotone" class="w-6 h-6" />
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bomba/Pane</p>
                    <p class="text-3xl font-black text-rose-600 dark:text-rose-400 tracking-tighter">{{ number_format($estatisticas['com_problemas'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-[9px] font-bold text-rose-500 uppercase tracking-widest animate-pulse">
                <x-icon name="triangle-exclamation" class="w-3 h-3" />
                <span>Atenção Crítica</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Filtros de Inteligência -->
    <div class="premium-card p-8">
        <form action="{{ route('pocos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6 items-end">
            <div class="md:col-span-2 lg:col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Filtro Global</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-400">
                        <x-icon name="magnifying-glass" class="w-4 h-4" />
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-12 pr-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                        placeholder="Código, localidade ou modelo de bomba...">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Localidade</label>
                <select name="localidade" class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                    <option value="">Todas</option>
                    @foreach($localidades as $loc)
                        <option value="{{ $loc->id }}" {{ request('localidade') == $loc->id ? 'selected' : '' }}>{{ $loc->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Operatividade</label>
                <select name="status" class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                    <option value="">Status (Todos)</option>
                    <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativos</option>
                    <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativos</option>
                    <option value="manutencao" {{ request('status') === 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full px-8 py-4 text-[10px] font-black text-white bg-slate-900 dark:bg-blue-600 rounded-2xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-95 uppercase tracking-widest flex items-center justify-center gap-2">
                    <x-icon name="sliders" class="w-4 h-4" />
                    Aplicar
                </button>
            </div>
        </form>
    </div>

    <!-- Grade de Ativos -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[9px] text-slate-400 uppercase tracking-[0.2em] bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-8 py-5 font-black">Identificação do Poço</th>
                        <th scope="col" class="px-8 py-5 font-black">Geolocalização</th>
                        <th scope="col" class="px-8 py-5 font-black">Especificações</th>
                        <th scope="col" class="px-8 py-5 font-black text-center">Status Operacional</th>
                        <th scope="col" class="px-8 py-5 font-black text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800 font-bold">
                    @forelse($pocos as $poco)
                    <tr class="hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/10 flex items-center justify-center text-blue-600 border border-blue-100 dark:border-blue-800/20 group-hover:scale-110 transition-transform">
                                    <x-icon name="faucet-drip" style="duotone" class="w-6 h-6" />
                                </div>
                                <div>
                                    <div class="text-gray-900 dark:text-white font-black uppercase tracking-tight text-base mb-0.5">{{ $poco->codigo ?? 'SEM CÓDIGO' }}</div>
                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 uppercase tracking-widest">
                                        <x-icon name="location-dot" class="w-3 h-3 text-blue-500" />
                                        {{ $poco->localidade->nome ?? 'S/L' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="space-y-1">
                                <div class="text-[11px] font-black text-gray-700 dark:text-slate-300 uppercase tracking-tighter line-clamp-1">{{ $poco->endereco }}</div>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] bg-gray-100 dark:bg-slate-800 px-2 py-0.5 rounded-md text-slate-500 font-mono">{{ $poco->latitude }}</span>
                                    <span class="text-[9px] bg-gray-100 dark:bg-slate-800 px-2 py-0.5 rounded-md text-slate-500 font-mono">{{ $poco->longitude }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1">
                                <div class="flex items-center gap-1.5 min-w-max">
                                    <x-icon name="ruler-vertical" class="w-3.5 h-3.5 text-slate-300" />
                                    <span class="text-[11px] uppercase tracking-tighter">{{ $poco->profundidade_metros }}m prof.</span>
                                </div>
                                <div class="flex items-center gap-1.5 min-w-max">
                                    <x-icon name="droplet" class="w-3.5 h-3.5 text-blue-400" />
                                    <span class="text-[11px] uppercase tracking-tighter">{{ $poco->vazao_litros_hora }}L/h</span>
                                </div>
                                <div class="flex items-center gap-1.5 min-w-max col-span-2">
                                    <x-icon name="bolt" class="w-3.5 h-3.5 text-amber-500" />
                                    <span class="text-[10px] uppercase tracking-tighter opacity-70">{{ $poco->tipo_bomba ?? 'BOMBA N/D' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $statusStyles = [
                                    'ativo' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'inativo' => 'bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-400',
                                    'manutencao' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    'bomba_queimada' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 animate-pulse',
                                ];
                                $style = $statusStyles[$poco->status] ?? 'bg-gray-100 text-gray-700';
                                $statusLabels = [
                                    'ativo' => 'Operante',
                                    'inativo' => 'Inativo',
                                    'manutencao' => 'Manutenção',
                                    'bomba_queimada' => 'Pane Elétrica',
                                ];
                                $label = $statusLabels[$poco->status] ?? $poco->status;
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.15em] {{ $style }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 shrink-0">
                                <a href="{{ route('pocos.show', $poco) }}" class="p-2.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all" title="Visualizar Detalhes">
                                    <x-icon name="eye" style="duotone" class="w-5 h-5" />
                                </a>
                                <a href="{{ route('pocos.edit', $poco) }}" class="p-2.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition-all" title="Editar Ativo">
                                    <x-icon name="pen-to-square" style="duotone" class="w-5 h-5" />
                                </a>
                                <button type="button" class="p-2.5 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all" title="Arquivar">
                                    <x-icon name="trash-can" style="duotone" class="w-5 h-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="max-w-md mx-auto flex flex-col items-center gap-6">
                                <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center text-gray-200 dark:text-slate-800 scale-125">
                                    <x-icon name="magnifying-glass" style="duotone" class="w-10 h-10" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Nenhum poço encontrado</h3>
                                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Tente ajustar seus filtros ou cadastre um novo ativo hídrico.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(is_object($pocos) && method_exists($pocos, 'links'))
        <div class="p-8 bg-gray-50/30 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-800">
            {{ $pocos->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
