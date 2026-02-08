<?php

namespace Modules\Agua\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;

class PontoDistribuicao extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'pontos_distribuicao';

    protected $fillable = [
        'codigo',
        'rede_agua_id',
        'localidade_id',
        'endereco',
        'latitude',
        'longitude',
        'nome_mapa',
        'numero_conexoes',
        'tipo',
        'capacidade_litros',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'numero_conexoes' => 'integer',
        'capacidade_litros' => 'decimal:2',
    ];

    // Relacionamentos
    public function redeAgua()
    {
        return $this->belongsTo(RedeAgua::class);
    }

    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    /**
     * Relacionamento com demandas de água na mesma localidade
     */
    public function demandas()
    {
        return $this->hasMany(\Modules\Demandas\App\Models\Demanda::class, 'localidade_id', 'localidade_id')
            ->where('tipo', 'agua');
    }

    /**
     * Relacionamento com ordens de serviço através das demandas
     */
    public function ordensServico()
    {
        return $this->hasManyThrough(
            \Modules\Ordens\App\Models\OrdemServico::class,
            \Modules\Demandas\App\Models\Demanda::class,
            'localidade_id',
            'demanda_id',
            'localidade_id',
            'id'
        )->where('demandas.tipo', 'agua');
    }
}

