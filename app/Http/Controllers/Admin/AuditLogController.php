<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AuditService;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'module', 'action', 'date_from', 'date_to', 'search']);
        $logs = $this->auditService->getAuditLogs($filters);
        $stats = $this->auditService->getAuditStats();
        $users = \App\Models\User::select('id', 'name')->get();
        $modules = \App\Models\AuditLog::select('module')
            ->whereNotNull('module')
            ->distinct()
            ->pluck('module');

        return view('admin.audit.index', compact('logs', 'stats', 'users', 'modules', 'filters'));
    }

    public function show($id)
    {
        $log = \App\Models\AuditLog::with('user')->findOrFail($id);
        return view('admin.audit.show', compact('log'));
    }

    public function clean(Request $request)
    {
        $days = $request->input('days', 90);
        
        try {
            $deleted = $this->auditService->cleanOldLogs($days);
            return redirect()->route('admin.audit.index')
                ->with('success', "{$deleted} logs antigos foram removidos");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao limpar logs: ' . $e->getMessage());
        }
    }
}
