@props(['funcionario'])

@if($funcionario->estaEmAtendimento() && $funcionario->ordemServicoAtual)
<div class="mb-8 p-8 bg-amber-50 dark:bg-amber-950/20 border-l-4 border-amber-500 rounded-r-[2rem] shadow-xl shadow-amber-500/5 animate-fade-in relative overflow-hidden group">
    <div class="absolute top-0 right-0 -mt-12 -mr-12 opacity-5 pointer-events-none group-hover:scale-110 transition-transform">
        <x-icon name="truck-fast" style="duotone" class="w-48 h-48" />
    </div>

    <div class="relative z-10 flex items-start gap-6">
        <div class="w-14 h-14 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-500/20 shrink-0">
            <x-icon name="satellite-dish" style="duotone" class="w-7 h-7 animate-pulse" />
        </div>

        <div class="flex-1 space-y-4">
            <div>
                <h3 class="text-sm font-black text-amber-900 dark:text-amber-200 uppercase tracking-tight">Efetivo em Engajamento Ativo</h3>
                <p class="text-[10px] font-black text-amber-700/60 dark:text-amber-400/60 uppercase tracking-widest italic mt-1">Sinal de rádio detectado em campo</p>
            </div>

            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-amber-800 dark:text-amber-300 uppercase tracking-widest italic">Missão:</span>
                    <a href="{{ route('admin.ordens.show', $funcionario->ordemServicoAtual->id) }}" class="px-4 py-1.5 bg-amber-500 text-white rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all shadow-md">
                        #{{ $funcionario->ordemServicoAtual->numero }}
                    </a>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <x-icon name="clock" class="w-3 h-3 text-amber-500" />
                        <span class="text-[10px] font-black text-amber-900 dark:text-amber-200 tabular-nums">{{ $funcionario->tempo_atendimento }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-icon name="location-dot" class="w-3 h-3 text-amber-500" />
                        <span class="text-[10px] font-black text-amber-900 dark:text-amber-200 uppercase tracking-tight">{{ $funcionario->ordemServicoAtual->demanda->localidade->nome ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
