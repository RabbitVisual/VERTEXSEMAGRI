<?php

namespace Modules\Funcionarios\App\Services;

use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Ordens\App\Models\OrdemServico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FuncionarioStatusService
{
    /**
     * Verifica se o funcionário pode receber uma nova ordem
     */
    public function podeReceberOrdem(int $funcionarioId): array
    {
        $funcionario = Funcionario::find($funcionarioId);

        if (!$funcionario) {
            return [
                'pode' => false,
                'motivo' => 'Funcionário não encontrado.',
            ];
        }

        if (!$funcionario->ativo) {
            return [
                'pode' => false,
                'motivo' => 'Funcionário está inativo.',
            ];
        }

        if ($funcionario->estaEmAtendimento()) {
            return [
                'pode' => false,
                'motivo' => "Funcionário está em atendimento da OS #{$funcionario->ordemServicoAtual->numero}.",
                'ordem_atual' => $funcionario->ordemServicoAtual,
            ];
        }

        if ($funcionario->status_campo === 'pausado') {
            return [
                'pode' => false,
                'motivo' => 'Funcionário está com status pausado.',
            ];
        }

        if ($funcionario->status_campo === 'offline') {
            return [
                'pode' => false,
                'motivo' => 'Funcionário está offline.',
            ];
        }

        return [
            'pode' => true,
            'motivo' => 'Funcionário disponível.',
        ];
    }

    /**
     * Inicia atendimento de uma ordem
     */
    public function iniciarAtendimento(int $funcionarioId, int $ordemServicoId): array
    {
        DB::beginTransaction();
        try {
            $funcionario = Funcionario::findOrFail($funcionarioId);
            $ordem = OrdemServico::findOrFail($ordemServicoId);

            // Verificar se pode receber ordem
            $verificacao = $this->podeReceberOrdem($funcionarioId);
            if (!$verificacao['pode']) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => $verificacao['motivo'],
                ];
            }

            // Verificar se a ordem não está sendo atendida por outro
            if ($ordem->status === 'em_execucao' && $ordem->funcionario_id !== $funcionarioId) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Esta ordem já está sendo atendida por outro funcionário.',
                ];
            }

            // Atualizar funcionário
            $funcionario->iniciarAtendimento($ordemServicoId);

            // Atualizar ordem
            $ordem->update([
                'status' => 'em_execucao',
                'data_inicio' => $ordem->data_inicio ?? now(),
                'funcionario_id' => $funcionarioId,
            ]);

            DB::commit();

            Log::info("Atendimento iniciado", [
                'funcionario_id' => $funcionarioId,
                'ordem_servico_id' => $ordemServicoId,
            ]);

            return [
                'success' => true,
                'message' => 'Atendimento iniciado com sucesso.',
                'funcionario' => $funcionario->fresh(),
                'ordem' => $ordem->fresh(),
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro ao iniciar atendimento: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao iniciar atendimento: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Finaliza atendimento de uma ordem
     */
    public function finalizarAtendimento(int $funcionarioId, int $ordemServicoId): array
    {
        DB::beginTransaction();
        try {
            $funcionario = Funcionario::findOrFail($funcionarioId);
            $ordem = OrdemServico::findOrFail($ordemServicoId);

            // Verificar se o funcionário está atendendo esta ordem
            if ($funcionario->ordem_servico_atual_id !== $ordemServicoId) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Este funcionário não está atendendo esta ordem.',
                ];
            }

            // Calcular tempo de execução
            $tempoExecucao = 0;
            if ($funcionario->atendimento_iniciado_em) {
                $tempoExecucao = $funcionario->atendimento_iniciado_em->diffInMinutes(now());
            }

            // Atualizar funcionário
            $funcionario->finalizarAtendimento();

            // Atualizar ordem
            $ordem->update([
                'status' => 'concluida',
                'data_conclusao' => now(),
                'tempo_execucao' => $tempoExecucao,
            ]);

            DB::commit();

            Log::info("Atendimento finalizado", [
                'funcionario_id' => $funcionarioId,
                'ordem_servico_id' => $ordemServicoId,
                'tempo_execucao' => $tempoExecucao,
            ]);

            return [
                'success' => true,
                'message' => 'Atendimento finalizado com sucesso.',
                'tempo_execucao' => $tempoExecucao,
                'funcionario' => $funcionario->fresh(),
                'ordem' => $ordem->fresh(),
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro ao finalizar atendimento: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao finalizar atendimento: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Cancela atendimento (libera funcionário sem concluir ordem)
     */
    public function cancelarAtendimento(int $funcionarioId, string $motivo = null): array
    {
        DB::beginTransaction();
        try {
            $funcionario = Funcionario::findOrFail($funcionarioId);

            if (!$funcionario->estaEmAtendimento()) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Funcionário não está em atendimento.',
                ];
            }

            $ordemId = $funcionario->ordem_servico_atual_id;

            // Liberar funcionário
            $funcionario->finalizarAtendimento();

            // Voltar ordem para pendente
            if ($ordemId) {
                $ordem = OrdemServico::find($ordemId);
                if ($ordem) {
                    $ordem->update([
                        'status' => 'pendente',
                        'data_inicio' => null,
                    ]);

                    if ($motivo) {
                        $ordem->observacoes = ($ordem->observacoes ? $ordem->observacoes . "\n\n" : '')
                            . "Atendimento cancelado em " . now()->format('d/m/Y H:i') . ": {$motivo}";
                        $ordem->save();
                    }
                }
            }

            DB::commit();

            Log::info("Atendimento cancelado", [
                'funcionario_id' => $funcionarioId,
                'ordem_servico_id' => $ordemId,
                'motivo' => $motivo,
            ]);

            return [
                'success' => true,
                'message' => 'Atendimento cancelado com sucesso.',
                'funcionario' => $funcionario->fresh(),
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro ao cancelar atendimento: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao cancelar atendimento: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Retorna estatísticas de status dos funcionários
     */
    public function getEstatisticas(): array
    {
        return [
            'total' => Funcionario::where('ativo', true)->count(),
            'disponiveis' => Funcionario::disponiveis()->count(),
            'em_atendimento' => Funcionario::emAtendimento()->count(),
            'pausados' => Funcionario::where('status_campo', 'pausado')->count(),
            'offline' => Funcionario::where('status_campo', 'offline')->count(),
        ];
    }

    /**
     * Retorna lista de funcionários em atendimento com detalhes
     */
    public function getFuncionariosEmAtendimento()
    {
        return Funcionario::emAtendimento()
            ->with(['ordemServicoAtual.demanda.localidade'])
            ->get()
            ->map(function($funcionario) {
                return [
                    'id' => $funcionario->id,
                    'nome' => $funcionario->nome,
                    'funcao' => $funcionario->funcao,
                    'ordem_numero' => $funcionario->ordemServicoAtual->numero,
                    'ordem_id' => $funcionario->ordemServicoAtual->id,
                    'tipo_servico' => $funcionario->ordemServicoAtual->tipo_servico,
                    'localidade' => $funcionario->ordemServicoAtual->demanda->localidade->nome ?? 'N/A',
                    'tempo_atendimento' => $funcionario->tempo_atendimento,
                    'iniciado_em' => $funcionario->atendimento_iniciado_em?->format('d/m/Y H:i'),
                ];
            });
    }

    /**
     * Atualiza status do funcionário (disponível, pausado, offline)
     */
    public function atualizarStatus(int $funcionarioId, string $novoStatus): array
    {
        try {
            $funcionario = Funcionario::findOrFail($funcionarioId);

            // Se está em atendimento, não pode mudar para certos status
            if ($funcionario->estaEmAtendimento() && in_array($novoStatus, ['disponivel', 'offline'])) {
                return [
                    'success' => false,
                    'message' => 'Não é possível alterar o status enquanto há atendimento em andamento.',
                ];
            }

            $funcionario->update([
                'status_campo' => $novoStatus,
                'ultima_atualizacao_status' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'Status atualizado com sucesso.',
                'funcionario' => $funcionario->fresh(),
            ];

        } catch (\Exception $e) {
            Log::error("Erro ao atualizar status: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao atualizar status: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Força a liberação de um funcionário (Admin)
     */
    public function forcarLiberacao(int $funcionarioId, string $motivo): array
    {
        return $this->cancelarAtendimento($funcionarioId, "LIBERAÇÃO FORÇADA: " . $motivo);
    }
}

