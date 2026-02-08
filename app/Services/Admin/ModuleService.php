<?php

namespace App\Services\Admin;

use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ModuleService
{
    /**
     * Get all modules with their status
     */
    public function getAllModules(): array
    {
        $modules = Module::all();
        $modulesData = [];

        foreach ($modules as $module) {
            // Construir namespace baseado no nome do módulo
            $namespace = 'Modules\\' . $module->getStudlyName();

            $modulesData[] = [
                'name' => $module->getName(),
                'alias' => $module->get('alias', $module->getName()),
                'description' => $module->getDescription() ?? $module->get('description', 'Sem descrição'),
                'version' => $module->get('version', '1.0.0'),
                'author' => $module->get('author', 'N/A'),
                'company' => $module->get('company', 'N/A'),
                'keywords' => $module->get('keywords', []),
                'enabled' => $module->isEnabled(),
                'path' => $module->getPath(),
                'namespace' => $namespace,
                'priority' => (int) ($module->getPriority() ?: $module->get('priority', 0)),
            ];
        }

        return $modulesData;
    }

    /**
     * Enable a module
     */
    public function enableModule(string $moduleName): bool
    {
        try {
            $module = Module::find($moduleName);

            if (!$module) {
                return false;
            }

            Module::enable($moduleName);

            try {
                if (class_exists(\App\Models\AuditLog::class) && method_exists(\App\Models\AuditLog::class, 'log')) {
                    \App\Models\AuditLog::log(
                        'module.enable',
                        null,
                        null,
                        'admin',
                        "Módulo {$moduleName} habilitado",
                        ['enabled' => false],
                        ['enabled' => true]
                    );
                }
            } catch (\Exception $e) {
                // Ignorar erros de log de auditoria
            }

            return true;
        } catch (\Exception $e) {
            \Log::error("Error enabling module {$moduleName}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Disable a module
     */
    public function disableModule(string $moduleName): bool
    {
        try {
            $module = Module::find($moduleName);

            if (!$module) {
                return false;
            }

            Module::disable($moduleName);

            try {
                if (class_exists(\App\Models\AuditLog::class) && method_exists(\App\Models\AuditLog::class, 'log')) {
                    \App\Models\AuditLog::log(
                        'module.disable',
                        null,
                        null,
                        'admin',
                        "Módulo {$moduleName} desabilitado",
                        ['enabled' => true],
                        ['enabled' => false]
                    );
                }
            } catch (\Exception $e) {
                // Ignorar erros de log de auditoria
            }

            return true;
        } catch (\Exception $e) {
            \Log::error("Error disabling module {$moduleName}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get module statistics
     */
    public function getModuleStats(string $moduleName): array
    {
        $module = Module::find($moduleName);

        if (!$module) {
            return [];
        }

        // Contar registros em tabelas do módulo (se existirem)
        $stats = [
            'enabled' => $module->isEnabled(),
            'version' => $module->get('version', '1.0.0'),
        ];

        // Adicionar estatísticas específicas por módulo
        try {
            // Mapeamento de módulos para suas tabelas principais
            $moduleTables = [
                'Localidades' => 'localidades',
                'Pessoas' => 'pessoas_cad',
                'Demandas' => 'demandas',
                'Ordens' => 'ordens_servico',
                'Equipes' => 'equipes',
                'Funcionarios' => 'funcionarios',
                'Materiais' => 'materiais',
                'Iluminacao' => 'pontos_luz',
                'Agua' => 'redes_agua',
                'Pocos' => 'pocos',
                'Estradas' => 'trechos',
                'CAF' => 'cadastros_caf',
                'ProgramasAgricultura' => 'programas',
                'Notificacoes' => 'notificacoes',
            ];

            if (isset($moduleTables[$moduleName]) && Schema::hasTable($moduleTables[$moduleName])) {
                $tableName = $moduleTables[$moduleName];
                
                // Verificar se tabela tem coluna deleted_at (soft deletes)
                $hasSoftDeletes = Schema::hasColumn($tableName, 'deleted_at');
                
                $query = DB::table($tableName);
                if ($hasSoftDeletes) {
                    $query->whereNull('deleted_at');
                }
                $stats['total_registros'] = $query->count();
                
                // Estatísticas adicionais por módulo
                switch ($moduleName) {
                    case 'Demandas':
                        if (Schema::hasTable('demandas')) {
                            $queryAbertas = DB::table('demandas')->where('status', 'aberta');
                            $queryAndamento = DB::table('demandas')->where('status', 'em_andamento');
                            $queryConcluidas = DB::table('demandas')->where('status', 'concluida');
                            
                            if (Schema::hasColumn('demandas', 'deleted_at')) {
                                $queryAbertas->whereNull('deleted_at');
                                $queryAndamento->whereNull('deleted_at');
                                $queryConcluidas->whereNull('deleted_at');
                            }
                            
                            $stats['abertas'] = $queryAbertas->count();
                            $stats['em_andamento'] = $queryAndamento->count();
                            $stats['concluidas'] = $queryConcluidas->count();
                        }
                        break;
                    case 'Ordens':
                        if (Schema::hasTable('ordens_servico')) {
                            $queryPendentes = DB::table('ordens_servico')->where('status', 'pendente');
                            $queryExecucao = DB::table('ordens_servico')->where('status', 'em_execucao');
                            $queryConcluidas = DB::table('ordens_servico')->where('status', 'concluida');
                            
                            if (Schema::hasColumn('ordens_servico', 'deleted_at')) {
                                $queryPendentes->whereNull('deleted_at');
                                $queryExecucao->whereNull('deleted_at');
                                $queryConcluidas->whereNull('deleted_at');
                            }
                            
                            $stats['pendentes'] = $queryPendentes->count();
                            $stats['em_execucao'] = $queryExecucao->count();
                            $stats['concluidas'] = $queryConcluidas->count();
                        }
                        break;
                    case 'Equipes':
                        if (Schema::hasTable('equipes')) {
                            $queryAtivas = DB::table('equipes')->where('ativo', true);
                            $queryInativas = DB::table('equipes')->where('ativo', false);
                            
                            if (Schema::hasColumn('equipes', 'deleted_at')) {
                                $queryAtivas->whereNull('deleted_at');
                                $queryInativas->whereNull('deleted_at');
                            }
                            
                            $stats['ativas'] = $queryAtivas->count();
                            $stats['inativas'] = $queryInativas->count();
                        }
                        break;
                    case 'Materiais':
                        if (Schema::hasTable('materiais')) {
                            $queryComEstoque = DB::table('materiais')->where('quantidade_estoque', '>', 0);
                            $querySemEstoque = DB::table('materiais')->where('quantidade_estoque', '<=', 0);
                            
                            if (Schema::hasColumn('materiais', 'deleted_at')) {
                                $queryComEstoque->whereNull('deleted_at');
                                $querySemEstoque->whereNull('deleted_at');
                            }
                            
                            $stats['com_estoque'] = $queryComEstoque->count();
                            $stats['sem_estoque'] = $querySemEstoque->count();
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            // Ignorar erros de tabelas não existentes
            \Log::debug("Erro ao obter estatísticas do módulo {$moduleName}: " . $e->getMessage());
        }

        return $stats;
    }

    /**
     * Get overall statistics for modules page
     */
    public function getOverallStats(): array
    {
        try {
            $modules = Module::all();
            
            // Converter para Collection se necessário
            if (!($modules instanceof Collection)) {
                if (is_array($modules)) {
                    $modules = collect($modules);
                } else {
                    // Se for um objeto iterável, converter para array primeiro
                    $modules = collect(iterator_to_array($modules));
                }
            }
            
            $totalModules = $modules->count();
            $enabledModules = $modules->filter(function($m) {
                if (is_object($m) && method_exists($m, 'isEnabled')) {
                    return $m->isEnabled();
                }
                return false;
            })->count();
            
            $disabledModules = $totalModules - $enabledModules;

            return [
                'total' => $totalModules,
                'enabled' => $enabledModules,
                'disabled' => $disabledModules,
                'percentage_enabled' => $totalModules > 0 ? round(($enabledModules / $totalModules) * 100, 1) : 0,
            ];
        } catch (\Exception $e) {
            \Log::error("Erro ao obter estatísticas gerais dos módulos: " . $e->getMessage(), [
                'exception' => $e,
            ]);
            return [
                'total' => 0,
                'enabled' => 0,
                'disabled' => 0,
                'percentage_enabled' => 0,
            ];
        }
    }
}

