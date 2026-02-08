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
                        <x-icon name="eye" class="w-5 h-5" />
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
