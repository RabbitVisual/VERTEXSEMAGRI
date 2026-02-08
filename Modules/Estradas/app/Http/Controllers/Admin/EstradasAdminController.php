<?php

namespace Modules\Estradas\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Estradas\App\Models\Trecho;
use Modules\Localidades\App\Models\Localidade;
use Modules\Demandas\App\Models\Demanda;
use Modules\Ordens\App\Models\OrdemServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EstradasAdminController extends Controller
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
                  ->orWhere('nome', 'like', "%{$search}%")
                  ->orWhereHas('localidade', function($q) use ($search) {
                      $q->where('nome', 'like', "%{$search}%");
                  });
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

        // Estatísticas completas
        $estatisticas = $this->calcularEstatisticas();

        return view('estradas::admin.index', compact('trechos', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $trecho = Trecho::with([
            'localidade',
            'demandas' => function($query) {
                $query->with(['pessoa', 'usuario', 'ordemServico'])->orderBy('created_at', 'desc');
            },
            'ordensServico' => function($query) {
                $query->with(['equipe', 'demanda', 'materiais'])->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Estatísticas do trecho específico
        $estatisticasTrecho = $trecho->estatisticas;

        // Demandas relacionadas (mesma localidade, tipo estrada)
        $demandasRelacionadas = Demanda::where('localidade_id', $trecho->localidade_id)
            ->where('tipo', 'estrada')
            ->with(['pessoa', 'usuario', 'ordemServico'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Ordens relacionadas
        $ordensRelacionadas = OrdemServico::whereHas('demanda', function($q) use ($trecho) {
                $q->where('localidade_id', $trecho->localidade_id)
                  ->where('tipo', 'estrada');
            })
            ->with(['demanda', 'equipe', 'materiais'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('estradas::admin.show', compact('trecho', 'estatisticasTrecho', 'demandasRelacionadas', 'ordensRelacionadas'));
    }

    /**
     * Calcula estatísticas gerais do módulo Estradas
     */
    private function calcularEstatisticas()
    {
        try {
            $totalTrechos = Trecho::count();
            $trechosBoa = Trecho::where('condicao', 'boa')->count();
            $trechosRegular = Trecho::where('condicao', 'regular')->count();
            $trechosRuim = Trecho::where('condicao', 'ruim')->count();
            $trechosPessima = Trecho::where('condicao', 'pessima')->count();
            $precisaManutencao = Trecho::whereNotNull('proxima_manutencao')->where('proxima_manutencao', '<=', now())->count();

            // Estatísticas de demandas de estrada
            $totalDemandas = 0;
            $demandasAbertas = 0;
            $demandasEmAndamento = 0;
            $demandasConcluidas = 0;

            if (Schema::hasTable('demandas')) {
                $totalDemandas = Demanda::where('tipo', 'estrada')->count();
                $demandasAbertas = Demanda::where('tipo', 'estrada')->where('status', 'aberta')->count();
                $demandasEmAndamento = Demanda::where('tipo', 'estrada')->where('status', 'em_andamento')->count();
                $demandasConcluidas = Demanda::where('tipo', 'estrada')->where('status', 'concluida')->count();
            }

            // Estatísticas de ordens de serviço relacionadas a estradas
            $totalOrdens = 0;
            $ordensPendentes = 0;
            $ordensEmExecucao = 0;
            $ordensConcluidas = 0;

            if (Schema::hasTable('ordens_servico') && Schema::hasTable('demandas')) {
                $totalOrdens = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'estrada');
                })->count();

                $ordensPendentes = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'estrada');
                })->where('status', 'pendente')->count();

                $ordensEmExecucao = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'estrada');
                })->where('status', 'em_execucao')->count();

                $ordensConcluidas = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'estrada');
                })->where('status', 'concluida')->count();
            }

            return [
                'trechos' => [
                    'total' => $totalTrechos,
                    'boa' => $trechosBoa,
                    'regular' => $trechosRegular,
                    'ruim' => $trechosRuim,
                    'pessima' => $trechosPessima,
                    'precisa_manutencao' => $precisaManutencao,
                ],
                'demandas' => [
                    'total' => $totalDemandas,
                    'abertas' => $demandasAbertas,
                    'em_andamento' => $demandasEmAndamento,
                    'concluidas' => $demandasConcluidas,
                ],
                'ordens' => [
                    'total' => $totalOrdens,
                    'pendentes' => $ordensPendentes,
                    'em_execucao' => $ordensEmExecucao,
                    'concluidas' => $ordensConcluidas,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'trechos' => ['total' => 0, 'boa' => 0, 'regular' => 0, 'ruim' => 0, 'pessima' => 0, 'precisa_manutencao' => 0],
                'demandas' => ['total' => 0, 'abertas' => 0, 'em_andamento' => 0, 'concluidas' => 0],
                'ordens' => ['total' => 0, 'pendentes' => 0, 'em_execucao' => 0, 'concluidas' => 0],
            ];
        }
    }
}

