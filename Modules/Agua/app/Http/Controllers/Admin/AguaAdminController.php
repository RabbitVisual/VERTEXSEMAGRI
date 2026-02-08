<?php

namespace Modules\Agua\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Agua\App\Models\RedeAgua;
use Modules\Agua\App\Models\PontoDistribuicao;
use Modules\Localidades\App\Models\Localidade;
use Modules\Demandas\App\Models\Demanda;
use Modules\Ordens\App\Models\OrdemServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AguaAdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo_rede', 'localidade_id', 'search']);
        $query = RedeAgua::with(['localidade', 'pontosDistribuicao']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('material', 'like', "%{$search}%")
                  ->orWhereHas('localidade', function($q) use ($search) {
                      $q->where('nome', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_rede'])) {
            $query->where('tipo_rede', $filters['tipo_rede']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $redes = $query->orderBy('created_at', 'desc')->paginate(20);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas completas
        $estatisticas = $this->calcularEstatisticas();

        return view('agua::admin.index', compact('redes', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $rede = RedeAgua::with([
            'localidade',
            'pontosDistribuicao',
            'demandas' => function($query) {
                $query->with(['pessoa', 'usuario', 'ordemServico'])->orderBy('created_at', 'desc');
            },
            'ordensServico' => function($query) {
                $query->with(['equipe', 'demanda', 'materiais'])->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Estatísticas da rede específica
        $estatisticasRede = $rede->estatisticas;

        // Demandas relacionadas (mesma localidade, tipo água)
        $demandasRelacionadas = Demanda::where('localidade_id', $rede->localidade_id)
            ->where('tipo', 'agua')
            ->with(['pessoa', 'usuario', 'ordemServico'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Ordens relacionadas
        $ordensRelacionadas = OrdemServico::whereHas('demanda', function($q) use ($rede) {
                $q->where('localidade_id', $rede->localidade_id)
                  ->where('tipo', 'agua');
            })
            ->with(['demanda', 'equipe', 'materiais'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('agua::admin.show', compact('rede', 'estatisticasRede', 'demandasRelacionadas', 'ordensRelacionadas'));
    }

    /**
     * Calcula estatísticas gerais do módulo Água
     */
    private function calcularEstatisticas()
    {
        try {
            $totalRedes = RedeAgua::count();
            $redesFuncionando = RedeAgua::where('status', 'funcionando')->count();
            $redesComVazamento = RedeAgua::where('status', 'com_vazamento')->count();
            $redesInterrompidas = RedeAgua::where('status', 'interrompida')->count();

            $totalPontos = PontoDistribuicao::count();
            $pontosFuncionando = PontoDistribuicao::where('status', 'funcionando')->count();
            $pontosComDefeito = PontoDistribuicao::where('status', 'com_defeito')->count();

            // Estatísticas de demandas de água
            $totalDemandas = 0;
            $demandasAbertas = 0;
            $demandasEmAndamento = 0;
            $demandasConcluidas = 0;

            if (Schema::hasTable('demandas')) {
                $totalDemandas = Demanda::where('tipo', 'agua')->count();
                $demandasAbertas = Demanda::where('tipo', 'agua')->where('status', 'aberta')->count();
                $demandasEmAndamento = Demanda::where('tipo', 'agua')->where('status', 'em_andamento')->count();
                $demandasConcluidas = Demanda::where('tipo', 'agua')->where('status', 'concluida')->count();
            }

            // Estatísticas de ordens de serviço relacionadas a água
            $totalOrdens = 0;
            $ordensPendentes = 0;
            $ordensEmExecucao = 0;
            $ordensConcluidas = 0;

            if (Schema::hasTable('ordens_servico') && Schema::hasTable('demandas')) {
                $totalOrdens = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'agua');
                })->count();

                $ordensPendentes = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'agua');
                })->where('status', 'pendente')->count();

                $ordensEmExecucao = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'agua');
                })->where('status', 'em_execucao')->count();

                $ordensConcluidas = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'agua');
                })->where('status', 'concluida')->count();
            }

            return [
                'redes' => [
                    'total' => $totalRedes,
                    'funcionando' => $redesFuncionando,
                    'com_vazamento' => $redesComVazamento,
                    'interrompida' => $redesInterrompidas,
                ],
                'pontos' => [
                    'total' => $totalPontos,
                    'funcionando' => $pontosFuncionando,
                    'com_defeito' => $pontosComDefeito,
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
                'redes' => ['total' => 0, 'funcionando' => 0, 'com_vazamento' => 0, 'interrompida' => 0],
                'pontos' => ['total' => 0, 'funcionando' => 0, 'com_defeito' => 0],
                'demandas' => ['total' => 0, 'abertas' => 0, 'em_andamento' => 0, 'concluidas' => 0],
                'ordens' => ['total' => 0, 'pendentes' => 0, 'em_execucao' => 0, 'concluidas' => 0],
            ];
        }
    }
}

