@extends('admin.layouts.admin')

@section('title', 'Detalhes da Inscrição - ' . ($inscricao->pessoa->nom_pessoa ?? $inscricao->nome))

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans italic">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700 font-sans italic text-xs uppercase">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-sans italic tracking-tighter uppercase uppercase">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg font-sans italic text-xs uppercase">
                    <x-icon name="address-card" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans italic text-xs uppercase" style="duotone" />
                </div>
                <span>Detalhes da Inscrição</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic text-xs uppercase">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <a href="{{ route('admin.programas-agricultura.inscricoes.index') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase font-sans">Inscrições</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans italic text-xs uppercase">{{ $inscricao->cpf_formatado }}</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans italic text-xs uppercase">
            <a href="{{ route('admin.programas-agricultura.inscricoes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-colors font-sans italic text-xs uppercase">
                <x-icon name="arrow-left" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-sans italic text-xs uppercase font-sans italic tracking-tighter uppercase font-black text-[10px]">
        <!-- Ficha do Inscrito -->
        <div class="space-y-6 font-sans italic text-xs uppercase">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-200 dark:border-slate-700/50 text-center font-sans italic text-xs uppercase">
                 <div class="w-20 h-20 bg-purple-50 dark:bg-slate-900 rounded-2xl mx-auto flex items-center justify-center text-purple-600 text-2xl font-black italic shadow-inner border-2 border-purple-100 dark:border-slate-800 mb-4 font-sans italic text-xs uppercase">
                    {{ substr($inscricao->pessoa->nom_pessoa ?? $inscricao->nome, 0, 1) }}
                </div>
                <h2 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight font-sans italic text-xs uppercase">{{ $inscricao->pessoa->nom_pessoa ?? $inscricao->nome }}</h2>
                <p class="text-[10px] text-gray-500 font-bold italic font-sans italic text-xs uppercase">{{ $inscricao->cpf_formatado }}</p>

                <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-700 font-sans italic text-xs uppercase">
                    <span class="px-4 py-1.5 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-tighter italic font-sans italic text-xs uppercase">
                        {{ $inscricao->status_texto }}
                    </span>
                </div>
            </div>

            <div class="bg-slate-900 rounded-3xl p-6 text-white font-sans italic text-xs uppercase">
                 <h3 class="text-[10px] font-black text-purple-400 uppercase tracking-widest mb-6 italic font-sans italic text-xs uppercase font-sans">Vínculo com Evento</h3>
                 <div class="space-y-4 font-sans italic text-xs uppercase">
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">EVENTO ALVO</p>
                        <p class="font-bold tracking-tight italic text-amber-500 font-sans italic text-xs uppercase uppercase">{{ $inscricao->evento->titulo ?? 'N/A' }}</p>
                    </div>
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">DATA DA INSCRIÇÃO</p>
                        <p class="font-bold tracking-tight italic font-sans italic text-xs uppercase">{{ optional($inscricao->data_inscricao)->format('d/m/Y') ?: '--/--/----' }}</p>
                    </div>
                    <div class="font-sans italic text-xs uppercase font-black text-[10px]">
                        <p class="text-[9px] text-slate-400 font-sans italic text-xs uppercase">CÓDIGO PROTOCOLO</p>
                        <p class="font-bold tracking-tight italic font-sans italic text-xs uppercase">#EV-{{ str_pad($inscricao->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Coluna de Gestão de Presença -->
        <div class="lg:col-span-2 space-y-6 font-sans italic text-xs uppercase">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-gray-200 dark:border-slate-700/50 font-sans italic text-xs uppercase">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2 italic font-sans italic text-xs uppercase font-sans">
                    <x-icon name="clipboard-user" class="w-4 h-4 font-sans italic text-xs uppercase font-sans" style="duotone" />
                    Validação de Presença e Status
                </h3>

                <form action="{{ route('admin.programas-agricultura.inscricoes.update-status', $inscricao->id) }}" method="POST" class="space-y-6 font-sans italic text-xs uppercase">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic font-sans italic text-xs uppercase text-xs uppercase">Estado da Participação</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 font-sans italic text-xs uppercase">
                            @foreach(['inscrito', 'confirmado', 'presente', 'ausente', 'cancelado'] as $st)
                            <label class="relative font-sans italic text-xs uppercase">
                                <input type="radio" name="status" value="{{ $st }}" class="sr-only peer" {{ $inscricao->status == $st ? 'checked' : '' }}>
                                <div class="w-full py-4 text-center rounded-2xl border-2 border-gray-100 dark:border-slate-700 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all cursor-pointer font-sans italic text-xs uppercase">
                                    <span class="text-[9px] font-black uppercase italic text-gray-400 peer-checked:text-purple-700 dark:peer-checked:text-purple-400 font-sans italic text-xs uppercase">{{ $st }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="observacoes" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic font-sans italic text-xs uppercase text-xs uppercase">Notas Extras / Justificativa</label>
                        <textarea name="observacoes" id="observacoes" rows="4" placeholder="Ex: Justificativa de ausência ou notas sobre a participação..." class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-2xl focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all italic font-sans italic text-xs uppercase">{{ old('observacoes', $inscricao->observacoes) }}</textarea>
                    </div>

                    <div class="flex justify-end font-sans italic text-xs uppercase">
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition-all shadow-xl font-black uppercase tracking-widest text-[10px] italic font-sans italic text-xs uppercase">
                            <x-icon name="check-to-slot" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                            Validar Status
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-blue-50 dark:bg-slate-900/50 rounded-3xl p-6 border border-blue-100 dark:border-slate-800 font-sans italic text-xs uppercase">
                <div class="flex items-start gap-4 font-sans italic text-xs uppercase">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-xl font-sans italic text-xs uppercase">
                        <x-icon name="circle-info" class="w-5 h-5 text-blue-600 dark:text-blue-400 font-sans italic text-xs uppercase" style="duotone" />
                    </div>
                    <div class="font-sans italic text-xs uppercase">
                        <p class="text-xs font-black text-blue-900 dark:text-blue-200 uppercase mb-1 italic font-sans italic text-xs uppercase">Contatos do Participante</p>
                        <div class="space-y-1 font-sans italic text-xs uppercase">
                             <p class="text-[11px] font-bold text-blue-700 dark:text-blue-300 italic font-sans italic text-xs uppercase"><span class="opacity-50 font-black">TLF:</span> {{ $inscricao->telefone ?: ($inscricao->pessoa->num_tel_pessoa ?? 'N/I') }}</p>
                             <p class="text-[11px] font-bold text-blue-700 dark:text-blue-300 italic font-sans italic text-xs uppercase"><span class="opacity-50 font-black">EML:</span> {{ $inscricao->email ?: ($inscricao->pessoa->des_email_pessoa ?? 'N/I') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
