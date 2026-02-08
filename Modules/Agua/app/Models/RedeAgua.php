<?php

namespace Modules\Agua\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;

class RedeAgua extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'redes_agua';

    protected $fillable = [
        'codigo',
        'localidade_id',
        'tipo_rede', // principal, secundaria, ramal
        'diametro',
        'material', // PVC, ferro, polietileno
        'extensao_metros',
        'data_instalacao',
        'status', // funcionando, com_vazamento, interrompida
        'observacoes',
    ];

    protected $casts = [
        'extensao_metros' => 'decimal:2',
        'data_instalacao' => 'date',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    public function pontosDistribuicao()
    {
        return $this->hasMany(\Modules\Agua\App\Models\PontoDistribuicao::class);
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
            'localidade_id', // Foreign key on demandas table
            'demanda_id', // Foreign key on ordens_servico table
            'localidade_id', // Local key on redes_agua table
            'id' // Local key on demandas table
        )->where('demandas.tipo', 'agua');
    }


    /**
     * Estatísticas da rede
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
            'total_pontos' => $this->pontosDistribuicao()->count(),
            'pontos_funcionando' => $this->pontosDistribuicao()->where('status', 'funcionando')->count(),
        ];
    }
}

