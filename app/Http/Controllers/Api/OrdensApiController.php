<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Demandas\App\Models\Demanda;
use Illuminate\Http\Request;

class OrdensApiController extends BaseApiController
{
    /**
     * Lista todas as ordens de serviço
     */
    public function index(Request $request)
    {
        try {
            $query = OrdemServico::with(['demanda.localidade', 'equipe', 'usuarioAbertura', 'usuarioExecucao', 'materiais.material']);

            // Filtros
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('equipe_id')) {
                $query->where('equipe_id', $request->equipe_id);
            }

            if ($request->has('demanda_id')) {
                $query->where('demanda_id', $request->demanda_id);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('numero', 'like', "%{$search}%")
                      ->orWhere('tipo_servico', 'like', "%{$search}%")
                      ->orWhereHas('demanda', function($q) use ($search) {
                          $q->where('codigo', 'like', "%{$search}%");
                      });
                });
            }

            $perPage = $request->get('per_page', 20);
            $ordens = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return $this->paginated($ordens, 'Ordens de serviço recuperadas com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar ordens: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mostra uma ordem específica
     */
    public function show($id)
    {
        try {
            $ordem = OrdemServico::with([
                'demanda.localidade',
                'demanda.pessoa',
                'equipe',
                'usuarioAbertura',
                'usuarioExecucao',
                'materiais.material'
            ])->findOrFail($id);

            return $this->success($ordem, 'Ordem de serviço recuperada com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Ordem de serviço não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar ordem: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Cria uma nova ordem de serviço
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateRequest($request, [
                'demanda_id' => 'nullable|exists:demandas,id',
                'equipe_id' => 'required|exists:equipes,id',
                'tipo_servico' => 'required|string|max:255',
                'descricao' => 'required|string',
                'prioridade' => 'required|in:baixa,media,alta,urgente',
            ]);

            $validated['status'] = 'pendente';
            $validated['user_id_abertura'] = $request->user()->id;
            $validated['data_abertura'] = now();
            $validated['numero'] = OrdemServico::generateCode('OS', $validated['tipo_servico']);

            $ordem = OrdemServico::create($validated);

            // Atualizar status da demanda se existir
            if ($ordem->demanda_id) {
                $demanda = Demanda::find($ordem->demanda_id);
                if ($demanda && $demanda->status === 'aberta') {
                    $demanda->update(['status' => 'em_andamento']);
                }
            }

            return $this->success($ordem->load(['demanda', 'equipe']), 'Ordem de serviço criada com sucesso', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            return $this->error('Erro ao criar ordem: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Atualiza uma ordem de serviço
     */
    public function update(Request $request, $id)
    {
        try {
            $ordem = OrdemServico::findOrFail($id);

            $validated = $this->validateRequest($request, [
                'equipe_id' => 'sometimes|required|exists:equipes,id',
                'tipo_servico' => 'sometimes|required|string|max:255',
                'descricao' => 'sometimes|required|string',
                'prioridade' => 'sometimes|required|in:baixa,media,alta,urgente',
                'status' => 'sometimes|required|in:pendente,em_execucao,concluida,cancelada',
                'relatorio_execucao' => 'nullable|string',
            ]);

            $ordem->update($validated);

            return $this->success($ordem->load(['demanda', 'equipe']), 'Ordem de serviço atualizada com sucesso');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Ordem de serviço não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao atualizar ordem: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove uma ordem de serviço
     */
    public function destroy($id)
    {
        try {
            $ordem = OrdemServico::findOrFail($id);
            $ordem->delete();

            return $this->success(null, 'Ordem de serviço removida com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Ordem de serviço não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao remover ordem: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Estatísticas de ordens
     */
    public function stats()
    {
        try {
            $stats = [
                'total' => OrdemServico::count(),
                'pendentes' => OrdemServico::pendentes()->count(),
                'em_execucao' => OrdemServico::emExecucao()->count(),
                'concluidas' => OrdemServico::concluidas()->count(),
                'tempo_medio' => OrdemServico::whereNotNull('tempo_execucao')->avg('tempo_execucao'),
            ];

            return $this->success($stats, 'Estatísticas recuperadas com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar estatísticas: ' . $e->getMessage(), 500);
        }
    }
}

