@props(['ordemId', 'tipo' => 'antes'])

<div class="upload-fotos-container" data-ordem-id="{{ $ordemId }}" data-tipo="{{ $tipo }}">
    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-orange-500 dark:hover:border-orange-400 transition-colors cursor-pointer"
         onclick="document.getElementById('input-fotos-{{ $tipo }}-{{ $ordemId }}').click()">
        
        <input type="file" 
               id="input-fotos-{{ $tipo }}-{{ $ordemId }}" 
               class="hidden" 
               accept="image/*" 
               multiple 
               capture="environment"
               onchange="handleFotoUpload(this, '{{ $ordemId }}', '{{ $tipo }}')">
        
        <div class="flex flex-col items-center gap-3">
            <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    Tirar foto ou selecionar imagem
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $tipo === 'antes' ? 'Registre o estado antes do serviço' : 'Registre o resultado do serviço' }}
                </p>
            </div>
            <span class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-lg transition-colors">
                Adicionar Fotos
            </span>
        </div>
    </div>
    
    <!-- Preview de fotos pendentes (offline) -->
    <div id="preview-fotos-{{ $tipo }}-{{ $ordemId }}" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-3 hidden">
    </div>
    
    <!-- Loading indicator -->
    <div id="loading-{{ $tipo }}-{{ $ordemId }}" class="hidden mt-4">
        <div class="flex items-center justify-center gap-3 p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
            <svg class="animate-spin w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm text-orange-700 dark:text-orange-300">Enviando fotos...</span>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
async function handleFotoUpload(input, ordemId, tipo) {
    const files = Array.from(input.files);
    if (!files.length) return;
    
    const loadingEl = document.getElementById(`loading-${tipo}-${ordemId}`);
    const previewEl = document.getElementById(`preview-fotos-${tipo}-${ordemId}`);
    
    loadingEl.classList.remove('hidden');
    
    for (const file of files) {
        try {
            // Verificar se está online ou offline
            if (navigator.onLine) {
                // Upload normal
                const formData = new FormData();
                formData.append('tipo', tipo);
                formData.append('fotos[]', file);
                
                const response = await fetch(`/campo/ordens/${ordemId}/fotos`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Adicionar preview da foto enviada
                    if (result.fotos && result.fotos.length > 0) {
                        result.fotos.forEach(url => {
                            addFotoPreview(previewEl, url, false);
                        });
                    }
                } else {
                    throw new Error(result.error || 'Erro ao enviar foto');
                }
            } else {
                // Modo offline - salvar localmente
                if (window.campoOffline) {
                    const dataURL = await fileToDataURL(file);
                    await window.campoOffline.saveFotoOffline(parseInt(ordemId), dataURL, tipo);
                    
                    // Mostrar preview local
                    addFotoPreview(previewEl, dataURL, true);
                    
                    window.campoOffline.showNotification('Foto salva para envio quando online', 'warning');
                }
            }
        } catch (error) {
            console.error('Erro ao processar foto:', error);
            
            // Tentar salvar offline em caso de erro
            if (window.campoOffline) {
                try {
                    const dataURL = await fileToDataURL(file);
                    await window.campoOffline.saveFotoOffline(parseInt(ordemId), dataURL, tipo);
                    addFotoPreview(previewEl, dataURL, true);
                    window.campoOffline.showNotification('Foto salva localmente (erro de conexão)', 'warning');
                } catch (e) {
                    window.campoOffline.showNotification('Erro ao salvar foto', 'error');
                }
            }
        }
    }
    
    loadingEl.classList.add('hidden');
    input.value = ''; // Limpar input para permitir novo upload
    
    // Recarregar página se online para mostrar fotos
    if (navigator.onLine) {
        location.reload();
    }
}

function fileToDataURL(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = e => resolve(e.target.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

function addFotoPreview(container, src, isOffline = false) {
    container.classList.remove('hidden');
    
    const div = document.createElement('div');
    div.className = 'relative group';
    div.innerHTML = `
        <img src="${src}" alt="Preview" class="w-full h-32 object-cover rounded-lg border ${isOffline ? 'border-orange-400' : 'border-gray-200'} dark:border-gray-600">
        ${isOffline ? `
            <div class="absolute top-2 left-2 px-2 py-1 bg-orange-500 text-white text-xs font-medium rounded-full flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pendente
            </div>
        ` : ''}
    `;
    
    container.appendChild(div);
}
</script>
@endpush
@endonce
