<?php

namespace Modules\ProgramasAgricultura\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use App\Traits\HasHistory;

class Programa extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode, HasHistory;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'tipo',
        'status',
        'data_inicio',
        'data_fim',
        'vagas_disponiveis',
        'vagas_preenchidas',
        'requisitos',
        'documentos_necessarios',
        'beneficios',
        'orgao_responsavel',
        'observacoes',
        'publico',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'vagas_disponiveis' => 'integer',
        'vagas_preenchidas' => 'integer',
        'publico' => 'boolean',
    ];

    // Relacionamentos
    public function beneficiarios()
    {
        return $this->hasMany(Beneficiario::class);
    }

    public function beneficiariosAtivos()
    {
        return $this->hasMany(Beneficiario::class)
            ->whereIn('status', ['inscrito', 'aprovado', 'beneficiado']);
    }

    /**
     * Usuários (Co-Admins) responsáveis por este programa
     */
    public function usuariosResponsaveis()
    {
        return $this->belongsToMany(\App\Models\User::class, 'programas_responsaveis', 'programa_id', 'user_id');
    }

    /**
     * Relacionamento com cadastros CAF através dos beneficiários
     */
    public function cadastrosCaf()
    {
        return \Modules\CAF\App\Models\CadastroCAF::whereHas('pessoa.beneficiarios', function($q) {
            $q->where('programa_id', $this->id);
        });
    }

    // Accessors
    public function getTipoTextoAttribute(): string
    {
        $tipos = [
            'seguro_safra' => 'Seguro Safra',
            'pronaf' => 'PRONAF',
            'distribuicao_sementes' => 'Distribuição de Sementes',
            'distribuicao_insumos' => 'Distribuição de Insumos',
            'assistencia_tecnica' => 'Assistência Técnica',
            'credito_rural' => 'Crédito Rural',
            'feira_agricola' => 'Feira Agrícola',
            'capacitacao' => 'Capacitação',
            'outro' => 'Outro',
        ];

        return $tipos[$this->tipo] ?? ucfirst(str_replace('_', ' ', $this->tipo));
    }

    public function getStatusTextoAttribute(): string
    {
        $status = [
            'ativo' => 'Ativo',
            'inativo' => 'Inativo',
            'suspenso' => 'Suspenso',
        ];

        return $status[$this->status] ?? ucfirst($this->status);
    }

    public function getVagasRestantesAttribute(): ?int
    {
        if ($this->vagas_disponiveis === null) {
            return null;
        }

        return max(0, $this->vagas_disponiveis - $this->vagas_preenchidas);
    }

    public function getTemVagasAttribute(): bool
    {
        if ($this->vagas_disponiveis === null) {
            return true; // Sem limite de vagas
        }

        return $this->vagas_restantes > 0;
    }

    public function getEstaAtivoAttribute(): bool
    {
        if ($this->status !== 'ativo') {
            return false;
        }

        $hoje = now()->startOfDay();

        if ($this->data_inicio && $this->data_inicio->startOfDay()->isFuture()) {
            return false;
        }

        if ($this->data_fim && $this->data_fim->startOfDay()->isPast()) {
            return false;
        }

        return true;
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeComVagas($query)
    {
        return $query->where(function($q) {
            $q->whereNull('vagas_disponiveis')
              ->orWhereRaw('vagas_disponiveis > vagas_preenchidas');
        });
    }

    public function scopeDisponiveis($query)
    {
        $hoje = now()->startOfDay();

        return $query->where('status', 'ativo')
            ->where('publico', true)
            ->where(function($q) use ($hoje) {
                $q->whereNull('data_inicio')
                  ->orWhere('data_inicio', '<=', $hoje);
            })
            ->where(function($q) use ($hoje) {
                $q->whereNull('data_fim')
                  ->orWhere('data_fim', '>=', $hoje);
            });
    }
}
