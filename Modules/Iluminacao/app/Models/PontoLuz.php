<?php

namespace Modules\Iluminacao\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;

class PontoLuz extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'pontos_luz';

    protected $fillable = [
        'codigo',
        'localidade_id',
        'endereco',
        'latitude',
        'longitude',
        'nome_mapa',
        'tipo_lampada',
        'potencia',
        'tipo_poste',
        'altura_poste',
        'tipo_fiacao',
        'data_instalacao',
        'ultima_manutencao',
        'status', // funcionando, com_defeito, desligado
        'observacoes',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'potencia' => 'integer',
        'altura_poste' => 'decimal:2',
        'data_instalacao' => 'date',
        'ultima_manutencao' => 'date',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    /**
     * Relacionamento com demandas de iluminação na mesma localidade
     */
    public function demandas()
    {
        return $this->hasMany(\Modules\Demandas\App\Models\Demanda::class, 'localidade_id', 'localidade_id')
            ->where('tipo', 'luz');
    }

    /**
     * Relacionamento com ordens de serviço através das demandas
     */
    public function ordensServico()
    {
        return $this->hasManyThrough(
            \Modules\Ordens\App\Models\OrdemServico::class,
            \Modules\Demandas\App\Models\Demanda::class,
            'localidade_id', // Foreign key on demandas table
            'demanda_id', // Foreign key on ordens_servico table
            'localidade_id', // Local key on pontos_luz table
            'id' // Local key on demandas table
        )->where('demandas.tipo', 'luz');
    }

    /**
     * Estatísticas do ponto de luz
     */
    public function getEstatisticasAttribute()
    {
        return [
            'total_demandas' => $this->demandas()->count(),
            'demandas_abertas' => $this->demandas()->where('status', 'aberta')->count(),
            'demandas_em_andamento' => $this->demandas()->where('status', 'em_andamento')->count(),
            'demandas_concluidas' => $this->demandas()->where('status', 'concluida')->count(),
            'total_ordens' => $this->ordensServico()->count(),
            'ordens_pendentes' => $this->ordensServico()->where('ordens_servico.status', 'pendente')->count(),
            'ordens_em_execucao' => $this->ordensServico()->where('ordens_servico.status', 'em_execucao')->count(),
            'ordens_concluidas' => $this->ordensServico()->where('ordens_servico.status', 'concluida')->count(),
        ];
    }
}

