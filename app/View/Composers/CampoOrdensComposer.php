<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Ordens\App\Services\CampoOrdensService;

class CampoOrdensComposer
{
    protected $campoOrdensService;

    /**
     * Create a new campo ordens composer.
     */
    public function __construct(CampoOrdensService $campoOrdensService)
    {
        $this->campoOrdensService = $campoOrdensService;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Apenas para usuários autenticados com role 'campo'
        if (!Auth::check()) {
            $view->with('campoOrdensPendentes', 0);
            return;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verificar se o usuário tem a role 'campo'
        // O método hasRole vem do trait HasRoles do Spatie Permission
        if (!method_exists($user, 'hasRole') || !$user->hasRole('campo')) {
            $view->with('campoOrdensPendentes', 0);
            return;
        }

        try {
            $estatisticas = $this->campoOrdensService->buscarEstatisticas($user);

            $view->with('campoOrdensPendentes', $estatisticas['total_pendentes'] ?? 0);
        } catch (\Exception $e) {
            // Em caso de erro, não quebrar a página
            Log::warning('Erro ao buscar ordens pendentes no View Composer: ' . $e->getMessage());
            $view->with('campoOrdensPendentes', 0);
        }
    }
}

