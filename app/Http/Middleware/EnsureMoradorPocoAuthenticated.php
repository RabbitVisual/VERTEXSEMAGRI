<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Pocos\App\Models\UsuarioPoco;

class EnsureMoradorPocoAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $codigoAcesso = session('morador_codigo_acesso');

        if (!$codigoAcesso) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        $usuario = UsuarioPoco::porCodigoAcesso($codigoAcesso)->first();

        if (!$usuario) {
            session()->forget('morador_codigo_acesso');
            return redirect()->route('morador-poco.index')
                ->with('error', 'Código de acesso inválido.');
        }

        if ($usuario->status !== 'ativo') {
            session()->forget('morador_codigo_acesso');
            return redirect()->route('morador-poco.index')
                ->with('error', 'Seu cadastro está inativo. Entre em contato com o líder da comunidade.');
        }

        return $next($request);
    }
}

