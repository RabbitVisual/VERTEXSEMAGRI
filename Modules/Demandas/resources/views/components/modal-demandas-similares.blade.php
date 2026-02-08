{{-- Modal para exibir demandas similares encontradas --}}
@props(['demanda' => null, 'score' => 0, 'confianca' => 'baixa'])

{{-- Estilos inline para garantir que o modal funcione corretamente --}}
<style>
    #modalDemandasSimilares {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    #modalDemandasSimilares.hidden {
        display: none !important;
    }
    #modalOverlaySimilares {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.75);
        z-index: 99998;
    }
    #modalContentSimilares {
        position: relative;
        z-index: 100000;
        max-width: 42rem;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>

<div id="modalDemandasSimilares" class="hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Overlay com fundo escuro -->
    <div id="modalOverlaySimilares"></div>

    <!-- Modal Content -->
    <div id="modalContentSimilares" class="bg-white dark:bg-gray-800">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-amber-500 to-orange-500">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white" id="modal-title">Demanda Similar Encontrada!</h3>
                        <p class="text-sm text-white/80">Evite duplicatas vinculando-se à demanda existente</p>
                    </div>
                </div>
                <button type="button" onclick="fecharModalSimilares()" class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-5">
            <!-- Score de Similaridade -->
            <div class="mb-5 p-4 rounded-xl bg-gradient-to-r
                @if($confianca === 'alta') from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-2 border-red-300 dark:border-red-700
                @elseif($confianca === 'media') from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 border-2 border-amber-300 dark:border-amber-700
                @else from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-2 border-blue-300 dark:border-blue-700
                @endif">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl font-bold
                            @if($confianca === 'alta') text-red-600 dark:text-red-400
                            @elseif($confianca === 'media') text-amber-600 dark:text-amber-400
                            @else text-blue-600 dark:text-blue-400
                            @endif">
                            {{ number_format($score, 0) }}%
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                Similaridade
                                @if($confianca === 'alta') Muito Alta
                                @elseif($confianca === 'media') Alta
                                @else Moderada
                                @endif
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                @if($confianca === 'alta')
                                    Esta demanda é praticamente idêntica a uma existente
                                @elseif($confianca === 'media')
                                    Esta demanda é muito similar a uma existente
                                @else
                                    Encontramos uma demanda que pode estar relacionada
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="w-16 h-16">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                  fill="none"
                                  stroke="#e5e7eb"
                                  stroke-width="3" />
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                  fill="none"
                                  stroke="@if($confianca === 'alta')#dc2626 @elseif($confianca === 'media')#d97706 @else#2563eb @endif"
                                  stroke-width="3"
                                  stroke-dasharray="{{ $score }}, 100"
                                  stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
            </div>

            @if($demanda)
            <!-- Detalhes da Demanda Existente -->
            <div class="mb-5 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Demanda Existente
                </h4>

                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ $demanda->codigo }}
                            </span>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($demanda->status === 'aberta') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($demanda->status === 'em_andamento') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                @endif">
                                {{ $demanda->status_texto }}
                            </span>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $demanda->data_abertura?->format('d/m/Y') }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $demanda->motivo }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ Str::limit($demanda->descricao, 150) }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            {{ $demanda->localidade?->nome ?? 'Sem localidade' }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                            {{ $demanda->tipo_texto }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg text-emerald-700 dark:text-emerald-300 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            {{ $demanda->total_interessados ?? 1 }} pessoa(s) afetada(s)
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Explicação -->
            <div class="mb-5 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-700">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div class="flex-1">
                        <h5 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Por que vincular-se?</h5>
                        <ul class="text-xs text-blue-800 dark:text-blue-300 space-y-1 list-disc list-inside">
                            <li>Você receberá todas as atualizações sobre o andamento</li>
                            <li>A prioridade da demanda aumenta com mais pessoas afetadas</li>
                            <li>Evita trabalho duplicado para a equipe de campo</li>
                            <li>Sua descrição adicional será registrada na demanda</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Opções -->
            <div class="space-y-3">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">O que você deseja fazer?</p>

                <!-- Opção 1: Vincular -->
                <button type="button" onclick="vincularDemandaExistente()"
                        class="w-full flex items-center gap-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-300 dark:border-emerald-700 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors group">
                    <div class="p-3 bg-emerald-500 rounded-xl group-hover:bg-emerald-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-sm font-semibold text-emerald-900 dark:text-emerald-200">Vincular-me à demanda existente</div>
                        <div class="text-xs text-emerald-700 dark:text-emerald-400">Recomendado - Você será notificado sobre atualizações</div>
                    </div>
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>

                <!-- Opção 2: Criar nova mesmo assim -->
                <button type="button" onclick="criarNovaDemanda()"
                        class="w-full flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                    <div class="p-3 bg-gray-400 dark:bg-gray-600 rounded-xl group-hover:bg-gray-500 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300">Criar nova demanda mesmo assim</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Caso tenha certeza de que são problemas diferentes</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>

                <!-- Opção 3: Ver demanda existente -->
                @if($demanda)
                <a href="{{ route('demandas.show', $demanda->id) }}" target="_blank"
                   class="w-full flex items-center gap-4 p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-300 dark:border-indigo-700 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors group">
                    <div class="p-3 bg-indigo-500 rounded-xl group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">Ver detalhes da demanda existente</div>
                        <div class="text-xs text-indigo-600 dark:text-indigo-400">Abre em nova aba para você analisar</div>
                    </div>
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
            <button type="button" onclick="fecharModalSimilares()" class="w-full px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                Cancelar e voltar ao formulário
            </button>
        </div>
    </div>
</div>

<script>
// Variável global para armazenar o ID da demanda similar
window.demandaSimilarId = '{{ $demanda?->id ?? '' }}';

function fecharModalSimilares() {
    var modal = document.getElementById('modalDemandasSimilares');
    if (modal) {
        modal.classList.add('hidden');
    }
}

function vincularDemandaExistente() {
    var demandaId = window.demandaSimilarId;
    var form = document.getElementById('demandaForm');
    
    if (demandaId && form) {
        // Adiciona os inputs hidden ao formulário antes de submeter
        var vincularInput = document.getElementById('vincular_demanda_id');
        var forcarInput = document.getElementById('forcar_criar_nova');

        if (!vincularInput) {
            vincularInput = document.createElement('input');
            vincularInput.type = 'hidden';
            vincularInput.id = 'vincular_demanda_id';
            vincularInput.name = 'vincular_demanda_id';
            form.appendChild(vincularInput);
        }

        if (!forcarInput) {
            forcarInput = document.createElement('input');
            forcarInput.type = 'hidden';
            forcarInput.id = 'forcar_criar_nova';
            forcarInput.name = 'forcar_criar_nova';
            form.appendChild(forcarInput);
        }

        vincularInput.value = demandaId;
        forcarInput.value = '';
        form.submit();
    }
}

function criarNovaDemanda() {
    var form = document.getElementById('demandaForm');
    
    if (form) {
        // Adiciona os inputs hidden ao formulário antes de submeter
        var vincularInput = document.getElementById('vincular_demanda_id');
        var forcarInput = document.getElementById('forcar_criar_nova');

        if (!vincularInput) {
            vincularInput = document.createElement('input');
            vincularInput.type = 'hidden';
            vincularInput.id = 'vincular_demanda_id';
            vincularInput.name = 'vincular_demanda_id';
            form.appendChild(vincularInput);
        }

        if (!forcarInput) {
            forcarInput = document.createElement('input');
            forcarInput.type = 'hidden';
            forcarInput.id = 'forcar_criar_nova';
            forcarInput.name = 'forcar_criar_nova';
            form.appendChild(forcarInput);
        }

        vincularInput.value = '';
        forcarInput.value = '1';
        form.submit();
    }
}

// Inicialização quando o DOM estiver pronto
(function() {
    function initModal() {
        var overlay = document.getElementById('modalOverlaySimilares');
        if (overlay) {
            overlay.onclick = fecharModalSimilares;
        }

        // Abrir modal se houver demandas similares (via sessão)
        @if(session('warning_similaridade'))
        var modal = document.getElementById('modalDemandasSimilares');
        if (modal) {
            modal.classList.remove('hidden');
            console.log('Modal de demandas similares aberto');
        }
        @endif
    }

    // Executar quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModal);
    } else {
        initModal();
    }

    // Fechar modal com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalSimilares();
        }
    });
})();
</script>
