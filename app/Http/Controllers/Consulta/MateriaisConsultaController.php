<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Materiais\App\Models\Material;
use Illuminate\Http\Request;

class MateriaisConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['categoria', 'ativo', 'baixo_estoque', 'search']);
        $query = Material::query();

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nome', 'like', "%{$search}%")
                  ->orWhere('categoria', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['categoria'])) {
            $query->where('categoria', $filters['categoria']);
        }

        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo']);
        }

        if (isset($filters['baixo_estoque']) && $filters['baixo_estoque'] == '1') {
            $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
        }

        $materiais = $query->orderBy('nome')->paginate(20);

        // Estatísticas
        $estatisticas = [
            'total' => Material::count(),
            'ativos' => Material::where('ativo', true)->count(),
            'baixo_estoque' => Material::baixoEstoque()->count(),
            'sem_estoque' => Material::semEstoque()->count(),
        ];

        return view('consulta.materiais.index', compact('materiais', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);

        return view('consulta.materiais.show', compact('material'));
    }
}

