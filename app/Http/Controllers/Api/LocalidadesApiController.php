<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;

class LocalidadesApiController extends BaseApiController
{
    /**
     * Lista todas as localidades
     */
    public function index(Request $request)
    {
        try {
            $query = Localidade::query();

            if ($request->has('ativo')) {
                $query->where('ativo', $request->boolean('ativo'));
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('codigo', 'like', "%{$search}%");
                });
            }

            $perPage = $request->get('per_page', 20);
            $localidades = $query->orderBy('nome')->paginate($perPage);

            return $this->paginated($localidades, 'Localidades recuperadas com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar localidades: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mostra uma localidade específica
     */
    public function show($id)
    {
        try {
            $localidade = Localidade::findOrFail($id);
            return $this->success($localidade, 'Localidade recuperada com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Localidade não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao recuperar localidade: ' . $e->getMessage(), 500);
        }
    }
}

