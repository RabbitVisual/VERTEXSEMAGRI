<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Notificacoes\App\Models\Notificacao;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class NotificacoesConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['type', 'user_id', 'role', 'module_source', 'is_read', 'search']);
        $query = Notificacao::with('user');

        if (isset($filters['type']) && $filters['type'] !== '') {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['user_id']) && $filters['user_id'] !== '') {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['role']) && $filters['role'] !== '') {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['module_source']) && $filters['module_source'] !== '') {
            $query->where('module_source', $filters['module_source']);
        }

        if (isset($filters['is_read']) && $filters['is_read'] !== '' && $filters['is_read'] !== null) {
            $query->where('is_read', $filters['is_read']);
        }

        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);
        $users = User::select('id', 'name')->orderBy('name')->get();
        $roles = Role::all();

        // Módulos disponíveis
        $modules = [
            'Demandas' => 'Demandas',
            'Ordens' => 'Ordens',
            'Localidades' => 'Localidades',
            'Pessoas' => 'Pessoas',
            'Equipes' => 'Equipes',
            'Estradas' => 'Estradas',
            'Funcionarios' => 'Funcionários',
            'Iluminacao' => 'Iluminação',
            'Materiais' => 'Materiais',
            'Pocos' => 'Poços',
            'Agua' => 'Água',
            'Relatorios' => 'Relatórios',
        ];

        return view('consulta.notificacoes.index', compact('notifications', 'users', 'roles', 'modules', 'filters'));
    }

    public function show($id)
    {
        $notification = Notificacao::with('user')->findOrFail($id);
        return view('consulta.notificacoes.show', compact('notification'));
    }
}

