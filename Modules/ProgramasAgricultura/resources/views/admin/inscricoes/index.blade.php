@extends('admin.layouts.admin')

@section('title', 'Inscrições em Eventos - Agricultura')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700 font-sans">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-sans">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg font-sans">
                    <x-icon name="clipboard-check" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans" style="duotone" />
                </div>
                <span>Inscrições em Eventos</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors font-sans">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans">Agricultura</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans">
            <a href="{{ route('admin.programas-agricultura.eventos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-colors font-sans">
                <x-icon name="calendar-days" class="w-5 h-5 font-sans" style="duotone" />
                Agenda Técnica
            </a>
        </div>
    </div>

    <!-- Estatísticas Gerais -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 font-sans">
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans italic">Total Inscrições</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white mt-1 italic tracking-tighter font-sans">{{ $estatisticas['total'] }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="clipboard-list" class="w-6 h-6 text-amber-600 dark:text-amber-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans italic">Habilitados / Confirmados</p>
                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['confirmadas'] }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50 font-sans">
                    <x-icon name="circle-check" class="w-6 h-6 text-emerald-600 dark:text-emerald-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans italic">Presentes / Validado</p>
                    <p class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['presentes'] }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50 font-sans">
                    <x-icon name="user-check" class="w-6 h-6 text-blue-600 dark:text-blue-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans italic">Cancelamentos</p>
                    <p class="text-2xl font-black text-red-600 dark:text-red-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['canceladas'] }}</p>
                </div>
                <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800/50 font-sans">
                    <x-icon name="calendar-xmark" class="w-6 h-6 text-red-600 dark:text-red-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Inteligentes -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans">
        <form method="GET" action="{{ route('admin.programas-agricultura.inscricoes.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 italic font-sans">
                <div class="md:col-span-1 italic font-sans text-xs uppercase">
                    <div class="relative italic font-sans font-black">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none italic font-sans font-black">
                            <x-icon name="magnifying-glass" class="w-4 h-4 text-gray-400 italic font-sans font-black" />
                        </div>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Participante ou CPF..." class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 transition-all dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans italic">
                    </div>
                </div>
                <div>
                    <select name="evento_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-[10px] font-black uppercase tracking-widest rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans italic">
                        <option value="">Todos os Eventos</option>
                        @foreach($eventos as $ev)
                            <option value="{{ $ev->id }}" {{ ($filters['evento_id'] ?? '') == $ev->id ? 'selected' : '' }}>{{ $ev->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="bg-gray-50 border border-gray-200 text-gray-900 text-[10px] font-black uppercase tracking-widest rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans italic">
                        <option value="">Todos os Status</option>
                        <option value="confirmada" {{ ($filters['status'] ?? '') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                        <option value="presente" {{ ($filters['status'] ?? '') == 'presente' ? 'selected' : '' }}>Presente</option>
                        <option value="ausente" {{ ($filters['status'] ?? '') == 'ausente' ? 'selected' : '' }}>Ausente</option>
                        <option value="cancelada" {{ ($filters['status'] ?? '') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div class="flex gap-2 font-sans italic font-black text-xs uppercase">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 text-[10px] font-black text-white bg-slate-900 dark:bg-amber-600 rounded-xl hover:bg-slate-800 transition-all font-sans italic font-black text-xs uppercase tracking-widest">
                        Explorar
                    </button>
                    <a href="{{ route('admin.programas-agricultura.inscricoes.index') }}" class="inline-flex items-center justify-center p-3 text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors dark:bg-slate-700 dark:text-slate-300 font-sans italic font-black text-xs uppercase">
                        <x-icon name="rotate-right" class="w-5 h-5 font-sans italic font-black text-xs uppercase" style="duotone" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela Corporativa -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans italic font-black text-xs uppercase">
        <div class="overflow-x-auto font-sans italic font-black text-xs uppercase">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 font-sans italic font-black text-xs uppercase">
                <thead class="text-[10px] font-black text-slate-400 uppercase bg-gray-50/50 dark:bg-slate-900/50 tracking-widest font-sans italic text-xs">
                    <tr>
                        <th scope="col" class="px-6 py-5">Perfil / Participante</th>
                        <th scope="col" class="px-6 py-5">Cronograma / Evento</th>
                        <th scope="col" class="px-6 py-5 text-center">Registro</th>
                        <th scope="col" class="px-6 py-5 text-center">Validação</th>
                        <th scope="col" class="px-6 py-5 text-right font-sans italic text-xs">Gestão</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 font-sans italic text-xs">
                    @forelse($inscricoes as $inscricao)
                    <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/10 transition-colors group font-sans italic text-xs">
                        <td class="px-6 py-5 font-sans italic text-xs">
                            <div class="flex items-center gap-4 font-sans italic text-xs uppercase">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-900 flex items-center justify-center shadow-sm font-sans italic text-xs border border-gray-200 dark:border-slate-800">
                                    <span class="text-amber-600 font-black">{{ substr($inscricao->pessoa->nom_pessoa, 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-amber-600 transition-colors font-sans italic">
                                        {{ $inscricao->pessoa->nom_pessoa }}
                                    </div>
                                    <div class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest mt-1 italic">
                                        CPF: {{ $inscricao->pessoa->num_cpf_pessoa }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 font-sans italic text-xs uppercase">
                            <div class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest max-w-[200px] truncate italic font-sans">
                                {{ $inscricao->evento->titulo }}
                            </div>
                            <div class="text-[9px] font-black text-amber-500 mt-1 uppercase italic tracking-tighter">
                                Data: {{ $inscricao->evento->data_inicio->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center text-xs font-black text-gray-900 dark:text-white italic font-sans italic tracking-tighter uppercase uppercase font-sans">
                            {{ $inscricao->data_inscricao->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-5 text-center font-sans italic text-xs uppercase font-sans">
                            @php
                                $stMap = [
                                    'confirmada' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800',
                                    'presente' => 'bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800',
                                    'ausente' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                                    'cancelada' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800',
                                ];
                                $stClass = $stMap[$inscricao->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                            @endphp
                            <span class="px-3 py-1 text-[9px] font-black rounded-lg border {{ $stClass }} uppercase tracking-widest italic font-sans">
                                {{ $inscricao->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right font-sans italic text-xs uppercase italic font-sans">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all font-sans italic text-xs uppercase">
                                <a href="{{ route('admin.programas-agricultura.inscricoes.show', $inscricao->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-amber-600 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm font-sans italic" title="Validar Inscrição">
                                    <x-icon name="clipboard-check" class="w-5 h-5 font-sans italic text-xs" style="duotone" />
                                </a>
                                <form action="{{ route('admin.programas-agricultura.inscricoes.destroy', $inscricao->id) }}" method="POST" onsubmit="return confirm('Deseja realmente anular esta inscrição?')" class="inline italic">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-10 h-10 text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm font-sans italic">
                                        <x-icon name="trash" class="w-5 h-5 font-sans italic text-xs" style="duotone" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium italic">Nenhuma inscrição processada na base de dados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inscricoes->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $inscricoes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
