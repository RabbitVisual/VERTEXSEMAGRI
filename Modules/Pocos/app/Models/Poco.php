<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use App\Traits\HasHistory;

class Poco extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode, HasHistory;

    protected $fillable = [
        'codigo',
        'localidade_id',
        'endereco',
        'latitude',
        'longitude',
        'nome_mapa',
        'profundidade_metros',
        'vazao_litros_hora',
        'data_perfuracao',
        'diametro',
        'tipo_bomba',
        'potencia_bomba',
        'equipe_responsavel_id',
        'ultima_manutencao',
        'proxima_manutencao',
        'status', // ativo, inativo, manutencao, bomba_queimada
        'observacoes',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'profundidade_metros' => 'decimal:2',
        'vazao_litros_hora' => 'decimal:2',
        'potencia_bomba' => 'integer',
        'data_perfuracao' => 'date',
        'ultima_manutencao' => 'date',
        'proxima_manutencao' => 'date',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    public function equipeResponsavel()
    {
        return $this->belongsTo(\Modules\Equipes\App\Models\Equipe::class, 'equipe_responsavel_id');
    }

    /**
     * Estatísticas do poço
     */
    public function getEstatisticasAttribute()
    {
        return [
            'total_demandas' => $this->demandas()->count(),
            'demandas_abertas' => $this->demandas()->where('demandas.status', 'aberta')->count(),
            'demandas_em_andamento' => $this->demandas()->where('demandas.status', 'em_andamento')->count(),
            'demandas_concluidas' => $this->demandas()->where('demandas.status', 'concluida')->count(),
            'total_ordens' => $this->ordensServico()->count(),
            'ordens_pendentes' => $this->ordensServico()->where('ordens_servico.status', 'pendente')->count(),
            'ordens_em_execucao' => $this->ordensServico()->where('ordens_servico.status', 'em_execucao')->count(),
            'ordens_concluidas' => $this->ordensServico()->where('ordens_servico.status', 'concluida')->count(),
            'dias_sem_manutencao' => $this->diasSemManutencao(),
            'precisa_manutencao' => $this->precisaManutencao(),
        ];
    }

    /**
     * Relacionamento direto com Demandas relacionadas ao poço
     */
    public function demandas()
    {
        return $this->hasMany(\Modules\Demandas\App\Models\Demanda::class, 'poco_id')
            ->where('tipo', 'poco');
    }

    /**
     * Relacionamento com Ordens de Serviço através de Demandas diretamente relacionadas ao poço
     */
    public function ordensServico()
    {
        return $this->hasManyThrough(
            \Modules\Ordens\App\Models\OrdemServico::class,
            \Modules\Demandas\App\Models\Demanda::class,
            'poco_id', // Foreign key na tabela demandas
            'demanda_id', // Foreign key na tabela ordens_servico
            'id', // Local key na tabela pocos
            'id' // Local key na tabela demandas
        )->where('demandas.tipo', 'poco');
    }

    public function liderComunidade()
    {
        return $this->hasOne(LiderComunidade::class, 'poco_id');
    }

    public function usuariosPoco()
    {
        return $this->hasMany(UsuarioPoco::class, 'poco_id');
    }

    public function mensalidades()
    {
        return $this->hasMany(MensalidadePoco::class, 'poco_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(PagamentoPoco::class, 'poco_id');
    }

    public function boletos()
    {
        return $this->hasMany(BoletoPoco::class, 'poco_id');
    }

    // Accessors
    public function getStatusTextoAttribute()
    {
        $status = [
            'ativo' => 'Ativo',
            'inativo' => 'Inativo',
            'manutencao' => 'Em Manutenção',
            'bomba_queimada' => 'Bomba Queimada',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getStatusCorAttribute()
    {
        $cores = [
            'ativo' => 'success',
            'inativo' => 'secondary',
            'manutencao' => 'warning',
            'bomba_queimada' => 'danger',
        ];
        return $cores[$this->status] ?? 'secondary';
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeEmManutencao($query)
    {
        return $query->where('status', 'manutencao');
    }

    public function scopeComProblemas($query)
    {
        return $query->whereIn('status', ['manutencao', 'bomba_queimada', 'inativo']);
    }

    // Métodos auxiliares
    public function precisaManutencao()
    {
        if (!$this->proxima_manutencao) {
            return false;
        }
        return now()->greaterThanOrEqualTo($this->proxima_manutencao);
    }

    public function diasSemManutencao()
    {
        if (!$this->ultima_manutencao) {
            return null;
        }

        // Garantir que a data não seja no futuro
        if ($this->ultima_manutencao->isFuture()) {
            return 0;
        }

        // Calcular diferença em dias completos (sem decimais)
        $dias = now()->startOfDay()->diffInDays($this->ultima_manutencao->startOfDay(), false);

        // Se for negativo (data no futuro), retornar 0
        return max(0, (int) $dias);
    }
}

