<?php

namespace Modules\Demandas\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

/**
 * Model para interessados/afetados vinculados a uma demanda
 *
 * Permite que múltiplas pessoas sejam vinculadas à mesma demanda,
 * evitando duplicatas e aumentando a prioridade automaticamente.
 */
class DemandaInteressado extends Model
{
    use HasFactory;

    protected $table = 'demanda_interessados';

    protected $fillable = [
        'demanda_id',
        'pessoa_id',
        'nome',
        'apelido',
        'telefone',
        'email',
        'cpf',
        'descricao_adicional',
        'fotos',
        'user_id',
        'ip_address',
        'notificar',
        'confirmado',
        'data_vinculo',
        'score_similaridade',
        'metodo_vinculo',
    ];

    protected $casts = [
        'fotos' => 'array',
        'notificar' => 'boolean',
        'confirmado' => 'boolean',
        'data_vinculo' => 'datetime',
        'score_similaridade' => 'decimal:2',
    ];

    // ==================== RELACIONAMENTOS ====================

    /**
     * Demanda à qual este interessado está vinculado
     */
    public function demanda()
    {
        return $this->belongsTo(Demanda::class);
    }

    /**
     * Pessoa do CadÚnico (opcional)
     */
    public function pessoa()
    {
        return $this->belongsTo(\Modules\Pessoas\App\Models\PessoaCad::class, 'pessoa_id');
    }

    /**
     * Usuário que registrou o vínculo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==================== ACCESSORS ====================

    /**
     * Retorna o nome formatado (nome ou apelido se disponível)
     */
    public function getNomeExibicaoAttribute(): string
    {
        if ($this->apelido) {
            return "{$this->nome} ({$this->apelido})";
        }
        return $this->nome;
    }

    /**
     * Retorna o método de vínculo formatado
     */
    public function getMetodoVinculoTextoAttribute(): string
    {
        $metodos = [
            'manual' => 'Vinculado manualmente',
            'automatico' => 'Detectado automaticamente',
            'sugestao_aceita' => 'Sugestão aceita pelo usuário',
            'solicitante_original' => 'Solicitante original',
        ];

        return $metodos[$this->metodo_vinculo] ?? ucfirst($this->metodo_vinculo);
    }

    /**
     * Retorna o score de similaridade formatado
     */
    public function getScoreSimilaridadeTextoAttribute(): string
    {
        if ($this->score_similaridade === null) {
            return 'N/A';
        }

        $score = $this->score_similaridade;

        if ($score >= 90) {
            return "Muito alta ({$score}%)";
        } elseif ($score >= 75) {
            return "Alta ({$score}%)";
        } elseif ($score >= 60) {
            return "Média ({$score}%)";
        } else {
            return "Baixa ({$score}%)";
        }
    }

    // ==================== SCOPES ====================

    /**
     * Apenas interessados que desejam ser notificados
     */
    public function scopeNotificaveis($query)
    {
        return $query->where('notificar', true);
    }

    /**
     * Apenas interessados confirmados
     */
    public function scopeConfirmados($query)
    {
        return $query->where('confirmado', true);
    }

    /**
     * Interessados vinculados automaticamente
     */
    public function scopeAutomaticos($query)
    {
        return $query->where('metodo_vinculo', 'automatico');
    }

    // ==================== MÉTODOS ====================

    /**
     * Marca o interessado como confirmado
     */
    public function confirmar(): bool
    {
        $this->confirmado = true;
        return $this->save();
    }

    /**
     * Atualiza preferência de notificação
     */
    public function atualizarNotificacao(bool $notificar): bool
    {
        $this->notificar = $notificar;
        return $this->save();
    }

    /**
     * Verifica se o interessado pode ser notificado
     */
    public function podeSerNotificado(): bool
    {
        return $this->notificar && ($this->email || $this->telefone);
    }

    /**
     * Retorna dados públicos do interessado (LGPD compliant)
     */
    public function toPublicArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'apelido' => $this->apelido,
            'data_vinculo' => $this->data_vinculo?->format('d/m/Y H:i'),
            'metodo_vinculo' => $this->metodo_vinculo_texto,
            'confirmado' => $this->confirmado,
        ];
    }
}

