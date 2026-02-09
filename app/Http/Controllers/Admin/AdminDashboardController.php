<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AuditService;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index()
    {
        // Estatísticas gerais (Mantendo as existentes)
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('active', true)->count(),
            'inactive_users' => User::where('active', false)->count(),
            'total_logs' => $this->safeCount('audit_logs'),
            'logs_today' => $this->safeQuery('audit_logs', function($query) {
                return $query->whereDate('created_at', today())->count();
            }, 0),
            'logs_week' => $this->safeQuery('audit_logs', function($query) {
                return $query->where('created_at', '>=', now()->subWeek())->count();
            }, 0),
            'solicitacoes_campo_pendentes' => $this->safeQuery('solicitacoes_materiais_campo', function($query) {
                return $query->where('status', 'pendente')->count();
            }, 0),
        ];

        // Smart Widgets (New Intelligence) - Cached for 5 minutes
        $smartWidgets = Cache::remember('dashboard_smart_widgets', 300, function () {
            // 1. Newsroom: Demandas Concluídas sem Post no Blog
            $newsroomDrafts = 0;
            if (Schema::hasTable('demandas') && \Nwidart\Modules\Facades\Module::isEnabled('Demandas')) {
                // Check if Blog module is enabled to know where to check relationship
                if (\Nwidart\Modules\Facades\Module::isEnabled('Blog') && Schema::hasTable('blog_posts')) {
                    $newsroomDrafts = \Modules\Demandas\App\Models\Demanda::where('status', 'concluida')
                        ->whereNotExists(function ($query) {
                            $query->select(DB::raw(1))
                                ->from('blog_posts')
                                ->whereRaw('blog_posts.related_demand_id = demandas.id');
                        })
                        ->count();
                } else {
                    $newsroomDrafts = \Modules\Demandas\App\Models\Demanda::where('status', 'concluida')->count();
                }
            }

            // 2. Field Ops: Recent Syncs
            $recentSyncs = [];
            if (Schema::hasTable('offline_sync_logs')) {
                $recentSyncs = DB::table('offline_sync_logs')
                    ->join('users', 'offline_sync_logs.user_id', '=', 'users.id')
                    ->select('offline_sync_logs.*', 'users.name as user_name', 'users.photo as user_avatar')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($log) {
                        $log->time_ago = \Carbon\Carbon::parse($log->created_at)->diffForHumans();
                        $log->is_recent = \Carbon\Carbon::parse($log->created_at)->gt(now()->subHour());
                        $log->payload_size = strlen($log->payload ?? '') / 1024; // KB
                        $payload = json_decode($log->payload, true);
                        $log->photos_count = isset($payload['photos']) ? count($payload['photos']) : 0;
                        return $log;
                    });
            }

            // 3. Inventory Health: Low Stock
            $lowStockItems = [];
            if (Schema::hasTable('materiais') && \Nwidart\Modules\Facades\Module::isEnabled('Materiais')) {
                $lowStockItems = \Modules\Materiais\App\Models\Material::whereColumn('quantidade_estoque', '<=', 'quantidade_minima')
                    ->orderBy('quantidade_estoque', 'asc')
                    ->limit(5)
                    ->get();
            }

            return [
                'newsroom_drafts' => $newsroomDrafts,
                'recent_syncs' => $recentSyncs,
                'low_stock_items' => $lowStockItems
            ];
        });

        // Estatísticas por módulo
        $moduleStats = $this->getModuleStats();

        // Últimas atividades
        $recentLogs = $this->safeQueryAuditLogs();

        // Estatísticas de auditoria
        $auditStats = $this->auditService->getAuditStats();

        // Gráficos de dados
        $chartData = [
            'logs_by_day' => $this->getLogsByDay(7),
            'actions_distribution' => $this->getActionsDistribution(),
            'modules_activity' => $this->getModulesActivity(),
        ];

        return view('admin.dashboard.index', compact(
            'stats',
            'moduleStats',
            'recentLogs',
            'auditStats',
            'chartData',
            'smartWidgets'
        ));
    }

    private function getModuleStats(): array
    {
        $modules = [
            'Iluminacao' => 'pontos_luz',
            'Agua' => 'redes_agua',
            'Pocos' => 'pocos',
            'Estradas' => 'trechos',
            'Localidades' => 'localidades',
            'Equipes' => 'equipes',
            'Materiais' => 'materiais',
            'Demandas' => 'demandas',
            'Ordens' => 'ordens_servico',
        ];

        $stats = [];
        foreach ($modules as $module => $table) {
            $stats[$module] = $this->safeCount($table);
        }

        return $stats;
    }

    private function getLogsByDay(int $days = 7): array
    {
        if (!Schema::hasTable('audit_logs')) {
            return [];
        }

        try {
            $logs = AuditLog::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

            return $logs->pluck('count', 'date')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getActionsDistribution(): array
    {
        if (!Schema::hasTable('audit_logs')) {
            return [];
        }

        try {
            $actions = AuditLog::select(
                'action',
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonth())
            ->groupBy('action')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

            return $actions->pluck('count', 'action')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getModulesActivity(): array
    {
        if (!Schema::hasTable('audit_logs')) {
            return [];
        }

        try {
            $modules = AuditLog::select(
                'module',
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('module')
            ->where('created_at', '>=', now()->subMonth())
            ->groupBy('module')
            ->orderBy('count', 'desc')
            ->get();

            return $modules->pluck('count', 'module')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Conta registros de forma segura, retornando 0 se a tabela não existir
     */
    private function safeCount(string $table): int
    {
        try {
            if (!Schema::hasTable($table)) {
                return 0;
            }
            return DB::table($table)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Executa uma query de forma segura, retornando valor padrão se a tabela não existir
     */
    private function safeQuery(string $table, callable $callback, $default = null)
    {
        try {
            if (!Schema::hasTable($table)) {
                return $default;
            }
            $query = DB::table($table);
            return $callback($query);
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Busca logs de auditoria de forma segura
     */
    private function safeQueryAuditLogs()
    {
        try {
            if (!Schema::hasTable('audit_logs')) {
                return collect();
            }
            return AuditLog::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
}
