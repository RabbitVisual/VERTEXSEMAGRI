@props(['funcionario'])

@if($funcionario->estaEmAtendimento() && $funcionario->ordemServicoAtual)
<div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 dark:bg-amber-900/20 dark:border-amber-600">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-amber-600 dark:text-amber-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-amber-900 dark:text-amber-200">
                Funcionário em Atendimento
            </h3>
            <div class="mt-2 text-sm text-amber-800 dark:text-amber-300">
                <p>
                    Este funcionário está atualmente atendendo a
                    <a href="{{ route('admin.ordens.show', $funcionario->ordemServicoAtual->id) }}" class="font-semibold underline hover:text-amber-900 dark:hover:text-amber-100">
                        OS #{{ $funcionario->ordemServicoAtual->numero }}
                    </a>
                </p>
                <div class="mt-2 flex items-center gap-4 text-xs">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $funcionario->tempo_atendimento }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        {{ $funcionario->ordemServicoAtual->demanda->localidade->nome ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

