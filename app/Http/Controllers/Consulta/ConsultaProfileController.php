<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConsultaProfileController extends Controller
{
    /**
     * Exibir perfil do usuário consulta
     */
    public function index()
    {
        $user = Auth::user();
        $user->load(['roles', 'permissions']);

        return view('consulta.profile.index', compact('user'));
    }

    /**
     * Atualizar perfil do usuário consulta
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Usuários consulta não podem alterar CPF
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
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                $photo = $request->file('photo');
                $photoName = 'profile_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $photoPath = $photo->storeAs('profiles', $photoName, 'public');
                $validated['photo'] = $photoPath;
            }

            // CPF não pode ser alterado por usuários consulta

            // Atualizar senha se fornecida
            if (isset($validated['password']) && !empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('consulta.profile')
                ->with('success', 'Perfil atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }
}

