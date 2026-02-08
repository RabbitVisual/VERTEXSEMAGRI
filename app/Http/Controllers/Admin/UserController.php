<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'role', 'active']);
        $users = $this->userService->getAllUsers($filters);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'filters'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Remover formatação do CPF antes da validação
        if ($request->has('cpf')) {
            $cpfClean = preg_replace('/[^0-9]/', '', $request->cpf ?? '');
            $request->merge([
                'cpf' => !empty($cpfClean) ? $cpfClean : null,
            ]);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf' => 'nullable|string|size:11|unique:users,cpf',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'active' => 'boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        try {
            $user = $this->userService->createUser($validated);
            return redirect()->route('admin.users.index')
                ->with('success', "Usuário {$user->name} criado com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->load('roles');

        $auditLogs = collect([]);
        try {
            if (class_exists(\App\Models\AuditLog::class) && \Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
                $auditLogs = \App\Models\AuditLog::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
            }
        } catch (\Exception $e) {
            // Ignorar erros de audit logs
        }

        return view('admin.users.show', compact('user', 'auditLogs'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Remover formatação do CPF antes da validação
        if ($request->has('cpf')) {
            $cpfClean = preg_replace('/[^0-9]/', '', $request->cpf ?? '');
            $request->merge([
                'cpf' => !empty($cpfClean) ? $cpfClean : null,
            ]);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'cpf' => 'nullable|string|size:11|unique:users,cpf,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'active' => 'boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        try {
            $user = $this->userService->updateUser($user, $validated);
            return redirect()->route('admin.users.index')
                ->with('success', "Usuário {$user->name} atualizado com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $this->userService->deleteUser($user);
            return redirect()->route('admin.users.index')
                ->with('success', "Usuário {$user->name} deletado com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao deletar usuário: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            $user = $this->userService->toggleUserStatus($user);
            $status = $user->active ? 'ativado' : 'desativado';
            return redirect()->back()
                ->with('success', "Usuário {$status} com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao alterar status do usuário');
        }
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Upload da foto
            if ($request->hasFile('photo')) {
                // Deletar foto antiga se existir
                if ($user->photo && file_exists(public_path('storage/' . $user->photo))) {
                    unlink(public_path('storage/' . $user->photo));
                }

                $photo = $request->file('photo');
                $photoName = 'profile_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $photoPath = $photo->storeAs('profiles', $photoName, 'public');
                $validated['photo'] = $photoPath;
            }

            // Atualizar senha se fornecida
            if (isset($validated['password']) && !empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('admin.profile')
                ->with('success', 'Perfil atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }
}
