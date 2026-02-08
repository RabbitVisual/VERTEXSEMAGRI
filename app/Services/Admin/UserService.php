<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Get all users with pagination
     */
    public function getAllUsers(array $filters = [], int $perPage = 15)
    {
        $query = User::with('roles');

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $searchClean = preg_replace('/[^0-9]/', '', $search);
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$searchClean}%");
            });
        }

        if (isset($filters['role'])) {
            $query->role($filters['role']);
        }

        if (isset($filters['active'])) {
            $query->where('active', $filters['active']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Create a new user
     */
    public function createUser(array $data): User
    {
        DB::beginTransaction();
        
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => isset($data['cpf']) ? preg_replace('/[^0-9]/', '', $data['cpf']) : null,
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'] ?? null,
                'active' => $data['active'] ?? true,
            ]);

            if (isset($data['roles'])) {
                $user->assignRole($data['roles']);
            }

            AuditLog::log(
                'user.create',
                User::class,
                $user->id,
                'admin',
                "Usuário {$user->name} criado",
                null,
                $user->toArray()
            );

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update a user
     */
    public function updateUser(User $user, array $data): User
    {
        DB::beginTransaction();
        
        try {
            $oldValues = $user->toArray();
            
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => isset($data['cpf']) && !empty($data['cpf']) ? preg_replace('/[^0-9]/', '', $data['cpf']) : $user->cpf,
                'phone' => $data['phone'] ?? $user->phone,
                'active' => $data['active'] ?? $user->active,
            ];

            if (isset($data['password']) && !empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            if (isset($data['roles'])) {
                $user->syncRoles($data['roles']);
            }

            AuditLog::log(
                'user.update',
                User::class,
                $user->id,
                'admin',
                "Usuário {$user->name} atualizado",
                $oldValues,
                $user->toArray()
            );

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a user
     */
    public function deleteUser(User $user): bool
    {
        DB::beginTransaction();
        
        try {
            $oldValues = $user->toArray();
            $userName = $user->name;
            
            $user->delete();

            AuditLog::log(
                'user.delete',
                User::class,
                $user->id,
                'admin',
                "Usuário {$userName} deletado",
                $oldValues,
                null
            );

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus(User $user): User
    {
        $oldStatus = $user->active;
        $user->update(['active' => !$oldStatus]);

        AuditLog::log(
            'user.status',
            User::class,
            $user->id,
            'admin',
            "Status do usuário {$user->name} alterado",
            ['active' => $oldStatus],
            ['active' => !$oldStatus]
        );

        return $user;
    }
}

