<?php

use App\Helpers\FormatHelper;
use Illuminate\Support\Facades\Auth;

if (!function_exists('formatar_quantidade')) {
    /**
     * Formata uma quantidade baseado na unidade de medida
     *
     * Esta função é uma wrapper global para FormatHelper::formatarQuantidade()
     * para facilitar o uso em templates Blade.
     *
     * @param float|int|string $quantidade A quantidade a ser formatada
     * @param string|null $unidadeMedida A unidade de medida (ex: 'unidade', 'kg', 'metro', 'litro')
     * @return string A quantidade formatada
     *
     * @example
     * formatar_quantidade(1, 'unidade') // Retorna "1"
     * formatar_quantidade(1.5, 'metro') // Retorna "1,5"
     * formatar_quantidade(2.00, 'kg') // Retorna "2"
     */
    function formatar_quantidade($quantidade, ?string $unidadeMedida = null): string
    {
        return FormatHelper::formatarQuantidade($quantidade, $unidadeMedida);
    }
}

if (!function_exists('get_dashboard_route')) {
    /**
     * Retorna a rota de dashboard correta baseada no role do usuário autenticado
     *
     * @return string Nome da rota do dashboard
     */
    function get_dashboard_route(): string
    {
        if (!Auth::check()) {
            return 'login';
        }

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return 'admin.dashboard';
        }

        if ($user->hasRole('co-admin')) {
            return 'co-admin.dashboard';
        }

        if ($user->hasRole('campo')) {
            return 'campo.dashboard';
        }

        if ($user->hasRole('consulta')) {
            return 'consulta.dashboard';
        }

        // Fallback para login se não tiver role específica
        return 'login';
    }
}

