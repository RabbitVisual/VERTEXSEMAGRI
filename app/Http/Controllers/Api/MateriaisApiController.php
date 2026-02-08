<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Modules\Materiais\App\Models\Material;
use Illuminate\Http\Request;

class MateriaisApiController extends BaseApiController
{
    /**
     * Lista todos os materiais
     */
    public function index(Request $request)
    {
        try {
            $query = Material::query();

            if ($request->has('ativo')) {
                $query->where('ativo', $request->boolean('ativo'));
            }

            if ($request->has('categoria')) {
                $query->where('categoria', $request->categoria);
            }

            if ($request->has('baixo_estoque')) {
                $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('codigo', 'like', "%{$search}%");
                });
            }

            $perPage = $request->get('per_page', 20);
            $materiais = $query->orderBy('nome')->paginate($perPage);

            return $this->paginated($materiais, 'Materiais recuperados com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar materiais: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mostra um material específico
     */
    public function show($id)
    {
        try {
            $material = Material::findOrFail($id);
            return $this->success($material, 'Material recuperado com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Material não encontrado');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar material: ' . $e->getMessage(), 500);
        }
    }
}

