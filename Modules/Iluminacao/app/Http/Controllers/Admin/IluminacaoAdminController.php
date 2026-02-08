<?php

namespace Modules\Iluminacao\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Iluminacao\App\Models\PontoLuz;
use Modules\Localidades\App\Models\Localidade;
use Modules\Demandas\App\Models\Demanda;
use Modules\Ordens\App\Models\OrdemServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class IluminacaoAdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo_lampada', 'localidade_id', 'search']);
        $query = PontoLuz::with('localidade');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('endereco', 'like', "%{$search}%")
                  ->orWhereHas('localidade', function($q) use ($search) {
                      $q->where('nome', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_lampada'])) {
            $query->where('tipo_lampada', $filters['tipo_lampada']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $pontos = $query->orderBy('created_at', 'desc')->paginate(20);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas completas
        $estatisticas = $this->calcularEstatisticas();

        return view('iluminacao::admin.index', compact('pontos', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $ponto = PontoLuz::with([
            'localidade',
            'demandas' => function($query) {
                $query->with(['pessoa', 'usuario', 'ordemServico'])->orderBy('created_at', 'desc');
            },
            'ordensServico' => function($query) {
                $query->with(['equipe', 'demanda', 'materiais'])->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Estatísticas do ponto específico
        $estatisticasPonto = $ponto->estatisticas;

        // Demandas relacionadas (mesma localidade, tipo luz)
        $demandasRelacionadas = Demanda::where('localidade_id', $ponto->localidade_id)
            ->where('tipo', 'luz')
            ->with(['pessoa', 'usuario', 'ordemServico'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Ordens relacionadas
        $ordensRelacionadas = OrdemServico::whereHas('demanda', function($q) use ($ponto) {
                $q->where('localidade_id', $ponto->localidade_id)
                  ->where('tipo', 'luz');
            })
            ->with(['demanda', 'equipe', 'materiais'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('iluminacao::admin.show', compact('ponto', 'estatisticasPonto', 'demandasRelacionadas', 'ordensRelacionadas'));
    }

    /**
     * Calcula estatísticas gerais do módulo Iluminação
     */
    private function calcularEstatisticas()
    {
        try {
            $totalPontos = PontoLuz::count();
            $pontosFuncionando = PontoLuz::where('status', 'funcionando')->count();
            $pontosComDefeito = PontoLuz::where('status', 'com_defeito')->count();
            $pontosDesligados = PontoLuz::where('status', 'desligado')->count();

            // Estatísticas de demandas de iluminação
            $totalDemandas = 0;
            $demandasAbertas = 0;
            $demandasEmAndamento = 0;
            $demandasConcluidas = 0;

            if (Schema::hasTable('demandas')) {
                $totalDemandas = Demanda::where('tipo', 'luz')->count();
                $demandasAbertas = Demanda::where('tipo', 'luz')->where('status', 'aberta')->count();
                $demandasEmAndamento = Demanda::where('tipo', 'luz')->where('status', 'em_andamento')->count();
                $demandasConcluidas = Demanda::where('tipo', 'luz')->where('status', 'concluida')->count();
            }

            // Estatísticas de ordens de serviço relacionadas a iluminação
            $totalOrdens = 0;
            $ordensPendentes = 0;
            $ordensEmExecucao = 0;
            $ordensConcluidas = 0;

            if (Schema::hasTable('ordens_servico') && Schema::hasTable('demandas')) {
                $totalOrdens = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'luz');
                })->count();

                $ordensPendentes = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'luz');
                })->where('status', 'pendente')->count();

                $ordensEmExecucao = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'luz');
                })->where('status', 'em_execucao')->count();

                $ordensConcluidas = OrdemServico::whereHas('demanda', function($q) {
                    $q->where('tipo', 'luz');
                })->where('status', 'concluida')->count();
            }

            return [
                'pontos' => [
                    'total' => $totalPontos,
                    'funcionando' => $pontosFuncionando,
                    'com_defeito' => $pontosComDefeito,
                    'desligado' => $pontosDesligados,
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
                'pontos' => ['total' => 0, 'funcionando' => 0, 'com_defeito' => 0, 'desligado' => 0],
                'demandas' => ['total' => 0, 'abertas' => 0, 'em_andamento' => 0, 'concluidas' => 0],
                'ordens' => ['total' => 0, 'pendentes' => 0, 'em_execucao' => 0, 'concluidas' => 0],
            ];
        }
    }
}

