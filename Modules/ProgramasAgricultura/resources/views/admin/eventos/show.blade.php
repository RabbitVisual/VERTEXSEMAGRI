@extends('admin.layouts.admin')

@section('title', $evento->titulo . ' - Detalhes do Evento')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans italic">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700 font-sans italic text-xs uppercase">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-sans italic tracking-tighter uppercase uppercase">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg font-sans italic text-xs uppercase">
                    <x-icon name="calendar-check" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans italic text-xs uppercase" style="duotone" />
                </div>
                <span>{{ $evento->titulo }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic text-xs uppercase font-sans">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <a href="{{ route('admin.programas-agricultura.eventos.index') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase">Eventos</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans italic text-xs uppercase">{{ $evento->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans italic text-xs uppercase">
            <a href="{{ route('admin.programas-agricultura.eventos.edit', $evento->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 font-black uppercase tracking-widest text-[10px] font-sans italic text-xs uppercase">
                <x-icon name="calendar-pen" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                Reprogramar
            </a>
            <a href="{{ route('admin.programas-agricultura.eventos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-colors font-sans italic text-xs uppercase font-black">
                <x-icon name="arrow-left" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 font-sans italic text-xs uppercase font-sans italic tracking-tighter uppercase font-black text-[10px]">
        <!-- Painel de Controle LESTE -->
        <div class="lg:col-span-1 space-y-6 font-sans italic text-xs uppercase">
            <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-gray-100 dark:border-slate-700/50 shadow-sm font-sans italic text-xs uppercase">
                <div class="flex flex-col items-center text-center font-sans italic text-xs uppercase">
                    <span class="px-4 py-1.5 rounded-full border border-amber-100 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-tighter mb-4 italic font-sans italic text-xs uppercase">
                        {{ $evento->status_texto }}
                    </span>

                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 italic font-sans italic text-xs uppercase">Inscrições Realizadas</div>
                    <div class="text-4xl font-black text-gray-900 dark:text-white italic tracking-tighter font-sans italic text-xs uppercase">
                        {{ $evento->inscricoes_confirmadas_count }} / {{ $evento->vagas_totais ?: '∞' }}
                    </div>

                    @if($evento->vagas_totais > 0)
                    <div class="w-full h-2 bg-gray-100 dark:bg-slate-900 rounded-full mt-4 overflow-hidden shadow-inner font-sans italic text-xs uppercase">
                        @php $perc = min(100, ($evento->inscricoes_confirmadas_count / $evento->vagas_totais) * 100); @endphp
                        <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-600 font-sans italic text-xs uppercase" style="width: {{ $perc }}%"></div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="p-6 bg-slate-900 rounded-3xl text-white font-sans italic text-xs uppercase">
                <h4 class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-4 italic font-sans italic text-xs uppercase font-sans">Agenda Técnica</h4>
                <div class="space-y-4 font-sans italic text-xs uppercase">
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">DATA DO EVENTO</p>
                        <p class="font-bold tracking-tight italic font-sans italic text-xs uppercase uppercase">{{ $evento->data_inicio->format('d/m/Y') }}</p>
                    </div>
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">HORÁRIO</p>
                        <p class="font-bold tracking-tight italic font-sans italic text-xs uppercase uppercase">{{ \Carbon\Carbon::parse($evento->hora_inicio)->format('H:i') }}</p>
                    </div>
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">INSTRUTOR</p>
                        <p class="font-bold tracking-tight italic font-sans italic text-xs uppercase uppercase">{{ $evento->instrutor_palestrante ?: 'NÃO INFORMADO' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteúdo OESTE -->
        <div class="lg:col-span-3 space-y-6 font-sans italic text-xs uppercase">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-gray-100 dark:border-slate-700/50 shadow-sm font-sans italic text-xs uppercase">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-sans italic text-xs uppercase">
                    <div class="font-sans italic text-xs uppercase font-sans">
                        <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4 flex items-center gap-2 italic font-sans italic text-xs uppercase font-sans">
                            <x-icon name="map-pin" class="w-4 h-4 font-sans italic text-xs uppercase font-sans" style="duotone" />
                            Local de Realização
                        </h4>
                        <p class="text-sm font-black text-gray-900 dark:text-white italic font-sans italic text-xs uppercase">{{ $evento->localidade->nome ?? 'LOCAL EXTERNO' }}</p>
                        <p class="text-xs text-gray-500 italic mt-1 font-sans italic text-xs uppercase uppercase">{{ $evento->endereco }}</p>
                    </div>
                    <div class="font-sans italic text-xs uppercase font-sans">
                        <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-4 flex items-center gap-2 italic font-sans italic text-xs uppercase font-sans">
                             <x-icon name="circle-nodes" class="w-4 h-4 font-sans italic text-xs uppercase font-sans" style="duotone" />
                            Modalidade
                        </h4>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-lg text-[10px] font-black uppercase tracking-widest italic font-sans italic text-xs uppercase">
                            {{ $evento->tipo_texto }}
                        </span>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-100 dark:border-slate-700 font-sans italic text-xs uppercase">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic font-sans italic text-xs uppercase font-sans">Objetivos do Evento</h4>
                    <p class="text-sm text-gray-700 dark:text-gray-300 italic leading-relaxed font-sans italic text-xs uppercase">
                        {{ $evento->descricao ?: 'Sem detalhamento ementário cadastrado.' }}
                    </p>
                </div>
            </div>

            <!-- Listagem de Inscritos -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden border border-gray-100 dark:border-slate-700/50 shadow-sm font-sans italic text-xs uppercase">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between font-sans italic text-xs uppercase">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic font-sans italic text-xs uppercase font-sans">Lista de Presença / Inscritos</h3>
                    <a href="{{ route('admin.programas-agricultura.eventos.index') }}" class="text-[10px] font-black text-amber-600 uppercase italic font-sans italic text-xs uppercase font-sans">Listagem Completa</a>
                </div>
                <div class="overflow-x-auto font-sans italic text-xs uppercase">
                    <table class="w-full text-left font-sans italic text-xs uppercase">
                        <thead class="bg-slate-50/30 dark:bg-slate-900/10 font-sans italic text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest italic font-sans">Participante</th>
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest italic font-sans">CPF</th>
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest italic font-sans">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-sans italic text-xs uppercase">
                            @forelse($evento->inscricoes as $ins)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-900 transition-colors font-sans italic text-xs uppercase">
                                <td class="px-6 py-4 font-sans italic text-xs uppercase font-bold text-gray-900 dark:text-gray-200">{{ $ins->pessoa->nom_pessoa ?? $ins->nome }}</td>
                                <td class="px-6 py-4 font-sans italic text-xs uppercase font-medium text-gray-500">{{ $ins->cpf_formatado }}</td>
                                <td class="px-6 py-4 font-sans italic text-xs uppercase">
                                    <span class="text-[10px] font-black text-amber-600 uppercase italic font-sans italic text-xs uppercase">{{ $ins->status }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-xs text-gray-400 italic font-sans italic text-xs uppercase">Nenhuma inscrição protocolada para este evento.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
