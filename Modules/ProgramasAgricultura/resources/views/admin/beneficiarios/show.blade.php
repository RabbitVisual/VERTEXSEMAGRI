@extends('admin.layouts.admin')

@section('title', 'Ficha do Beneficiário - ' . $beneficiario->nome_completo)

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans italic">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700 font-sans italic text-xs uppercase">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-sans italic tracking-tighter uppercase uppercase">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg font-sans italic text-xs uppercase">
                    <x-icon name="user-check" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans italic text-xs uppercase" style="duotone" />
                </div>
                <span>Ficha do Beneficiário</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic text-xs uppercase">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <a href="{{ route('admin.programas-agricultura.beneficiarios.index') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase">Beneficiários</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans italic text-xs uppercase">{{ $beneficiario->cpf_formatado }}</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans italic text-xs uppercase">
             <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-colors font-sans italic text-xs uppercase">
                <x-icon name="print" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                Imprimir Prontuário
            </button>
            <a href="{{ route('admin.programas-agricultura.beneficiarios.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-colors font-sans italic text-xs uppercase">
                <x-icon name="arrow-left" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                Voltar
            </a>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-sans italic text-xs uppercase font-sans italic tracking-tighter uppercase font-black text-[10px]">
        <!-- Coluna de Identificação -->
        <div class="space-y-6 font-sans italic text-xs uppercase">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-200 dark:border-slate-700/50 text-center font-sans italic text-xs uppercase">
                <div class="w-24 h-24 bg-gradient-to-br from-amber-100 to-amber-200 rounded-3xl mx-auto flex items-center justify-center text-amber-600 text-3xl font-black italic shadow-inner border-4 border-white dark:border-slate-700 mb-4 font-sans italic text-xs uppercase">
                    {{ substr($beneficiario->nome_completo, 0, 1) }}
                </div>
                <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight font-sans italic text-xs uppercase">{{ $beneficiario->nome_completo }}</h2>
                <p class="text-xs text-gray-500 font-bold italic font-sans italic text-xs uppercase">{{ $beneficiario->cpf_formatado }}</p>

                <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-700 font-sans italic text-xs uppercase">
                     <span class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-black uppercase tracking-tighter italic font-sans italic text-xs uppercase">
                        {{ $beneficiario->status_texto }}
                    </span>
                </div>
            </div>

            <div class="bg-slate-900 rounded-3xl p-6 text-white font-sans italic text-xs uppercase">
                 <h3 class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-6 italic font-sans italic text-xs uppercase">Vinculação Setorial</h3>
                 <div class="space-y-4 font-sans italic text-xs uppercase">
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">PROGRAMA</p>
                        <p class="font-bold tracking-tight italic text-amber-500 font-sans italic text-xs uppercase">{{ $beneficiario->programa->nome ?? 'N/A' }}</p>
                    </div>
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">DATA DE ADESÃO</p>
                        <p class="font-bold tracking-tight italic font-sans italic text-xs uppercase">{{ optional($beneficiario->data_inscricao)->format('d/m/Y') ?: '--/--/----' }}</p>
                    </div>
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">TERRITÓRIO</p>
                        <p class="font-bold tracking-tight italic font-sans italic text-xs uppercase">{{ $beneficiario->localidade->nome ?? 'N/A' }}</p>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Coluna de Gestão -->
        <div class="lg:col-span-2 space-y-6 font-sans italic text-xs uppercase">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-gray-200 dark:border-slate-700/50 font-sans italic text-xs uppercase">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2 italic font-sans italic text-xs uppercase">
                    <x-icon name="gears" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                    Gestão de Status e Observações
                </h3>

                <form action="{{ route('admin.programas-agricultura.beneficiarios.update-status', $beneficiario->id) }}" method="POST" class="space-y-6 font-sans italic text-xs uppercase">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic font-sans italic text-xs uppercase text-xs uppercase">Alterar Estágio do Benefício</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 font-sans italic text-xs uppercase">
                            @foreach(['inscrito', 'aprovado', 'beneficiado', 'rejeitado'] as $st)
                            <label class="relative font-sans italic text-xs uppercase">
                                <input type="radio" name="status" value="{{ $st }}" class="sr-only peer" {{ $beneficiario->status == $st ? 'checked' : '' }}>
                                <div class="w-full py-4 text-center rounded-2xl border-2 border-gray-100 dark:border-slate-700 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20 transition-all cursor-pointer font-sans italic text-xs uppercase">
                                    <span class="text-[10px] font-black uppercase italic text-gray-400 peer-checked:text-amber-700 dark:peer-checked:text-amber-400 font-sans italic text-xs uppercase">{{ $st }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="observacoes" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic font-sans italic text-xs uppercase text-xs uppercase">Parecer Técnico / Notas de Gestão</label>
                        <textarea name="observacoes" id="observacoes" rows="4" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-2xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all italic font-sans italic text-xs uppercase">{{ old('observacoes', $beneficiario->observacoes) }}</textarea>
                    </div>

                    <div class="flex justify-end font-sans italic text-xs uppercase">
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 dark:bg-blue-600 text-white rounded-2xl hover:bg-slate-800 transition-all shadow-xl font-black uppercase tracking-widest text-[10px] italic font-sans italic text-xs uppercase">
                            <x-icon name="floppy-disk" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                            Consolidar Parecer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Prontuário Histórico -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-gray-200 dark:border-slate-700/50 font-sans italic text-xs uppercase">
                 <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 italic font-sans italic text-xs uppercase">Linha do Tempo de Cadastro</h3>
                 <div class="space-y-6 font-sans italic text-xs uppercase">
                    <div class="flex gap-4 font-sans italic text-xs uppercase">
                        <div class="w-8 flex flex-col items-center font-sans italic text-xs uppercase">
                            <div class="w-3 h-3 bg-amber-500 rounded-full font-sans italic text-xs uppercase"></div>
                            <div class="w-0.5 h-full bg-gray-100 dark:bg-slate-700 mt-1 font-sans italic text-xs uppercase"></div>
                        </div>
                        <div>
                             <p class="text-[10px] font-black text-gray-900 dark:text-white uppercase italic font-sans italic text-xs uppercase">Protocolo Inicial</p>
                             <p class="text-[9px] text-gray-500 font-bold italic font-sans italic text-xs uppercase">{{ optional($beneficiario->data_inscricao)->format('d/m/Y H:i') ?: 'Data não registrada' }}</p>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
