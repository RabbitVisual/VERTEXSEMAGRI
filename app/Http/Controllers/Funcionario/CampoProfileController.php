<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Modules\Ordens\App\Models\OrdemServico;

class CampoProfileController extends Controller
{
    /**
     * Exibir perfil do funcionário de campo
     */
    public function index()
    {
        $user = Auth::user();

        // Carregar relacionamentos necessários
        $user->load(['roles', 'permissions']);

        // Estatísticas do usuário
        $estatisticas = [
            'total_ordens' => OrdemServico::where('user_id_execucao', $user->id)->count(),
            'ordens_pendentes' => OrdemServico::where('user_id_execucao', $user->id)
                ->where('status', 'pendente')->count(),
            'ordens_em_execucao' => OrdemServico::where('user_id_execucao', $user->id)
                ->where('status', 'em_execucao')->count(),
            'ordens_concluidas' => OrdemServico::where('user_id_execucao', $user->id)
                ->where('status', 'concluida')->count(),
        ];

        return view('campo.profile.index', compact('user', 'estatisticas'));
    }

    /**
     * Atualizar perfil do funcionário
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Verificar senha atual se estiver alterando a senha
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'A senha atual está incorreta.'])->withInput();
            }
        }

        // Atualizar dados básicos
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        // CPF não pode ser alterado por usuários campo - apenas admin pode alterar

        // Atualizar senha se fornecida
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload de foto
        if ($request->hasFile('photo')) {
            // Remover foto antiga se existir
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->route('campo.profile.index')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}

