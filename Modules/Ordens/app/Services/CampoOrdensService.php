<?php

namespace Modules\Ordens\App\Services;

use Modules\Ordens\App\Models\OrdemServico;
use Modules\Demandas\App\Models\Demanda;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CampoOrdensService
{
    /**
     * Busca ordens da equipe do funcionário
     *
     * @param User $user
     * @param array $filtros
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buscarOrdensDoFuncionario(User $user, array $filtros = [])
    {
        $query = OrdemServico::with([
            'demanda.localidade',
            'demanda.pessoa',
            'equipe',
            'funcionario',
            'usuarioAtribuido',
            'usuarioExecucao'
        ])->minhasOrdens($user->id);

        // Filtros
        if (!empty($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        if (!empty($filtros['prioridade'])) {
            $query->where('prioridade', $filtros['prioridade']);
        }

        if (!empty($filtros['search'])) {
            $search = $filtros['search'];
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhereHas('demanda', function($q) use ($search) {
                      $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('solicitante_nome', 'like', "%{$search}%");
                  });
            });
        }

        return $query->orderBy('prioridade', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Inicia o atendimento de uma ordem
     *
     * @param OrdemServico $ordem
     * @param User $user
     * @return bool
     */
    public function iniciarAtendimento(OrdemServico $ordem, User $user): bool
    {
        // Verificar permissões
        if (!$ordem->usuarioPodeAcessar($user->id)) {
            return false;
        }

        if (!$ordem->podeIniciar()) {
            return false;
        }

        // Buscar funcionário associado ao usuário (via email)
        $funcionarioId = null;
        if ($user && $user->email) {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();
            if ($funcionario) {
                $funcionarioId = $funcionario->id;
            }
        }

        DB::beginTransaction();
        try {
            // Atualizar ordem com informações do funcionário
            $updateData = [
                'status' => 'em_execucao',
                'data_inicio' => now(),
                'user_id_execucao' => $user->id,
            ];

            // Preencher funcionario_id se encontrado e ainda não estiver preenchido
            if ($funcionarioId && !$ordem->funcionario_id) {
                $updateData['funcionario_id'] = $funcionarioId;
            }

            // Preencher user_id_atribuido se ainda não estiver preenchido
            if (!$ordem->user_id_atribuido) {
                $updateData['user_id_atribuido'] = $user->id;
            }

            $ordem->update($updateData);

            // Atualizar status da demanda relacionada
            if ($ordem->demanda_id && Schema::hasTable('demandas')) {
                $demanda = Demanda::find($ordem->demanda_id);
                if ($demanda && $demanda->status === 'aberta') {
                    $demanda->update(['status' => 'em_andamento']);
                }
            }

            // Registrar auditoria
            if (class_exists(\App\Models\AuditLog::class)) {
                \App\Models\AuditLog::log(
                    'ordem.iniciar',
                    OrdemServico::class,
                    $ordem->id,
                    'campo',
                    "Ordem de serviço {$ordem->numero} iniciada por {$user->name}" . ($funcionarioId ? " (Funcionário ID: {$funcionarioId})" : ''),
                    null,
                    [
                        'user_id' => $user->id,
                        'funcionario_id' => $funcionarioId,
                    ]
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Erro ao iniciar OS {$ordem->numero}: " . $e->getMessage(), [
                'user_id' => $user->id,
                'ordem_id' => $ordem->id,
                'exception' => $e,
            ]);
            return false;
        }
    }

    /**
     * Conclui uma ordem de serviço
     *
     * @param OrdemServico $ordem
     * @param User $user
     * @param array $dados
     * @return bool
     */
    public function concluirAtendimento(OrdemServico $ordem, User $user, array $dados): bool
    {
        // Verificar permissões
        if (!$ordem->usuarioPodeAcessar($user->id)) {
            return false;
        }

        if (!$ordem->podeConcluir()) {
            return false;
        }

        // Validar dados obrigatórios
        if (empty($dados['relatorio_execucao']) || strlen(trim($dados['relatorio_execucao'])) < 10) {
            return false;
        }

        // PROTEÇÃO CONTRA FRAUDE: Validações adicionais
        $fotosAntes = $ordem->fotos_antes ?? [];
        $fotosDepois = $ordem->fotos_depois ?? [];
        // Calcular tempo de execução garantindo valor positivo
        $tempoExecucao = 0;
        if ($ordem->data_inicio) {
            $tempoExecucao = abs($ordem->data_inicio->diffInMinutes(now()));
        }

        // Validar tempo mínimo de execução (5 minutos) para evitar conclusões instantâneas
        if ($tempoExecucao < 5) {
            \Log::warning("Tentativa de concluir OS {$ordem->numero} com tempo muito curto: {$tempoExecucao} minutos", [
                'user_id' => $user->id,
                'ordem_id' => $ordem->id,
            ]);
            // Permitir mas registrar para auditoria
        }

        // Validar se há fotos antes (obrigatório para comprovar início do trabalho)
        if (empty($fotosAntes)) {
            \Log::warning("Tentativa de concluir OS {$ordem->numero} sem fotos 'antes'", [
                'user_id' => $user->id,
                'ordem_id' => $ordem->id,
            ]);
            // Não bloquear, mas registrar para auditoria
        }

        // Validar se há fotos depois (recomendado para comprovar conclusão)
        if (empty($fotosDepois)) {
            \Log::info("OS {$ordem->numero} concluída sem fotos 'depois'", [
                'user_id' => $user->id,
                'ordem_id' => $ordem->id,
            ]);
        }

        // Validar relatório mínimo (já validado acima, mas garantir qualidade)
        $relatorioLimpo = trim(strip_tags($dados['relatorio_execucao']));
        if (strlen($relatorioLimpo) < 20) {
            return false; // Relatório muito curto
        }

        // Garantir que funcionario_id esteja preenchido
        $funcionarioId = $ordem->funcionario_id;
        if (!$funcionarioId && $user && $user->email) {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();
            if ($funcionario) {
                $funcionarioId = $funcionario->id;
            }
        }

        DB::beginTransaction();
        try {
            $updateData = [
                'status' => 'concluida',
                'data_conclusao' => now(),
                'tempo_execucao' => $tempoExecucao,
                'relatorio_execucao' => $dados['relatorio_execucao'],
                'observacoes' => $dados['observacoes'] ?? null,
            ];

            // Garantir que funcionario_id esteja preenchido na conclusão
            if ($funcionarioId && !$ordem->funcionario_id) {
                $updateData['funcionario_id'] = $funcionarioId;
            }

            // Garantir que user_id_execucao esteja preenchido
            if (!$ordem->user_id_execucao) {
                $updateData['user_id_execucao'] = $user->id;
            }

            $ordem->update($updateData);

            // Confirmar reservas de materiais (converter reservas em saídas definitivas)
            if ($ordem->materiais()->count() > 0) {
                foreach ($ordem->materiais as $ordemMaterial) {
                    $material = $ordemMaterial->material;
                    if ($material) {
                        try {
                            // Confirmar a reserva no estoque
                            $material->confirmarReserva($ordem->id);
                            
                            // Atualizar o status_reserva na tabela ordem_servico_materiais
                            if ($ordemMaterial->status_reserva === 'reservado') {
                                $ordemMaterial->update(['status_reserva' => 'confirmado']);
                            }
                        } catch (\Exception $e) {
                            \Log::warning("Erro ao confirmar reserva de material {$material->id} na OS {$ordem->numero}: " . $e->getMessage());
                        }
                    }
                }
            }

            // Atualizar status da demanda relacionada
            if ($ordem->demanda_id && Schema::hasTable('demandas')) {
                $demanda = Demanda::find($ordem->demanda_id);
                if ($demanda && $demanda->status !== 'concluida') {
                    $demanda->update([
                        'status' => 'concluida',
                        'data_conclusao' => now(),
                    ]);
                }
            }

            // Registrar auditoria da conclusão
            if (class_exists(\App\Models\AuditLog::class)) {
                \App\Models\AuditLog::log(
                    'ordem.concluir',
                    OrdemServico::class,
                    $ordem->id,
                    'campo',
                    "Ordem de serviço {$ordem->numero} concluída por {$user->name}" . ($funcionarioId ? " (Funcionário ID: {$funcionarioId})" : ''),
                    null,
                    [
                        'user_id' => $user->id,
                        'funcionario_id' => $funcionarioId ?? $ordem->funcionario_id,
                        'tempo_execucao' => $tempoExecucao,
                        'tem_fotos_antes' => !empty($fotosAntes),
                        'tem_fotos_depois' => !empty($fotosDepois),
                        'tamanho_relatorio' => strlen($relatorioLimpo),
                    ]
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Erro ao concluir OS {$ordem->numero}: " . $e->getMessage(), [
                'user_id' => $user->id,
                'ordem_id' => $ordem->id,
                'exception' => $e,
            ]);
            return false;
        }
    }

    /**
     * Atualiza o relatório de execução
     *
     * @param OrdemServico $ordem
     * @param User $user
     * @param string $relatorio
     * @return bool
     */
    public function atualizarRelatorio(OrdemServico $ordem, User $user, string $relatorio): bool
    {
        if (!$ordem->usuarioPodeAcessar($user->id)) {
            return false;
        }

        if ($ordem->status !== 'em_execucao') {
            return false;
        }

        $ordem->update(['relatorio_execucao' => $relatorio]);
        return true;
    }

    /**
     * Busca estatísticas do funcionário
     *
     * @param User $user
     * @return array
     */
    public function buscarEstatisticas(User $user): array
    {
        $query = OrdemServico::minhasOrdens($user->id);

        return [
            'total_pendentes' => (clone $query)->pendentes()->count(),
            'total_em_execucao' => (clone $query)->emExecucao()->count(),
            'total_concluidas_hoje' => (clone $query)->concluidas()
                ->whereDate('data_conclusao', today())->count(),
            'total_concluidas_semana' => (clone $query)->concluidas()
                ->whereBetween('data_conclusao', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'ordem_em_execucao' => (clone $query)->emExecucao()
                ->where('user_id_execucao', $user->id)
                ->with(['demanda.localidade'])
                ->first(),
        ];
    }
}

