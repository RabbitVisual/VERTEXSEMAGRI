@extends('admin.layouts.admin')

@section('title', 'Agenda de Eventos - Agricultura')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg font-sans">
                    <x-icon name="calendar-days" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans" style="duotone" />
                </div>
                <span>Agenda de Eventos</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors italic font-sans">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans">Agricultura</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans">
            <a href="{{ route('admin.programas-agricultura.programas.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-colors font-sans">
                <x-icon name="leaf" class="w-5 h-5 font-sans" style="duotone" />
                Programas
            </a>
            <a href="{{ route('admin.programas-agricultura.eventos.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 transition-all shadow-lg shadow-amber-500/20 uppercase tracking-widest text-[10px] font-sans">
                <x-icon name="plus" class="w-5 h-5 font-sans" style="duotone" />
                Novo Evento
            </a>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 font-sans">
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans">Total Eventos</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white mt-1 italic tracking-tighter font-sans">{{ $estatisticas['total'] }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50 font-sans">
                    <x-icon name="calendar" class="w-6 h-6 text-amber-600 dark:text-amber-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans">Agendados</p>
                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['agendados'] }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50 font-sans">
                    <x-icon name="clock" class="w-6 h-6 text-emerald-600 dark:text-emerald-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans">Total de Inscritos</p>
                    <p class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1 italic tracking-tighter font-sans">{{ $eventos->sum('inscricoes_count') }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50 font-sans">
                    <x-icon name="users" class="w-6 h-6 text-blue-600 dark:text-blue-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic font-sans">Ativos no Portal</p>
                    <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['publicos'] }}</p>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800/50 font-sans">
                    <x-icon name="globe" class="w-6 h-6 text-purple-600 dark:text-purple-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans">
        <form method="GET" action="{{ route('admin.programas-agricultura.eventos.index') }}" class="p-6 font-sans">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 font-sans">
                <div class="md:col-span-2">
                    <div class="relative font-sans">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none font-sans">
                            <x-icon name="magnifying-glass" class="w-4 h-4 text-gray-400 font-sans" />
                        </div>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Pesquisar por título ou código do evento..." class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 transition-all dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans">
                    </div>
                </div>
                <div>
                    <select name="status" class="bg-gray-50 border border-gray-200 text-gray-900 text-[10px] font-black uppercase tracking-widest rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans">
                        <option value="">Todos os Status</option>
                        <option value="agendado" {{ ($filters['status'] ?? '') == 'agendado' ? 'selected' : '' }}>Agendado</option>
                        <option value="em_andamento" {{ ($filters['status'] ?? '') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="concluido" {{ ($filters['status'] ?? '') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                        <option value="cancelado" {{ ($filters['status'] ?? '') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="flex gap-2 font-sans">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 text-[10px] font-black text-white bg-slate-900 dark:bg-amber-600 rounded-xl hover:bg-slate-800 transition-all active:scale-95 font-sans">
                        <x-icon name="filter" class="w-4 h-4 font-sans" style="duotone" />
                        Filtrar
                    </button>
                    <a href="{{ route('admin.programas-agricultura.eventos.index') }}" class="inline-flex items-center justify-center p-3 text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors dark:bg-slate-700 dark:text-slate-300 font-sans">
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
                        <th scope="col" class="px-6 py-5">Data / Cronograma</th>
                        <th scope="col" class="px-6 py-5">Evento / Identificação</th>
                        <th scope="col" class="px-6 py-5 text-center italic">Local / Território</th>
                        <th scope="col" class="px-6 py-5 text-center">Ocupação</th>
                        <th scope="col" class="px-6 py-5 text-right font-sans">Gestão Especializada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 font-sans text-xs">
                    @forelse($eventos as $evento)
                    <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/10 transition-colors group font-sans">
                        <td class="px-6 py-5 font-sans">
                            <div class="flex flex-col font-sans">
                                <span class="text-sm font-black text-gray-900 dark:text-white italic tracking-tighter">{{ $evento->data_inicio->format('d/m/Y') }}</span>
                                <span class="text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-widest mt-1">{{ $evento->hora_inicio_formatada }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 font-sans">
                            <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-amber-600 transition-colors">
                                {{ $evento->titulo }}
                            </div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 italic">
                                {{ $evento->tipo }} • {{ $evento->codigo }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center italic text-gray-500 font-sans">
                            <div class="flex items-center justify-center gap-2 font-sans">
                                <x-icon name="location-dot" class="w-4 h-4 text-slate-400 font-sans" />
                                <span class="font-bold uppercase text-[10px] tracking-wide">{{ $evento->localidade->nome ?? 'CENTRO' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center font-sans">
                            <div class="inline-flex px-3 py-1 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 rounded-lg font-black text-[10px] border border-amber-100 dark:border-amber-800 uppercase tracking-tighter">
                                {{ $evento->inscricoes_count }} / {{ $evento->vagas_totais ?: '∞' }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right font-sans">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all font-sans">
                                <a href="{{ route('admin.programas-agricultura.eventos.show', $evento->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-amber-600 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm font-sans" title="Explorar Agenda">
                                    <x-icon name="eye" class="w-5 h-5 font-sans" style="duotone" />
                                </a>
                                <a href="{{ route('admin.programas-agricultura.eventos.edit', $evento->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm font-sans">
                                    <x-icon name="pencil-square" class="w-5 h-5 font-sans" style="duotone" />
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium italic">Nenhum evento localizado na agenda técnica.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($eventos->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $eventos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
