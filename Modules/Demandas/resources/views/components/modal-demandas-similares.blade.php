@props(['demanda' => null, 'score' => 0, 'confianca' => 'baixa'])

<div id="modalDemandasSimilares" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Panel -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">

            <!-- Header -->
            <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-amber-500 to-orange-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <x-icon name="triangle-exclamation" class="w-6 h-6 text-white" />
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">
                                Demanda Similar Encontrada
                            </h3>
                            <p class="text-sm text-amber-100">
                                Similaridade detectada: <strong>{{ $score }}%</strong> ({{ ucfirst($confianca) }})
                            </p>
                        </div>
                    </div>
                    <button type="button" onclick="fecharModalSimilares()" class="text-white/70 hover:text-white transition-colors">
                        <x-icon name="xmark" class="w-6 h-6" />
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="px-4 py-5 sm:p-6 space-y-4">
                <div class="p-4 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800">
                    <p class="text-sm text-amber-800 dark:text-amber-200">
                        O sistema detectou que você está tentando cadastrar uma demanda muito parecida com uma já existente e aberta.
                        Para evitar duplicidade, sugerimos vincular este novo pedido à demanda já existente.
                    </p>
                </div>

                @if($demanda)
                <div class="border rounded-xl overflow-hidden border-gray-200 dark:border-gray-700">
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <span class="font-semibold text-gray-700 dark:text-gray-200">Demanda Existente #{{ $demanda->codigo }}</span>
                        <a href="{{ route('demandas.show', $demanda->id) }}" target="_blank" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                            Ver detalhes completos
                            <x-icon name="arrow-up-right-from-square" class="w-3 h-3" />
                        </a>
                    </div>
                    <div class="p-4 space-y-3 bg-white dark:bg-gray-800">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Solicitante</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $demanda->solicitante_nome ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Localidade</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $demanda->localidade->nome ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $demanda->created_at->format('d/m/Y H:i') }} ({{ $demanda->created_at->diffForHumans() }})</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Interessados</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $demanda->total_interessados }} pessoa(s)
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Descrição</label>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1 bg-gray-50 dark:bg-gray-900 p-2 rounded border border-gray-100 dark:border-gray-700">
                                {{ Str::limit($demanda->descricao, 200) }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer Buttons -->
            <div class="px-4 py-4 sm:px-6 bg-gray-50 dark:bg-gray-700/30 flex flex-col sm:flex-row gap-3 sm:justify-end">
                <button type="button" onclick="criarNovaDemanda()" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700 w-full sm:w-auto order-2 sm:order-1">
                    <x-icon name="plus" class="w-4 h-4 mr-2" />
                    Ignorar e Criar Nova
                </button>
                <button type="button" onclick="vincularDemandaExistente()" class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto order-1 sm:order-2">
                    <x-icon name="link" class="w-4 h-4 mr-2" />
                    Vincular a esta Demanda
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variável global
    window.demandaSimilarId = '{{ $demanda?->id ?? '' }}';

    function fecharModalSimilares() {
        const modal = document.getElementById('modalDemandasSimilares');
        if (modal) modal.classList.add('hidden');
    }

    function vincularDemandaExistente() {
        if (!window.demandaSimilarId) return;
        submitFormWithAction(window.demandaSimilarId, '');
    }

    function criarNovaDemanda() {
        submitFormWithAction('', '1');
    }

    function submitFormWithAction(vincularId, forcarNova) {
        const form = document.getElementById('demandaForm');
        if (!form) return;

        let vincularInput = document.getElementById('vincular_demanda_id');
        let forcarInput = document.getElementById('forcar_criar_nova');

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

        vincularInput.value = vincularId;
        forcarInput.value = forcarNova;
        form.submit();
    }
</script>
