<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PermissionService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $roles = $this->permissionService->getAllRoles()->load('users');
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionService->getPermissionsGrouped();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = $this->permissionService->createRole($validated);
            return redirect()->route('admin.roles.index')
                ->with('success', "Role {$role->name} criada com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar role: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $role->load('permissions');
        $permissions = $this->permissionService->getPermissionsGrouped();
        return view('admin.roles.show', compact('role', 'permissions'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $this->permissionService->getPermissionsGrouped();
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = $this->permissionService->updateRole($role, $validated);
            return redirect()->route('admin.roles.index')
                ->with('success', "Role {$role->name} atualizada com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar role: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $this->permissionService->deleteRole($role);
            return redirect()->route('admin.roles.index')
                ->with('success', "Role {$role->name} deletada com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao deletar role: ' . $e->getMessage());
        }
    }
}
