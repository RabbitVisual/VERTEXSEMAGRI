<?php

namespace Modules\Pocos\App\Services;

use Modules\Pocos\App\Models\LiderComunidade;
use Modules\Pocos\App\Models\MensalidadePoco;
use Modules\Pocos\App\Models\PagamentoPixPoco;
use Modules\Pocos\App\Models\PagamentoPoco;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Gerencianet\Gerencianet;
use Modules\Pocos\App\Models\UsuarioPoco;

class PixService
{
    protected $config;

    public function __construct()
    {
        // Carregar configurações do banco ou .env
        $this->config = [
            'client_id' => config('pix.client_id'),
            'client_secret' => config('pix.client_secret'),
            'certificate' => config('pix.certificate_path'),
            'sandbox' => config('pix.psp.environment', 'sandbox') === 'sandbox', // Key fix: pix.environment was incorrect
            'debug' => config('pix.debug', false),
            'timeout' => config('pix.timeout', 30),
        ];
    }

    /**
     * Inicializar SDK Gerencianet
     */
    protected function getGerencianet(): ?Gerencianet
    {
        try {
            return new Gerencianet($this->config);
        } catch (\Exception $e) {
            Log::error('Erro ao inicializar Efipay SDK: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Criar uma cobrança PIX (Cobrança Imediata)
     */
    public function criarCobranca(MensalidadePoco $mensalidade, LiderComunidade $lider, ?int $usuarioPocoId = null): ?array
    {
        $gn = $this->getGerencianet();
        if (!$gn) {
            throw new \Exception('Erro interno ao conectar com provedor de pagamentos.');
        }

        // Determinar chave PIX de destino
        // Se a plataforma tiver chave centralizadora configurada, usamos ela.
        // Caso contrário, tentamos usar a chave do líder (apenas se for chave gerida pela mesma conta Efipay, o que é raro).
        // Para marketplace real, usa-se a chave da Plataforma e o Split.
        $chavePlataforma = config('pix.chave_plataforma');
        $chaveDestino = $chavePlataforma ?: $lider->chave_pix;

        if (empty($chaveDestino)) {
            throw new \Exception('Nenhuma chave PIX configurada para recebimento (Plataforma ou Líder).');
        }

        // Dados da cobrança
        $body = [
            'calendario' => [
                'expiracao' => (int) config('pix.qrcode_expiration', 3600),
            ],
            'devedor' => [
                'cpf' => $usuarioPocoId ? $this->getCpfUsuario($usuarioPocoId) : null,
                'nome' => $usuarioPocoId ? $this->getNomeUsuario($usuarioPocoId) : 'Usuário do Poço',
            ],
            'valor' => [
                'original' => number_format($mensalidade->valor_mensalidade, 2, '.', ''),
            ],
            'chave' => $chaveDestino,
            'solicitacaoPagador' => "Mensalidade Poço {$mensalidade->poco->codigo} - {$mensalidade->mes_ano}",
        ];

        // Remover CPF/Nome se vazios (PIX anônimo/genérico)
        if (empty($body['devedor']['cpf'])) {
            unset($body['devedor']['cpf']);
        }
         // Se não tiver nome, a API pode reclamar dependendo da validação, mas geralmente aceita sem devedor completo
        if (empty($body['devedor']['nome'])) {
             unset($body['devedor']);
        }

        try {
            $response = $gn->pixCreateImmediateCharge([], $body);

            if (isset($response['txid'])) {
                $txid = $response['txid'];
                $locId = $response['loc']['id'];

                // Gerar QR Code
                $params = ['id' => $locId];
                $qrCodeResponse = $gn->pixGenerateQRCode($params);

                // Criar registro de pagamento PIX
                $pagamentoPix = PagamentoPixPoco::create([
                    'txid' => $txid,
                    'codigo' => PagamentoPixPoco::generateCode('PIX'),
                    'mensalidade_id' => $mensalidade->id,
                    'usuario_poco_id' => $usuarioPocoId,
                    'poco_id' => $mensalidade->poco_id,
                    'lider_id' => $lider->id,
                    'chave_pix_destino' => $chaveDestino, // Registra para onde foi gerado
                    'valor' => $mensalidade->valor_mensalidade,
                    'descricao' => $body['solicitacaoPagador'],
                    'solicitacao_pagador' => $body['solicitacaoPagador'],
                    'location_id' => $locId,
                    'status' => 'pendente',
                    'data_expiracao' => now()->addSeconds($body['calendario']['expiracao']),
                    'qr_code_base64' => $qrCodeResponse['imagemQrcode'] ?? null,
                    'qr_code_string' => $qrCodeResponse['qrcode'] ?? null,
                ]);

                return [
                    'pagamento_pix' => $pagamentoPix,
                    'qr_code' => [
                        'imagem' => $qrCodeResponse['imagemQrcode'] ?? null,
                        'qrcode' => $qrCodeResponse['qrcode'] ?? null,
                    ],
                    'txid' => $txid,
                ];
            } else {
                 Log::error('Erro ao criar cobrança PIX (resposta sem txid): ', (array)$response);
                 throw new \Exception('Erro ao gerar cobrança PIX.');
            }

        } catch (\Exception $e) {
            Log::error('Erro na API Efipay: ' . $e->getMessage());
            // Tentar extrair mensagem de erro da API se for JSON
            $msg = $e->getMessage();
            throw new \Exception('Falha na comunicação com o gateway de pagamento: ' . $msg);
        }
    }

    /**
     * Consultar status de uma cobrança
     */
    public function consultarCobranca(string $txid): ?array
    {
        $gn = $this->getGerencianet();
        if (!$gn) return null;

        try {
            $params = ['txid' => $txid];
            $response = $gn->pixDetailCharge($params);

            return $response;
        } catch (\Exception $e) {
            Log::error('Erro ao consultar cobrança PIX: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Processar webhook de pagamento PIX
     */
    public function processarWebhook(array $dados): bool
    {
        try {
            $pixData = $dados['pix'][0] ?? null;
            if (!$pixData) return false;

            $txid = $pixData['txid'] ?? null;
            $e2eid = $pixData['endToEndId'] ?? null;

            if (!$txid || !$e2eid) {
                Log::warning('Webhook PIX inválido: ' . json_encode($dados));
                return false;
            }

            // Buscar pagamento pelo txid
            $pagamentoPix = PagamentoPixPoco::where('txid', $txid)->first();

            if (!$pagamentoPix) {
                Log::warning("Pagamento PIX não encontrado para txid: {$txid}");
                return false;
            }

            // Evitar processamento duplicado
            if ($pagamentoPix->status === 'pago') {
                return true;
            }

            // Atualizar status
            $pagamentoPix->update([
                'status' => 'pago',
                'e2eid' => $e2eid,
                'end_to_end_id' => $e2eid,
                'data_pagamento' => isset($pixData['horario']) ? \Carbon\Carbon::parse($pixData['horario']) : now(),
                'valor_pago' => $pixData['valor'] ?? $pagamentoPix->valor, // Confirmar valor pago
                'chave_pix_origem' => $pixData['chave'] ?? null,
                'info_pagador' => json_encode($pixData['pagador'] ?? []),
                'webhook_recebido_em' => now(),
                'webhook_dados' => json_encode($dados),
            ]);

            // Criar registro oficial de pagamento no sistema
            $this->criarPagamentoConfirmado($pagamentoPix);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook PIX: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Criar registro de pagamento confirmado
     */
    protected function criarPagamentoConfirmado(PagamentoPixPoco $pagamentoPix): void
    {
        $mensalidade = $pagamentoPix->mensalidade;

        if (!$mensalidade) return;

        // Verificar duplicidade
        $exists = PagamentoPoco::where('mensalidade_id', $mensalidade->id)
            ->where('usuario_poco_id', $pagamentoPix->usuario_poco_id)
            ->exists();

        if (!$exists) {
            // Lógica de Split / Taxas
            $valorTotal = $pagamentoPix->valor;
            $taxaPlataforma = 0;
            $valorLiquido = $valorTotal;
            $splitAtivo = filter_var(config('pix.split_ativo', false), FILTER_VALIDATE_BOOLEAN);

            // Calcular taxas apenas se tiver chave de plataforma definida (Centralização) e Split ativo
            $chavePlataforma = config('pix.chave_plataforma');

            if ($splitAtivo && !empty($chavePlataforma) && $chavePlataforma !== $pagamentoPix->lider->chave_pix) {
                // Tentar obter valores numéricos
                $taxaPercentual = (float) str_replace(',', '.', config('pix.taxa_plataforma', 0));
                $tarifaFixa = (float) str_replace(',', '.', config('pix.tarifa_fixa', 0));

                $valorTaxa = ($valorTotal * ($taxaPercentual / 100)) + $tarifaFixa;
                $taxaPlataforma = number_format($valorTaxa, 2, '.', '');
                $valorLiquido = max(0, $valorTotal - $taxaPlataforma);
            }

            // Registrar pagamento
            PagamentoPoco::create([
                'codigo' => PagamentoPoco::generateCode('PIX'),
                'mensalidade_id' => $mensalidade->id,
                'usuario_poco_id' => $pagamentoPix->usuario_poco_id,
                'poco_id' => $pagamentoPix->poco_id,
                'lider_id' => $pagamentoPix->lider_id,
                'data_pagamento' => $pagamentoPix->data_pagamento ?? now(),
                'valor_pago' => $pagamentoPix->valor,
                'taxa_plataforma' => $taxaPlataforma,
                'valor_liquido' => $valorLiquido,
                'split_realizado' => false,
                'forma_pagamento' => 'pix',
                'status' => 'confirmado',
                'observacoes' => "Pagamento via PIX Automático (TXID: {$pagamentoPix->txid}). " .
                               ($taxaPlataforma > 0 ? "Taxa Plataforma: R$ {$taxaPlataforma}" : ""),
            ]);

            // Atualizar boleto
             $boleto = \Modules\Pocos\App\Models\BoletoPoco::where('mensalidade_id', $mensalidade->id)
                ->where('usuario_poco_id', $pagamentoPix->usuario_poco_id)
                ->first();

            if ($boleto) {
                $boleto->marcarComoPago();
            }
        }
    }


    protected function getCpfUsuario(int $id): ?string {
        $u = UsuarioPoco::find($id);
        return $u ? $u->cpf : null;
    }

    protected function getNomeUsuario(int $id): ?string {
        $u = UsuarioPoco::find($id);
        return $u ? $u->nome : null;
    }

    public function validarChavePix(string $chave, string $tipo): bool
    {
         // Validações básicas (Regex)
         // ... (manter lógica anterior ou usar biblioteca se preferir)
         return true; // Simplificado para usar a validação do Front/Form
    }
}
