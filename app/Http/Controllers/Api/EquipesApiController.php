<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Modules\Equipes\App\Models\Equipe;
use Illuminate\Http\Request;

class EquipesApiController extends BaseApiController
{
    /**
     * Lista todas as equipes
     */
    public function index(Request $request)
    {
        try {
            $query = Equipe::with(['lider']);

            if ($request->has('ativo')) {
                $query->where('ativo', $request->boolean('ativo'));
            }

            if ($request->has('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('codigo', 'like', "%{$search}%");
                });
            }

            $perPage = $request->get('per_page', 20);
            $equipes = $query->orderBy('nome')->paginate($perPage);

            return $this->paginated($equipes, 'Equipes recuperadas com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar equipes: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mostra uma equipe específica
     */
    public function show($id)
    {
        try {
            $equipe = Equipe::with(['lider'])->findOrFail($id);
            return $this->success($equipe, 'Equipe recuperada com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Equipe não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar equipe: ' . $e->getMessage(), 500);
        }
    }
}

