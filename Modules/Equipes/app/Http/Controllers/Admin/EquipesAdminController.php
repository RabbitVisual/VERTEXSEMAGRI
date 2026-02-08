<?php

namespace Modules\Equipes\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Equipes\App\Models\Equipe;
use Illuminate\Http\Request;

class EquipesAdminController extends Controller
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

        return view('equipes::admin.index', compact('equipes', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $equipe = Equipe::with([
            'lider',
            'funcionarios',
            'membros',
            'ordensServico' => function($query) {
                $query->with(['demanda', 'materiais'])->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Estatísticas da equipe
        $estatisticas = $equipe->estatisticas;

        // Ordens recentes
        $ordensRecentes = $equipe->ordensServico()
            ->with(['demanda', 'materiais'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('equipes::admin.show', compact('equipe', 'estatisticas', 'ordensRecentes'));
    }
}

