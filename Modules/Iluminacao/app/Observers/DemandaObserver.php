<?php

namespace Modules\Iluminacao\App\Observers;

use Modules\Demandas\App\Models\Demanda;
use Modules\Iluminacao\App\Models\PontoLuzHistorico;
use Illuminate\Support\Facades\DB;

class DemandaObserver
{
    /**
     * Handle the Demanda "updated" event.
     */
    public function updated(Demanda $demanda): void
    {
        // Check if status changed to 'concluida' and has PontoLuz linked
        if ($demanda->isDirty('status') && $demanda->status === 'concluida' && $demanda->ponto_luz_id) {
            
            $tipo = 'manutencao';
            if (stripos($demanda->descricao, 'instalação') !== false || stripos($demanda->motivo, 'instalação') !== false) {
                $tipo = 'instalacao';
            }

            $hasMaterials = false;
            
            // Check if Demanda has OS and OS has materials
            if ($demanda->ordemServico && $demanda->ordemServico->materiais()->exists()) {
                foreach ($demanda->ordemServico->materiais as $osMaterialItem) {
                    // $osMaterialItem is OrdemServicoMaterial instance
                    $materialName = $osMaterialItem->material->nome ?? 'Material';
                    $materialCode = $osMaterialItem->material->codigo ?? 'N/A';
                    
                    // Include Code in description
                    $desc = "Serviço concluído via Demanda #{$demanda->codigo}. Material: {$materialName} (Cod: {$materialCode})";

                    PontoLuzHistorico::create([
                        'ponto_luz_id' => $demanda->ponto_luz_id,
                        'demanda_id' => $demanda->id,
                        'user_id' => auth()->id() ?? $demanda->user_id,
                        'material_id' => $osMaterialItem->material_id,
                        'quantidade_material' => $osMaterialItem->quantidade ?? 0,
                        'tipo_evento' => $tipo,
                        'descricao' => $desc,
                        'data_evento' => now(),
                        'observacoes' => $demanda->observacoes,
                    ]);
                    $hasMaterials = true;
                }
            }

            if (!$hasMaterials) {
                PontoLuzHistorico::create([
                    'ponto_luz_id' => $demanda->ponto_luz_id,
                    'demanda_id' => $demanda->id,
                    'user_id' => auth()->id() ?? $demanda->user_id,
                    'tipo_evento' => $tipo,
                    'descricao' => "Serviço concluído via Demanda #{$demanda->codigo}",
                    'data_evento' => now(),
                    'observacoes' => $demanda->observacoes,
                ]);
            }
        }
    }
}
