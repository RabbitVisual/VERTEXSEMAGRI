<?php

namespace Modules\Funcionarios\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Funcionarios\App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FuncionariosAdminController extends Controller
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

        return view('funcionarios::admin.index', compact('funcionarios', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $funcionario = Funcionario::with([
            'equipes' => function($query) {
                $query->with('lider');
            }
        ])->findOrFail($id);

        // Estatísticas
        $estatisticas = [
            'total_equipes' => $funcionario->equipes()->count(),
            'equipes_ativas' => $funcionario->equipes()->where('ativo', true)->count(),
            'esta_em_equipe_ativa' => $funcionario->estaEmEquipeAtiva(),
        ];

        // Ordens de serviço do funcionário (através das equipes)
        $ordensServico = collect();
        if (Schema::hasTable('ordens_servico')) {
            $ordensServico = \Modules\Ordens\App\Models\OrdemServico::whereHas('equipe.funcionarios', function($q) use ($funcionario) {
                $q->where('funcionarios.id', $funcionario->id);
            })
            ->with(['demanda', 'equipe'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        }

        return view('funcionarios::admin.show', compact('funcionario', 'estatisticas', 'ordensServico'));
    }
}

