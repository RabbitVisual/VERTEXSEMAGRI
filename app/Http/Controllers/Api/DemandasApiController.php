<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Modules\Demandas\App\Models\Demanda;
use Illuminate\Http\Request;

class DemandasApiController extends BaseApiController
{
    /**
     * Lista todas as demandas
     */
    public function index(Request $request)
    {
        try {
            $query = Demanda::with(['localidade', 'pessoa', 'usuario', 'ordemServico']);

            // Filtros
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            if ($request->has('prioridade')) {
                $query->where('prioridade', $request->prioridade);
            }

            if ($request->has('localidade_id')) {
                $query->where('localidade_id', $request->localidade_id);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('codigo', 'like', "%{$search}%")
                      ->orWhere('solicitante_nome', 'like', "%{$search}%")
                      ->orWhere('motivo', 'like', "%{$search}%");
                });
            }

            $perPage = $request->get('per_page', 20);
            $demandas = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return $this->paginated($demandas, 'Demandas recuperadas com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar demandas: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mostra uma demanda específica
     */
    public function show($id)
    {
        try {
            $demanda = Demanda::with(['localidade', 'pessoa', 'usuario', 'ordemServico.equipe'])
                ->findOrFail($id);

            return $this->success($demanda, 'Demanda recuperada com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Demanda não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar demanda: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Cria uma nova demanda
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateRequest($request, [
                'solicitante_nome' => 'required|string|max:255',
                'solicitante_telefone' => 'required|string|max:20',
                'solicitante_email' => 'nullable|email|max:255',
                'localidade_id' => 'required|exists:localidades,id',
                'tipo' => 'required|in:agua,luz,estrada,poco',
                'prioridade' => 'required|in:baixa,media,alta,urgente',
                'motivo' => 'required|string|max:255',
                'descricao' => 'required|string|min:20',
                'pessoa_id' => 'nullable|exists:pessoas_cad,id',
            ]);

            $validated['status'] = 'aberta';
            $validated['user_id'] = $request->user()->id;
            $validated['data_abertura'] = now();
            $validated['codigo'] = Demanda::generateCode('DEM', $validated['tipo']);

            $demanda = Demanda::create($validated);

            return $this->success($demanda->load(['localidade', 'pessoa', 'usuario']), 'Demanda criada com sucesso', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            return $this->error('Erro ao criar demanda: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Atualiza uma demanda
     */
    public function update(Request $request, $id)
    {
        try {
            $demanda = Demanda::findOrFail($id);

            $validated = $this->validateRequest($request, [
                'solicitante_nome' => 'sometimes|required|string|max:255',
                'solicitante_telefone' => 'sometimes|required|string|max:20',
                'solicitante_email' => 'nullable|email|max:255',
                'localidade_id' => 'sometimes|required|exists:localidades,id',
                'tipo' => 'sometimes|required|in:agua,luz,estrada,poco',
                'prioridade' => 'sometimes|required|in:baixa,media,alta,urgente',
                'motivo' => 'sometimes|required|string|max:255',
                'descricao' => 'sometimes|required|string|min:20',
                'status' => 'sometimes|required|in:aberta,em_andamento,concluida,cancelada',
                'observacoes' => 'nullable|string',
            ]);

            $demanda->update($validated);

            return $this->success($demanda->load(['localidade', 'pessoa', 'usuario']), 'Demanda atualizada com sucesso');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Demanda não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao atualizar demanda: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove uma demanda
     */
    public function destroy($id)
    {
        try {
            $demanda = Demanda::findOrFail($id);
            $demanda->delete();

            return $this->success(null, 'Demanda removida com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Demanda não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao remover demanda: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Estatísticas de demandas
     */
    public function stats()
    {
        try {
            $stats = [
                'total' => Demanda::count(),
                'abertas' => Demanda::abertas()->count(),
                'em_andamento' => Demanda::emAndamento()->count(),
                'concluidas' => Demanda::concluidas()->count(),
                'por_tipo' => [
                    'agua' => Demanda::porTipo('agua')->count(),
                    'luz' => Demanda::porTipo('luz')->count(),
                    'estrada' => Demanda::porTipo('estrada')->count(),
                    'poco' => Demanda::porTipo('poco')->count(),
                ],
                'por_prioridade' => [
                    'baixa' => Demanda::where('prioridade', 'baixa')->count(),
                    'media' => Demanda::where('prioridade', 'media')->count(),
                    'alta' => Demanda::where('prioridade', 'alta')->count(),
                    'urgente' => Demanda::where('prioridade', 'urgente')->count(),
                ],
            ];

            return $this->success($stats, 'Estatísticas recuperadas com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar estatísticas: ' . $e->getMessage(), 500);
        }
    }
}

