<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Funcionarios\App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionariosConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['funcao', 'ativo', 'search', 'com_equipe']);
        $query = Funcionario::with('equipes');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['funcao'])) {
            $query->where('funcao', $filters['funcao']);
        }

        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo'] === '1');
        }

        if (isset($filters['com_equipe']) && $filters['com_equipe'] !== '') {
            if ($filters['com_equipe'] === '1') {
                $query->has('equipes');
            } else {
                $query->doesntHave('equipes');
            }
        }

        $funcionarios = $query->orderBy('nome')->paginate(20);

        // Estatísticas
        $estatisticas = [
            'total' => Funcionario::count(),
            'ativos' => Funcionario::where('ativo', true)->count(),
            'com_equipe' => Funcionario::has('equipes')->count(),
            'sem_equipe' => Funcionario::doesntHave('equipes')->count(),
        ];

        return view('consulta.funcionarios.index', compact('funcionarios', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $funcionario = Funcionario::with('equipes')->findOrFail($id);

        // Estatísticas
        $estatisticas = [
            'total_equipes' => $funcionario->equipes()->count(),
        ];

        return view('consulta.funcionarios.show', compact('funcionario', 'estatisticas'));
    }
}

