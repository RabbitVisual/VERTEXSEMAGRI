<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Funcionarios\App\Models\Funcionario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FuncionarioSenhaController extends Controller
{
    /**
     * Exibe o gerenciador de senhas do funcionário
     */
    public function show($funcionarioId)
    {
        $funcionario = Funcionario::findOrFail($funcionarioId);
        $user = $funcionario->user();

        // Buscar senha temporária se existir
        $senhaTemporaria = null;
        $senhaInfo = DB::table('funcionario_senhas')
            ->where('funcionario_id', $funcionario->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($senhaInfo && !$senhaInfo->visualizada) {
            try {
                $senhaTemporaria = Crypt::decryptString($senhaInfo->senha_temporaria);
            } catch (\Exception $e) {
                $senhaTemporaria = null;
            }
        }

        return view('admin.funcionarios.senha', compact('funcionario', 'user', 'senhaTemporaria', 'senhaInfo'));
    }

    /**
     * Gera uma nova senha aleatória para o funcionário
     */
    public function gerarSenha(Request $request, $funcionarioId)
    {
        $funcionario = Funcionario::findOrFail($funcionarioId);

        if (!$funcionario->email) {
            return redirect()->back()
                ->with('error', 'O funcionário precisa ter um email cadastrado para gerar senha.');
        }

        $user = $funcionario->user();

        if (!$user) {
            // Criar usuário se não existir
            $user = User::create([
                'name' => $funcionario->nome,
                'email' => $funcionario->email,
                'password' => Hash::make(Str::random(12)), // Será atualizado abaixo
                'active' => true,
            ]);

            $user->assignRole('campo');
        }

        // Gerar nova senha
        $novaSenha = Str::random(12);

        // Atualizar senha do usuário e ativar
        $user->update([
            'password' => Hash::make($novaSenha),
            'active' => true,
        ]);

        // Garantir que tem role 'campo'
        if (!$user->hasRole('campo')) {
            $user->assignRole('campo');
        }

        // Marcar senhas anteriores como visualizadas
        DB::table('funcionario_senhas')
            ->where('funcionario_id', $funcionario->id)
            ->update(['visualizada' => true]);

        // Armazenar nova senha temporária
        DB::table('funcionario_senhas')->insert([
            'funcionario_id' => $funcionario->id,
            'user_id' => $user->id,
            'senha_temporaria' => Crypt::encryptString($novaSenha),
            'visualizada' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.funcionarios.senha.show', $funcionario->id)
            ->with('success', 'Nova senha gerada com sucesso!')
            ->with('nova_senha', $novaSenha);
    }

    /**
     * Altera a senha do funcionário
     */
    public function alterarSenha(Request $request, $funcionarioId)
    {
        $request->validate([
            'nova_senha' => 'required|string|min:8|confirmed',
        ]);

        $funcionario = Funcionario::findOrFail($funcionarioId);
        $user = $funcionario->user();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Usuário não encontrado para este funcionário.');
        }

        // Atualizar senha e ativar usuário
        $user->update([
            'password' => Hash::make($request->nova_senha),
            'active' => true,
        ]);

        // Garantir que tem role 'campo'
        if (!$user->hasRole('campo')) {
            $user->assignRole('campo');
        }

        // Marcar senhas anteriores como visualizadas
        DB::table('funcionario_senhas')
            ->where('funcionario_id', $funcionario->id)
            ->update(['visualizada' => true]);

        // Armazenar nova senha temporária
        DB::table('funcionario_senhas')->insert([
            'funcionario_id' => $funcionario->id,
            'user_id' => $user->id,
            'senha_temporaria' => Crypt::encryptString($request->nova_senha),
            'visualizada' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.funcionarios.senha.show', $funcionario->id)
            ->with('success', 'Senha alterada com sucesso!')
            ->with('nova_senha', $request->nova_senha);
    }

    /**
     * Exibe o comprovante de acesso do funcionário
     */
    public function comprovante($funcionarioId)
    {
        $funcionario = Funcionario::findOrFail($funcionarioId);
        $user = $funcionario->user();

        if (!$user) {
            return redirect()->route('admin.funcionarios.senha.show', $funcionario->id)
                ->with('error', 'Usuário não encontrado. Gere uma senha primeiro.');
        }

        // Buscar senha temporária não visualizada
        $senhaInfo = DB::table('funcionario_senhas')
            ->where('funcionario_id', $funcionario->id)
            ->where('visualizada', false)
            ->orderBy('created_at', 'desc')
            ->first();

        $senha = null;
        if ($senhaInfo) {
            try {
                $senha = Crypt::decryptString($senhaInfo->senha_temporaria);
            } catch (\Exception $e) {
                $senha = null;
            }
        }

        if (!$senha) {
            return redirect()->route('admin.funcionarios.senha.show', $funcionario->id)
                ->with('error', 'Nenhuma senha disponível para exibir. Gere uma nova senha.');
        }

        // URL do site
        $urlLogin = route('login');

        // Dados para o QR Code
        $qrCodeData = json_encode([
            'url' => $urlLogin,
            'email' => $user->email,
            'nome' => $funcionario->nome,
        ]);

        return view('admin.funcionarios.comprovante', compact('funcionario', 'user', 'senha', 'urlLogin', 'qrCodeData'));
    }

    /**
     * Marca a senha como visualizada
     */
    public function marcarVisualizada($funcionarioId)
    {
        DB::table('funcionario_senhas')
            ->where('funcionario_id', $funcionarioId)
            ->update(['visualizada' => true]);

        return redirect()->route('admin.funcionarios.senha.show', $funcionarioId)
            ->with('success', 'Senha marcada como visualizada.');
    }

    /**
     * Inicia a personificação do funcionário
     */
    public function loginAs($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $user = $funcionario->user();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Usuário não encontrado para este funcionário.');
        }

        if (!$user->active) {
            return redirect()->back()
                ->with('error', 'O usuário deste funcionário está desativado.');
        }

        // Salvar ID do admin original para retorno
        $impersonatorId = Auth::id();
        Log::info('[Impersonation] Starting.', [
            'admin_id' => $impersonatorId,
            'session_id' => session()->getId()
        ]);

        // Fazer login como o usuário do funcionário
        Auth::login($user);

        // Re-inserir o ID na nova sessão
        session(['impersonator_id' => $impersonatorId]);

        // FORÇAR gravação da sessão antes do redirecionamento
        session()->save();

        Log::info('[Impersonation] Logged in as user.', [
            'new_user_id' => Auth::id(),
            'new_session_id' => session()->getId(),
            'impersonator_id_in_session' => session('impersonator_id')
        ]);

        return redirect()->route('campo.ordens.index')
            ->with('success', "Você agora está visualizando o sistema como {$funcionario->nome}.");
    }

    /**
     * Para a personificação e volta ao admin
     */
    public function stopImpersonating()
    {
        Log::info('[Impersonation] Stop requested.', [
            'current_user_id' => Auth::id(),
            'session_id' => session()->getId(),
            'impersonator_id_exists' => session()->has('impersonator_id'),
            'impersonator_id_value' => session('impersonator_id')
        ]);

        if (!session()->has('impersonator_id')) {
            Log::warning('[Impersonation] No impersonator_id in session. Redirecting to login.');
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sessão de visualização expirada.');
        }

        $adminId = session()->pull('impersonator_id');
        $admin = User::findOrFail($adminId);

        // Voltar ao admin
        Auth::login($admin);

        Log::info('[Impersonation] Restored admin account.', [
            'restored_admin_id' => Auth::id(),
            'new_session_id' => session()->getId()
        ]);

        // Garantir que a sessão de admin esteja limpa e SALVA
        session()->forget('impersonator_id');
        session()->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Você voltou para sua conta de Administrador.');
    }
}
