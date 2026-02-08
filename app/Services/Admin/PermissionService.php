<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\AuditLog;

class PermissionService
{
    /**
     * Get all roles with permissions
     */
    public function getAllRoles()
    {
        return Role::with('permissions')->get();
    }

    /**
     * Get all permissions grouped by module
     */
    public function getPermissionsGrouped(): array
    {
        $permissions = Permission::orderBy('name')->get();
        $grouped = [];

        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name);
            $module = $parts[0] ?? 'other';
            
            // Para permissões com múltiplos pontos (ex: lider-comunidade.usuarios.create)
            // Pegar apenas a primeira parte como módulo
            // Se tiver mais de 2 partes, agrupar as partes intermediárias
            $action = count($parts) > 1 ? implode('.', array_slice($parts, 1)) : 'unknown';

            // Normalizar nomes de módulos com hífen para exibição
            $moduleDisplay = str_replace('-', ' ', $module);
            $moduleDisplay = ucwords($moduleDisplay);

            if (!isset($grouped[$module])) {
                $grouped[$module] = [];
            }

            $grouped[$module][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'action' => $action,
                'display_name' => $this->getPermissionDisplayName($permission->name),
            ];
        }

        // Ordenar módulos alfabeticamente
        ksort($grouped);

        return $grouped;
    }

    /**
     * Get a human-readable display name for a permission
     */
    protected function getPermissionDisplayName(string $permissionName): string
    {
        // Mapear ações comuns para nomes legíveis
        $actionMap = [
            'view' => 'Visualizar',
            'create' => 'Criar',
            'edit' => 'Editar',
            'update' => 'Atualizar',
            'delete' => 'Excluir',
            'approve' => 'Aprovar',
            'manage' => 'Gerenciar',
            'index' => 'Listar',
            'show' => 'Visualizar Detalhes',
        ];

        $parts = explode('.', $permissionName);
        
        if (count($parts) === 1) {
            return ucfirst(str_replace(['-', '_'], ' ', $permissionName));
        }

        $module = str_replace(['-', '_'], ' ', $parts[0]);
        $module = ucwords($module);
        
        $action = end($parts);
        $actionDisplay = $actionMap[$action] ?? ucfirst(str_replace(['-', '_'], ' ', $action));

        // Se tiver partes intermediárias (ex: lider-comunidade.usuarios.create)
        if (count($parts) > 2) {
            $submodule = implode(' ', array_slice($parts, 1, -1));
            $submodule = ucwords(str_replace(['-', '_'], ' ', $submodule));
            return "{$module} - {$submodule} - {$actionDisplay}";
        }

        return "{$module} - {$actionDisplay}";
    }

    /**
     * Create a new role
     */
    public function createRole(array $data): Role
    {
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        AuditLog::log(
            'role.create',
            Role::class,
            $role->id,
            'admin',
            "Role {$role->name} criada",
            null,
            $role->toArray()
        );

        return $role;
    }

    /**
     * Update a role
     */
    public function updateRole(Role $role, array $data): Role
    {
        $oldValues = $role->toArray();
        
        $role->update([
            'name' => $data['name'],
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        AuditLog::log(
            'role.update',
            Role::class,
            $role->id,
            'admin',
            "Role {$role->name} atualizada",
            $oldValues,
            $role->toArray()
        );

        return $role;
    }

    /**
     * Delete a role
     */
    public function deleteRole(Role $role): bool
    {
        $oldValues = $role->toArray();
        $roleName = $role->name;
        
        $role->delete();

        AuditLog::log(
            'role.delete',
            Role::class,
            $role->id,
            'admin',
            "Role {$roleName} deletada",
            $oldValues,
            null
        );

        return true;
    }

    /**
     * Create a new permission
     */
    public function createPermission(string $name, ?string $guardName = 'web'): Permission
    {
        $permission = Permission::create([
            'name' => $name,
            'guard_name' => $guardName,
        ]);

        AuditLog::log(
            'permission.create',
            Permission::class,
            $permission->id,
            'admin',
            "Permissão {$permission->name} criada",
            null,
            $permission->toArray()
        );

        return $permission;
    }
}

