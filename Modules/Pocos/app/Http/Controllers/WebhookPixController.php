<?php

namespace Modules\Pocos\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Services\PixService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookPixController extends Controller
{
    protected $pixService;

    public function __construct(PixService $pixService)
    {
        $this->pixService = $pixService;
    }

    /**
     * Receber webhook de pagamento PIX
     */
    public function webhook(Request $request)
    {
        try {
            $dados = $request->all();
            
            Log::info('Webhook PIX recebido:', $dados);

            // Validar assinatura do webhook (se configurado)
            // $assinatura = $request->header('X-Signature');
            // if (!$this->validarAssinatura($dados, $assinatura)) {
            //     return response()->json(['error' => 'Assinatura inválida'], 401);
            // }

            // Processar webhook
            $processado = $this->pixService->processarWebhook($dados);

            if ($processado) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['error' => 'Erro ao processar webhook'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook PIX: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao processar webhook'], 500);
        }
    }

    /**
     * Validar assinatura do webhook (implementar conforme PSP)
     */
    protected function validarAssinatura(array $dados, ?string $assinatura): bool
    {
        // Implementar validação de assinatura conforme documentação do PSP
        // Por exemplo, usando HMAC SHA256
        return true; // Por enquanto, sempre retorna true
    }
}

