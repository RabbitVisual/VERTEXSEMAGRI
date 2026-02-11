<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DemandasConsultaController extends Controller
{
    use \App\Traits\DemandasSearchable;

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo', 'prioridade', 'localidade_id', 'search']);
        $query = Demanda::with($this->getDemandasDefaultRelations());
        $query = $this->applyDemandasFilters($query, $filters);

        $demandas = $query->orderBy('created_at', 'desc')->paginate(20);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas gerais
        $estatisticas = [
            'total' => Demanda::count(),
            'abertas' => Demanda::abertas()->count(),
            'em_andamento' => Demanda::emAndamento()->count(),
            'concluidas' => Demanda::concluidas()->count(),
            'urgentes' => Demanda::urgentes()->count(),
            'sem_os' => Demanda::whereDoesntHave('ordemServico')->count(),
            'por_tipo' => [
                'agua' => Demanda::porTipo('agua')->count(),
                'luz' => Demanda::porTipo('luz')->count(),
                'estrada' => Demanda::porTipo('estrada')->count(),
                'poco' => Demanda::porTipo('poco')->count(),
            ],
        ];

        return view('consulta.demandas.index', compact('demandas', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $demanda = Demanda::with([
            'localidade',
            'pessoa.localidade',
            'usuario',
            'ordemServico.equipe',
            'ordemServico.usuarioAbertura',
            'ordemServico.usuarioExecucao'
        ])->findOrFail($id);

        // Estatísticas da demanda
        $estatisticas = [
            'dias_aberta' => $demanda->diasAberta(),
            'tem_os' => $demanda->temOS(),
            'pode_criar_os' => $demanda->podeCriarOS(),
            'pode_concluir' => $demanda->podeConcluir(),
            'pode_cancelar' => $demanda->podeCancelar(),
        ];

        return view('consulta.demandas.show', compact('demanda', 'estatisticas'));
    }
}
