<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfflineSyncLog;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Materiais\App\Models\Material;
use Modules\Localidades\App\Models\Localidade;
use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Equipes\App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CampoApiController extends Controller
{
    /**
     * Retorna ordens do funcionário para cache offline
     * Inclui todos os dados necessários para trabalhar sem internet
     */
    public function ordens(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        try {
            $ordens = OrdemServico::with([
                'demanda:id,codigo,solicitante_nome,solicitante_telefone,tipo,localidade_id,prioridade,motivo,descricao',
                'demanda.localidade:id,nome,codigo,latitude,longitude',
                'equipe:id,nome,codigo',
                'funcionario:id,nome,funcao,telefone',
                'materiais.material:id,nome,codigo,unidade_medida,quantidade_estoque,valor_unitario'
            ])
            ->minhasOrdens($user->id)
            ->whereIn('status', ['pendente', 'em_execucao'])
            ->orderBy('prioridade', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($ordem) {
                return [
                    'id' => $ordem->id,
                    'numero' => $ordem->numero,
                    'tipo_servico' => $ordem->tipo_servico,
                    'descricao' => $ordem->descricao,
                    'prioridade' => $ordem->prioridade,
                    'prioridade_texto' => $ordem->prioridade_texto,
                    'status' => $ordem->status,
                    'status_texto' => $ordem->status_texto,
                    'data_abertura' => $ordem->data_abertura?->format('Y-m-d H:i:s'),
                    'data_inicio' => $ordem->data_inicio?->format('Y-m-d H:i:s'),
                    'relatorio_execucao' => $ordem->relatorio_execucao,
                    'observacoes' => $ordem->observacoes,
                    'fotos_antes' => $ordem->fotos_antes ?? [],
                    'fotos_depois' => $ordem->fotos_depois ?? [],
                    'demanda' => $ordem->demanda ? [
                        'id' => $ordem->demanda->id,
                        'codigo' => $ordem->demanda->codigo,
                        'solicitante' => $ordem->demanda->solicitante_nome,
                        'telefone' => $ordem->demanda->solicitante_telefone,
                        'tipo' => $ordem->demanda->tipo,
                        'prioridade' => $ordem->demanda->prioridade,
                        'motivo' => $ordem->demanda->motivo,
                        'descricao' => $ordem->demanda->descricao,
                        'localidade' => $ordem->demanda->localidade ? [
                            'id' => $ordem->demanda->localidade->id,
                            'nome' => $ordem->demanda->localidade->nome,
                            'codigo' => $ordem->demanda->localidade->codigo,
                            'latitude' => $ordem->demanda->localidade->latitude,
                            'longitude' => $ordem->demanda->localidade->longitude,
                        ] : null,
                    ] : null,
                    'equipe' => $ordem->equipe ? [
                        'id' => $ordem->equipe->id,
                        'nome' => $ordem->equipe->nome,
                        'codigo' => $ordem->equipe->codigo,
                    ] : null,
                    'funcionario' => $ordem->funcionario ? [
                        'id' => $ordem->funcionario->id,
                        'nome' => $ordem->funcionario->nome,
                        'funcao' => $ordem->funcionario->funcao,
                        'telefone' => $ordem->funcionario->telefone,
                    ] : null,
                    'materiais' => $ordem->materiais->map(function ($mat) {
                        return [
                            'id' => $mat->id,
                            'material_id' => $mat->material_id,
                            'nome' => $mat->material?->nome,
                            'codigo' => $mat->material?->codigo,
                            'quantidade' => $mat->quantidade,
                            'unidade' => $mat->material?->unidade_medida,
                            'valor_unitario' => $mat->valor_unitario,
                        ];
                    }),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $ordens,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'cache_version' => time(),
                'updated_at' => now()->toIso8601String()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erro ao buscar ordens para cache: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar ordens'], 500);
        }
    }

    /**
     * Retorna materiais disponíveis para cache offline
     */
    public function materiais(Request $request)
    {
        try {
            $materiais = Material::where('ativo', true)
                ->select('id', 'nome', 'codigo', 'categoria', 'unidade_medida', 'quantidade_estoque', 'quantidade_minima', 'valor_unitario')
                ->orderBy('nome')
                ->get()
                ->map(function ($material) {
                    return [
                        'id' => $material->id,
                        'nome' => $material->nome,
                        'codigo' => $material->codigo,
                        'categoria' => $material->categoria,
                        'unidade' => $material->unidade_medida,
                        'estoque' => $material->quantidade_estoque,
                        'estoque_minimo' => $material->quantidade_minima,
                        'valor_unitario' => $material->valor_unitario,
                        'baixo_estoque' => $material->quantidade_estoque <= $material->quantidade_minima
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $materiais,
                'cache_version' => time(),
                'updated_at' => now()->toIso8601String()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erro ao buscar materiais para cache: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar materiais'], 500);
        }
    }

    /**
     * Retorna localidades para cache offline
     */
    public function localidades(Request $request)
    {
        try {
            $localidades = Localidade::where('ativo', true)
                ->select('id', 'nome', 'codigo', 'tipo', 'latitude', 'longitude')
                ->orderBy('nome')
                ->get()
                ->map(function ($loc) {
                    return [
                        'id' => $loc->id,
                        'nome' => $loc->nome,
                        'codigo' => $loc->codigo,
                        'tipo' => $loc->tipo,
                        'latitude' => $loc->latitude,
                        'longitude' => $loc->longitude,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $localidades,
                'cache_version' => time(),
                'updated_at' => now()->toIso8601String()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erro ao buscar localidades para cache: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar localidades'], 500);
        }
    }

    /**
     * Retorna equipes para cache offline
     */
    public function equipes(Request $request)
    {
        try {
            $equipes = Equipe::where('ativo', true)
                ->with('funcionarios:id,nome,funcao,telefone')
                ->select('id', 'nome', 'codigo', 'descricao')
                ->orderBy('nome')
                ->get()
                ->map(function ($equipe) {
                    return [
                        'id' => $equipe->id,
                        'nome' => $equipe->nome,
                        'codigo' => $equipe->codigo,
                        'descricao' => $equipe->descricao,
                        'funcionarios' => $equipe->funcionarios->map(function ($func) {
                            return [
                                'id' => $func->id,
                                'nome' => $func->nome,
                                'funcao' => $func->funcao,
                                'telefone' => $func->telefone,
                            ];
                        }),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $equipes,
                'cache_version' => time(),
                'updated_at' => now()->toIso8601String()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erro ao buscar equipes para cache: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar equipes'], 500);
        }
    }

    /**
     * Sincroniza ações offline com AUDITORIA e IDEMPOTÊNCIA
     * 
     * Garante:
     * - Não duplica ações (verifica UUID único)
     * - Auditoria completa (quem, quando, o quê)
     * - Integridade dos dados (hash)
     * - Transações atômicas
     */
    public function sync(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        $request->validate([
            'actions' => 'required|array',
            'actions.*.uuid' => 'required|uuid',
            'actions.*.type' => 'required|string',
            'actions.*.data' => 'required|array',
            'actions.*.timestamp' => 'required|integer',
            'device_id' => 'nullable|string|max:100',
            'device_info' => 'nullable|string|max:255',
        ]);

        $actions = $request->input('actions', []);
        $deviceId = $request->input('device_id');
        $deviceInfo = $request->input('device_info');
        $results = [];
        $syncedCount = 0;
        $duplicateCount = 0;
        $failedCount = 0;

        foreach ($actions as $action) {
            $clientUuid = $action['uuid'];
            
            // VERIFICAÇÃO DE DUPLICATA (IDEMPOTÊNCIA)
            if (OfflineSyncLog::wasAlreadyProcessed($clientUuid)) {
                $results[] = [
                    'uuid' => $clientUuid,
                    'status' => 'duplicate',
                    'message' => 'Ação já processada anteriormente'
                ];
                $duplicateCount++;
                continue;
            }

            // Registrar a ação para auditoria
            $syncLog = OfflineSyncLog::registerAction([
                'client_uuid' => $clientUuid,
                'user_id' => $user->id,
                'action_type' => $action['type'],
                'payload' => $action['data'],
                'client_timestamp' => date('Y-m-d H:i:s', $action['timestamp'] / 1000),
                'device_id' => $deviceId,
                'device_info' => $deviceInfo,
            ]);

            // Processar a ação dentro de uma transação
            DB::beginTransaction();
            
            try {
                $syncLog->markAsProcessing();
                
                $result = $this->processAction($action, $user, $syncLog);
                
                if ($result['success']) {
                    DB::commit();
                    $syncLog->markAsCompleted($result);
                    $syncedCount++;
                    
                    $results[] = [
                        'uuid' => $clientUuid,
                        'status' => 'success',
                        'message' => $result['message'] ?? 'Ação processada com sucesso',
                        'data' => $result['data'] ?? null
                    ];
                } else {
                    DB::rollBack();
                    $syncLog->markAsFailed($result['message'] ?? 'Erro desconhecido');
                    $failedCount++;
                    
                    $results[] = [
                        'uuid' => $clientUuid,
                        'status' => 'failed',
                        'message' => $result['message'] ?? 'Erro ao processar ação'
                    ];
                }
                
            } catch (\Exception $e) {
                DB::rollBack();
                $syncLog->markAsFailed($e->getMessage());
                $failedCount++;
                
                Log::error("Erro ao sincronizar ação {$clientUuid}: " . $e->getMessage());
                
                $results[] = [
                    'uuid' => $clientUuid,
                    'status' => 'failed',
                    'message' => 'Erro interno: ' . $e->getMessage()
                ];
            }
        }

        // Log de auditoria geral da sincronização
        Log::info("Sincronização offline do usuário {$user->id} ({$user->name}): " .
                  "{$syncedCount} sucesso, {$duplicateCount} duplicados, {$failedCount} falhas");

        return response()->json([
            'success' => true,
            'summary' => [
                'total' => count($actions),
                'synced' => $syncedCount,
                'duplicates' => $duplicateCount,
                'failed' => $failedCount,
            ],
            'results' => $results,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'synced_at' => now()->toIso8601String()
        ]);
    }

    /**
     * Processa uma ação individual
     */
    private function processAction(array $action, $user, OfflineSyncLog $syncLog): array
    {
        $type = $action['type'] ?? '';
        $data = $action['data'] ?? [];

        switch ($type) {
            case 'iniciar_ordem':
                return $this->processIniciarOrdem($data, $user, $syncLog);
                
            case 'adicionar_material':
                return $this->processAdicionarMaterial($data, $user, $syncLog);
                
            case 'remover_material':
                return $this->processRemoverMaterial($data, $user, $syncLog);
                
            case 'atualizar_relatorio':
                return $this->processAtualizarRelatorio($data, $user, $syncLog);
                
            case 'concluir_ordem':
                return $this->processConcluirOrdem($data, $user, $syncLog);
                
            default:
                return ['success' => false, 'message' => "Tipo de ação desconhecido: {$type}"];
        }
    }

    private function processIniciarOrdem(array $data, $user, OfflineSyncLog $syncLog): array
    {
        $ordemId = $data['ordem_id'] ?? null;
        if (!$ordemId) {
            return ['success' => false, 'message' => 'ID da ordem não fornecido'];
        }

        $ordem = OrdemServico::find($ordemId);
        if (!$ordem) {
            return ['success' => false, 'message' => 'Ordem não encontrada'];
        }

        if (!$ordem->usuarioPodeAcessar($user->id)) {
            return ['success' => false, 'message' => 'Sem permissão para esta ordem'];
        }

        // Verificar se já foi iniciada (idempotência no nível do modelo)
        if ($ordem->status !== 'pendente') {
            return [
                'success' => true,
                'message' => 'Ordem já estava iniciada',
                'data' => ['ordem_id' => $ordem->id, 'status' => $ordem->status]
            ];
        }

        $ordem->update([
            'status' => 'em_execucao',
            'data_inicio' => $data['client_timestamp'] ?? now(),
            'user_id_execucao' => $user->id
        ]);

        // Atualizar syncLog com o modelo afetado
        $syncLog->update([
            'model_type' => OrdemServico::class,
            'model_id' => $ordem->id,
        ]);

        return [
            'success' => true,
            'message' => 'Ordem iniciada com sucesso',
            'data' => ['ordem_id' => $ordem->id, 'status' => 'em_execucao']
        ];
    }

    private function processAdicionarMaterial(array $data, $user, OfflineSyncLog $syncLog): array
    {
        $ordemId = $data['ordem_id'] ?? null;
        $materialId = $data['material_id'] ?? null;
        $quantidade = $data['quantidade'] ?? null;

        if (!$ordemId || !$materialId || !$quantidade) {
            return ['success' => false, 'message' => 'Dados incompletos para adicionar material'];
        }

        $ordem = OrdemServico::find($ordemId);
        if (!$ordem || !$ordem->usuarioPodeAcessar($user->id)) {
            return ['success' => false, 'message' => 'Sem permissão para esta ordem'];
        }

        $material = Material::find($materialId);
        if (!$material) {
            return ['success' => false, 'message' => 'Material não encontrado'];
        }

        // Verificar se já foi adicionado com mesmo UUID (evita duplicata de material)
        $existingSync = OfflineSyncLog::where('action_type', 'adicionar_material')
            ->where('model_type', OrdemServico::class)
            ->where('model_id', $ordemId)
            ->where('status', 'completed')
            ->whereJsonContains('payload->material_id', $materialId)
            ->first();

        if ($existingSync) {
            return [
                'success' => true,
                'message' => 'Material já foi adicionado anteriormente',
                'data' => ['duplicate' => true]
            ];
        }

        if (!$material->temEstoqueSuficiente($quantidade)) {
            return ['success' => false, 'message' => "Estoque insuficiente. Disponível: {$material->quantidade_estoque}"];
        }

        \Modules\Ordens\App\Models\OrdemServicoMaterial::create([
            'ordem_servico_id' => $ordemId,
            'material_id' => $materialId,
            'quantidade' => $quantidade,
            'valor_unitario' => $material->valor_unitario ?? 0
        ]);

        $material->removerEstoque($quantidade, "Sync offline - OS #{$ordem->numero} por {$user->name}");

        $syncLog->update([
            'model_type' => OrdemServico::class,
            'model_id' => $ordemId,
        ]);

        return [
            'success' => true,
            'message' => 'Material adicionado com sucesso',
            'data' => [
                'ordem_id' => $ordemId,
                'material_id' => $materialId,
                'quantidade' => $quantidade
            ]
        ];
    }

    private function processRemoverMaterial(array $data, $user, OfflineSyncLog $syncLog): array
    {
        $ordemId = $data['ordem_id'] ?? null;
        $materialId = $data['material_id'] ?? null;

        if (!$ordemId || !$materialId) {
            return ['success' => false, 'message' => 'Dados incompletos'];
        }

        $ordem = OrdemServico::find($ordemId);
        if (!$ordem || !$ordem->usuarioPodeAcessar($user->id)) {
            return ['success' => false, 'message' => 'Sem permissão'];
        }

        $ordemMaterial = \Modules\Ordens\App\Models\OrdemServicoMaterial::where('ordem_servico_id', $ordemId)
            ->where('material_id', $materialId)
            ->first();

        if (!$ordemMaterial) {
            return [
                'success' => true,
                'message' => 'Material já foi removido anteriormente',
                'data' => ['already_removed' => true]
            ];
        }

        $quantidade = $ordemMaterial->quantidade;
        $material = $ordemMaterial->material;

        $ordemMaterial->delete();

        if ($material) {
            $material->adicionarEstoque($quantidade, "Devolução sync offline - OS #{$ordem->numero} por {$user->name}");
        }

        $syncLog->update([
            'model_type' => OrdemServico::class,
            'model_id' => $ordemId,
        ]);

        return [
            'success' => true,
            'message' => 'Material removido com sucesso',
            'data' => ['ordem_id' => $ordemId, 'material_id' => $materialId]
        ];
    }

    private function processAtualizarRelatorio(array $data, $user, OfflineSyncLog $syncLog): array
    {
        $ordemId = $data['ordem_id'] ?? null;
        $relatorio = $data['relatorio'] ?? null;

        if (!$ordemId || !$relatorio) {
            return ['success' => false, 'message' => 'Dados incompletos'];
        }

        $ordem = OrdemServico::find($ordemId);
        if (!$ordem || !$ordem->usuarioPodeAcessar($user->id)) {
            return ['success' => false, 'message' => 'Sem permissão'];
        }

        $ordem->update(['relatorio_execucao' => $relatorio]);

        $syncLog->update([
            'model_type' => OrdemServico::class,
            'model_id' => $ordemId,
        ]);

        return [
            'success' => true,
            'message' => 'Relatório atualizado',
            'data' => ['ordem_id' => $ordemId]
        ];
    }

    private function processConcluirOrdem(array $data, $user, OfflineSyncLog $syncLog): array
    {
        $ordemId = $data['ordem_id'] ?? null;
        $relatorio = $data['relatorio'] ?? null;

        if (!$ordemId) {
            return ['success' => false, 'message' => 'ID da ordem não fornecido'];
        }

        $ordem = OrdemServico::find($ordemId);
        if (!$ordem || !$ordem->usuarioPodeAcessar($user->id)) {
            return ['success' => false, 'message' => 'Sem permissão'];
        }

        // Verificar se já foi concluída
        if ($ordem->status === 'concluida') {
            return [
                'success' => true,
                'message' => 'Ordem já estava concluída',
                'data' => ['ordem_id' => $ordem->id, 'status' => 'concluida']
            ];
        }

        $tempoExecucao = $ordem->data_inicio ? now()->diffInMinutes($ordem->data_inicio) : null;

        $ordem->update([
            'status' => 'concluida',
            'data_conclusao' => $data['client_timestamp'] ?? now(),
            'tempo_execucao' => $tempoExecucao,
            'relatorio_execucao' => $relatorio ?: $ordem->relatorio_execucao,
            'observacoes' => $data['observacoes'] ?? $ordem->observacoes,
        ]);

        // Atualizar demanda relacionada
        if ($ordem->demanda) {
            $ordem->demanda->update([
                'status' => 'concluida',
                'data_conclusao' => now()
            ]);
        }

        $syncLog->update([
            'model_type' => OrdemServico::class,
            'model_id' => $ordemId,
        ]);

        return [
            'success' => true,
            'message' => 'Ordem concluída com sucesso',
            'data' => [
                'ordem_id' => $ordem->id,
                'status' => 'concluida',
                'tempo_execucao' => $tempoExecucao
            ]
        ];
    }

    /**
     * Retorna histórico de sincronizações do usuário
     */
    public function syncHistory(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        $logs = OfflineSyncLog::forUser($user->id)
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get()
            ->map(function ($log) {
                return [
                    'uuid' => $log->client_uuid,
                    'action' => $log->action_type,
                    'status' => $log->status,
                    'message' => $log->error_message,
                    'client_time' => $log->client_timestamp?->format('Y-m-d H:i:s'),
                    'synced_at' => $log->synced_at?->format('Y-m-d H:i:s'),
                    'processed_at' => $log->processed_at?->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $logs,
        ]);
    }
}
