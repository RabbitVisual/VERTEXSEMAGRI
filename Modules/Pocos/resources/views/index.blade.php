@extends('Co-Admin.layouts.app')

@section('title', 'Gestão de Poços Artesianos')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Premium Header Section -->
    <div class="relative overflow-hidden bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl mb-8">
        <!-- Background Decorations -->
        <div class="absolute top-0 right-0 -mt-12 -mr-12 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="relative px-8 py-10 md:px-12 md:py-16">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Gestão de Ativos Hídricos
                    </div>

                    <div class="space-y-2">
                        <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tight">
                            Poços <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400 font-light">Artesianos</span>
                        </h1>
                        <p class="text-slate-400 text-sm font-bold uppercase tracking-widest leading-relaxed max-w-xl">
                            Monitoramento técnico e gestão operacional da rede de poços do município.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('pocos.create') }}" class="group relative px-8 py-4 bg-white text-slate-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl shadow-white/10">
                        <div class="flex items-center gap-3">
                            <x-icon name="plus" class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" />
                            Cadastrar Poço
                        </div>
                    </a>
                </div>
            </div>

            <!-- Header Quick Stats -->
            @if(isset($estatisticas))
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Mapeado</p>
                    <p class="text-xl font-black text-white">{{ number_format($estatisticas['total'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Em Operação</p>
                    <p class="text-xl font-black text-emerald-400">{{ number_format($estatisticas['ativos'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Em Manutenção</p>
                    <p class="text-xl font-black text-amber-400">{{ number_format($estatisticas['em_manutencao'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/5 backdrop-blur-sm">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Com Problemas</p>
                    <p class="text-xl font-black text-rose-400">{{ number_format($estatisticas['com_problemas'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

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
                <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identificação do Poço</th>
                        <th scope="col" class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Geolocalização</th>
                        <th scope="col" class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Especificações</th>
                        <th scope="col" class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Operacional</th>
                        <th scope="col" class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right whitespace-nowrap">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($pocos as $poco)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-all duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 border border-blue-100 dark:border-blue-800/30 group-hover:scale-110 transition-all duration-500">
                                    <x-icon name="faucet-drip" class="w-6 h-6" />
                                </div>
                                <div>
                                    <div class="text-slate-900 dark:text-white font-black uppercase tracking-tight text-sm mb-0.5 group-hover:text-blue-600 transition-colors">{{ $poco->codigo ?? 'SEM CÓDIGO' }}</div>
                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                        <x-icon name="location-dot" class="w-3 h-3 text-blue-500" />
                                        {{ $poco->localidade->nome ?? 'S/L' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="space-y-1.5">
                                <div class="text-[11px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter line-clamp-1 leading-tight">{{ $poco->endereco }}</div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 rounded-full text-slate-500 font-black tracking-widest border border-gray-200 dark:border-slate-700">{{ $poco->latitude }}</span>
                                    <span class="text-[9px] bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 rounded-full text-slate-500 font-black tracking-widest border border-gray-200 dark:border-slate-700">{{ $poco->longitude }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                                <div class="flex items-center gap-2">
                                    <x-icon name="ruler-vertical" class="w-3.5 h-3.5 text-slate-300" />
                                    <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-tighter">{{ number_format($poco->profundidade_metros, 1) }}m</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-icon name="droplet" class="w-3.5 h-3.5 text-blue-400" />
                                    <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-tighter">{{ number_format($poco->vazao_litros_hora, 0, ',', '.') }}L/h</span>
                                </div>
                                <div class="flex items-center gap-2 col-span-2">
                                    <x-icon name="bolt" class="w-3.5 h-3.5 text-amber-500" />
                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest opacity-70 truncate">{{ $poco->tipo_bomba ?? 'BOMBA N/D' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $statusMap = [
                                    'ativo' => ['label' => 'Operante', 'variant' => 'success'],
                                    'inativo' => ['label' => 'Inativo', 'variant' => 'secondary'],
                                    'manutencao' => ['label' => 'Manutenção', 'variant' => 'warning'],
                                    'bomba_queimada' => ['label' => 'Falha Crítica', 'variant' => 'danger'],
                                ];
                                $st = $statusMap[$poco->status] ?? ['label' => $poco->status, 'variant' => 'info'];
                            @endphp
                            <x-pocos::badge :variant="$st['variant']" class="text-[9px] px-3 py-1 font-black uppercase tracking-[0.15em] border-none shadow-sm">
                                <span class="relative flex h-1.5 w-1.5 mr-1.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-current opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-current"></span>
                                </span>
                                {{ $st['label'] }}
                            </x-pocos::badge>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                                <x-pocos::button href="{{ route('pocos.show', $poco->id) }}" variant="secondary" size="sm" class="hover:bg-blue-600 hover:text-white border-none shadow-none">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </x-pocos::button>
                                <x-pocos::button href="{{ route('pocos.edit', $poco->id) }}" variant="secondary" size="sm" class="hover:bg-amber-500 hover:text-white border-none shadow-none">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </x-pocos::button>
                                <form action="{{ route('pocos.destroy', $poco->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmar arquivamento?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-pocos::button type="submit" variant="secondary" size="sm" class="hover:bg-red-500 hover:text-white border-none shadow-none">
                                        <x-icon name="trash-can" class="w-4 h-4" />
                                    </x-pocos::button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="max-w-md mx-auto flex flex-col items-center gap-6">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center text-slate-200 dark:text-slate-800 border border-dashed border-slate-200 dark:border-slate-700">
                                    <x-icon name="magnifying-glass" class="w-10 h-10" />
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-tight">Nenhum poço encontrado</h3>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-2">Ajuste os filtros de busca ou cadastre um novo ativo.</p>
                                </div>
                                <x-pocos::button href="{{ route('pocos.create') }}" variant="primary" size="sm" class="mt-4 !bg-blue-600">
                                    Cadastrar Novo Poço
                                </x-pocos::button>
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
