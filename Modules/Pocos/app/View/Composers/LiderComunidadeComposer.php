<?php

namespace Modules\Pocos\App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Pocos\App\Models\LiderComunidade;
use Modules\Pocos\App\Models\SolicitacaoBaixaPoco;

class LiderComunidadeComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Apenas para usuários autenticados
        if (!Auth::check()) {
            $view->with('solicitacoesPendentes', 0);
            return;
        }

        try {
            $user = Auth::user();
            
            // Buscar líder pelo user_id
            $lider = LiderComunidade::where('user_id', $user->id)->first();
            
            if (!$lider || !$lider->poco_id) {
                $view->with('solicitacoesPendentes', 0);
                return;
            }

            // Contar solicitações pendentes do poço do líder
            $solicitacoesPendentes = SolicitacaoBaixaPoco::where('poco_id', $lider->poco_id)
                ->where('status', 'pendente')
                ->count();

            $view->with('solicitacoesPendentes', $solicitacoesPendentes);
        } catch (\Exception $e) {
            // Em caso de erro, não quebrar a página
            Log::warning('Erro ao buscar solicitações pendentes no View Composer: ' . $e->getMessage());
            $view->with('solicitacoesPendentes', 0);
        }
    }
}

