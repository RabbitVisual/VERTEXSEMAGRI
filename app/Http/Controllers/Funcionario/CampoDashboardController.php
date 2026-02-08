<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use Modules\Ordens\App\Services\CampoOrdensService;
use Modules\Notificacoes\App\Services\NotificacaoService;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CampoDashboardController extends Controller
{
    protected $campoOrdensService;
    protected $notificacaoService;

    public function __construct(CampoOrdensService $campoOrdensService, NotificacaoService $notificacaoService)
    {
        $this->campoOrdensService = $campoOrdensService;
        $this->notificacaoService = $notificacaoService;
        // Middlewares já aplicados nas rotas em routes/campo.php
    }

    /**
     * Dashboard do funcionário de campo
     */
    public function index()
    {
        $user = Auth::user();

        // Buscar estatísticas básicas
        $estatisticas = $this->campoOrdensService->buscarEstatisticas($user);

        // Buscar ordens pendentes (limitado a 5)
        $ordensPendentes = $this->campoOrdensService->buscarOrdensDoFuncionario($user, ['status' => 'pendente'])
            ->with(['demanda.localidade', 'equipe'])
            ->orderBy('prioridade', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Buscar notificações recentes (limitado a 5)
        $notificacoes = collect([]);
        try {
            $notificacoes = $this->notificacaoService->getUserNotifications($user->id, 5, false) ?? collect([]);
        } catch (\Exception $e) {
            $notificacoes = collect([]);
        }

        // Estatísticas avançadas para gráficos
        $estatisticasAvancadas = $this->buscarEstatisticasAvancadas($user);

        // Dados para gráficos (últimos 30 dias)
        $dadosGraficos = $this->buscarDadosGraficos($user);

        // Localidades mais visitadas
        $localidadesFrequentes = $this->buscarLocalidadesFrequentes($user);

        // Timeline de atividades recentes
        $atividadesRecentes = $this->buscarAtividadesRecentes($user);

        // Avisos recentes (se módulo disponível)
        $avisosRecentes = $this->buscarAvisosRecentes();

        // Status do funcionário
        $statusFuncionario = $this->buscarStatusFuncionario($user);

        return view('campo.dashboard', compact(
            'estatisticas',
            'ordensPendentes',
            'notificacoes',
            'estatisticasAvancadas',
            'localidadesFrequentes',
            'atividadesRecentes',
            'avisosRecentes',
            'statusFuncionario',
            'dadosGraficos'
        ));
    }

    /**
     * Buscar estatísticas avançadas para gráficos
     */
    private function buscarEstatisticasAvancadas($user)
    {
        // Ordens por dia da semana (últimas 4 semanas)
        $ordensPorDia = OrdemServico::where(function($query) use ($user) {
            $query->where('user_id_execucao', $user->id)
                  ->orWhere('user_id_atribuido', $user->id);
        })
        ->where('status', 'concluida')
        ->where('data_conclusao', '>=', Carbon::now()->subWeeks(4))
        ->selectRaw('DAYNAME(data_conclusao) as dia, COUNT(*) as total')
        ->groupBy('dia')
        ->get()
        ->pluck('total', 'dia');

        // Ordens por prioridade (últimos 30 dias)
        $ordensPorPrioridade = OrdemServico::where(function($query) use ($user) {
            $query->where('user_id_execucao', $user->id)
                  ->orWhere('user_id_atribuido', $user->id);
        })
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->selectRaw('prioridade, COUNT(*) as total')
        ->groupBy('prioridade')
        ->get()
        ->pluck('total', 'prioridade');

        // Tempo médio de execução (últimas 20 ordens concluídas)
        $tempoMedioExecucao = OrdemServico::where('user_id_execucao', $user->id)
            ->where('status', 'concluida')
            ->whereNotNull('data_inicio')
            ->whereNotNull('data_conclusao')
            ->orderBy('data_conclusao', 'desc')
            ->limit(20)
            ->get()
            ->map(function($ordem) {
                $inicio = Carbon::parse($ordem->data_inicio);
                $fim = Carbon::parse($ordem->data_conclusao);
                return $inicio->diffInHours($fim);
            })
            ->avg();

        return [
            'ordens_por_dia' => $ordensPorDia,
            'ordens_por_prioridade' => $ordensPorPrioridade,
            'tempo_medio_execucao' => round($tempoMedioExecucao ?? 0, 1),
            'total_mes' => OrdemServico::where('user_id_execucao', $user->id)
                ->where('status', 'concluida')
                ->whereMonth('data_conclusao', Carbon::now()->month)
                ->whereYear('data_conclusao', Carbon::now()->year)
                ->count(),
        ];
    }

    /**
     * Buscar localidades mais frequentes
     */
    private function buscarLocalidadesFrequentes($user)
    {
        return OrdemServico::where('user_id_execucao', $user->id)
            ->where('status', 'concluida')
            ->with('demanda.localidade')
            ->whereHas('demanda.localidade')
            ->select('demanda_id', DB::raw('COUNT(*) as total'))
            ->groupBy('demanda_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function($ordem) {
                return [
                    'localidade' => $ordem->demanda->localidade ?? null,
                    'total' => $ordem->total,
                ];
            })
            ->filter(function($item) {
                return $item['localidade'] !== null;
            })
            ->values();
    }

    /**
     * Buscar atividades recentes
     */
    private function buscarAtividadesRecentes($user)
    {
        $atividades = collect();

        // Ordens iniciadas
        $ordensIniciadas = OrdemServico::where('user_id_execucao', $user->id)
            ->whereNotNull('data_inicio')
            ->orderBy('data_inicio', 'desc')
            ->limit(5)
            ->get()
            ->map(function($ordem) {
                return [
                    'tipo' => 'ordem_iniciada',
                    'titulo' => "Ordem {$ordem->numero} iniciada",
                    'descricao' => $ordem->descricao,
                    'data' => $ordem->data_inicio,
                    'icone' => 'play',
                    'cor' => 'blue',
                ];
            });

        // Ordens concluídas
        $ordensConcluidas = OrdemServico::where('user_id_execucao', $user->id)
            ->where('status', 'concluida')
            ->orderBy('data_conclusao', 'desc')
            ->limit(5)
            ->get()
            ->map(function($ordem) {
                return [
                    'tipo' => 'ordem_concluida',
                    'titulo' => "Ordem {$ordem->numero} concluída",
                    'descricao' => $ordem->descricao,
                    'data' => $ordem->data_conclusao,
                    'icone' => 'check',
                    'cor' => 'green',
                ];
            });

        return $atividades->merge($ordensIniciadas)->merge($ordensConcluidas)
            ->sortByDesc('data')
            ->take(10)
            ->values();
    }

    /**
     * Buscar avisos recentes
     */
    private function buscarAvisosRecentes()
    {
        try {
            if (class_exists(\Modules\Avisos\App\Models\Aviso::class)) {
                return \Modules\Avisos\App\Models\Aviso::where('ativo', true)
                    ->where(function($query) {
                        $query->whereNull('data_inicio')
                              ->orWhere('data_inicio', '<=', Carbon::now());
                    })
                    ->where(function($query) {
                        $query->whereNull('data_fim')
                              ->orWhere('data_fim', '>=', Carbon::now());
                    })
                    ->orderBy('created_at', 'desc')
                    ->limit(3)
                    ->get();
            }
        } catch (\Exception $e) {
            // Módulo não disponível
        }

        return collect([]);
    }

    /**
     * Buscar dados para gráficos
     */
    private function buscarDadosGraficos($user)
    {
        $ultimos30Dias = collect();
        for ($i = 29; $i >= 0; $i--) {
            $data = Carbon::now()->subDays($i);
            $ultimos30Dias->push([
                'data' => $data->format('Y-m-d'),
                'label' => $data->format('d/m'),
                'pendente' => 0,
                'em_execucao' => 0,
                'concluida' => 0,
            ]);
        }

        $ordens = OrdemServico::where(function($query) use ($user) {
                $query->where('user_id_execucao', $user->id)
                      ->orWhere('user_id_atribuido', $user->id);
            })
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as data, status, COUNT(*) as total')
            ->groupBy('data', 'status')
            ->get();

        foreach ($ordens as $ordem) {
            $ultimos30Dias = $ultimos30Dias->map(function($item) use ($ordem) {
                if ($item['data'] === $ordem->data) {
                    $item[$ordem->status] = $ordem->total;
                }
                return $item;
            });
        }

        return [
            'ordens_por_dia' => $ultimos30Dias->values(),
            'ordens_por_prioridade' => OrdemServico::where(function($query) use ($user) {
                    $query->where('user_id_execucao', $user->id)
                          ->orWhere('user_id_atribuido', $user->id);
                })
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->selectRaw('prioridade, COUNT(*) as total')
                ->groupBy('prioridade')
                ->get()
                ->pluck('total', 'prioridade'),
        ];
    }

    /**
     * Buscar status do funcionário
     */
    private function buscarStatusFuncionario($user)
    {
        try {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();

            if ($funcionario) {
                return [
                    'status_campo' => $funcionario->status_campo ?? 'disponivel',
                    'ordem_atual' => $funcionario->ordem_servico_atual_id ?? null,
                    'atendimento_iniciado' => $funcionario->atendimento_iniciado_em ?? null,
                ];
            }
        } catch (\Exception $e) {
            // Módulo não disponível
        }

        return [
            'status_campo' => 'disponivel',
            'ordem_atual' => null,
            'atendimento_iniciado' => null,
        ];
    }

    /**
     * Buscar dados para filtros
     */
    public function filtros(Request $request)
    {
        $user = Auth::user();

        // Localidades disponíveis
        $localidades = Localidade::where('ativo', true)
            ->orderBy('nome')
            ->select('id', 'nome', 'tipo', 'cidade')
            ->get();

        // Períodos sugeridos
        $periodos = [
            'hoje' => ['inicio' => Carbon::today(), 'fim' => Carbon::today()->endOfDay()],
            'semana' => ['inicio' => Carbon::now()->startOfWeek(), 'fim' => Carbon::now()->endOfWeek()],
            'mes' => ['inicio' => Carbon::now()->startOfMonth(), 'fim' => Carbon::now()->endOfMonth()],
            'ultimos_30' => ['inicio' => Carbon::now()->subDays(30), 'fim' => Carbon::now()],
            'ultimos_90' => ['inicio' => Carbon::now()->subDays(90), 'fim' => Carbon::now()],
        ];

        return response()->json([
            'success' => true,
            'localidades' => $localidades,
            'periodos' => $periodos,
            'status' => ['pendente', 'em_execucao', 'concluida'],
            'prioridades' => ['alta', 'media', 'baixa'],
        ]);
    }

    /**
     * Buscar estatísticas com filtros
     */
    public function estatisticas(Request $request)
    {
        $user = Auth::user();
        $filtros = $request->only(['data_inicio', 'data_fim', 'status', 'prioridade', 'localidade_id']);

        $query = OrdemServico::where(function($q) use ($user) {
            $q->where('user_id_execucao', $user->id)
              ->orWhere('user_id_atribuido', $user->id);
        });

        // Aplicar filtros
        if (isset($filtros['data_inicio'])) {
            $query->where('created_at', '>=', Carbon::parse($filtros['data_inicio'])->startOfDay());
        }

        if (isset($filtros['data_fim'])) {
            $query->where('created_at', '<=', Carbon::parse($filtros['data_fim'])->endOfDay());
        }

        if (isset($filtros['status'])) {
            $query->where('status', $filtros['status']);
        }

        if (isset($filtros['prioridade'])) {
            $query->where('prioridade', $filtros['prioridade']);
        }

        if (isset($filtros['localidade_id'])) {
            $query->whereHas('demanda', function($q) use ($filtros) {
                $q->where('localidade_id', $filtros['localidade_id']);
            });
        }

        // Estatísticas por dia (últimos 30 dias)
        $ordensPorDia = clone $query;
        $ordensPorDia = $ordensPorDia->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as data, COUNT(*) as total, status')
            ->groupBy('data', 'status')
            ->orderBy('data')
            ->get()
            ->groupBy('data')
            ->map(function($group) {
                return [
                    'data' => $group->first()->data,
                    'pendente' => $group->where('status', 'pendente')->sum('total'),
                    'em_execucao' => $group->where('status', 'em_execucao')->sum('total'),
                    'concluida' => $group->where('status', 'concluida')->sum('total'),
                ];
            })
            ->values();

        // Estatísticas por prioridade
        $ordensPorPrioridade = clone $query;
        $ordensPorPrioridade = $ordensPorPrioridade->selectRaw('prioridade, COUNT(*) as total')
            ->groupBy('prioridade')
            ->get()
            ->pluck('total', 'prioridade');

        // Estatísticas por status
        $ordensPorStatus = clone $query;
        $ordensPorStatus = $ordensPorStatus->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        return response()->json([
            'success' => true,
            'ordens_por_dia' => $ordensPorDia,
            'ordens_por_prioridade' => $ordensPorPrioridade,
            'ordens_por_status' => $ordensPorStatus,
            'total' => $query->count(),
        ]);
    }
}

