<?php

namespace Modules\Ordens\App\Observers;

use Modules\Ordens\App\Models\OrdemServico;
use Modules\Materiais\App\Models\Material;
use Modules\Materiais\App\Models\MaterialMovimentacao;
use Illuminate\Support\Facades\DB;

class OrdemServicoObserver
{
    public function updated(OrdemServico $ordemServico): void
    {
        // Debugging
        // file_put_contents('observer_log.txt', "Updated OS {$ordemServico->id}. Status: {$ordemServico->status}\n", FILE_APPEND);
        
        if ($ordemServico->isDirty('status') && $ordemServico->status === 'concluida') {
            
            // Check materials
            $materiais = $ordemServico->materiais; // Load collection
            
            if ($materiais->count() > 0) {
                foreach ($materiais as $osMaterial) {
                    $material = Material::find($osMaterial->material_id);
                    if (!$material) continue;

                    $hasReservation = MaterialMovimentacao::where('ordem_servico_id', $ordemServico->id)
                        ->where('material_id', $material->id)
                        ->where('status', 'reservado')
                        ->exists();
                        
                    if ($hasReservation) {
                         MaterialMovimentacao::where('ordem_servico_id', $ordemServico->id)
                            ->where('material_id', $material->id)
                            ->where('status', 'reservado')
                            ->update(['status' => 'confirmado']);
                    } else {
                        $hasConfirmed = MaterialMovimentacao::where('ordem_servico_id', $ordemServico->id)
                            ->where('material_id', $material->id)
                            ->where('status', 'confirmado')
                            ->exists();
                            
                        if (!$hasConfirmed) {
                            // Deduct logic
                            // Since we might be inside transaction or not, ensure we save.
                            // We can manually decrement.
                            $material->decrement('quantidade_estoque', $osMaterial->quantidade);
                            
                            // Log movement
                            MaterialMovimentacao::create([
                                'material_id' => $material->id,
                                'tipo' => 'saida',
                                'status' => 'confirmado',
                                'quantidade' => $osMaterial->quantidade,
                                'valor_unitario' => $osMaterial->valor_unitario,
                                'motivo' => "Uso na OS #{$ordemServico->numero}",
                                'ordem_servico_id' => $ordemServico->id,
                                'user_id' => auth()->id() ?? 1, // Fallback user
                            ]);
                        }
                    }
                }
            }
        }
    }
}
