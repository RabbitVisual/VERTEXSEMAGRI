<?php

namespace Modules\Ordens\App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemServicoMaterial extends Model
{
    protected $table = 'ordem_servico_materiais';

    protected $fillable = [
        'ordem_servico_id',
        'material_id',
        'quantidade',
        'valor_unitario',
        'status_reserva',
        'poste_id',
    ];

    protected $casts = [
        'quantidade' => 'decimal:2',
        'valor_unitario' => 'decimal:2',
    ];

    // Relacionamentos
    public function ordemServico()
    {
        return $this->belongsTo(OrdemServico::class);
    }

    public function material()
    {
        return $this->belongsTo(\Modules\Materiais\App\Models\Material::class);
    }

    public function poste()
    {
        return $this->belongsTo(\Modules\Iluminacao\App\Models\Poste::class);
    }
}
