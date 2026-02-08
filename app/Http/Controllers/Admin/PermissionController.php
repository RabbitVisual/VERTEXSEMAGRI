<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PermissionService;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->getPermissionsGrouped();
        $totalPermissions = Permission::count();
        return view('admin.permissions.index', compact('permissions', 'totalPermissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        try {
            $permission = $this->permissionService->createPermission($validated['name']);
            return redirect()->route('admin.permissions.index')
                ->with('success', "Permissão {$permission->name} criada com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao criar permissão: ' . $e->getMessage());
        }
    }
}
