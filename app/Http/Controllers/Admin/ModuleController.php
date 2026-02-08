<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ModuleService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    protected $moduleService;

    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    public function index(Request $request)
    {
        $modules = $this->moduleService->getAllModules();
        $overallStats = $this->moduleService->getOverallStats();
        
        // Filtros
        $filter = $request->get('filter', 'all'); // all, enabled, disabled
        $search = $request->get('search', '');
        
        // Aplicar filtros
        if ($filter === 'enabled') {
            $modules = array_filter($modules, fn($m) => $m['enabled']);
        } elseif ($filter === 'disabled') {
            $modules = array_filter($modules, fn($m) => !$m['enabled']);
        }
        
        // Aplicar busca
        if ($search) {
            $modules = array_filter($modules, function($m) use ($search) {
                return stripos($m['name'], $search) !== false 
                    || stripos($m['description'] ?? '', $search) !== false;
            });
        }
        
        // Reindexar array
        $modules = array_values($modules);
        
        return view('admin.modules.index', compact('modules', 'overallStats', 'filter', 'search'));
    }

    public function show(string $moduleName)
    {
        $module = collect($this->moduleService->getAllModules())
            ->firstWhere('name', $moduleName);

        if (!$module) {
            return redirect()->route('admin.modules.index')
                ->with('error', 'Módulo não encontrado');
        }

        $stats = $this->moduleService->getModuleStats($moduleName);

        return view('admin.modules.show', compact('module', 'stats'));
    }

    public function enable(string $moduleName)
    {
        $result = $this->moduleService->enableModule($moduleName);

        if ($result) {
            return redirect()->route('admin.modules.index')
                ->with('success', "Módulo {$moduleName} habilitado com sucesso");
        }

        return redirect()->route('admin.modules.index')
            ->with('error', "Erro ao habilitar módulo {$moduleName}");
    }

    public function disable(string $moduleName)
    {
        $result = $this->moduleService->disableModule($moduleName);

        if ($result) {
            return redirect()->route('admin.modules.index')
                ->with('success', "Módulo {$moduleName} desabilitado com sucesso");
        }

        return redirect()->route('admin.modules.index')
            ->with('error', "Erro ao desabilitar módulo {$moduleName}");
    }
}
