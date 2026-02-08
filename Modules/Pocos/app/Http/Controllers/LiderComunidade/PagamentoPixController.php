<?php

namespace Modules\Pocos\App\Http\Controllers\LiderComunidade;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Models\MensalidadePoco;
use Modules\Pocos\App\Models\PagamentoPixPoco;
use Modules\Pocos\App\Services\PixService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoPixController extends Controller
{
    protected $pixService;

    public function __construct(PixService $pixService)
    {
        $this->pixService = $pixService;
    }

    /**
     * Gerar QR Code PIX para uma mensalidade
     */
    public function gerarQrCode(Request $request, MensalidadePoco $mensalidade)
    {
        $lider = Auth::user()->liderComunidade;
        
        if (!$lider || $lider->id !== $mensalidade->lider_id) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        if (!$lider->chave_pix || !$lider->pix_ativo) {
            return response()->json(['error' => 'Chave PIX não cadastrada ou inativa.'], 400);
        }

        try {
            $usuarioPocoId = $request->input('usuario_poco_id');
            $resultado = $this->pixService->criarCobranca($mensalidade, $lider, $usuarioPocoId);

            return response()->json([
                'success' => true,
                'pagamento_pix' => $resultado['pagamento_pix'],
                'qr_code_base64' => $resultado['qr_code']['imagem'] ?? null,
                'qr_code_string' => $resultado['qr_code']['qrcode'] ?? null,
                'txid' => $resultado['txid'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Consultar status de um pagamento PIX
     */
    public function consultarStatus(PagamentoPixPoco $pagamentoPix)
    {
        $lider = Auth::user()->liderComunidade;
        
        if (!$lider || $lider->id !== $pagamentoPix->lider_id) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        try {
            $status = $this->pixService->consultarCobranca($pagamentoPix->txid);
            
            if ($status && isset($status['status']) && $status['status'] === 'CONCLUIDA') {
                $pagamentoPix->update([
                    'status' => 'pago',
                    'data_pagamento' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'status' => $pagamentoPix->status,
                'data_pagamento' => $pagamentoPix->data_pagamento,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Listar pagamentos PIX de uma mensalidade
     */
    public function index(MensalidadePoco $mensalidade)
    {
        $lider = Auth::user()->liderComunidade;
        
        if (!$lider || $lider->id !== $mensalidade->lider_id) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Não autorizado.');
        }

        $pagamentosPix = $mensalidade->pagamentosPix()
            ->with(['usuarioPoco'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pocos::lider-comunidade.pagamentos-pix.index', compact('mensalidade', 'pagamentosPix'));
    }
}

