<?php

namespace Modules\Funcionarios\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use App\Models\User;

class Funcionario extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $fillable = [
        'codigo',
        'nome',
        'cpf',
        'telefone',
        'email',
        'funcao', // eletricista, encanador, operador, motorista, supervisor, tecnico
        'data_admissao',
        'data_demissao',
        'ativo',
        'observacoes',
        'status_campo', // disponivel, em_atendimento, pausado, offline
        'ordem_servico_atual_id',
        'atendimento_iniciado_em',
        'ultima_atualizacao_status',
    ];

    protected $casts = [
        'data_admissao' => 'date',
        'data_demissao' => 'date',
        'ativo' => 'boolean',
        'atendimento_iniciado_em' => 'datetime',
        'ultima_atualizacao_status' => 'datetime',
    ];

    // Relacionamentos
    public function equipes()
    {
        return $this->belongsToMany(\Modules\Equipes\App\Models\Equipe::class, 'equipe_funcionarios', 'funcionario_id', 'equipe_id')
            ->withTimestamps();
    }

    /**
     * Relacionamento opcional com User baseado no email
     */
    public function user()
    {
        if (!$this->email) {
            return null;
        }
        return User::where('email', $this->email)->first();
    }

    /**
     * Verifica se o funcionário está vinculado a alguma equipe ativa
     */
    public function estaEmEquipeAtiva(): bool
    {
        return $this->equipes()->where('ativo', true)->exists();
    }

    /**
     * Retorna o número de equipes ativas que o funcionário pertence
     */
    public function totalEquipesAtivas(): int
    {
        return $this->equipes()->where('ativo', true)->count();
    }

    /**
     * Scope para funcionários ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para funcionários por função
     */
    public function scopePorFuncao($query, string $funcao)
    {
        return $query->where('funcao', $funcao);
    }

    /**
     * Scope para funcionários sem equipe
     */
    public function scopeSemEquipe($query)
    {
        return $query->doesntHave('equipes');
    }

    /**
     * Scope para funcionários com equipe
     */
    public function scopeComEquipe($query)
    {
        return $query->has('equipes');
    }

    /**
     * Retorna o nome formatado da função
     */
    public function getFuncaoFormatadaAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->funcao));
    }

    /**
     * Verifica se o funcionário pode ser deletado
     */
    public function podeSerDeletado(): bool
    {
        return $this->equipes()->count() === 0;
    }

    /**
     * Relacionamento com a ordem de serviço atual
     */
    public function ordemServicoAtual()
    {
        return $this->belongsTo(\Modules\Ordens\App\Models\OrdemServico::class, 'ordem_servico_atual_id');
    }

    /**
     * Relacionamento com ordens de serviço atribuídas ao funcionário
     */
    public function ordensServico()
    {
        return $this->hasMany(\Modules\Ordens\App\Models\OrdemServico::class, 'funcionario_id');
    }

    /**
     * Relacionamento com movimentações de materiais
     */
    public function movimentacoesMateriais()
    {
        return $this->hasMany(\Modules\Materiais\App\Models\MaterialMovimentacao::class, 'funcionario_id');
    }

    /**
     * Verifica se o funcionário está disponível para receber nova ordem
     */
    public function estaDisponivel(): bool
    {
        return $this->ativo &&
               $this->status_campo === 'disponivel' &&
               $this->ordem_servico_atual_id === null;
    }

    /**
     * Verifica se está em atendimento
     */
    public function estaEmAtendimento(): bool
    {
        return $this->status_campo === 'em_atendimento' &&
               $this->ordem_servico_atual_id !== null;
    }

    /**
     * Inicia atendimento de uma ordem
     */
    public function iniciarAtendimento($ordemServicoId): void
    {
        $this->update([
            'status_campo' => 'em_atendimento',
            'ordem_servico_atual_id' => $ordemServicoId,
            'atendimento_iniciado_em' => now(),
            'ultima_atualizacao_status' => now(),
        ]);
    }

    /**
     * Finaliza atendimento atual
     */
    public function finalizarAtendimento(): void
    {
        $this->update([
            'status_campo' => 'disponivel',
            'ordem_servico_atual_id' => null,
            'atendimento_iniciado_em' => null,
            'ultima_atualizacao_status' => now(),
        ]);
    }

    /**
     * Atualiza status para pausado
     */
    public function pausarAtendimento(): void
    {
        $this->update([
            'status_campo' => 'pausado',
            'ultima_atualizacao_status' => now(),
        ]);
    }

    /**
     * Retorna o tempo em atendimento formatado
     */
    public function getTempoAtendimentoAttribute(): ?string
    {
        if (!$this->atendimento_iniciado_em) {
            return null;
        }

        $minutos = $this->atendimento_iniciado_em->diffInMinutes(now());
        $horas = floor($minutos / 60);
        $mins = $minutos % 60;

        if ($horas > 0) {
            return "{$horas}h {$mins}min";
        }
        return "{$mins}min";
    }

    /**
     * Retorna o status formatado
     */
    public function getStatusCampoTextoAttribute(): string
    {
        $textos = [
            'disponivel' => 'Disponível',
            'em_atendimento' => 'Em Atendimento',
            'pausado' => 'Pausado',
            'offline' => 'Offline',
        ];
        return $textos[$this->status_campo] ?? 'Desconhecido';
    }

    /**
     * Retorna a cor do status
     */
    public function getStatusCampoCorAttribute(): string
    {
        $cores = [
            'disponivel' => 'success',
            'em_atendimento' => 'warning',
            'pausado' => 'info',
            'offline' => 'secondary',
        ];
        return $cores[$this->status_campo] ?? 'secondary';
    }

    /**
     * Scope para funcionários disponíveis
     */
    public function scopeDisponiveis($query)
    {
        return $query->where('ativo', true)
                     ->where('status_campo', 'disponivel')
                     ->whereNull('ordem_servico_atual_id');
    }

    /**
     * Scope para funcionários em atendimento
     */
    public function scopeEmAtendimento($query)
    {
        return $query->where('status_campo', 'em_atendimento')
                     ->whereNotNull('ordem_servico_atual_id');
    }

    /**
     * Scope para funcionários ocupados (não disponíveis)
     */
    public function scopeOcupados($query)
    {
        return $query->where(function($q) {
            $q->where('status_campo', '!=', 'disponivel')
              ->orWhereNotNull('ordem_servico_atual_id');
        });
    }
}

