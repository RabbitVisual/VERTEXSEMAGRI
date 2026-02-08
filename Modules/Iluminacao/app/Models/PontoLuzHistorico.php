<?php

namespace Modules\Iluminacao\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PontoLuzHistorico extends Model
{
    use HasFactory;

    protected $table = 'pontos_luz_historico';

    protected $fillable = [
        'ponto_luz_id',
        'demanda_id',
        'user_id',
        'material_id',
        'quantidade_material',
        'tipo_evento', // instalacao, manutencao, auditoria
        'descricao',
        'data_evento',
        'observacoes',
    ];

    protected $casts = [
        'data_evento' => 'datetime',
        'quantidade_material' => 'decimal:2',
    ];

    public function pontoLuz()
    {
        return $this->belongsTo(PontoLuz::class, 'ponto_luz_id');
    }

    public function demanda()
    {
        return $this->belongsTo(\Modules\Demandas\App\Models\Demanda::class, 'demanda_id');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function material()
    {
        return $this->belongsTo(\Modules\Materiais\App\Models\Material::class, 'material_id');
    }
}
