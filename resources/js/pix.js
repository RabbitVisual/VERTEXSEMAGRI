/**
 * Gerenciamento de PIX - QR Code e Pagamentos
 */

import QRCode from 'qrcode';

/**
 * Gerar QR Code PIX para uma mensalidade
 */
export async function gerarQrCodePix(mensalidadeId, usuarioPocoId = null) {
    try {
        const response = await fetch(`/lider-comunidade/mensalidades/${mensalidadeId}/gerar-qrcode-pix`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({
                usuario_poco_id: usuarioPocoId,
            }),
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Erro ao gerar QR Code PIX');
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro ao gerar QR Code PIX:', error);
        throw error;
    }
}

/**
 * Exibir QR Code em um modal
 */
export async function exibirQrCodeModal(mensalidadeId, usuarioPocoId = null) {
    try {
        const data = await gerarQrCodePix(mensalidadeId, usuarioPocoId);
        
        // Criar modal
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50';
        modal.innerHTML = `
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">QR Code PIX</h3>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="text-center mb-4">
                    <div id="qrcode-container" class="flex justify-center mb-4"></div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        Valor: <strong class="text-gray-900 dark:text-white">R$ ${parseFloat(data.pagamento_pix.valor).toFixed(2).replace('.', ',')}</strong>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">
                        Escaneie o QR Code com o app do seu banco
                    </p>
                </div>
                
                <div class="space-y-2">
                    <button onclick="copiarCodigoPix('${data.qr_code_string}')" 
                            class="w-full px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors">
                        Copiar Código PIX
                    </button>
                    <button onclick="consultarStatusPix(${data.pagamento_pix.id})" 
                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-colors">
                        Verificar Pagamento
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Gerar QR Code visual
        if (data.qr_code_string) {
            const canvas = document.createElement('canvas');
            QRCode.toCanvas(canvas, data.qr_code_string, {
                width: 300,
                margin: 2,
            }, (error) => {
                if (error) {
                    console.error('Erro ao gerar QR Code visual:', error);
                    document.getElementById('qrcode-container').innerHTML = '<p class="text-red-600">Erro ao gerar QR Code</p>';
                } else {
                    document.getElementById('qrcode-container').appendChild(canvas);
                }
            });
        } else if (data.qr_code_base64) {
            // Usar imagem base64 se disponível
            const img = document.createElement('img');
            img.src = `data:image/png;base64,${data.qr_code_base64}`;
            img.className = 'w-64 h-64 mx-auto';
            document.getElementById('qrcode-container').appendChild(img);
        }
        
        // Fechar modal ao clicar fora
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
        
    } catch (error) {
        alert('Erro ao gerar QR Code PIX: ' + error.message);
    }
}

/**
 * Copiar código PIX para área de transferência
 */
export function copiarCodigoPix(codigoPix) {
    navigator.clipboard.writeText(codigoPix).then(() => {
        alert('Código PIX copiado para a área de transferência!');
    }).catch((error) => {
        console.error('Erro ao copiar código PIX:', error);
        alert('Erro ao copiar código PIX');
    });
}

/**
 * Consultar status de um pagamento PIX
 */
export async function consultarStatusPix(pagamentoPixId) {
    try {
        const response = await fetch(`/lider-comunidade/mensalidades/pagamentos-pix/${pagamentoPixId}/status`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
        });

        if (!response.ok) {
            throw new Error('Erro ao consultar status');
        }

        const data = await response.json();
        
        if (data.status === 'pago') {
            alert('Pagamento confirmado! O pagamento foi recebido.');
            location.reload(); // Recarregar página para atualizar status
        } else {
            alert('Pagamento ainda pendente. Aguarde a confirmação.');
        }
        
        return data;
    } catch (error) {
        console.error('Erro ao consultar status PIX:', error);
        alert('Erro ao consultar status do pagamento');
    }
}

// Tornar funções globais para uso em onclick
window.exibirQrCodeModal = exibirQrCodeModal;
window.copiarCodigoPix = copiarCodigoPix;
window.consultarStatusPix = consultarStatusPix;

