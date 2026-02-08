<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Estradas\App\Models\Trecho;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EstradasConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['tipo', 'condicao', 'localidade_id', 'search']);
        $query = Trecho::with('localidade');

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
        if (!empty($filters['condicao'])) {
            $query->where('condicao', $filters['condicao']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $trechos = $query->orderBy('nome')->paginate(20);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas
        $estatisticas = [
            'total' => Trecho::count(),
            'por_tipo' => [
                'vicinal' => Trecho::where('tipo', 'vicinal')->count(),
                'principal' => Trecho::where('tipo', 'principal')->count(),
                'secundaria' => Trecho::where('tipo', 'secundaria')->count(),
            ],
            'por_condicao' => [
                'boa' => Trecho::where('condicao', 'boa')->count(),
                'regular' => Trecho::where('condicao', 'regular')->count(),
                'ruim' => Trecho::where('condicao', 'ruim')->count(),
                'pessima' => Trecho::where('condicao', 'pessima')->count(),
            ],
            'precisa_manutencao' => Trecho::whereNotNull('proxima_manutencao')->where('proxima_manutencao', '<=', now())->count(),
        ];

        return view('consulta.estradas.index', compact('trechos', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $trecho = Trecho::with([
            'localidade',
            'demandas.ordemServico',
            'ordensServico.equipe',
            'ordensServico.usuarioAbertura',
            'historicoManutencoes'
        ])->findOrFail($id);

        // Estatísticas do trecho
        $estatisticas = [
            'total_demandas' => $trecho->demandas()->count(),
            'demandas_abertas' => $trecho->demandas()->where('status', 'aberta')->count(),
            'total_ordens' => $trecho->ordensServico()->count(),
            'ordens_pendentes' => $trecho->ordensServico()->where('status', 'pendente')->count(),
            'ordens_em_execucao' => $trecho->ordensServico()->where('status', 'em_execucao')->count(),
            'ordens_concluidas' => $trecho->ordensServico()->where('status', 'concluida')->count(),
            'dias_sem_manutencao' => $trecho->diasSemManutencao(),
            'precisa_manutencao' => $trecho->precisaManutencao(),
        ];

        return view('consulta.estradas.show', compact('trecho', 'estatisticas'));
    }
}

