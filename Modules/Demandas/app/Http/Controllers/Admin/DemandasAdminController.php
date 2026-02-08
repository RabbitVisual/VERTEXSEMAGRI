<?php

namespace Modules\Demandas\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Modules\Demandas\App\Services\SimilaridadeDemandaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DemandasAdminController extends Controller
{
    protected $similaridadeService;

    public function __construct(SimilaridadeDemandaService $similaridadeService)
    {
        $this->similaridadeService = $similaridadeService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo', 'prioridade', 'localidade_id', 'search']);
        $query = Demanda::with(['localidade', 'pessoa', 'usuario', 'ordemServico']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('solicitante_nome', 'like', "%{$search}%")
                  ->orWhere('solicitante_apelido', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('motivo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhereHas('pessoa', function($q) use ($search) {
                      $q->where('nom_pessoa', 'like', "%{$search}%")
                        ->orWhere('nom_apelido_pessoa', 'like', "%{$search}%")
                        ->orWhere('num_cpf_pessoa', 'like', "%{$search}%");
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

        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $demandas = $query->orderBy('created_at', 'desc')->paginate(20);

        // Análise de Similaridade para cada demanda listada
        // Isso permite alertar visualmente sobre possíveis duplicidades
        foreach ($demandas as $demanda) {
            if (in_array($demanda->status, ['aberta', 'em_andamento'])) {
                // Busca similares
                $similares = $this->similaridadeService->buscarSimilares([
                    'localidade_id' => $demanda->localidade_id,
                    'tipo' => $demanda->tipo,
                    'descricao' => $demanda->descricao,
                    'motivo' => $demanda->motivo,
                ], 5);

                // Filtra a própria demanda da lista de resultados
                $similares = $similares->filter(function($item) use ($demanda) {
                    return $item['demanda']->id !== $demanda->id;
                });

                $melhorMatch = $similares->first();

                // Se houver similaridade alta (> 80%), adiciona alerta
                if ($melhorMatch && $melhorMatch['score'] >= 80) {
                    $demanda->duplicidade_alert = [
                        'score' => $melhorMatch['score'],
                        'demanda_id' => $melhorMatch['demanda']->id,
                        'codigo' => $melhorMatch['demanda']->codigo,
                        'resumo' => Str::limit($melhorMatch['demanda']->descricao ?? $melhorMatch['demanda']->motivo, 50)
                    ];
                }
            }
        }

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

        return view('demandas::admin.index', compact('demandas', 'localidades', 'filters', 'estatisticas'));
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

        return view('demandas::admin.show', compact('demanda', 'estatisticas'));
    }
}
