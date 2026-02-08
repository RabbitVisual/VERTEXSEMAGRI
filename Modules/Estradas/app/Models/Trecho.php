<?php

namespace Modules\Estradas\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use App\Traits\HasHistory;
use Carbon\Carbon;

class Trecho extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode, HasHistory;

    protected $fillable = [
        'codigo',
        'nome',
        'localidade_id',
        'tipo', // vicinal, principal, secundaria
        'extensao_km',
        'largura_metros',
        'tipo_pavimento', // asfalto, cascalho, terra
        'condicao', // boa, regular, ruim, pessima
        'tem_ponte',
        'numero_pontes',
        'ultima_manutencao',
        'proxima_manutencao',
        'observacoes',
    ];

    protected $casts = [
        'extensao_km' => 'decimal:2',
        'largura_metros' => 'decimal:2',
        'tem_ponte' => 'boolean',
        'numero_pontes' => 'integer',
        'ultima_manutencao' => 'date',
        'proxima_manutencao' => 'date',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    /**
     * Estatísticas do trecho
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
            'dias_sem_manutencao' => $this->diasSemManutencao(),
            'precisa_manutencao' => $this->precisaManutencao(),
        ];
    }

    public function demandas()
    {
        return $this->hasMany(\Modules\Demandas\App\Models\Demanda::class, 'localidade_id', 'localidade_id')
            ->where('tipo', 'estrada');
    }

    /**
     * Relacionamento com Ordens de Serviço através de Demandas
     */
    public function ordensServico()
    {
        return $this->hasManyThrough(
            \Modules\Ordens\App\Models\OrdemServico::class,
            \Modules\Demandas\App\Models\Demanda::class,
            'localidade_id', // Foreign key na tabela demandas
            'demanda_id', // Foreign key na tabela ordens_servico
            'localidade_id', // Local key na tabela trechos
            'id' // Local key na tabela demandas
        )->where('demandas.tipo', 'estrada');
    }

    /**
     * Calcula dias sem manutenção
     */
    public function diasSemManutencao()
    {
        if (!$this->ultima_manutencao) {
            return null;
        }
        // Se a data da última manutenção estiver no futuro, considera 0 dias sem manutenção
        if ($this->ultima_manutencao->isFuture()) {
            return 0;
        }
        $dias = now()->startOfDay()->diffInDays($this->ultima_manutencao->startOfDay(), false);
        return max(0, (int) $dias); // Garante que seja um inteiro não negativo
    }

    /**
     * Verifica se precisa de manutenção
     */
    public function precisaManutencao(): bool
    {
        if (!$this->proxima_manutencao) {
            return false;
        }
        return $this->proxima_manutencao->isPast() || $this->proxima_manutencao->isToday();
    }

    /**
     * Accessor para condição em texto
     */
    public function getCondicaoTextoAttribute(): string
    {
        $condicoes = [
            'boa' => 'Boa',
            'regular' => 'Regular',
            'ruim' => 'Ruim',
            'pessima' => 'Péssima',
        ];
        return $condicoes[$this->condicao] ?? $this->condicao;
    }

    /**
     * Accessor para tipo em texto
     */
    public function getTipoTextoAttribute(): string
    {
        $tipos = [
            'vicinal' => 'Vicinal',
            'principal' => 'Principal',
            'secundaria' => 'Secundária',
        ];
        return $tipos[$this->tipo] ?? $this->tipo;
    }

    /**
     * Accessor para tipo de pavimento em texto
     */
    public function getTipoPavimentoTextoAttribute(): ?string
    {
        if (!$this->tipo_pavimento) {
            return null;
        }
        $tipos = [
            'asfalto' => 'Asfalto',
            'cascalho' => 'Cascalho',
            'terra' => 'Terra',
        ];
        return $tipos[$this->tipo_pavimento] ?? $this->tipo_pavimento;
    }

    /**
     * Scope para trechos que precisam de manutenção
     */
    public function scopePrecisaManutencao($query)
    {
        return $query->where(function($q) {
            $q->whereNotNull('proxima_manutencao')
              ->where('proxima_manutencao', '<=', now());
        });
    }

    /**
     * Scope para trechos por condição
     */
    public function scopePorCondicao($query, string $condicao)
    {
        return $query->where('condicao', $condicao);
    }

    /**
     * Scope para trechos por tipo
     */
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}

