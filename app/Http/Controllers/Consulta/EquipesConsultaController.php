<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Equipes\App\Models\Equipe;
use Illuminate\Http\Request;

class EquipesConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['tipo', 'ativo', 'search']);
        $query = Equipe::with(['lider', 'funcionarios']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nome', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }

        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo']);
        }

        $equipes = $query->orderBy('nome')->paginate(20);

        // Estatísticas
        $estatisticas = [
            'total' => Equipe::count(),
            'ativas' => Equipe::where('ativo', true)->count(),
            'com_funcionarios' => Equipe::has('funcionarios')->count(),
            'sem_funcionarios' => Equipe::doesntHave('funcionarios')->count(),
        ];

        return view('consulta.equipes.index', compact('equipes', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $equipe = Equipe::with(['lider', 'funcionarios', 'ordensServico'])->findOrFail($id);

        // Estatísticas
        $estatisticas = [
            'total_funcionarios' => $equipe->funcionarios()->count(),
            'total_ordens' => $equipe->ordensServico()->count() ?? 0,
        ];

        return view('consulta.equipes.show', compact('equipe', 'estatisticas'));
    }
}

