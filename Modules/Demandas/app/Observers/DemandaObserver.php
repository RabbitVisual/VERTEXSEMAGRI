<?php

namespace Modules\Demandas\App\Observers;

use Modules\Demandas\App\Models\Demanda;
use Modules\Demandas\App\Services\SimilaridadeDemandaService;
use Modules\Demandas\App\Mail\DemandaCriada;
use Modules\Demandas\App\Mail\DemandaStatusChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DemandaObserver
{
    protected $similaridadeService;

    public function __construct(SimilaridadeDemandaService $similaridadeService)
    {
        $this->similaridadeService = $similaridadeService;
    }

    /**
     * Handle the Demanda "created" event.
     */
    public function created(Demanda $demanda): void
    {
        // Enviar email de confirmação se houver email do solicitante
        if ($demanda->solicitante_email && $demanda->codigo) {
            try {
                Mail::to($demanda->solicitante_email)
                    ->send(new DemandaCriada($demanda));
            } catch (\Exception $e) {
                Log::error('Erro ao enviar email de criação de demanda: ' . $e->getMessage());
            }
        }

        // Calcular e persistir score de similaridade
        $this->atualizarScoreSimilaridade($demanda);
    }

    /**
     * Handle the Demanda "updated" event.
     */
    public function updated(Demanda $demanda): void
    {
        // Enviar email se status mudou
        if ($demanda->isDirty('status') && $demanda->solicitante_email) {
            try {
                Mail::to($demanda->solicitante_email)
                    ->send(new DemandaStatusChanged($demanda));
            } catch (\Exception $e) {
                Log::error('Erro ao enviar email de mudança de status: ' . $e->getMessage());
            }
        }

        // Recalcular score se campos relevantes mudaram
        if ($demanda->isDirty(['localidade_id', 'tipo', 'motivo', 'descricao'])) {
            $this->atualizarScoreSimilaridade($demanda);
        }
    }

    /**
     * Atualiza o score de similaridade máxima da demanda
     */
    protected function atualizarScoreSimilaridade(Demanda $demanda): void
    {
        try {
            // Não verificar demandas concluídas ou canceladas
            if (in_array($demanda->status, ['concluida', 'cancelada'])) {
                $demanda->score_similaridade_max = 0;
                $demanda->saveQuietly();
                return;
            }

            // Buscar similaridade com outras demandas abertas
            $dados = $demanda->toArray();
            
            // Buscar 5 resultados para garantir que encontramos outros além da própria demanda
            $similares = $this->similaridadeService->buscarSimilares($dados, 5);
            
            // Filtrar a própria demanda dos resultados (se já existir no banco)
            $similares = $similares->filter(function ($item) use ($demanda) {
                return $item['demanda']->id !== $demanda->id;
            });

            if ($similares->isNotEmpty()) {
                $melhorMatch = $similares->first();
                $demanda->score_similaridade_max = $melhorMatch['score'];
            } else {
                $demanda->score_similaridade_max = 0;
            }

            $demanda->saveQuietly();

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar score de similaridade: ' . $e->getMessage());
        }
    }
}
