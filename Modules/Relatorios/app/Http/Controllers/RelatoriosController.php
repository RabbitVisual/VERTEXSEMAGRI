<?php

namespace Modules\Relatorios\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use App\Helpers\FormatHelper;
use App\Helpers\TranslationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as LogFacade;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class RelatoriosController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Relatorios');
    }

    /**
     * Log de auditoria para acesso a relatórios
     */
    protected function logRelatorioAccess(string $tipo, array $filters = []): void
    {
        try {
            if (Schema::hasTable('audit_logs')) {
                AuditLog::create([
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'action' => 'relatorio.access',
                    'model_type' => 'Modules\Relatorios\App\Http\Controllers\RelatoriosController',
                    'module' => 'Relatorios',
                    'description' => "Acesso ao relatório: {$tipo}",
                    'new_values' => ['tipo' => $tipo, 'filters' => $filters],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        } catch (\Exception $e) {
            LogFacade::warning("Erro ao registrar log de acesso ao relatório: " . $e->getMessage());
        }
    }

    public function index()
    {
        try {
            // Log de acesso
            $this->logRelatorioAccess('dashboard');
        } catch (\Exception $e) {
            LogFacade::warning("Erro ao registrar log de acesso: " . $e->getMessage());
        }

        try {
            $stats = [
            'pessoas' => [
                'total' => $this->safeCount('pessoas_cad'),
                'ativas' => $this->safeCountWhere('pessoas_cad', 'ativo', true),
                'beneficiarias_pbf' => $this->safeQuery('pessoas_cad', function($query) {
                    return $query->whereNotNull('ref_pbf')
                        ->where('ref_pbf', '>', 0)
                        ->where('ativo', true)
                        ->count();
                }, 0),
            ],
            'demandas' => [
                'total' => $this->safeCount('demandas'),
                'abertas' => $this->safeCountWhere('demandas', 'status', 'aberta'),
                'em_andamento' => $this->safeCountWhere('demandas', 'status', 'em_andamento'),
                'concluidas' => $this->safeCountWhere('demandas', 'status', 'concluida'),
                'urgentes' => $this->safeCountWhere('demandas', 'prioridade', 'urgente'),
                'por_tipo' => $this->getDemandasPorTipo(),
            ],
            'ordens' => [
                'total' => $this->safeCount('ordens_servico'),
                'pendentes' => $this->safeCountWhere('ordens_servico', 'status', 'pendente'),
                'em_execucao' => $this->safeCountWhere('ordens_servico', 'status', 'em_execucao'),
                'concluidas' => $this->safeCountWhere('ordens_servico', 'status', 'concluida'),
                'canceladas' => $this->safeCountWhere('ordens_servico', 'status', 'cancelada'),
            ],
            'localidades' => [
                'total' => $this->safeCount('localidades'),
                'ativas' => $this->safeCountWhere('localidades', 'ativo', true),
                'com_mais_pessoas' => $this->getLocalidadesComMaisPessoas(),
                'com_mais_beneficiarias' => $this->getLocalidadesComMaisBeneficiarias(),
            ],
            'infraestrutura' => [
                'pontos_luz' => [
                    'total' => $this->safeCount('pontos_luz'),
                    'funcionando' => $this->safeCountWhere('pontos_luz', 'status', 'funcionando'),
                    'com_defeito' => $this->safeCountWhere('pontos_luz', 'status', 'com_defeito'),
                ],
                'redes_agua' => [
                    'total' => $this->safeCount('redes_agua'),
                    'funcionando' => $this->safeCountWhere('redes_agua', 'status', 'funcionando'),
                    'com_vazamento' => $this->safeCountWhere('redes_agua', 'status', 'com_vazamento'),
                ],
                'pocos' => [
                    'total' => $this->safeCount('pocos'),
                    'ativos' => $this->safeCountWhere('pocos', 'status', 'ativo'),
                    'em_manutencao' => $this->safeCountWhere('pocos', 'status', 'manutencao'),
                    'com_problema' => $this->safeCountWhere('pocos', 'status', 'bomba_queimada'),
                ],
                'trechos' => [
                    'total' => $this->safeCount('trechos'),
                ],
                'pontos_distribuicao' => [
                    'total' => $this->safeCount('pontos_distribuicao'),
                    'funcionando' => $this->safeCountWhere('pontos_distribuicao', 'status', 'funcionando'),
                ],
            ],
            'equipes' => [
                'total' => $this->safeCount('equipes'),
                'ativas' => $this->safeCountWhere('equipes', 'ativo', true),
                'por_tipo' => $this->safeQuery('equipes', function($query) {
                    return $query->select('tipo', DB::raw('count(*) as total'))
                        ->where('ativo', true)
                        ->groupBy('tipo')
                        ->pluck('total', 'tipo')
                        ->toArray();
                }, []),
            ],
            'materiais' => [
                'total' => $this->safeCount('materiais'),
                'ativos' => $this->safeQuery('materiais', function($q) {
                    return $q->where('ativo', 1)->count();
                }, 0),
                'baixo_estoque' => $this->safeQuery('materiais', function($q) {
                    return $q->whereColumn('quantidade_estoque', '<=', 'quantidade_minima')->count();
                }, 0),
            ],
            'funcionarios' => [
                'total' => $this->safeCount('funcionarios'),
                'ativos' => $this->safeCountWhere('funcionarios', 'ativo', true),
            ],
            'caf' => [
                'cadastros_total' => $this->safeCount('cadastros_caf'),
                'conjuges_total' => $this->safeCount('conjuges_caf'),
                'familiares_total' => $this->safeCount('familiares_caf'),
                'imoveis_total' => $this->safeCount('imoveis_caf'),
            ],
            'programas' => [
                'total' => $this->safeCount('programas'),
                'ativos' => $this->safeCountWhere('programas', 'status', 'ativo'),
                'beneficiarios_total' => $this->safeCount('beneficiarios'),
            ],
            'eventos' => [
                'total' => $this->safeCount('eventos'),
                'inscricoes_total' => $this->safeCount('inscricoes_eventos'),
            ],
            'notificacoes' => [
                'total' => $this->safeCount('notifications'),
                'nao_lidas' => $this->safeCountWhere('notifications', 'is_read', false),
                'por_tipo' => $this->safeQuery('notifications', function($query) {
                    return $query->select('type', DB::raw('count(*) as total'))
                        ->groupBy('type')
                        ->pluck('total', 'type')
                        ->toArray();
                }, []),
                'por_modulo' => $this->safeQuery('notifications', function($query) {
                    return $query->select('module_source', DB::raw('count(*) as total'))
                        ->whereNotNull('module_source')
                        ->groupBy('module_source')
                        ->pluck('total', 'module_source')
                        ->toArray();
                }, []),
            ],
            'auditoria' => [
                'total_logs' => $this->safeCount('audit_logs'),
                'por_acao' => $this->safeQuery('audit_logs', function($query) {
                    return $query->select('action', DB::raw('count(*) as total'))
                        ->groupBy('action')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->pluck('total', 'action')
                        ->toArray();
                }, []),
                'por_modulo' => $this->safeQuery('audit_logs', function($query) {
                    return $query->select('module', DB::raw('count(*) as total'))
                        ->whereNotNull('module')
                        ->groupBy('module')
                        ->pluck('total', 'module')
                        ->toArray();
                }, []),
            ],
            'materiais_movimentacoes' => [
                'total' => $this->safeCount('material_movimentacoes'),
                'entradas' => $this->safeCountWhere('material_movimentacoes', 'tipo', 'entrada'),
                'saidas' => $this->safeCountWhere('material_movimentacoes', 'tipo', 'saida'),
                'confirmadas' => $this->safeCountWhere('material_movimentacoes', 'status', 'confirmado'),
                'pendentes' => $this->safeCountWhere('material_movimentacoes', 'status', 'pendente'),
            ],
                    'solicitacoes_materiais' => [
                        'total' => $this->safeCount('solicitacoes_materiais'),
                        'pendentes' => 0, // A tabela solicitacoes_materiais não tem coluna status
                        'aprovadas' => 0, // A tabela solicitacoes_materiais não tem coluna status
                        'rejeitadas' => 0, // A tabela solicitacoes_materiais não tem coluna status
                    ],
            'usuarios' => [
                'total' => $this->safeCount('users'),
                'ativos' => $this->safeQuery('users', function($q) {
                    return $q->where('active', 1)->count();
                }, 0),
                'por_role' => $this->safeQuery('model_has_roles', function($query) {
                    return $query->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                        ->select('roles.name', DB::raw('count(*) as total'))
                        ->groupBy('roles.name')
                        ->pluck('total', 'roles.name')
                        ->toArray();
                }, []),
            ],
        ];

        // Dados para gráficos
        $chartData = [
            'demandas_por_mes' => $this->getDemandasPorMes(),
            'os_por_status' => $this->getOSPorStatus(),
            'materiais_por_categoria' => $this->getMateriaisPorCategoria(),
            'pessoas_por_localidade' => $this->getPessoasPorLocalidade(),
            'demandas_por_localidade' => $this->getDemandasPorLocalidade(),
        ];

        return view('relatorios::index', compact('stats', 'chartData'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao carregar dashboard de relatórios: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Estrutura robusta padrão para evitar Undefined Array Key
            $defaultStats = [
                'demandas' => ['total' => 0, 'abertas' => 0, 'concluidas' => 0, 'em_andamento' => 0, 'urgentes' => 0, 'por_tipo' => []],
                'ordens' => ['total' => 0, 'pendentes' => 0, 'em_execucao' => 0, 'concluidas' => 0, 'canceladas' => 0],
                'localidades' => ['total' => 0, 'ativas' => 0, 'com_mais_pessoas' => [], 'com_mais_beneficiarias' => []],
                'materiais' => ['total' => 0, 'baixo_estoque' => 0, 'ativos' => 0],
                // Adicione outros conforme necessário pela view
            ];

            return view('relatorios::index', [
                'stats' => $defaultStats,
                'chartData' => [
                    'demandas_por_mes' => [],
                    'os_por_status' => [],
                    'materiais_por_categoria' => [],
                    'pessoas_por_localidade' => [],
                    'demandas_por_localidade' => [],
                ],
                'error' => 'Erro ao carregar estatísticas. Algumas informações podem estar indisponíveis.'
            ]);
        }
    }

    private function safeCountWhere(string $table, string $column, $value, bool $withSoftDeletes = true): int
    {
        try {
            if (!Schema::hasTable($table)) {
                return 0;
            }
            $query = DB::table($table);

            // Se a tabela tiver coluna deleted_at, filtrar apenas registros não deletados
            if ($withSoftDeletes && Schema::hasColumn($table, 'deleted_at')) {
                $query->whereNull('deleted_at');
            }

            // Tratar valores booleanos corretamente (1 ou 0 para campos tinyint)
            if (is_bool($value)) {
                $query->where($column, $value ? 1 : 0);
            } else {
                $query->where($column, $value);
            }

            return $query->count();
        } catch (\Exception $e) {
            LogFacade::error("Erro ao contar registros na tabela {$table}: " . $e->getMessage());
            return 0;
        }
    }

    private function safeCountWhereColumn(string $table, string $column1, string $operator, string $column2, bool $withSoftDeletes = true): int
    {
        try {
            if (!Schema::hasTable($table)) {
                return 0;
            }
            $query = DB::table($table)->whereColumn($column1, $operator, $column2);

            // Se a tabela tiver coluna deleted_at, filtrar apenas registros não deletados
            if ($withSoftDeletes && Schema::hasColumn($table, 'deleted_at')) {
                $query->whereNull('deleted_at');
            }

            return $query->count();
        } catch (\Exception $e) {
            LogFacade::error("Erro ao contar registros na tabela {$table} usando whereColumn: " . $e->getMessage());
            return 0;
        }
    }

    private function getDemandasPorMes()
    {
        return $this->safeQuery('demandas', function($query) {
            return $query->select(
                    DB::raw('MONTH(created_at) as mes'),
                    DB::raw('YEAR(created_at) as ano'),
                    DB::raw('count(*) as total')
                )
                ->whereYear('created_at', now()->year)
                ->groupBy('mes', 'ano')
                ->orderBy('mes')
                ->get()
                ->mapWithKeys(function($item) {
                    $mesNome = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                    return [$mesNome[$item->mes - 1] => $item->total];
                })
                ->toArray();
        }, []);
    }

    private function getOSPorStatus()
    {
        return $this->safeQuery('ordens_servico', function($query) {
            return $query->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->pluck('total', 'status')
                ->toArray();
        }, []);
    }

    private function getMateriaisPorCategoria()
    {
        return $this->safeQuery('materiais', function($query) {
            return $query->select('categoria', DB::raw('count(*) as total'))
                ->whereNull('deleted_at')
                ->groupBy('categoria')
                ->orderBy('categoria')
                ->get()
                ->pluck('total', 'categoria')
                ->toArray();
        }, []);
    }

    private function safeQuery(string $table, callable $callback, $default = null, bool $withSoftDeletes = true)
    {
        try {
            if (!Schema::hasTable($table)) {
                return $default;
            }
            $query = DB::table($table);

            // Se a tabela tiver coluna deleted_at, filtrar apenas registros não deletados
            if ($withSoftDeletes && Schema::hasColumn($table, 'deleted_at')) {
                $query->whereNull('deleted_at');
            }

            return $callback($query);
        } catch (\Exception $e) {
            return $default;
        }
    }

    private function getDemandasPorTipo()
    {
        return $this->safeQuery('demandas', function($query) {
            return $query->select('tipo', DB::raw('count(*) as total'))
                ->groupBy('tipo')
                ->get()
                ->pluck('total', 'tipo')
                ->toArray();
        }, []);
    }

    private function getLocalidadesComMaisPessoas($limit = 10)
    {
        return $this->safeQuery('pessoas_cad', function($query) use ($limit) {
            return $query->select('localidade_id', DB::raw('count(*) as total'))
                ->whereNotNull('localidade_id')
                ->where('ativo', true)
                ->groupBy('localidade_id')
                ->orderBy('total', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($item) {
                    $localidade = DB::table('localidades')->where('id', $item->localidade_id)->first();
                    return [
                        'localidade' => $localidade ? $localidade->nome : 'N/A',
                        'total' => $item->total
                    ];
                })
                ->toArray();
        }, []);
    }

    private function getLocalidadesComMaisBeneficiarias($limit = 10)
    {
        return $this->safeQuery('pessoas_cad', function($query) use ($limit) {
            return $query->select('localidade_id', DB::raw('count(*) as total'))
                ->whereNotNull('localidade_id')
                ->whereNotNull('ref_pbf')
                ->where('ref_pbf', '>', 0)
                ->where('ativo', true)
                ->whereNull('deleted_at')
                ->groupBy('localidade_id')
                ->orderBy('total', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($item) {
                    $localidade = DB::table('localidades')->where('id', $item->localidade_id)->first();
                    return [
                        'localidade' => $localidade ? $localidade->nome : 'N/A',
                        'total' => $item->total
                    ];
                })
                ->toArray();
        }, []);
    }

    private function getPessoasPorLocalidade()
    {
        return $this->safeQuery('pessoas_cad', function($query) {
            return $query->select('localidade_id', DB::raw('count(*) as total'))
                ->whereNotNull('localidade_id')
                ->where('ativo', true)
                ->groupBy('localidade_id')
                ->get()
                ->mapWithKeys(function($item) {
                    $localidade = DB::table('localidades')->where('id', $item->localidade_id)->first();
                    $nome = $localidade ? $localidade->nome : 'Sem localidade';
                    return [$nome => $item->total];
                })
                ->toArray();
        }, []);
    }

    private function getDemandasPorLocalidade()
    {
        return $this->safeQuery('demandas', function($query) {
            return $query->join('localidades', 'demandas.localidade_id', '=', 'localidades.id')
                ->select('localidades.nome', DB::raw('count(*) as total'))
                ->groupBy('localidades.nome')
                ->get()
                ->pluck('total', 'nome')
                ->toArray();
        }, []);
    }

    private function safeCount(string $table, bool $withSoftDeletes = true): int
    {
        try {
            if (!Schema::hasTable($table)) {
                return 0;
            }
            $query = DB::table($table);

            // Se a tabela tiver coluna deleted_at, filtrar apenas registros não deletados
            if ($withSoftDeletes && Schema::hasColumn($table, 'deleted_at')) {
                $query->whereNull('deleted_at');
            }

            return $query->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function relatorioPessoas(Request $request)
    {
        try {
            $filters = $request->only(['localidade_id', 'beneficiaria_pbf']);
            $this->logRelatorioAccess('pessoas', $filters);

        $query = DB::table('pessoas_cad')
            ->leftJoin('localidades', 'pessoas_cad.localidade_id', '=', 'localidades.id')
            ->select(
                'pessoas_cad.*',
                'localidades.nome as localidade_nome'
            )
            ->where('pessoas_cad.ativo', true)
            ->whereNull('pessoas_cad.deleted_at');

        if (!empty($filters['localidade_id'])) {
            $query->where('pessoas_cad.localidade_id', $filters['localidade_id']);
        }

        if (!empty($filters['beneficiaria_pbf']) && $filters['beneficiaria_pbf'] == '1') {
            $query->whereNotNull('pessoas_cad.ref_pbf')->where('pessoas_cad.ref_pbf', '>', 0);
        }

        $pessoas = $query->get();

        $format = $request->get('format', 'csv');
        $filename = 'relatorio_pessoas_' . date('Ymd_His');

        $columns = [
            'nom_pessoa' => 'Nome',
            'num_nis_pessoa_atual' => 'NIS',
            'num_cpf_pessoa' => 'CPF',
            'dta_nasc_pessoa' => 'Data Nascimento',
            'localidade_nome' => 'Localidade',
            'ref_pbf' => 'Beneficiária PBF',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($pessoas, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($pessoas, $columns, $filename, 'Relatório de Pessoas');
        } else {
            return $this->exportCsv($pessoas, $columns, $filename, 'Relatório de Pessoas');
        }
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de pessoas: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de pessoas. Por favor, tente novamente.');
        }
    }

    public function relatorioLocalidades(Request $request)
    {
        try {
            $this->logRelatorioAccess('localidades');
            $query = DB::table('localidades')
            ->leftJoin('pessoas_cad', 'localidades.id', '=', 'pessoas_cad.localidade_id')
            ->leftJoin('demandas', 'localidades.id', '=', 'demandas.localidade_id')
            ->select(
                'localidades.*',
                DB::raw('COUNT(DISTINCT pessoas_cad.id) as total_pessoas'),
                DB::raw('COUNT(DISTINCT CASE WHEN pessoas_cad.ref_pbf IS NOT NULL AND pessoas_cad.ref_pbf > 0 THEN pessoas_cad.id END) as total_beneficiarias'),
                DB::raw('COUNT(DISTINCT demandas.id) as total_demandas')
            )
            ->where('localidades.ativo', true)
            ->groupBy('localidades.id');

        $localidades = $query->get();

        $format = $request->get('format', 'csv');
        $filename = 'relatorio_localidades_' . date('Ymd_His');

        $columns = [
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'cidade' => 'Cidade',
            'total_pessoas' => 'Total Pessoas',
            'total_beneficiarias' => 'Beneficiárias PBF',
            'total_demandas' => 'Total Demandas',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($localidades, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($localidades, $columns, $filename, 'Relatório de Localidades');
        } else {
            return $this->exportCsv($localidades, $columns, $filename, 'Relatório de Localidades');
        }
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de localidades: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de localidades. Por favor, tente novamente.');
        }
    }

    // ========== RELATÓRIOS ESPECÍFICOS ==========

    public function relatorioDemandas(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['status', 'tipo', 'prioridade', 'localidade_id', 'data_inicio', 'data_fim']);
            $this->logRelatorioAccess('demandas', $filters);

        $query = DB::table('demandas')
            ->leftJoin('localidades', 'demandas.localidade_id', '=', 'localidades.id')
            ->leftJoin('users', 'demandas.user_id', '=', 'users.id')
            ->select(
                'demandas.*',
                'localidades.nome as localidade_nome',
                'users.name as usuario_nome'
            )
            ->whereNull('demandas.deleted_at');

        $this->applyDemandaFilters($query, $filters);

        // Verificar se é uma requisição de exportação
        $format = $request->query('format') ?? $request->input('format');
        if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
            $demandas = $query->get();
            return $this->exportDemandas($demandas, $format);
        }

        $demandas = $query->orderBy('demandas.created_at', 'desc')->paginate(20);

        // Estatísticas
        $stats = $this->getDemandaStats($filters);
        $chartData = $this->getDemandaChartData($filters);

        // Localidades para filtro
        $localidades = $this->safeQuery('localidades', function($q) {
            return $q->where('ativo', true)->orderBy('nome')->get(['id', 'nome']);
        }, collect([]));

            return view('relatorios::demandas', compact('demandas', 'stats', 'chartData', 'localidades', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de demandas: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de demandas. Por favor, tente novamente.');
        }
    }

    public function relatorioOrdens(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['status', 'tipo_servico', 'prioridade', 'equipe_id', 'data_inicio', 'data_fim']);
            $this->logRelatorioAccess('ordens', $filters);

        $query = DB::table('ordens_servico')
            ->leftJoin('demandas', 'ordens_servico.demanda_id', '=', 'demandas.id')
            ->leftJoin('equipes', 'ordens_servico.equipe_id', '=', 'equipes.id')
            ->leftJoin('localidades', 'demandas.localidade_id', '=', 'localidades.id')
            ->select(
                'ordens_servico.*',
                'demandas.codigo as demanda_codigo',
                'demandas.tipo as demanda_tipo',
                'demandas.solicitante_nome as solicitante_nome',
                'equipes.nome as equipe_nome',
                'localidades.nome as localidade_nome'
            )
            ->whereNull('ordens_servico.deleted_at');

        $this->applyOrdemFilters($query, $filters);

        // Verificar se é uma requisição de exportação
        $format = $request->query('format') ?? $request->input('format');
        if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
            $ordens = $query->get();
            return $this->exportOrdens($ordens, $format);
        }

        $ordens = $query->orderBy('ordens_servico.created_at', 'desc')->paginate(20);

        // Estatísticas
        $stats = $this->getOrdemStats($filters);
        $chartData = $this->getOrdemChartData($filters);

        // Dados para filtros
        $equipes = $this->safeQuery('equipes', function($q) {
            return $q->where('ativo', true)->orderBy('nome')->get(['id', 'nome']);
        }, collect([]));

            return view('relatorios::ordens', compact('ordens', 'stats', 'chartData', 'equipes', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de ordens: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de ordens. Por favor, tente novamente.');
        }
    }

    public function relatorioMateriais(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['categoria', 'baixo_estoque', 'ativo']);
            $this->logRelatorioAccess('materiais', $filters);

            if (!Schema::hasTable('materiais')) {
                return view('relatorios::materiais', [
                    'materiais' => collect([])->paginate(20),
                    'stats' => [
                        'total' => 0,
                        'baixo_estoque' => 0,
                        'valor_total' => 0,
                    ],
                    'chartData' => ['por_categoria' => []],
                    'filters' => $filters,
                ]);
            }

            $query = DB::table('materiais')
                ->select('materiais.*')
                ->whereNull('materiais.deleted_at');

            $this->applyMaterialFilters($query, $filters);

            // Verificar se é uma requisição de exportação
            $format = $request->query('format') ?? $request->input('format');
            if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
                $materiais = $query->orderBy('nome')->get();
                return $this->exportMateriais($materiais, $format);
            }

            $materiais = $query->orderBy('nome')->paginate(20);

            // Estatísticas
            $stats = $this->getMaterialStats($filters);
            $chartData = $this->getMaterialChartData($filters);

            return view('relatorios::materiais', compact('materiais', 'stats', 'chartData', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error('Erro ao gerar relatório de materiais: ' . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return view('relatorios::materiais', [
                'materiais' => collect([])->paginate(20),
                'stats' => [
                    'total' => 0,
                    'baixo_estoque' => 0,
                    'valor_total' => 0,
                ],
                'chartData' => ['por_categoria' => []],
                'filters' => $filters ?? [],
            ]);
        }
    }

    public function relatorioInfraestrutura(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['tipo', 'localidade_id', 'status']);
            $this->logRelatorioAccess('infraestrutura', $filters);

            $stats = [
                'pontos_luz' => $this->getInfraestruturaStats('pontos_luz', $filters),
                'redes_agua' => $this->getInfraestruturaStats('redes_agua', $filters),
                'pocos' => $this->getInfraestruturaStats('pocos', $filters),
                'trechos' => $this->getInfraestruturaStats('trechos', $filters),
            ];

            $chartData = $this->getInfraestruturaChartData($filters);

            $localidades = $this->safeQuery('localidades', function($q) {
                return $q->where('ativo', true)->orderBy('nome')->get(['id', 'nome']);
            }, collect([]));

            return view('relatorios::infraestrutura', compact('stats', 'chartData', 'localidades', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de infraestrutura: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de infraestrutura. Por favor, tente novamente.');
        }
    }

    public function relatorioEquipes(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['tipo', 'ativo']);
            $this->logRelatorioAccess('equipes', $filters);

        $query = DB::table('equipes')
            ->leftJoin('ordens_servico', 'equipes.id', '=', 'ordens_servico.equipe_id')
            ->leftJoin('users', 'equipes.lider_id', '=', 'users.id')
            ->select(
                'equipes.id',
                'equipes.nome',
                'equipes.codigo',
                'equipes.tipo',
                'equipes.descricao',
                'equipes.lider_id',
                'equipes.ativo',
                'equipes.created_at',
                'equipes.updated_at',
                'users.name as lider_nome',
                DB::raw('COUNT(DISTINCT ordens_servico.id) as total_os'),
                DB::raw('COUNT(DISTINCT CASE WHEN ordens_servico.status = "concluida" THEN ordens_servico.id END) as os_concluidas'),
                DB::raw('AVG(ordens_servico.tempo_execucao) as tempo_medio_execucao')
            )
            ->whereNull('equipes.deleted_at')
            ->groupBy(
                'equipes.id',
                'equipes.nome',
                'equipes.codigo',
                'equipes.tipo',
                'equipes.descricao',
                'equipes.lider_id',
                'equipes.ativo',
                'equipes.created_at',
                'equipes.updated_at',
                'users.name'
            );

        $this->applyEquipeFilters($query, $filters);

        // Verificar se é uma requisição de exportação
        $format = $request->query('format') ?? $request->input('format');
        if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
            $equipes = $query->get();
            return $this->exportEquipes($equipes, $format);
        }

        $equipes = $query->orderBy('equipes.nome')->paginate(20);

        $stats = $this->getEquipeStats($filters);
        $chartData = $this->getEquipeChartData($filters);

            return view('relatorios::equipes', compact('equipes', 'stats', 'chartData', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de equipes: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de equipes. Por favor, tente novamente.');
        }
    }

    public function relatorioGeral(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['data_inicio', 'data_fim', 'localidade_id']);
            $this->logRelatorioAccess('geral', $filters);

        $stats = [
            'geral' => $this->getGeralStats($filters),
            'demandas' => $this->getDemandaStats($filters),
            'ordens' => $this->getOrdemStats($filters),
            'materiais' => $this->getMaterialStats([]),
            'infraestrutura' => $this->getInfraestruturaGeralStats(),
            'equipes' => $this->getEquipeStats([]),
        ];

        $chartData = $this->getGeralChartData($filters);

        $localidades = $this->safeQuery('localidades', function($q) {
            return $q->where('ativo', true)->orderBy('nome')->get(['id', 'nome']);
        }, collect([]));

            return view('relatorios::geral', compact('stats', 'chartData', 'localidades', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório geral: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório geral. Por favor, tente novamente.');
        }
    }

    // ========== ANÁLISES ==========

    public function analiseTemporal(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['data_inicio', 'data_fim', 'tipo_analise', 'localidade_id']);
            $this->logRelatorioAccess('analise_temporal', $filters);

        $dataInicio = $filters['data_inicio'] ?? now()->subMonths(6)->format('Y-m-d');
        $dataFim = $filters['data_fim'] ?? now()->format('Y-m-d');
        $tipoAnalise = $filters['tipo_analise'] ?? 'demandas';

        $analises = [
            'demandas' => $this->getAnaliseTemporalDemandas($dataInicio, $dataFim, $filters),
            'ordens' => $this->getAnaliseTemporalOrdens($dataInicio, $dataFim, $filters),
            'materiais' => $this->getAnaliseTemporalMateriais($dataInicio, $dataFim, $filters),
        ];

        $chartData = $analises[$tipoAnalise] ?? $analises['demandas'];

        $localidades = $this->safeQuery('localidades', function($q) {
            return $q->where('ativo', true)->orderBy('nome')->get(['id', 'nome']);
        }, collect([]));

            return view('relatorios::temporal', compact('analises', 'chartData', 'tipoAnalise', 'localidades', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar análise temporal: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar análise temporal. Por favor, tente novamente.');
        }
    }

    public function analiseGeografica(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['data_inicio', 'data_fim']);
            $this->logRelatorioAccess('analise_geografica', $filters);

            $analises = [
                'por_localidade' => $this->getAnaliseGeograficaPorLocalidade($filters),
                'distribuicao' => $this->getAnaliseGeograficaDistribuicao($filters),
                'comparativo' => $this->getAnaliseGeograficaComparativo($filters),
            ];

            $chartData = $this->getGeograficaChartData($filters);

            // Obter dados para o mapa interativo
            $mapMarkers = $this->getMapMarkersGeografica($filters);

            return view('relatorios::geografica', compact('analises', 'chartData', 'filters', 'mapMarkers'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar análise geográfica: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar análise geográfica. Por favor, tente novamente.');
        }
    }

    /**
     * Obtém marcadores para o mapa da análise geográfica
     */
    protected function getMapMarkersGeografica(array $filters = []): array
    {
        $markers = [];

        // Localidades com coordenadas
        $localidades = $this->safeQuery('localidades', function($query) {
            return $query->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('ativo', true)
                ->get(['id', 'nome', 'codigo', 'tipo', 'latitude', 'longitude', 'numero_moradores']);
        }, collect([]));

        foreach ($localidades as $loc) {
            // Contar demandas e pessoas por localidade
            $totalDemandas = $this->safeQuery('demandas', function($q) use ($loc) {
                return $q->where('localidade_id', $loc->id)->count();
            }, 0);

            $totalPessoas = $this->safeQuery('pessoas_cad', function($q) use ($loc) {
                return $q->where('localidade_id', $loc->id)->where('ativo', true)->count();
            }, 0);

            $markers[] = [
                'lat' => (float) $loc->latitude,
                'lng' => (float) $loc->longitude,
                'nome' => $loc->nome,
                'tipo' => 'localidade',
                'popup' => $this->buildLocalidadePopup($loc, $totalDemandas, $totalPessoas),
                'info' => "Demandas: {$totalDemandas} | Pessoas: {$totalPessoas}"
            ];
        }

        // Poços com coordenadas
        $pocos = $this->safeQuery('pocos', function($query) {
            return $query->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(['id', 'nome', 'codigo', 'status', 'latitude', 'longitude']);
        }, collect([]));

        foreach ($pocos as $poco) {
            $statusLabel = ucfirst(str_replace('_', ' ', $poco->status ?? 'desconhecido'));
            $markers[] = [
                'lat' => (float) $poco->latitude,
                'lng' => (float) $poco->longitude,
                'nome' => $poco->nome ?? $poco->codigo ?? "Poço #{$poco->id}",
                'tipo' => 'poco',
                'popup' => "<div class='text-center p-2'>
                    <strong class='text-blue-600'>{$poco->nome}</strong><br>
                    <span class='text-xs text-gray-500'>Poço Artesiano</span><br>
                    <span class='text-xs'>Status: <strong>{$statusLabel}</strong></span>
                </div>"
            ];
        }

        // Pontos de Luz com coordenadas
        $pontosLuz = $this->safeQuery('pontos_luz', function($query) {
            return $query->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(['id', 'codigo', 'status', 'latitude', 'longitude', 'potencia']);
        }, collect([]));

        foreach ($pontosLuz as $ponto) {
            $statusLabel = ucfirst(str_replace('_', ' ', $ponto->status ?? 'desconhecido'));
            $markers[] = [
                'lat' => (float) $ponto->latitude,
                'lng' => (float) $ponto->longitude,
                'nome' => $ponto->codigo ?? "Ponto #{$ponto->id}",
                'tipo' => 'ponto_luz',
                'popup' => "<div class='text-center p-2'>
                    <strong class='text-yellow-600'>{$ponto->codigo}</strong><br>
                    <span class='text-xs text-gray-500'>Ponto de Iluminação</span><br>
                    <span class='text-xs'>Status: <strong>{$statusLabel}</strong></span>
                    " . ($ponto->potencia ? "<br><span class='text-xs'>Potência: {$ponto->potencia}W</span>" : "") . "
                </div>"
            ];
        }

        // Pontos de Distribuição de Água
        $pontosDistribuicao = $this->safeQuery('pontos_distribuicao', function($query) {
            return $query->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(['id', 'nome', 'codigo', 'status', 'latitude', 'longitude']);
        }, collect([]));

        foreach ($pontosDistribuicao as $ponto) {
            $statusLabel = ucfirst(str_replace('_', ' ', $ponto->status ?? 'desconhecido'));
            $markers[] = [
                'lat' => (float) $ponto->latitude,
                'lng' => (float) $ponto->longitude,
                'nome' => $ponto->nome ?? $ponto->codigo ?? "Ponto #{$ponto->id}",
                'tipo' => 'ponto_distribuicao',
                'popup' => "<div class='text-center p-2'>
                    <strong class='text-blue-600'>{$ponto->nome}</strong><br>
                    <span class='text-xs text-gray-500'>Ponto de Distribuição</span><br>
                    <span class='text-xs'>Status: <strong>{$statusLabel}</strong></span>
                </div>"
            ];
        }

        return $markers;
    }

    /**
     * Constrói o popup HTML para uma localidade no mapa
     */
    protected function buildLocalidadePopup($localidade, int $totalDemandas, int $totalPessoas): string
    {
        $tipoLabel = ucfirst(str_replace('_', ' ', $localidade->tipo ?? 'localidade'));
        $moradores = $localidade->numero_moradores ? number_format($localidade->numero_moradores, 0, ',', '.') : 'N/I';

        return "<div class='p-2' style='min-width: 200px;'>
            <div class='text-center border-b pb-2 mb-2'>
                <strong class='text-green-600 text-base'>{$localidade->nome}</strong>
                " . ($localidade->codigo ? "<br><span class='text-xs text-gray-500'>{$localidade->codigo}</span>" : "") . "
            </div>
            <div class='text-xs space-y-1'>
                <div class='flex justify-between'>
                    <span class='text-gray-500'>Tipo:</span>
                    <span class='font-medium'>{$tipoLabel}</span>
                </div>
                <div class='flex justify-between'>
                    <span class='text-gray-500'>Moradores:</span>
                    <span class='font-medium'>{$moradores}</span>
                </div>
                <div class='flex justify-between'>
                    <span class='text-gray-500'>Pessoas Cadastradas:</span>
                    <span class='font-medium text-purple-600'>{$totalPessoas}</span>
                </div>
                <div class='flex justify-between'>
                    <span class='text-gray-500'>Demandas:</span>
                    <span class='font-medium text-indigo-600'>{$totalDemandas}</span>
                </div>
            </div>
        </div>";
    }

    public function analisePerformance(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['data_inicio', 'data_fim', 'equipe_id']);
            $this->logRelatorioAccess('analise_performance', $filters);

        $performance = [
            'equipes' => $this->getPerformanceEquipes($filters),
            'tempo_medio' => $this->getPerformanceTempoMedio($filters),
            'taxa_conclusao' => $this->getPerformanceTaxaConclusao($filters),
            'satisfacao' => $this->getPerformanceSatisfacao($filters),
        ];

        $chartData = $this->getPerformanceChartData($filters);

        $equipes = $this->safeQuery('equipes', function($q) {
            return $q->where('ativo', true)->orderBy('nome')->get(['id', 'nome']);
        }, collect([]));

            return view('relatorios::performance', compact('performance', 'chartData', 'equipes', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar análise de performance: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar análise de performance. Por favor, tente novamente.');
        }
    }

    public function analiseTendencias(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['data_inicio', 'data_fim', 'tipo']);
            $this->logRelatorioAccess('analise_tendencias', $filters);

            $tendencias = [
                'demandas' => $this->getTendenciasDemandas($filters),
                'ordens' => $this->getTendenciasOrdens($filters),
                'materiais' => $this->getTendenciasMateriais($filters),
            ];

            $chartData = $this->getTendenciasChartData($filters);

            return view('relatorios::tendencias', compact('tendencias', 'chartData', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar análise de tendências: " . $e->getMessage(), [
                'filters' => $filters ?? [],
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar análise de tendências. Por favor, tente novamente.');
        }
    }

    // ========== API ENDPOINTS PARA DADOS JSON ==========

    public function apiDemandas(Request $request)
    {
        $filters = $this->getFilters($request, ['status', 'tipo', 'data_inicio', 'data_fim']);
        $chartData = $this->getDemandaChartData($filters);
        return response()->json($chartData);
    }

    public function apiOrdens(Request $request)
    {
        $filters = $this->getFilters($request, ['status', 'data_inicio', 'data_fim']);
        $chartData = $this->getOrdemChartData($filters);
        return response()->json($chartData);
    }

    public function apiMateriais(Request $request)
    {
        $chartData = $this->getMaterialChartData([]);
        return response()->json($chartData);
    }

    // ========== MÉTODOS AUXILIARES PRIVADOS ==========

    private function getFilters(Request $request, array $allowed): array
    {
        $filters = [];
        foreach ($allowed as $key) {
            $filters[$key] = $request->input($key, '');
        }
        return $filters;
    }

    private function applyDemandaFilters($query, array $filters): void
    {
        if (!empty($filters['status'])) {
            $query->where('demandas.status', $filters['status']);
        }
        if (!empty($filters['tipo'])) {
            $query->where('demandas.tipo', $filters['tipo']);
        }
        if (!empty($filters['prioridade'])) {
            $query->where('demandas.prioridade', $filters['prioridade']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('demandas.localidade_id', $filters['localidade_id']);
        }
        if (!empty($filters['data_inicio'])) {
            $query->whereDate('demandas.created_at', '>=', $filters['data_inicio']);
        }
        if (!empty($filters['data_fim'])) {
            $query->whereDate('demandas.created_at', '<=', $filters['data_fim']);
        }
    }

    private function applyOrdemFilters($query, array $filters): void
    {
        if (!empty($filters['status'])) {
            $query->where('ordens_servico.status', $filters['status']);
        }
        if (!empty($filters['tipo_servico'])) {
            $query->where('ordens_servico.tipo_servico', $filters['tipo_servico']);
        }
        if (!empty($filters['prioridade'])) {
            $query->where('ordens_servico.prioridade', $filters['prioridade']);
        }
        if (!empty($filters['equipe_id'])) {
            $query->where('ordens_servico.equipe_id', $filters['equipe_id']);
        }
        if (!empty($filters['data_inicio'])) {
            $query->whereDate('ordens_servico.created_at', '>=', $filters['data_inicio']);
        }
        if (!empty($filters['data_fim'])) {
            $query->whereDate('ordens_servico.created_at', '<=', $filters['data_fim']);
        }
    }

    private function applyMaterialFilters($query, array $filters): void
    {
        if (!empty($filters['categoria'])) {
            $query->where('categoria', $filters['categoria']);
        }
        if (isset($filters['baixo_estoque']) && $filters['baixo_estoque'] == '1') {
            $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
        }
        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo'] == '1' ? 1 : 0);
        }
    }

    private function applyEquipeFilters($query, array $filters): void
    {
        if (!empty($filters['tipo'])) {
            $query->where('equipes.tipo', $filters['tipo']);
        }
        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('equipes.ativo', $filters['ativo'] == '1' ? 1 : 0);
        }
    }

    private function getDemandaStats(array $filters): array
    {
        $query = DB::table('demandas')->whereNull('deleted_at');
        $this->applyDemandaFilters($query, $filters);

        return [
            'total' => (clone $query)->count(),
            'abertas' => (clone $query)->where('status', 'aberta')->count(),
            'em_andamento' => (clone $query)->where('status', 'em_andamento')->count(),
            'concluidas' => (clone $query)->where('status', 'concluida')->count(),
            'canceladas' => (clone $query)->where('status', 'cancelada')->count(),
            'por_tipo' => $this->getDemandasPorTipo(),
            'por_prioridade' => $this->safeQuery('demandas', function($q) use ($filters) {
                $this->applyDemandaFilters($q, $filters);
                return $q->select('prioridade', DB::raw('count(*) as total'))
                    ->groupBy('prioridade')
                    ->pluck('total', 'prioridade')
                    ->toArray();
            }, []),
        ];
    }

    private function getOrdemStats(array $filters): array
    {
        $query = DB::table('ordens_servico')->whereNull('deleted_at');
        $this->applyOrdemFilters($query, $filters);

        return [
            'total' => (clone $query)->count(),
            'pendentes' => (clone $query)->where('status', 'pendente')->count(),
            'em_execucao' => (clone $query)->where('status', 'em_execucao')->count(),
            'concluidas' => (clone $query)->where('status', 'concluida')->count(),
            'canceladas' => (clone $query)->where('status', 'cancelada')->count(),
            'tempo_medio' => (clone $query)->whereNotNull('tempo_execucao')->avg('tempo_execucao'),
        ];
    }

    private function getMaterialStats(array $filters): array
    {
        try {
            if (!Schema::hasTable('materiais')) {
                return [
                    'total' => 0,
                    'baixo_estoque' => 0,
                    'valor_total' => 0,
                    'por_categoria' => [],
                ];
            }

            $baseQuery = DB::table('materiais')->whereNull('deleted_at');
            $this->applyMaterialFilters($baseQuery, $filters);

            // Total
            $total = (clone $baseQuery)->count();

            // Baixo estoque
            $baixoEstoqueQuery = DB::table('materiais')->whereNull('deleted_at');
            $this->applyMaterialFilters($baixoEstoqueQuery, $filters);
            $baixoEstoque = $baixoEstoqueQuery->whereColumn('quantidade_estoque', '<=', 'quantidade_minima')->count();

            // Valor total do estoque
            $valorTotalQuery = DB::table('materiais')->whereNull('deleted_at');
            $this->applyMaterialFilters($valorTotalQuery, $filters);
            $valorTotal = $valorTotalQuery->select(DB::raw('SUM(COALESCE(quantidade_estoque, 0) * COALESCE(valor_unitario, 0)) as valor_total'))
                ->first()->valor_total ?? 0;

            return [
                'total' => $total,
                'baixo_estoque' => $baixoEstoque,
                'valor_total' => floatval($valorTotal),
                'por_categoria' => $this->getMateriaisPorCategoria(),
            ];
        } catch (\Exception $e) {
            LogFacade::error('Erro ao coletar estatísticas de materiais: ' . $e->getMessage());
            return [
                'total' => 0,
                'baixo_estoque' => 0,
                'valor_total' => 0,
                'por_categoria' => [],
            ];
        }
    }

    private function getEquipeStats(array $filters): array
    {
        $query = DB::table('equipes')->whereNull('deleted_at');
        $this->applyEquipeFilters($query, $filters);

        return [
            'total' => (clone $query)->count(),
            'ativas' => (clone $query)->where('ativo', true)->count(),
            'por_tipo' => $this->safeQuery('equipes', function($q) use ($filters) {
                $q->whereNull('deleted_at');
                $this->applyEquipeFilters($q, $filters);
                return $q->select('tipo', DB::raw('count(*) as total'))
                    ->groupBy('tipo')
                    ->pluck('total', 'tipo')
                    ->toArray();
            }, []),
        ];
    }

    private function getGeralStats(array $filters): array
    {
        // Aplicar filtros de data se existirem
        $dataInicio = !empty($filters['data_inicio']) ? $filters['data_inicio'] : null;
        $dataFim = !empty($filters['data_fim']) ? $filters['data_fim'] : null;
        $localidadeId = !empty($filters['localidade_id']) ? $filters['localidade_id'] : null;

        // Query base para pessoas
        $pessoasQuery = DB::table('pessoas_cad')->where('ativo', true)->whereNull('deleted_at');
        if ($localidadeId) {
            $pessoasQuery->where('localidade_id', $localidadeId);
        }

        // Query base para localidades
        $localidadesQuery = DB::table('localidades')->where('ativo', true);
        if ($localidadeId) {
            $localidadesQuery->where('id', $localidadeId);
        }

        // Query base para demandas
        $demandasQuery = DB::table('demandas')->whereNull('deleted_at');
        if ($localidadeId) {
            $demandasQuery->where('localidade_id', $localidadeId);
        }
        if ($dataInicio) {
            $demandasQuery->whereDate('created_at', '>=', $dataInicio);
        }
        if ($dataFim) {
            $demandasQuery->whereDate('created_at', '<=', $dataFim);
        }

        // Query base para ordens
        $ordensQuery = DB::table('ordens_servico')->whereNull('ordens_servico.deleted_at');
        if ($dataInicio) {
            $ordensQuery->whereDate('ordens_servico.created_at', '>=', $dataInicio);
        }
        if ($dataFim) {
            $ordensQuery->whereDate('ordens_servico.created_at', '<=', $dataFim);
        }
        if ($localidadeId) {
            $ordensQuery->join('demandas', function($join) use ($localidadeId) {
                $join->on('ordens_servico.demanda_id', '=', 'demandas.id')
                     ->where('demandas.localidade_id', '=', $localidadeId)
                     ->whereNull('demandas.deleted_at');
            });
        }

        // Query base para materiais
        $materiaisQuery = DB::table('materiais')->whereNull('deleted_at')->where('ativo', 1);

        return [
            'pessoas' => $pessoasQuery->count(),
            'pessoas_ativas' => $pessoasQuery->where('ativo', true)->count(),
            'beneficiarias_pbf' => (clone $pessoasQuery)->whereNotNull('ref_pbf')->where('ref_pbf', '>', 0)->count(),
            'localidades' => $localidadesQuery->count(),
            'localidades_ativas' => $localidadesQuery->where('ativo', true)->count(),
            'demandas_total' => $demandasQuery->count(),
            'demandas_abertas' => (clone $demandasQuery)->where('status', 'aberta')->count(),
            'demandas_em_andamento' => (clone $demandasQuery)->where('status', 'em_andamento')->count(),
            'demandas_concluidas' => (clone $demandasQuery)->where('status', 'concluida')->count(),
            'ordens_total' => $this->safeQuery('ordens_servico', function($q) use ($dataInicio, $dataFim, $localidadeId) {
                $q->whereNull('deleted_at');
                if ($dataInicio) {
                    $q->whereDate('created_at', '>=', $dataInicio);
                }
                if ($dataFim) {
                    $q->whereDate('created_at', '<=', $dataFim);
                }
                if ($localidadeId) {
                    $q->join('demandas', 'ordens_servico.demanda_id', '=', 'demandas.id')
                      ->where('demandas.localidade_id', $localidadeId)
                      ->whereNull('demandas.deleted_at');
                }
                return $q->count();
            }, 0),
            'ordens_pendentes' => $this->safeQuery('ordens_servico', function($q) use ($dataInicio, $dataFim, $localidadeId) {
                $q->whereNull('deleted_at')->where('status', 'pendente');
                if ($dataInicio) {
                    $q->whereDate('created_at', '>=', $dataInicio);
                }
                if ($dataFim) {
                    $q->whereDate('created_at', '<=', $dataFim);
                }
                if ($localidadeId) {
                    $q->join('demandas', 'ordens_servico.demanda_id', '=', 'demandas.id')
                      ->where('demandas.localidade_id', $localidadeId)
                      ->whereNull('demandas.deleted_at');
                }
                return $q->count();
            }, 0),
            'ordens_em_execucao' => $this->safeQuery('ordens_servico', function($q) use ($dataInicio, $dataFim, $localidadeId) {
                $q->whereNull('deleted_at')->where('status', 'em_execucao');
                if ($dataInicio) {
                    $q->whereDate('created_at', '>=', $dataInicio);
                }
                if ($dataFim) {
                    $q->whereDate('created_at', '<=', $dataFim);
                }
                if ($localidadeId) {
                    $q->join('demandas', 'ordens_servico.demanda_id', '=', 'demandas.id')
                      ->where('demandas.localidade_id', $localidadeId)
                      ->whereNull('demandas.deleted_at');
                }
                return $q->count();
            }, 0),
            'ordens_concluidas' => $this->safeQuery('ordens_servico', function($q) use ($dataInicio, $dataFim, $localidadeId) {
                $q->whereNull('deleted_at')->where('status', 'concluida');
                if ($dataInicio) {
                    $q->whereDate('created_at', '>=', $dataInicio);
                }
                if ($dataFim) {
                    $q->whereDate('created_at', '<=', $dataFim);
                }
                if ($localidadeId) {
                    $q->join('demandas', 'ordens_servico.demanda_id', '=', 'demandas.id')
                      ->where('demandas.localidade_id', $localidadeId)
                      ->whereNull('demandas.deleted_at');
                }
                return $q->count();
            }, 0),
            'materiais_total' => $materiaisQuery->count(),
            'materiais_baixo_estoque' => (clone $materiaisQuery)->whereColumn('quantidade_estoque', '<=', 'quantidade_minima')->count(),
            'infraestrutura' => [
                'pontos_luz' => $this->safeCount('pontos_luz'),
                'pontos_luz_funcionando' => $this->safeCountWhere('pontos_luz', 'status', 'funcionando'),
                'redes_agua' => $this->safeCount('redes_agua'),
                'pocos' => $this->safeCount('pocos'),
                'pocos_ativos' => $this->safeCountWhere('pocos', 'status', 'ativo'),
                'pocos_vazao_total' => $this->safeQuery('pocos', function($q) {
                    return $q->where('status', 'ativo')->sum('vazao_litros_hora') ?? 0;
                }, 0),
                'pontos_distribuicao' => $this->safeCount('pontos_distribuicao'),
                'pontos_distribuicao_funcionando' => $this->safeCountWhere('pontos_distribuicao', 'status', 'funcionando'),
            ],
            'equipes' => [
                'total' => $this->safeCount('equipes'),
                'ativas' => $this->safeCountWhere('equipes', 'ativo', true),
            ],
            'funcionarios' => [
                'total' => $this->safeCount('funcionarios'),
                'ativos' => $this->safeCountWhere('funcionarios', 'ativo', true),
            ],
        ];
    }

    private function getInfraestruturaGeralStats(): array
    {
        return [
            'pontos_luz' => $this->safeCount('pontos_luz'),
            'pontos_luz_funcionando' => $this->safeCountWhere('pontos_luz', 'status', 'funcionando'),
            'redes_agua' => $this->safeCount('redes_agua'),
            'pocos' => $this->safeCount('pocos'),
            'pocos_ativos' => $this->safeCountWhere('pocos', 'status', 'ativo'),
            'pocos_vazao_total' => $this->safeQuery('pocos', function($q) {
                return $q->where('status', 'ativo')->sum('vazao_litros_hora') ?? 0;
            }, 0),
            'trechos' => $this->safeCount('trechos'),
            'pontos_distribuicao' => $this->safeCount('pontos_distribuicao'),
            'pontos_distribuicao_funcionando' => $this->safeCountWhere('pontos_distribuicao', 'status', 'funcionando'),
        ];
    }

    private function getInfraestruturaStats(string $tipo, array $filters): array
    {
        if (!Schema::hasTable($tipo)) {
            return ['total' => 0, 'ativos' => 0];
        }

        $query = DB::table($tipo);

        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }
        // Aplicar filtro de status apenas se a coluna existir
        if (!empty($filters['status']) && Schema::hasColumn($tipo, 'status')) {
            $query->where('status', $filters['status']);
        }

        $total = (clone $query)->count();

        // Determinar o que significa "ativo" para cada tipo de tabela
        $ativosQuery = clone $query;
        $hasAtivoColumn = Schema::hasColumn($tipo, 'ativo');
        $hasStatusColumn = Schema::hasColumn($tipo, 'status');

        if ($hasAtivoColumn) {
            // Se a tabela tem coluna 'ativo', usar ela
            $ativos = $ativosQuery->where('ativo', true)->count();
        } elseif ($hasStatusColumn) {
            // Caso contrário, usar status baseado no tipo de tabela
            switch ($tipo) {
                case 'pocos':
                    $ativos = $ativosQuery->where('status', 'ativo')->count();
                    break;
                case 'pontos_luz':
                case 'redes_agua':
                    $ativos = $ativosQuery->where('status', 'funcionando')->count();
                    break;
                default:
                    // Para outras tabelas, tentar status 'ativo' ou 'funcionando'
                    $ativos = $ativosQuery->where(function($q) {
                        $q->where('status', 'ativo')
                          ->orWhere('status', 'funcionando');
                    })->count();
            }
        } else {
            // Tabelas sem 'ativo' nem 'status' - usar lógica específica
            switch ($tipo) {
                case 'trechos':
                    // Para trechos, considerar 'boa' ou 'regular' como ativos
                    $ativos = $ativosQuery->where(function($q) {
                        $q->where('condicao', 'boa')
                          ->orWhere('condicao', 'regular');
                    })->count();
                    break;
                default:
                    // Para outras tabelas sem status/ativo, considerar todos como ativos
                    $ativos = $total;
            }
        }

        return [
            'total' => $total,
            'ativos' => $ativos,
        ];
    }

    private function getDemandaChartData(array $filters): array
    {
        return [
            'por_mes' => $this->getDemandasPorMesComFiltros($filters),
            'por_status' => $this->safeQuery('demandas', function($q) use ($filters) {
                $this->applyDemandaFilters($q, $filters);
                return $q->select('status', DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->pluck('total', 'status')
                    ->toArray();
            }, []),
            'por_tipo' => $this->getDemandasPorTipo(),
            'por_localidade' => $this->getDemandasPorLocalidadeComFiltros($filters),
        ];
    }

    private function getOrdemChartData(array $filters): array
    {
        return [
            'por_mes' => $this->getOrdensPorMesComFiltros($filters),
            'por_status' => $this->getOSPorStatus(),
            'por_tipo' => $this->safeQuery('ordens_servico', function($q) use ($filters) {
                $this->applyOrdemFilters($q, $filters);
                return $q->select('tipo', DB::raw('count(*) as total'))
                    ->whereNotNull('tipo')
                    ->groupBy('tipo')
                    ->pluck('total', 'tipo')
                    ->toArray();
            }, []),
            'por_equipe' => $this->safeQuery('ordens_servico', function($q) use ($filters) {
                $this->applyOrdemFilters($q, $filters);
                return $q->join('equipes', 'ordens_servico.equipe_id', '=', 'equipes.id')
                    ->select('equipes.nome', DB::raw('count(*) as total'))
                    ->groupBy('equipes.nome')
                    ->pluck('total', 'nome')
                    ->toArray();
            }, []),
            'tempo_medio' => $this->getTempoMedioPorMes($filters),
        ];
    }

    private function getMaterialChartData(array $filters): array
    {
        return [
            'por_categoria' => $this->getMateriaisPorCategoria(),
            'estoque_valor' => $this->safeQuery('materiais', function($q) use ($filters) {
                $this->applyMaterialFilters($q, $filters);
                return $q->whereNull('deleted_at')
                    ->select('categoria', DB::raw('SUM(COALESCE(quantidade_estoque, 0) * COALESCE(valor_unitario, 0)) as valor'))
                    ->groupBy('categoria')
                    ->orderBy('categoria')
                    ->pluck('valor', 'categoria')
                    ->toArray();
            }, []),
            'baixo_estoque' => $this->safeQuery('materiais', function($q) {
                return $q->whereNull('deleted_at')
                    ->whereColumn('quantidade_estoque', '<=', 'quantidade_minima')
                    ->select('nome', 'quantidade_estoque', 'quantidade_minima')
                    ->orderBy('nome')
                    ->get()
                    ->toArray();
            }, []),
        ];
    }

    private function getEquipeChartData(array $filters): array
    {
        return [
            'por_tipo' => $this->safeQuery('equipes', function($q) use ($filters) {
                $q->whereNull('deleted_at');
                $this->applyEquipeFilters($q, $filters);
                return $q->select('tipo', DB::raw('count(*) as total'))
                    ->groupBy('tipo')
                    ->pluck('total', 'tipo')
                    ->toArray();
            }, []),
            'performance' => $this->getEquipePerformance($filters),
        ];
    }

    private function getInfraestruturaChartData(array $filters): array
    {
        return [
            'distribuicao' => [
                'Pontos de Luz' => $this->safeCount('pontos_luz'),
                'Redes de Água' => $this->safeCount('redes_agua'),
                'Poços' => $this->safeCount('pocos'),
                'Trechos' => $this->safeCount('trechos'),
            ],
            'por_localidade' => $this->getInfraestruturaPorLocalidade($filters),
        ];
    }

    private function getGeralChartData(array $filters): array
    {
        return [
            'demandas_por_mes' => $this->getDemandasPorMesComFiltros($filters),
            'ordens_por_mes' => $this->getOrdensPorMesComFiltros($filters),
            'os_por_status' => $this->getOSPorStatus(),
            'materiais_por_categoria' => $this->getMateriaisPorCategoria(),
        ];
    }

    private function getGeograficaChartData(array $filters): array
    {
        return [
            'pessoas_por_localidade' => $this->getPessoasPorLocalidade(),
            'demandas_por_localidade' => $this->getDemandasPorLocalidadeComFiltros($filters),
            'infraestrutura_por_localidade' => $this->getInfraestruturaPorLocalidade($filters),
        ];
    }

    private function getPerformanceChartData(array $filters): array
    {
        return [
            'equipes' => $this->getEquipePerformance($filters),
            'tempo_medio' => $this->getTempoMedioPorMes($filters),
        ];
    }

    private function getTendenciasChartData(array $filters): array
    {
        return [
            'demandas' => $this->getDemandasPorMesComFiltros($filters),
            'ordens' => $this->getOrdensPorMesComFiltros($filters),
        ];
    }

    // Métodos auxiliares para dados de gráficos
    private function getDemandasPorMesComFiltros(array $filters): array
    {
        return $this->safeQuery('demandas', function($query) use ($filters) {
            $this->applyDemandaFilters($query, $filters);
            $dataInicio = $filters['data_inicio'] ?? now()->subMonths(11)->format('Y-m-d');
            $dataFim = $filters['data_fim'] ?? now()->format('Y-m-d');

            return $query->select(
                    DB::raw('MONTH(created_at) as mes'),
                    DB::raw('YEAR(created_at) as ano'),
                    DB::raw('count(*) as total')
                )
                ->whereDate('created_at', '>=', $dataInicio)
                ->whereDate('created_at', '<=', $dataFim)
                ->groupBy('mes', 'ano')
                ->orderBy('ano')
                ->orderBy('mes')
                ->get()
                ->mapWithKeys(function($item) {
                    $mesNome = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                    $key = $mesNome[$item->mes - 1] . '/' . $item->ano;
                    return [$key => $item->total];
                })
                ->toArray();
        }, []);
    }

    private function getOrdensPorMesComFiltros(array $filters): array
    {
        return $this->safeQuery('ordens_servico', function($query) use ($filters) {
            $this->applyOrdemFilters($query, $filters);
            $dataInicio = $filters['data_inicio'] ?? now()->subMonths(11)->format('Y-m-d');
            $dataFim = $filters['data_fim'] ?? now()->format('Y-m-d');

            return $query->select(
                    DB::raw('MONTH(created_at) as mes'),
                    DB::raw('YEAR(created_at) as ano'),
                    DB::raw('count(*) as total')
                )
                ->whereDate('created_at', '>=', $dataInicio)
                ->whereDate('created_at', '<=', $dataFim)
                ->groupBy('mes', 'ano')
                ->orderBy('ano')
                ->orderBy('mes')
                ->get()
                ->mapWithKeys(function($item) {
                    $mesNome = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                    $key = $mesNome[$item->mes - 1] . '/' . $item->ano;
                    return [$key => $item->total];
                })
                ->toArray();
        }, []);
    }

    private function getDemandasPorLocalidadeComFiltros(array $filters): array
    {
        return $this->safeQuery('demandas', function($query) use ($filters) {
            $this->applyDemandaFilters($query, $filters);
            return $query->leftJoin('localidades', 'demandas.localidade_id', '=', 'localidades.id')
                ->select(DB::raw("COALESCE(localidades.nome, 'Sem localidade') as nome"), DB::raw('count(*) as total'))
                ->groupBy('nome')
                ->pluck('total', 'nome')
                ->toArray();
        }, []);
    }

    private function getTempoMedioPorMes(array $filters): array
    {
        return $this->safeQuery('ordens_servico', function($query) use ($filters) {
            $this->applyOrdemFilters($query, $filters);
            return $query->select(
                    DB::raw('MONTH(data_conclusao) as mes'),
                    DB::raw('YEAR(data_conclusao) as ano'),
                    DB::raw('AVG(tempo_execucao) as tempo_medio')
                )
                ->whereNotNull('tempo_execucao')
                ->whereNotNull('data_conclusao')
                ->groupBy('mes', 'ano')
                ->orderBy('ano')
                ->orderBy('mes')
                ->get()
                ->mapWithKeys(function($item) {
                    $mesNome = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                    $key = $mesNome[$item->mes - 1] . '/' . $item->ano;
                    return [$key => round($item->tempo_medio, 2)];
                })
                ->toArray();
        }, []);
    }

    private function getEquipePerformance(array $filters): array
    {
        return $this->safeQuery('equipes', function($query) use ($filters) {
            $query->whereNull('equipes.deleted_at');
            $this->applyEquipeFilters($query, $filters);
            return $query->leftJoin('ordens_servico', 'equipes.id', '=', 'ordens_servico.equipe_id')
                ->select(
                    'equipes.nome',
                    DB::raw('COUNT(ordens_servico.id) as total_os'),
                    DB::raw('COUNT(CASE WHEN ordens_servico.status = "concluida" THEN 1 END) as concluidas'),
                    DB::raw('COUNT(CASE WHEN ordens_servico.status != "concluida" AND ordens_servico.id IS NOT NULL THEN 1 END) as pendentes'),
                    DB::raw('AVG(ordens_servico.tempo_execucao) as tempo_medio')
                )
                ->groupBy('equipes.id', 'equipes.nome')
                ->get()
                ->map(function($item) {
                    return [
                        'nome' => $item->nome,
                        'total_os' => $item->total_os,
                        'concluidas' => $item->concluidas,
                        'pendentes' => $item->pendentes,
                        'taxa_conclusao' => $item->total_os > 0 ? round(($item->concluidas / $item->total_os) * 100, 2) : 0,
                        'tempo_medio' => round($item->tempo_medio ?? 0, 2),
                    ];
                })
                ->toArray();
        }, []);
    }

    private function getInfraestruturaPorLocalidade(array $filters): array
    {
        $result = [];
        $tabelas = ['pontos_luz', 'redes_agua', 'pocos', 'trechos'];

        foreach ($tabelas as $tabela) {
            if (Schema::hasTable($tabela)) {
                $query = DB::table($tabela)
                    ->join('localidades', "{$tabela}.localidade_id", '=', 'localidades.id')
                    ->select('localidades.nome', DB::raw('count(*) as total'))
                    ->groupBy('localidades.nome');

                if (!empty($filters['localidade_id'])) {
                    $query->where('localidades.id', $filters['localidade_id']);
                }

                $result[$tabela] = $query->pluck('total', 'nome')->toArray();
            }
        }

        return $result;
    }

    // Métodos de análise temporal
    private function getAnaliseTemporalDemandas(string $dataInicio, string $dataFim, array $filters): array
    {
        return [
            'por_dia' => $this->safeQuery('demandas', function($q) use ($dataInicio, $dataFim, $filters) {
                $this->applyDemandaFilters($q, $filters);
                return $q->select(DB::raw('DATE(created_at) as data'), DB::raw('count(*) as total'))
                    ->whereDate('created_at', '>=', $dataInicio)
                    ->whereDate('created_at', '<=', $dataFim)
                    ->groupBy('data')
                    ->orderBy('data')
                    ->pluck('total', 'data')
                    ->toArray();
            }, []),
            'por_semana' => $this->getAgrupadoPorSemana('demandas', $dataInicio, $dataFim, $filters),
            'por_mes' => $this->getDemandasPorMesComFiltros(array_merge($filters, ['data_inicio' => $dataInicio, 'data_fim' => $dataFim])),
        ];
    }

    private function getAnaliseTemporalOrdens(string $dataInicio, string $dataFim, array $filters): array
    {
        return [
            'por_dia' => $this->safeQuery('ordens_servico', function($q) use ($dataInicio, $dataFim, $filters) {
                $this->applyOrdemFilters($q, $filters);
                return $q->select(DB::raw('DATE(created_at) as data'), DB::raw('count(*) as total'))
                    ->whereDate('created_at', '>=', $dataInicio)
                    ->whereDate('created_at', '<=', $dataFim)
                    ->groupBy('data')
                    ->orderBy('data')
                    ->pluck('total', 'data')
                    ->toArray();
            }, []),
            'por_semana' => $this->getAgrupadoPorSemana('ordens_servico', $dataInicio, $dataFim, $filters),
            'por_mes' => $this->getOrdensPorMesComFiltros(array_merge($filters, ['data_inicio' => $dataInicio, 'data_fim' => $dataFim])),
        ];
    }

    private function getAnaliseTemporalMateriais(string $dataInicio, string $dataFim, array $filters): array
    {
        return [
            'movimentacoes' => $this->safeQuery('material_movimentacoes', function($q) use ($dataInicio, $dataFim) {
                return $q->select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(CASE WHEN tipo = "entrada" THEN quantidade ELSE -quantidade END) as saldo'))
                    ->whereDate('created_at', '>=', $dataInicio)
                    ->whereDate('created_at', '<=', $dataFim)
                    ->groupBy('data')
                    ->orderBy('data')
                    ->pluck('saldo', 'data')
                    ->toArray();
            }, []),
        ];
    }

    private function getAgrupadoPorSemana(string $tabela, string $dataInicio, string $dataFim, array $filters): array
    {
        return $this->safeQuery($tabela, function($q) use ($tabela, $dataInicio, $dataFim, $filters) {
            if ($tabela === 'demandas') {
                $this->applyDemandaFilters($q, $filters);
            } elseif ($tabela === 'ordens_servico') {
                $this->applyOrdemFilters($q, $filters);
            }

            return $q->select(
                    DB::raw('YEAR(created_at) as ano'),
                    DB::raw('WEEK(created_at) as semana'),
                    DB::raw('count(*) as total')
                )
                ->whereDate('created_at', '>=', $dataInicio)
                ->whereDate('created_at', '<=', $dataFim)
                ->groupBy('ano', 'semana')
                ->orderBy('ano')
                ->orderBy('semana')
                ->get()
                ->mapWithKeys(function($item) {
                    $key = "Sem {$item->semana}/{$item->ano}";
                    return [$key => $item->total];
                })
                ->toArray();
        }, []);
    }

    // Métodos de análise geográfica
    private function getAnaliseGeograficaPorLocalidade(array $filters): array
    {
        return [
            'pessoas' => $this->getPessoasPorLocalidade(),
            'demandas' => $this->getDemandasPorLocalidadeComFiltros($filters),
            'ordens' => $this->safeQuery('ordens_servico', function($q) use ($filters) {
                $this->applyOrdemFilters($q, $filters);
                return $q->join('demandas', 'ordens_servico.demanda_id', '=', 'demandas.id')
                    ->join('localidades', 'demandas.localidade_id', '=', 'localidades.id')
                    ->select('localidades.nome', DB::raw('count(*) as total'))
                    ->groupBy('localidades.nome')
                    ->pluck('total', 'nome')
                    ->toArray();
            }, []),
        ];
    }

    private function getAnaliseGeograficaDistribuicao(array $filters): array
    {
        return [
            'densidade_pessoas' => $this->getPessoasPorLocalidade(),
            'densidade_demandas' => $this->getDemandasPorLocalidadeComFiltros($filters),
        ];
    }

    private function getAnaliseGeograficaComparativo(array $filters): array
    {
        $localidades = $this->safeQuery('localidades', function($q) {
            return $q->where('ativo', true)->get(['id', 'nome']);
        }, collect([]));

        $comparativo = [];
        foreach ($localidades as $loc) {
            $comparativo[$loc->nome] = [
                'pessoas' => $this->safeCountWhere('pessoas_cad', 'localidade_id', $loc->id),
                'demandas' => $this->safeCountWhere('demandas', 'localidade_id', $loc->id),
                'beneficiarias' => DB::table('pessoas_cad')
                    ->where('localidade_id', $loc->id)
                    ->whereNotNull('ref_pbf')
                    ->where('ref_pbf', '>', 0)
                    ->count(),
            ];
        }

        return $comparativo;
    }

    // Métodos de performance
    private function getPerformanceEquipes(array $filters): array
    {
        return $this->getEquipePerformance($filters);
    }

    private function getPerformanceTempoMedio(array $filters): array
    {
        return $this->getTempoMedioPorMes($filters);
    }

    private function getPerformanceTaxaConclusao(array $filters): array
    {
        return $this->safeQuery('ordens_servico', function($q) use ($filters) {
            $this->applyOrdemFilters($q, $filters);
            return $q->select(
                    DB::raw('MONTH(created_at) as mes'),
                    DB::raw('YEAR(created_at) as ano'),
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN status = "concluida" THEN 1 ELSE 0 END) as concluidas')
                )
                ->groupBy('mes', 'ano')
                ->orderBy('ano')
                ->orderBy('mes')
                ->get()
                ->mapWithKeys(function($item) {
                    $mesNome = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                    $key = $mesNome[$item->mes - 1] . '/' . $item->ano;
                    $taxa = $item->total > 0 ? round(($item->concluidas / $item->total) * 100, 2) : 0;
                    return [$key => $taxa];
                })
                ->toArray();
        }, []);
    }

    private function getPerformanceSatisfacao(array $filters): array
    {
        // Placeholder - pode ser expandido se houver sistema de avaliação
        return [];
    }

    // Métodos de tendências
    private function getTendenciasDemandas(array $filters): array
    {
        return $this->getDemandasPorMesComFiltros($filters);
    }

    private function getTendenciasOrdens(array $filters): array
    {
        return $this->getOrdensPorMesComFiltros($filters);
    }

    private function getTendenciasMateriais(array $filters): array
    {
        return $this->getAnaliseTemporalMateriais(
            $filters['data_inicio'] ?? now()->subMonths(6)->format('Y-m-d'),
            $filters['data_fim'] ?? now()->format('Y-m-d'),
            []
        );
    }

    // Métodos de exportação
    private function exportDemandas($demandas, string $format)
    {
        // Converter para Collection se necessário
        if (!$demandas instanceof \Illuminate\Support\Collection) {
            $demandas = collect($demandas);
        }

        // Formatar dados antes de exportar
        $demandasFormatadas = $demandas->map(function($demanda) {
            return (object) [
                'codigo' => $demanda->codigo ?? 'N/A',
                'solicitante_nome' => $demanda->solicitante_nome ?? 'N/A',
                'tipo' => TranslationHelper::translateType($demanda->tipo ?? 'outros'),
                'prioridade' => TranslationHelper::translateStatus($demanda->prioridade ?? 'media'),
                'status' => TranslationHelper::translateStatus($demanda->status ?? 'pendente'),
                'localidade_nome' => $demanda->localidade_nome ?? 'N/A',
                'data_abertura' => $demanda->data_abertura ? \Carbon\Carbon::parse($demanda->data_abertura)->format('d/m/Y') : 'N/A',
                'data_conclusao' => $demanda->data_conclusao ? \Carbon\Carbon::parse($demanda->data_conclusao)->format('d/m/Y') : 'N/A',
            ];
        });

        $filename = 'relatorio_demandas_' . date('Ymd_His');
        $columns = [
            'codigo' => 'Código',
            'solicitante_nome' => 'Solicitante',
            'tipo' => 'Tipo',
            'prioridade' => 'Prioridade',
            'status' => 'Status',
            'localidade_nome' => 'Localidade',
            'data_abertura' => 'Data Abertura',
            'data_conclusao' => 'Data Conclusão',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($demandasFormatadas, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($demandasFormatadas, $columns, $filename, 'Relatório de Demandas');
        } else {
            return $this->exportCsv($demandasFormatadas, $columns, $filename, 'Relatório de Demandas');
        }
    }

    private function exportOrdens($ordens, string $format)
    {
        // Converter para Collection se necessário
        if (!$ordens instanceof \Illuminate\Support\Collection) {
            $ordens = collect($ordens);
        }

        // Formatar dados antes de exportar
        $ordensFormatadas = $ordens->map(function($ordem) {
            return (object) [
                'numero' => $ordem->numero ?? 'N/A',
                'demanda_codigo' => $ordem->demanda_codigo ?? 'N/A',
                'solicitante_nome' => $ordem->solicitante_nome ?? 'N/A',
                'tipo_servico' => TranslationHelper::translateType($ordem->tipo_servico ?? 'outros'),
                'prioridade' => TranslationHelper::translateStatus($ordem->prioridade ?? 'media'),
                'status' => TranslationHelper::translateStatus($ordem->status ?? 'pendente'),
                'equipe_nome' => $ordem->equipe_nome ?? 'N/A',
                'localidade_nome' => $ordem->localidade_nome ?? 'N/A',
                'data_abertura' => $ordem->data_abertura ? \Carbon\Carbon::parse($ordem->data_abertura)->format('d/m/Y') : 'N/A',
                'data_conclusao' => $ordem->data_conclusao ? \Carbon\Carbon::parse($ordem->data_conclusao)->format('d/m/Y') : 'N/A',
                'tempo_execucao' => ($ordem->tempo_execucao && $ordem->tempo_execucao > 0) ? number_format($ordem->tempo_execucao, 0, ',', '.') . ' min' : '0 min',
            ];
        });

        $filename = 'relatorio_ordens_' . date('Ymd_His');
        $columns = [
            'numero' => 'Número',
            'demanda_codigo' => 'Código Demanda',
            'solicitante_nome' => 'Solicitante',
            'tipo_servico' => 'Tipo Serviço',
            'prioridade' => 'Prioridade',
            'status' => 'Status',
            'equipe_nome' => 'Equipe',
            'localidade_nome' => 'Localidade',
            'data_abertura' => 'Data Abertura',
            'data_conclusao' => 'Data Conclusão',
            'tempo_execucao' => 'Tempo Execução',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($ordensFormatadas, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($ordensFormatadas, $columns, $filename, 'Relatório de Ordens de Serviço');
        } else {
            return $this->exportCsv($ordensFormatadas, $columns, $filename, 'Relatório de Ordens de Serviço');
        }
    }

    private function exportMateriais($materiais, string $format)
    {
        // Converter para Collection se necessário
        if (!$materiais instanceof \Illuminate\Support\Collection) {
            $materiais = collect($materiais);
        }

        // Formatar dados antes de exportar
        $materiaisFormatados = $materiais->map(function($material) {
            return (object) [
                'codigo' => $material->codigo ?? 'N/A',
                'nome' => $material->nome ?? 'N/A',
                'categoria' => TranslationHelper::translateType($material->categoria ?? 'outros'),
                'quantidade_estoque' => FormatHelper::formatarQuantidade($material->quantidade_estoque ?? 0, $material->unidade_medida ?? null),
                'quantidade_minima' => FormatHelper::formatarQuantidade($material->quantidade_minima ?? 0, $material->unidade_medida ?? null),
                'valor_unitario' => 'R$ ' . number_format($material->valor_unitario ?? 0, 2, ',', '.'),
                'unidade_medida' => ucfirst($material->unidade_medida ?? 'unidade'),
                'status' => ($material->ativo ?? false) ? 'Ativo' : 'Inativo',
            ];
        });

        $filename = 'relatorio_materiais_' . date('Ymd_His');
        $columns = [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'categoria' => 'Categoria',
            'quantidade_estoque' => 'Estoque',
            'quantidade_minima' => 'Mínimo',
            'valor_unitario' => 'Valor Unitário',
            'unidade_medida' => 'Unidade',
            'status' => 'Status',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($materiaisFormatados, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($materiaisFormatados, $columns, $filename, 'Relatório de Materiais');
        } else {
            return $this->exportCsv($materiaisFormatados, $columns, $filename, 'Relatório de Materiais');
        }
    }

    private function exportEquipes($equipes, string $format)
    {
        // Converter para Collection se necessário
        if (!$equipes instanceof \Illuminate\Support\Collection) {
            $equipes = collect($equipes);
        }

        $filename = 'relatorio_equipes_' . date('Ymd_His');
        $columns = [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'lider_nome' => 'Líder',
            'total_os' => 'Total OS',
            'os_concluidas' => 'OS Concluídas',
            'tempo_medio_execucao' => 'Tempo Médio (min)',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($equipes, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($equipes, $columns, $filename, 'Relatório de Equipes');
        } else {
            return $this->exportCsv($equipes, $columns, $filename, 'Relatório de Equipes');
        }
    }

    // ========== NOVOS RELATÓRIOS ==========

    public function relatorioNotificacoes(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['type', 'module_source', 'is_read', 'user_id', 'data_inicio', 'data_fim']);
            $this->logRelatorioAccess('notificacoes', $filters);

            $query = DB::table('notifications')
                ->leftJoin('users', 'notifications.user_id', '=', 'users.id')
                ->select(
                    'notifications.*',
                    'users.name as usuario_nome',
                    'users.email as usuario_email'
                );

            if (!empty($filters['type'])) {
                $query->where('notifications.type', $filters['type']);
            }
            if (!empty($filters['module_source'])) {
                $query->where('notifications.module_source', $filters['module_source']);
            }
            if (isset($filters['is_read']) && $filters['is_read'] !== '') {
                $query->where('notifications.is_read', $filters['is_read'] == '1' ? 1 : 0);
            }
            if (!empty($filters['user_id'])) {
                $query->where('notifications.user_id', $filters['user_id']);
            }
            if (!empty($filters['data_inicio'])) {
                $query->whereDate('notifications.created_at', '>=', $filters['data_inicio']);
            }
            if (!empty($filters['data_fim'])) {
                $query->whereDate('notifications.created_at', '<=', $filters['data_fim']);
            }

            // Verificar se é uma requisição de exportação
            $format = $request->query('format') ?? $request->input('format');
            if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
                $notificacoes = $query->orderBy('notifications.created_at', 'desc')->get();
                return $this->exportNotificacoes($notificacoes, $format);
            }

            $notificacoes = $query->orderBy('notifications.created_at', 'desc')->paginate(20);

            // Estatísticas
            $stats = [
                'total' => $this->safeCount('notifications'),
                'nao_lidas' => $this->safeCountWhere('notifications', 'is_read', false),
                'lidas' => $this->safeCountWhere('notifications', 'is_read', true),
                'por_tipo' => $this->safeQuery('notifications', function($q) {
                    return $q->select('type', DB::raw('count(*) as total'))
                        ->groupBy('type')
                        ->pluck('total', 'type')
                        ->toArray();
                }, []),
                'por_modulo' => $this->safeQuery('notifications', function($q) {
                    return $q->select('module_source', DB::raw('count(*) as total'))
                        ->whereNotNull('module_source')
                        ->groupBy('module_source')
                        ->pluck('total', 'module_source')
                        ->toArray();
                }, []),
            ];

            // Usuários para filtro
            $usuarios = $this->safeQuery('users', function($q) {
                return $q->orderBy('name')->get(['id', 'name', 'email']);
            }, collect([]));

            return view('relatorios::notificacoes', compact('notificacoes', 'stats', 'filters', 'usuarios'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de notificações: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de notificações. Por favor, tente novamente.');
        }
    }

    public function relatorioAuditoria(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['action', 'module', 'user_id', 'model_type', 'data_inicio', 'data_fim']);
            $this->logRelatorioAccess('auditoria', $filters);

            $query = DB::table('audit_logs')
                ->leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
                ->select(
                    'audit_logs.*',
                    'users.name as usuario_nome',
                    'users.email as usuario_email'
                );

            if (!empty($filters['action'])) {
                $query->where('audit_logs.action', $filters['action']);
            }
            if (!empty($filters['module'])) {
                $query->where('audit_logs.module', $filters['module']);
            }
            if (!empty($filters['user_id'])) {
                $query->where('audit_logs.user_id', $filters['user_id']);
            }
            if (!empty($filters['model_type'])) {
                $query->where('audit_logs.model_type', 'like', '%' . $filters['model_type'] . '%');
            }
            if (!empty($filters['data_inicio'])) {
                $query->whereDate('audit_logs.created_at', '>=', $filters['data_inicio']);
            }
            if (!empty($filters['data_fim'])) {
                $query->whereDate('audit_logs.created_at', '<=', $filters['data_fim']);
            }

            // Verificar se é uma requisição de exportação
            $format = $request->query('format') ?? $request->input('format');
            if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
                $logs = $query->orderBy('audit_logs.created_at', 'desc')->get();
                return $this->exportAuditoria($logs, $format);
            }

            $logs = $query->orderBy('audit_logs.created_at', 'desc')->paginate(20);

            // Estatísticas
            $stats = [
                'total' => $this->safeCount('audit_logs'),
                'por_acao' => $this->safeQuery('audit_logs', function($q) {
                    return $q->select('action', DB::raw('count(*) as total'))
                        ->groupBy('action')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->pluck('total', 'action')
                        ->toArray();
                }, []),
                'por_modulo' => $this->safeQuery('audit_logs', function($q) {
                    return $q->select('module', DB::raw('count(*) as total'))
                        ->whereNotNull('module')
                        ->groupBy('module')
                        ->pluck('total', 'module')
                        ->toArray();
                }, []),
                'por_usuario' => $this->safeQuery('audit_logs', function($q) {
                    return $q->join('users', 'audit_logs.user_id', '=', 'users.id')
                        ->select('users.name', DB::raw('count(*) as total'))
                        ->whereNotNull('audit_logs.user_id')
                        ->groupBy('users.id', 'users.name')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->pluck('total', 'users.name')
                        ->toArray();
                }, []),
            ];

            // Usuários para filtro
            $usuarios = $this->safeQuery('users', function($q) {
                return $q->orderBy('name')->get(['id', 'name', 'email']);
            }, collect([]));

            return view('relatorios::auditoria', compact('logs', 'stats', 'filters', 'usuarios'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de auditoria: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de auditoria. Por favor, tente novamente.');
        }
    }

    public function relatorioSolicitacoesMateriais(Request $request)
    {
        try {
            // A tabela solicitacoes_materiais não tem coluna status, então removemos esse filtro
            $filters = $this->getFilters($request, ['data_inicio', 'data_fim']);
            $this->logRelatorioAccess('solicitacoes_materiais', $filters);

            if (!Schema::hasTable('solicitacoes_materiais')) {
                return view('relatorios::solicitacoes_materiais', [
                    'solicitacoes' => collect([])->paginate(20),
                    'stats' => ['total' => 0, 'pendentes' => 0, 'aprovadas' => 0, 'rejeitadas' => 0],
                    'filters' => $filters,
                ]);
            }

            $query = DB::table('solicitacoes_materiais')
                ->leftJoin('users', 'solicitacoes_materiais.user_id', '=', 'users.id')
                ->select(
                    'solicitacoes_materiais.*',
                    'users.name as usuario_nome'
                )
                ->whereNull('solicitacoes_materiais.deleted_at');

            // Removido filtro de status pois a tabela não tem essa coluna
            if (!empty($filters['data_inicio'])) {
                $query->whereDate('solicitacoes_materiais.created_at', '>=', $filters['data_inicio']);
            }
            if (!empty($filters['data_fim'])) {
                $query->whereDate('solicitacoes_materiais.created_at', '<=', $filters['data_fim']);
            }

            // Verificar se é uma requisição de exportação
            $format = $request->query('format') ?? $request->input('format');
            if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
                $solicitacoes = $query->orderBy('solicitacoes_materiais.created_at', 'desc')->get();
                return $this->exportSolicitacoesMateriais($solicitacoes, $format);
            }

            $solicitacoes = $query->orderBy('solicitacoes_materiais.created_at', 'desc')->paginate(20);

            // Estatísticas - A tabela solicitacoes_materiais não tem coluna status
            $stats = [
                'total' => $this->safeCount('solicitacoes_materiais'),
                'pendentes' => 0, // Não aplicável - tabela não tem status
                'aprovadas' => 0, // Não aplicável - tabela não tem status
                'rejeitadas' => 0, // Não aplicável - tabela não tem status
            ];

            return view('relatorios::solicitacoes_materiais', compact('solicitacoes', 'stats', 'filters'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de solicitações de materiais: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de solicitações de materiais. Por favor, tente novamente.');
        }
    }

    public function relatorioMovimentacoesMateriais(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['tipo', 'status', 'material_id', 'data_inicio', 'data_fim']);
            $this->logRelatorioAccess('movimentacoes_materiais', $filters);

            $query = DB::table('material_movimentacoes')
                ->leftJoin('materiais', 'material_movimentacoes.material_id', '=', 'materiais.id')
                ->leftJoin('funcionarios', 'material_movimentacoes.funcionario_id', '=', 'funcionarios.id')
                ->select(
                    'material_movimentacoes.*',
                    'materiais.nome as material_nome',
                    'materiais.codigo as material_codigo',
                    'materiais.unidade_medida as material_unidade_medida',
                    'funcionarios.nome as funcionario_nome'
                )
                ->whereNull('materiais.deleted_at');

            if (!empty($filters['tipo'])) {
                $query->where('material_movimentacoes.tipo', $filters['tipo']);
            }
            if (!empty($filters['status'])) {
                $query->where('material_movimentacoes.status', $filters['status']);
            }
            if (!empty($filters['material_id'])) {
                $query->where('material_movimentacoes.material_id', $filters['material_id']);
            }
            if (!empty($filters['data_inicio'])) {
                $query->whereDate('material_movimentacoes.created_at', '>=', $filters['data_inicio']);
            }
            if (!empty($filters['data_fim'])) {
                $query->whereDate('material_movimentacoes.created_at', '<=', $filters['data_fim']);
            }

            // Verificar se é uma requisição de exportação
            $format = $request->query('format') ?? $request->input('format');
            if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
                $movimentacoes = $query->orderBy('material_movimentacoes.created_at', 'desc')->get();
                return $this->exportMovimentacoesMateriais($movimentacoes, $format);
            }

            $movimentacoes = $query->orderBy('material_movimentacoes.created_at', 'desc')->paginate(20);

            // Estatísticas
            $stats = [
                'total' => $this->safeCount('material_movimentacoes'),
                'entradas' => $this->safeCountWhere('material_movimentacoes', 'tipo', 'entrada'),
                'saidas' => $this->safeCountWhere('material_movimentacoes', 'tipo', 'saida'),
                'confirmadas' => $this->safeCountWhere('material_movimentacoes', 'status', 'confirmado'),
                'pendentes' => $this->safeCountWhere('material_movimentacoes', 'status', 'pendente'),
            ];

            // Materiais para filtro
            $materiais = $this->safeQuery('materiais', function($q) {
                return $q->whereNull('deleted_at')->orderBy('nome')->get(['id', 'nome', 'codigo']);
            }, collect([]));

            return view('relatorios::movimentacoes_materiais', compact('movimentacoes', 'stats', 'filters', 'materiais'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de movimentações de materiais: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de movimentações de materiais. Por favor, tente novamente.');
        }
    }

    public function relatorioUsuarios(Request $request)
    {
        try {
            $filters = $this->getFilters($request, ['active', 'role']);
            $this->logRelatorioAccess('usuarios', $filters);

            // Usar subconsulta para evitar problemas com GROUP BY
            $query = DB::table('users')
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.phone',
                    'users.active',
                    'users.created_at',
                    'users.updated_at',
                    DB::raw('GROUP_CONCAT(DISTINCT roles.name ORDER BY roles.name) as roles')
                )
                ->groupBy('users.id', 'users.name', 'users.email', 'users.phone', 'users.active', 'users.created_at', 'users.updated_at');

            if (isset($filters['active']) && $filters['active'] !== '') {
                $query->where('users.active', $filters['active'] == '1' ? 1 : 0);
            }
            if (!empty($filters['role'])) {
                $query->where('roles.name', $filters['role']);
            }

            // Verificar se é uma requisição de exportação
            $format = $request->query('format') ?? $request->input('format');
            if ($format && in_array($format, ['csv', 'excel', 'pdf'])) {
                $usuarios = $query->orderBy('users.name')->get();
                return $this->exportUsuarios($usuarios, $format);
            }

            $usuarios = $query->orderBy('users.name')->paginate(20);

            // Estatísticas
            $stats = [
                'total' => $this->safeCount('users'),
                'ativos' => $this->safeQuery('users', function($q) {
                    return $q->where('active', 1)->count();
                }, 0),
                'inativos' => $this->safeQuery('users', function($q) {
                    return $q->where('active', 0)->count();
                }, 0),
                'por_role' => $this->safeQuery('model_has_roles', function($q) {
                    return $q->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                        ->select('roles.name', DB::raw('count(*) as total'))
                        ->groupBy('roles.name')
                        ->pluck('total', 'roles.name')
                        ->toArray();
                }, []),
            ];

            // Roles para filtro
            $roles = $this->safeQuery('roles', function($q) {
                return $q->orderBy('name')->get(['id', 'name']);
            }, collect([]));

            return view('relatorios::usuarios', compact('usuarios', 'stats', 'filters', 'roles'));
        } catch (\Exception $e) {
            LogFacade::error("Erro ao gerar relatório de usuários: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('relatorios.index')
                ->with('error', 'Erro ao gerar relatório de usuários. Por favor, tente novamente.');
        }
    }

    // ========== MÉTODOS DE EXPORTAÇÃO ADICIONAIS ==========

    private function exportNotificacoes($notificacoes, string $format)
    {
        if (!$notificacoes instanceof \Illuminate\Support\Collection) {
            $notificacoes = collect($notificacoes);
        }

        $filename = 'relatorio_notificacoes_' . date('Ymd_His');
        $columns = [
            'title' => 'Título',
            'message' => 'Mensagem',
            'type' => 'Tipo',
            'module_source' => 'Módulo',
            'usuario_nome' => 'Usuário',
            'is_read' => 'Lida',
            'created_at' => 'Data Criação',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($notificacoes, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($notificacoes, $columns, $filename, 'Relatório de Notificações');
        } else {
            return $this->exportCsv($notificacoes, $columns, $filename, 'Relatório de Notificações');
        }
    }

    private function exportAuditoria($logs, string $format)
    {
        if (!$logs instanceof \Illuminate\Support\Collection) {
            $logs = collect($logs);
        }

        $filename = 'relatorio_auditoria_' . date('Ymd_His');
        $columns = [
            'action' => 'Ação',
            'module' => 'Módulo',
            'usuario_nome' => 'Usuário',
            'model_type' => 'Modelo',
            'description' => 'Descrição',
            'ip_address' => 'IP',
            'created_at' => 'Data',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($logs, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($logs, $columns, $filename, 'Relatório de Auditoria');
        } else {
            return $this->exportCsv($logs, $columns, $filename, 'Relatório de Auditoria');
        }
    }

    private function exportSolicitacoesMateriais($solicitacoes, string $format)
    {
        if (!$solicitacoes instanceof \Illuminate\Support\Collection) {
            $solicitacoes = collect($solicitacoes);
        }

        $filename = 'relatorio_solicitacoes_materiais_' . date('Ymd_His');
        $columns = [
            'codigo' => 'Código',
            'usuario_nome' => 'Solicitante',
            'status' => 'Status',
            'observacoes' => 'Observações',
            'created_at' => 'Data Solicitação',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($solicitacoes, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($solicitacoes, $columns, $filename, 'Relatório de Solicitações de Materiais');
        } else {
            return $this->exportCsv($solicitacoes, $columns, $filename, 'Relatório de Solicitações de Materiais');
        }
    }

    private function exportMovimentacoesMateriais($movimentacoes, string $format)
    {
        if (!$movimentacoes instanceof \Illuminate\Support\Collection) {
            $movimentacoes = collect($movimentacoes);
        }

        // Formatar dados antes de exportar
        $movimentacoesFormatadas = $movimentacoes->map(function($mov) {
            return (object) [
                'material_nome' => $mov->material_nome ?? 'N/A',
                'material_codigo' => $mov->material_codigo ?? 'N/A',
                'tipo' => TranslationHelper::translateAction($mov->tipo ?? ''),
                'status' => TranslationHelper::translateStatus($mov->status ?? ''),
                'quantidade' => FormatHelper::formatarQuantidade($mov->quantidade ?? 0, $mov->material_unidade_medida ?? null),
                'valor_total' => 'R$ ' . number_format($mov->valor_total ?? 0, 2, ',', '.'),
                'funcionario_nome' => $mov->funcionario_nome ?? 'N/A',
                'created_at' => $mov->created_at ? \Carbon\Carbon::parse($mov->created_at)->format('d/m/Y H:i') : 'N/A',
            ];
        });

        $filename = 'relatorio_movimentacoes_materiais_' . date('Ymd_His');
        $columns = [
            'material_nome' => 'Material',
            'material_codigo' => 'Código Material',
            'tipo' => 'Tipo',
            'status' => 'Status',
            'quantidade' => 'Quantidade',
            'valor_total' => 'Valor Total',
            'funcionario_nome' => 'Funcionário',
            'created_at' => 'Data',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($movimentacoesFormatadas, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($movimentacoesFormatadas, $columns, $filename, 'Relatório de Movimentações de Materiais');
        } else {
            return $this->exportCsv($movimentacoesFormatadas, $columns, $filename, 'Relatório de Movimentações de Materiais');
        }
    }

    private function exportUsuarios($usuarios, string $format)
    {
        if (!$usuarios instanceof \Illuminate\Support\Collection) {
            $usuarios = collect($usuarios);
        }

        $filename = 'relatorio_usuarios_' . date('Ymd_His');
        $columns = [
            'name' => 'Nome',
            'email' => 'Email',
            'phone' => 'Telefone',
            'active' => 'Ativo',
            'roles' => 'Funções',
            'created_at' => 'Data Criação',
        ];

        if ($format === 'excel') {
            return $this->exportExcel($usuarios, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($usuarios, $columns, $filename, 'Relatório de Usuários');
        } else {
            return $this->exportCsv($usuarios, $columns, $filename, 'Relatório de Usuários');
        }
    }
}
