<?php

namespace Modules\Pocos\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Models\Poco;
use Modules\Localidades\App\Models\Localidade;
use Modules\Equipes\App\Models\Equipe;
use Modules\Demandas\App\Models\Demanda;
use Modules\Ordens\App\Models\OrdemServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PocosAdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'localidade_id', 'equipe_responsavel_id', 'search']);
        $query = Poco::with(['localidade', 'equipeResponsavel']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('endereco', 'like', "%{$search}%")
                  ->orWhere('tipo_bomba', 'like', "%{$search}%")
                  ->orWhereHas('localidade', function($q) use ($search) {
                      $q->where('nome', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }
        if (!empty($filters['equipe_responsavel_id'])) {
            $query->where('equipe_responsavel_id', $filters['equipe_responsavel_id']);
        }

        $pocos = $query->orderBy('codigo')->paginate(20);

        $localidades = collect([]);
        $equipes = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }
        if (Schema::hasTable('equipes')) {
            $equipes = Equipe::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas completas
        $estatisticas = $this->calcularEstatisticas();

        return view('pocos::admin.index', compact('pocos', 'localidades', 'equipes', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $poco = Poco::with([
            'localidade',
            'equipeResponsavel',
            'demandas' => function($query) {
                $query->with(['pessoa', 'usuario', 'ordemServico'])->orderBy('created_at', 'desc');
            },
            'ordensServico' => function($query) {
                $query->with(['equipe', 'demanda', 'materiais'])->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Estatísticas do poço específico
        $estatisticasPoco = $poco->estatisticas;

        // Demandas relacionadas diretamente ao poço
        $demandasRelacionadas = Demanda::where('poco_id', $poco->id)
            ->where('tipo', 'poco')
            ->with(['pessoa', 'usuario', 'ordemServico'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Ordens relacionadas
        $ordensRelacionadas = OrdemServico::whereHas('demanda', function($q) use ($poco) {
                $q->where('poco_id', $poco->id)
                  ->where('tipo', 'poco');
            })
            ->with(['demanda', 'equipe', 'materiais'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('pocos::admin.show', compact('poco', 'estatisticasPoco', 'demandasRelacionadas', 'ordensRelacionadas'));
    }

    /**
     * Calcula estatísticas gerais do módulo Poços
     */
    private function calcularEstatisticas()
    {
        try {
            $totalPocos = Poco::count();
            $pocosAtivos = Poco::ativos()->count();
            $pocosEmManutencao = Poco::emManutencao()->count();
            $pocosComProblemas = Poco::comProblemas()->count();

            // Estatísticas de demandas de poço
            $totalDemandas = 0;
            $demandasAbertas = 0;
            $demandasEmAndamento = 0;
            $demandasConcluidas = 0;

            if (Schema::hasTable('demandas')) {
                $totalDemandas = Demanda::where('tipo', 'poco')->count();
                $demandasAbertas = Demanda::where('tipo', 'poco')->where('status', 'aberta')->count();
                $demandasEmAndamento = Demanda::where('tipo', 'poco')->where('status', 'em_andamento')->count();
                $demandasConcluidas = Demanda::where('tipo', 'poco')->where('status', 'concluida')->count();
            }

            // Estatísticas de ordens de serviço relacionadas a poços
            $totalOrdens = 0;
            $ordensPendentes = 0;
            $ordensEmExecucao = 0;
            $ordensConcluidas = 0;

            if (Schema::hasTable('ordens_servico') && Schema::hasTable('demandas')) {
                $totalOrdens = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'poco');
                })->count();

                $ordensPendentes = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'poco');
                })->where('status', 'pendente')->count();

                $ordensEmExecucao = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'poco');
                })->where('status', 'em_execucao')->count();

                $ordensConcluidas = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'poco');
                })->where('status', 'concluida')->count();
            }

            return [
                'pocos' => [
                    'total' => $totalPocos,
                    'ativos' => $pocosAtivos,
                    'em_manutencao' => $pocosEmManutencao,
                    'com_problemas' => $pocosComProblemas,
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
                'pocos' => ['total' => 0, 'ativos' => 0, 'em_manutencao' => 0, 'com_problemas' => 0],
                'demandas' => ['total' => 0, 'abertas' => 0, 'em_andamento' => 0, 'concluidas' => 0],
                'ordens' => ['total' => 0, 'pendentes' => 0, 'em_execucao' => 0, 'concluidas' => 0],
            ];
        }
    }
}

