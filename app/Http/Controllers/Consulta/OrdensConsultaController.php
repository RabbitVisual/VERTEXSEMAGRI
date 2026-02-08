<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Ordens\App\Models\OrdemServico;
use Illuminate\Http\Request;

class OrdensConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo', 'prioridade', 'equipe_id', 'search']);
        $query = OrdemServico::with(['demanda', 'equipe', 'usuarioAbertura', 'usuarioExecucao']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhereHas('demanda', function($q) use ($search) {
                      $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('solicitante_nome', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }

        if (!empty($filters['prioridade'])) {
            $query->where('prioridade', $filters['prioridade']);
        }

        if (!empty($filters['equipe_id'])) {
            $query->where('equipe_id', $filters['equipe_id']);
        }

        $ordens = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estatísticas
        $estatisticas = [
            'total' => OrdemServico::count(),
            'abertas' => OrdemServico::where('status', 'aberta')->count(),
            'em_andamento' => OrdemServico::where('status', 'em_andamento')->count(),
            'concluidas' => OrdemServico::where('status', 'concluida')->count(),
            'canceladas' => OrdemServico::where('status', 'cancelada')->count(),
        ];

        return view('consulta.ordens.index', compact('ordens', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $ordem = OrdemServico::with([
            'demanda.localidade',
            'demanda.pessoa',
            'equipe',
            'usuarioAbertura',
            'usuarioExecucao'
        ])->findOrFail($id);

        return view('consulta.ordens.show', compact('ordem'));
    }
}

