<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;

class PagamentoPoco extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'pagamentos_poco';

    protected $fillable = [
        'codigo',
        'mensalidade_id',
        'usuario_poco_id',
        'poco_id',
        'lider_id',
        'data_pagamento',
        'valor_pago',
        'taxa_plataforma',
        'valor_liquido',
        'split_realizado',
        'forma_pagamento',
        'comprovante',
        'observacoes',
        'status',
    ];

    protected $casts = [
        'data_pagamento' => 'date',
        'valor_pago' => 'decimal:2',
        'forma_pagamento' => 'string',
        'status' => 'string',
    ];

    // Relacionamentos
    public function mensalidade()
    {
        return $this->belongsTo(MensalidadePoco::class, 'mensalidade_id');
    }

    public function usuarioPoco()
    {
        return $this->belongsTo(UsuarioPoco::class, 'usuario_poco_id');
    }

    public function poco()
    {
        return $this->belongsTo(Poco::class);
    }

    public function lider()
    {
        return $this->belongsTo(LiderComunidade::class, 'lider_id');
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'pendente' => 'Pendente',
            'confirmado' => 'Confirmado',
            'cancelado' => 'Cancelado',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getFormaPagamentoTextoAttribute(): string
    {
        $formas = [
            'dinheiro' => 'Dinheiro',
            'pix' => 'PIX',
            'transferencia' => 'Transferência',
            'outro' => 'Outro',
        ];
        return $formas[$this->forma_pagamento] ?? $this->forma_pagamento;
    }

    // Scopes
    public function scopeConfirmados($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopePorMensalidade($query, $mensalidadeId)
    {
        return $query->where('mensalidade_id', $mensalidadeId);
    }

    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_poco_id', $usuarioId);
    }

    public function scopePorPoco($query, $pocoId)
    {
        return $query->where('poco_id', $pocoId);
    }

    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_pagamento', [$dataInicio, $dataFim]);
    }

    // Gerar código automaticamente se não fornecido
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pagamento) {
            if (empty($pagamento->codigo)) {
                $pagamento->codigo = PagamentoPoco::generateCode('PAG', $pagamento->forma_pagamento ?? null);
            }
        });
    }
}
