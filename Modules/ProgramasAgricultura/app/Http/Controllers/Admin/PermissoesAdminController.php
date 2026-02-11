<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\ProgramasAgricultura\App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissoesAdminController extends Controller
{
    /**
     * Lista a matriz de permissões
     */
    public function index()
    {
        $users = User::role('co-admin')->with('programasResponsaveis')->get();
        $programas = Programa::all();

        return view('programasagricultura::admin.permissao.index', compact('users', 'programas'));
    }

    /**
     * Salva as atribuições
     */
    public function store(Request $request)
    {
        $request->validate([
            'permissoes' => 'nullable|array',
            'permissoes.*.*' => 'exists:programas,id'
        ]);

        try {
            DB::beginTransaction();

            // Limpa permissões de quem entrou no post (para simplificar)
            $coAdmins = User::role('co-admin')->get();

            foreach ($coAdmins as $user) {
                $selecionados = $request->input("permissoes.{$user->id}", []);
                $user->programasResponsaveis()->sync($selecionados);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Permissões atualizadas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar permissões: ' . $e->getMessage());
        }
    }
}
