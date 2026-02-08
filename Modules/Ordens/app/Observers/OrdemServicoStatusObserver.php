<?php

namespace Modules\Ordens\App\Observers;

use Modules\Ordens\App\Models\OrdemServico;
use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Funcionarios\App\Services\FuncionarioStatusService;
use Illuminate\Support\Facades\Log;

class OrdemServicoStatusObserver
{
    protected $statusService;

    public function __construct(FuncionarioStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Handle the OrdemServico "updating" event.
     * Disparado ANTES de salvar as alterações
     */
    public function updating(OrdemServico $ordem): void
    {
        // Verificar mudança de status
        if ($ordem->isDirty('status')) {
            $statusAntigo = $ordem->getOriginal('status');
            $statusNovo = $ordem->status;

            Log::info("Ordem #{$ordem->numero} mudando status", [
                'status_antigo' => $statusAntigo,
                'status_novo' => $statusNovo,
                'funcionario_id' => $ordem->funcionario_id,
            ]);

            // Se estava em execução e agora foi concluída ou cancelada
            if ($statusAntigo === 'em_execucao' && in_array($statusNovo, ['concluida', 'cancelada'])) {
                if ($ordem->funcionario_id) {
                    $this->liberarFuncionario($ordem->funcionario_id, $ordem->id);
                }
            }

            // Se era pendente e passou para em_execucao
            if ($statusAntigo === 'pendente' && $statusNovo === 'em_execucao') {
                if ($ordem->funcionario_id) {
                    $this->ocuparFuncionario($ordem->funcionario_id, $ordem->id);
                }
            }
        }

        // Verificar mudança de funcionário
        if ($ordem->isDirty('funcionario_id')) {
            $funcionarioAntigoId = $ordem->getOriginal('funcionario_id');
            $funcionarioNovoId = $ordem->funcionario_id;

            // Liberar funcionário anterior se existir e ordem está em execução
            if ($funcionarioAntigoId && $ordem->status === 'em_execucao') {
                $this->liberarFuncionario($funcionarioAntigoId, $ordem->id);
            }

            // Ocupar novo funcionário se ordem está em execução
            if ($funcionarioNovoId && $ordem->status === 'em_execucao') {
                $this->ocuparFuncionario($funcionarioNovoId, $ordem->id);
            }
        }
    }

    /**
     * Marca funcionário como ocupado
     */
    protected function ocuparFuncionario(int $funcionarioId, int $ordemId): void
    {
        try {
            $resultado = $this->statusService->iniciarAtendimento($funcionarioId, $ordemId);

            if ($resultado['success']) {
                Log::info("Funcionário #{$funcionarioId} marcado como em atendimento da OS #{$ordemId}");
            } else {
                Log::warning("Não foi possível marcar funcionário como em atendimento", [
                    'funcionario_id' => $funcionarioId,
                    'ordem_id' => $ordemId,
                    'motivo' => $resultado['message'] ?? 'Desconhecido',
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Erro ao ocupar funcionário: " . $e->getMessage(), [
                'funcionario_id' => $funcionarioId,
                'ordem_id' => $ordemId,
            ]);
        }
    }

    /**
     * Libera funcionário
     */
    protected function liberarFuncionario(int $funcionarioId, int $ordemId): void
    {
        try {
            $funcionario = Funcionario::find($funcionarioId);

            if (!$funcionario) {
                return;
            }

            // Só liberar se realmente está atendendo esta ordem
            if ($funcionario->ordem_servico_atual_id === $ordemId) {
                $funcionario->finalizarAtendimento();
                Log::info("Funcionário #{$funcionarioId} liberado da OS #{$ordemId}");
            }
        } catch (\Exception $e) {
            Log::error("Erro ao liberar funcionário: " . $e->getMessage(), [
                'funcionario_id' => $funcionarioId,
                'ordem_id' => $ordemId,
            ]);
        }
    }
}

