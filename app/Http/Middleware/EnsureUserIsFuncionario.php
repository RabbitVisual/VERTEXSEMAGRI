<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnsureUserIsFuncionario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar se tem role 'campo'
        if (!$user->hasRole('campo')) {
            abort(403, 'Acesso negado. Você não possui permissão para acessar o Painel de Campo. Se você acredita que deveria ter acesso, entre em contato com o administrador do sistema.');
        }

        // Verificar se está vinculado a uma equipe
        $temEquipe = DB::table('equipe_membros')
            ->where('user_id', $user->id)
            ->exists();

        // Ou verificar se tem funcionário vinculado que está em equipe
        if (!$temEquipe && $user->email) {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();
            if ($funcionario) {
                $temEquipe = DB::table('equipe_funcionarios')
                    ->where('funcionario_id', $funcionario->id)
                    ->exists();
            }
        }

        if (!$temEquipe) {
            abort(403, 'Acesso ao Painel de Campo indisponível. Para acessar o sistema, é necessário que seu usuário esteja vinculado a uma equipe de trabalho. Entre em contato com o administrador do sistema para solicitar a vinculação à equipe apropriada.');
        }

        return $next($request);
    }
}
