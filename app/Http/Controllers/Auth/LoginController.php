<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ValidatesRecaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ValidatesRecaptcha;
    public function showLoginForm()
    {
        // Usar view do módulo Homepage se estiver ativo, senão usar view padrão
        if (\Nwidart\Modules\Facades\Module::isEnabled('Homepage')) {
            return view('homepage::auth.login');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar reCAPTCHA se estiver habilitado
        $this->validateRecaptcha($request, 'login');

        $request->validate([
            'login_type' => 'required|in:email,cpf',
            'email' => 'required_if:login_type,email|email|nullable',
            'cpf' => 'required_if:login_type,cpf|string|nullable',
            'password' => 'required',
        ]);

        $credentials = [];
        $loginField = 'email';

        if ($request->login_type === 'cpf') {
            // Remover máscara do CPF
            $cpf = preg_replace('/[^0-9]/', '', $request->cpf ?? '');

            if (strlen($cpf) !== 11) {
                throw ValidationException::withMessages([
                    'cpf' => __('CPF deve conter 11 dígitos.'),
                ]);
            }

            $loginField = 'cpf';

            // Buscar usuário diretamente pelo CPF na tabela users
            $user = \App\Models\User::where('cpf', $cpf)->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'cpf' => __('CPF não encontrado ou não vinculado a um usuário. Use o login por e-mail.'),
                ]);
            }

            $credentials = ['email' => $user->email, 'password' => $request->password];
        } else {
            $credentials = $request->only('email', 'password');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // IMPORTANTE: Verificar role 'campo' PRIMEIRO para evitar acesso ao painel admin
            // Redirecionar funcionário de campo para painel campo
            if ($user->hasRole('campo')) {
                return redirect()->route('campo.dashboard');
            }

            // Redirecionar usuário consulta para painel consulta
            if ($user->hasRole('consulta')) {
                try {
                    return redirect()->route('consulta.dashboard');
                } catch (\Exception $e) {
                    return redirect('/consulta/dashboard');
                }
            }

            // Redirecionar admin para painel admin
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            // Redirecionar co-admin para painel co-admin
            if ($user->hasRole('co-admin')) {
                return redirect()->route('co-admin.dashboard');
            }

            // Redirecionar líder de comunidade para painel do líder
            if ($user->hasRole('lider-comunidade')) {
                return redirect()->route('lider-comunidade.dashboard');
            }

            // Outros usuários vão para dashboard padrão
            return redirect()->route('dashboard');
        }

        throw ValidationException::withMessages([
            $loginField => __('As credenciais fornecidas estão incorretas.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Auto-login para contas demo (apenas em desenvolvimento)
     */
    public function autoLogin(Request $request, string $type)
    {
        if (app()->environment('production')) {
            abort(404);
        }

        $credentials = match($type) {
            'admin' => [
                'email' => 'admin@vertexsemagri.com',
                'password' => 'admin123',
            ],
            'coadmin' => [
                'email' => 'coadmin@vertexsemagri.com',
                'password' => 'coadmin123',
            ],
            default => abort(404),
        };

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // IMPORTANTE: Verificar role 'campo' PRIMEIRO para evitar acesso ao painel admin
            // Redirecionar funcionário de campo para painel campo
            if ($user->hasRole('campo')) {
                return redirect()->route('campo.dashboard');
            }

            // Redirecionar usuário consulta para painel consulta
            if ($user->hasRole('consulta')) {
                // Usar URL direta como fallback se a rota não estiver definida
                try {
                    return redirect()->route('consulta.dashboard');
                } catch (\Exception $e) {
                    return redirect('/consulta/dashboard');
                }
            }

            // Redirecionar admin para painel admin
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            // Redirecionar co-admin para painel co-admin
            if ($user->hasRole('co-admin')) {
                return redirect()->route('co-admin.dashboard');
            }

            // Redirecionar líder de comunidade para painel do líder
            if ($user->hasRole('lider-comunidade')) {
                return redirect()->route('lider-comunidade.dashboard');
            }

            // Outros usuários vão para dashboard padrão
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Erro ao fazer auto-login');
    }
}

