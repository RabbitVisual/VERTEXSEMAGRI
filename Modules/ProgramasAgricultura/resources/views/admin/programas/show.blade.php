@extends('admin.layouts.admin')

@section('title', $programa->nome . ' - Detalhes do Programa')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans italic">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700 font-sans italic">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-sans italic tracking-tighter uppercase">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg font-sans italic">
                    <x-icon name="leaf" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans italic" style="duotone" />
                </div>
                <span>{{ $programa->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic text-xs uppercase">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 font-sans italic">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic" />
                <a href="{{ route('admin.programas-agricultura.programas.index') }}" class="hover:text-amber-600 font-sans italic">Programas</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans italic">{{ $programa->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans italic">
            <a href="{{ route('admin.programas-agricultura.programas.edit', $programa->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 font-black uppercase tracking-widest text-[10px] font-sans italic">
                <x-icon name="pencil-square" class="w-4 h-4 font-sans italic" style="duotone" />
                Editar Estrutura
            </a>
            <a href="{{ route('admin.programas-agricultura.programas.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-colors font-sans italic uppercase text-[10px] font-black">
                <x-icon name="arrow-left" class="w-4 h-4 font-sans italic" style="duotone" />
                Voltar
            </a>
        </div>
    </div>

    <!-- Dashboard do Programa -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 font-sans italic text-xs uppercase">
        <!-- Estatísticas Rápidas -->
        <div class="lg:col-span-1 space-y-6 font-sans italic">
            <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-gray-100 dark:border-slate-700/50 shadow-sm font-sans italic">
                <div class="flex flex-col items-center text-center font-sans italic text-xs uppercase">
                    @php
                        $stMap = [
                            'ativo' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800',
                            'suspenso' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                            'encerrado' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800',
                        ];
                    @endphp
                    <span class="px-4 py-1.5 rounded-full border {{ $stMap[$programa->status] ?? '' }} text-[10px] font-black uppercase tracking-tighter mb-4 italic font-sans italic">
                        {{ $programa->status }}
                    </span>

                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 italic font-sans italic">Taxa de Ocupação</div>
                    <div class="text-4xl font-black text-gray-900 dark:text-white italic tracking-tighter font-sans italic">
                         @if($programa->vagas_disponiveis > 0)
                            {{ number_format(($programa->beneficiarios_ativos_count / $programa->vagas_disponiveis) * 100, 0) }}%
                        @else
                            100%
                        @endif
                    </div>

                    <div class="w-full h-2 bg-gray-100 dark:bg-slate-900 rounded-full mt-4 overflow-hidden shadow-inner font-sans italic uppercase">
                        @php $perc = $programa->vagas_disponiveis > 0 ? min(100, ($programa->beneficiarios_ativos_count / $programa->vagas_disponiveis) * 100) : 100; @endphp
                        <div class="h-full bg-gradient-to-r from-amber-400 to-amber-600 font-sans italic" style="width: {{ $perc }}%"></div>
                    </div>
                    <p class="text-[9px] text-gray-500 mt-2 font-bold italic font-sans">
                        {{ $programa->beneficiarios_ativos_count }} DE {{ $programa->vagas_disponiveis ?: '∞' }} VAGAS
                    </p>
                </div>
            </div>

            <div class="p-6 bg-slate-900 rounded-3xl text-white font-sans italic uppercase text-[10px]">
                <h4 class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-4 italic font-sans">Ficha Técnica</h4>
                <div class="space-y-4 font-sans italic">
                    <div class="font-sans italic uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic">TIPO</p>
                        <p class="font-bold tracking-tight italic font-sans uppercase">{{ $programa->tipo_texto }}</p>
                    </div>
                    <div class="font-sans italic uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic">INÍCIO DA VIGÊNCIA</p>
                        <p class="font-bold tracking-tight italic font-sans uppercase">{{ optional($programa->data_inicio)->format('d/m/Y') ?: 'ABERTO' }}</p>
                    </div>
                    <div class="font-sans italic uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic">ÓRGÃO GESTOR</p>
                        <p class="font-bold tracking-tight italic font-sans uppercase">{{ $programa->orgao_responsavel }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteúdo Detalhado -->
        <div class="lg:col-span-3 space-y-6 font-sans italic text-xs uppercase">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-gray-100 dark:border-slate-700/50 shadow-sm font-sans italic">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-sans italic">
                    <div class="font-sans italic uppercase text-xs">
                        <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4 flex items-center gap-2 italic font-sans">
                            <x-icon name="circle-info" class="w-4 h-4 font-sans" style="duotone" />
                            Escopo do Programa
                        </h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300 italic leading-relaxed font-sans uppercase text-xs">
                            {{ $programa->descricao ?: 'Sem descrição detalhada cadastrada.' }}
                        </p>
                    </div>
                    <div class="font-sans italic uppercase text-xs">
                        <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-4 flex items-center gap-2 italic uppercase font-sans">
                            <x-icon name="file-contract" class="w-4 h-4 font-sans uppercase" style="duotone" />
                            Requisitos de Acesso
                        </h4>
                        <ul class="space-y-2 text-xs text-gray-700 dark:text-gray-300 font-sans italic uppercase text-xs">
                             <li class="flex items-start gap-2 italic uppercase font-sans">
                                <x-icon name="check-double" class="w-4 h-4 text-emerald-500 mt-0.5 font-sans italic text-xs uppercase" />
                                <span class="font-bold italic">{{ $programa->requisitos ?: 'Requisitos padrão da Secretaria' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-100 dark:border-slate-700 font-sans italic uppercase text-xs">
                    <h4 class="text-[10px] font-black text-purple-600 uppercase tracking-widest mb-4 flex items-center gap-2 italic font-sans uppercase text-xs">
                        <x-icon name="list-check" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                        Documentação Necessária
                    </h4>
                    <div class="flex flex-wrap gap-2 font-sans italic uppercase text-xs">
                        @foreach(explode(',', $programa->documentos_necessarios) as $doc)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg text-[10px] font-black text-gray-600 dark:text-gray-400 uppercase tracking-tighter italic font-sans uppercase text-xs">
                                {{ trim($doc) ?: 'Padrão Setorial' }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Listagem Rápida de Beneficiários vinculados -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden border border-gray-100 dark:border-slate-700/50 shadow-sm font-sans italic uppercase text-xs">
                 <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between font-sans italic uppercase text-xs">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic font-sans uppercase text-xs">Últimos Beneficiários Vinculados</h3>
                    <a href="{{ route('admin.programas-agricultura.beneficiarios.index', ['programa_id' => $programa->id]) }}" class="text-[10px] font-black text-amber-600 uppercase hover:underline italic font-sans uppercase text-xs">Ver Todos</a>
                </div>
                <div class="overflow-x-auto font-sans italic uppercase text-xs">
                    <table class="w-full text-left font-sans italic uppercase text-xs">
                        <thead class="bg-slate-50/30 dark:bg-slate-900/10 font-sans italic uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest italic font-sans">Beneficiário</th>
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest italic font-sans">Status</th>
                                <th class="px-6 py-3 text-right font-sans"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-sans italic uppercase text-xs">
                            @foreach($programa->beneficiarios()->latest()->take(5)->get() as $ben)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-900 transition-colors font-sans italic uppercase text-xs">
                                <td class="px-6 py-4 font-sans italic uppercase text-xs">
                                    <div class="flex items-center gap-3 font-sans italic uppercase text-xs">
                                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 font-black text-[10px] font-sans italic text-xs uppercase">
                                            {{ substr($ben->pessoa->nom_pessoa ?? '?', 0, 1) }}
                                        </div>
                                        <span class="text-xs font-bold text-gray-900 dark:text-gray-200 font-sans italic uppercase text-xs">{{ $ben->pessoa->nom_pessoa ?? 'Excluído' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-sans italic uppercase text-xs">
                                    <span class="text-[9px] font-black text-amber-500 uppercase italic font-sans uppercase text-xs">{{ $ben->status }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-sans italic uppercase text-xs">
                                    <a href="{{ route('admin.programas-agricultura.beneficiarios.show', $ben->id) }}" class="text-xs font-black text-blue-600 hover:text-blue-800 italic font-sans uppercase text-xs">FICHA</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
