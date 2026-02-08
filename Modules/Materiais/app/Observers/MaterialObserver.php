<?php

namespace Modules\Materiais\App\Observers;

use Modules\Materiais\App\Models\Material;
use Modules\Notificacoes\App\Services\NotificacaoService;
use Illuminate\Support\Facades\Log;

class MaterialObserver
{
    protected $notificacaoService;

    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    /**
     * Handle the Material "updated" event.
     */
    public function updated(Material $material): void
    {
        // Verificar se quantidade_estoque foi alterada
        if ($material->wasChanged('quantidade_estoque')) {
            $oldEstoque = $material->getOriginal('quantidade_estoque');
            $this->verificarEstoqueBaixo($material, $oldEstoque);
        }
    }

    /**
     * Verifica se o estoque está baixo e envia notificação se necessário
     */
    protected function verificarEstoqueBaixo(Material $material, float $oldEstoque): void
    {
        try {
            // Verificar se está com estoque baixo agora
            $estaBaixoAgora = $material->estaComEstoqueBaixo();
            $estavaBaixoAntes = $oldEstoque <= $material->quantidade_minima;

            // Só enviar notificação se:
            // 1. Está baixo agora E não estava baixo antes (acabou de ficar baixo)
            // 2. OU está baixo agora E não foi enviado alerta nas últimas 24 horas
            if ($estaBaixoAgora && (!$estavaBaixoAntes || !$material->ultimo_alerta_estoque || $material->ultimo_alerta_estoque->lt(now()->subHours(24)))) {
                $tipoNotificacao = $material->quantidade_estoque <= 0 ? 'error' : 'warning';
                $mensagem = $material->quantidade_estoque <= 0
                    ? "O material {$material->nome} ({$material->codigo}) está SEM ESTOQUE!"
                    : "O material {$material->nome} ({$material->codigo}) está com estoque baixo: {$material->quantidade_estoque} {$material->unidade_medida} (mínimo: {$material->quantidade_minima} {$material->unidade_medida})";

                // Notificar admins
                $this->notificacaoService->sendToRole(
                    'admin',
                    $tipoNotificacao,
                    $material->quantidade_estoque <= 0 ? 'Material Sem Estoque' : 'Material com Estoque Baixo',
                    $mensagem,
                    route('admin.materiais.show', $material->id),
                    [
                        'material_id' => $material->id,
                        'codigo' => $material->codigo,
                        'nome' => $material->nome,
                        'quantidade_estoque' => $material->quantidade_estoque,
                        'quantidade_minima' => $material->quantidade_minima,
                        'categoria' => $material->categoria,
                    ],
                    'Materiais',
                    Material::class,
                    $material->id
                );

                // Atualizar timestamp do último alerta
                $material->update(['ultimo_alerta_estoque' => now()]);
            }
        } catch (\Exception $e) {
            // Log do erro mas não interrompe o fluxo
            Log::warning('Erro ao verificar estoque baixo no Observer: ' . $e->getMessage(), [
                'material_id' => $material->id,
                'error' => $e->getTraceAsString(),
            ]);
        }
    }
}
