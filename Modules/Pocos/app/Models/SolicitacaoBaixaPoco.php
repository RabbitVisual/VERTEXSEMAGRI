<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class SolicitacaoBaixaPoco extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'solicitacoes_baixa_poco';

    protected $fillable = [
        'boleto_poco_id',
        'usuario_poco_id',
        'mensalidade_id',
        'poco_id',
        'data_pagamento',
        'valor_pago',
        'forma_pagamento',
        'comprovante',
        'observacoes',
        'status',
        'motivo_rejeicao',
        'aprovado_por',
        'aprovado_em',
    ];

    protected $casts = [
        'data_pagamento' => 'date',
        'valor_pago' => 'decimal:2',
        'aprovado_em' => 'datetime',
    ];

    // Relacionamentos
    public function boleto()
    {
        return $this->belongsTo(BoletoPoco::class, 'boleto_poco_id');
    }

    public function usuarioPoco()
    {
        return $this->belongsTo(UsuarioPoco::class, 'usuario_poco_id');
    }

    public function mensalidade()
    {
        return $this->belongsTo(MensalidadePoco::class, 'mensalidade_id');
    }

    public function poco()
    {
        return $this->belongsTo(Poco::class, 'poco_id');
    }

    public function aprovadoPor()
    {
        return $this->belongsTo(User::class, 'aprovado_por');
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'pendente' => 'Pendente',
            'aprovada' => 'Aprovada',
            'rejeitada' => 'Rejeitada',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getFormaPagamentoTextoAttribute(): string
    {
        if (!$this->forma_pagamento) {
            return 'Não informado';
        }
        
        $formas = [
            'dinheiro' => 'Dinheiro',
            'pix' => 'PIX',
            'transferencia' => 'Transferência',
            'outro' => 'Outro',
        ];
        return $formas[$this->forma_pagamento] ?? ucfirst($this->forma_pagamento);
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeAprovadas($query)
    {
        return $query->where('status', 'aprovada');
    }

    public function scopeRejeitadas($query)
    {
        return $query->where('status', 'rejeitada');
    }

    public function scopePorPoco($query, $pocoId)
    {
        return $query->where('poco_id', $pocoId);
    }

    // Métodos
    public function podeSerAprovada(): bool
    {
        return $this->status === 'pendente';
    }

    public function podeSerRejeitada(): bool
    {
        return $this->status === 'pendente';
    }
}

