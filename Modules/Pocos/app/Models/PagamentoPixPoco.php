<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;

class PagamentoPixPoco extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'pagamentos_pix_poco';

    protected $fillable = [
        'txid',
        'codigo',
        'mensalidade_id',
        'usuario_poco_id',
        'poco_id',
        'lider_id',
        'chave_pix_destino',
        'valor',
        'descricao',
        'solicitacao_pagador',
        'qr_code_base64',
        'qr_code_string',
        'location_id',
        'status',
        'data_expiracao',
        'data_pagamento',
        'e2eid',
        'end_to_end_id',
        'chave_pix_origem',
        'nome_pagador',
        'cpf_pagador',
        'info_pagador',
        'webhook_recebido_em',
        'webhook_dados',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_expiracao' => 'datetime',
        'data_pagamento' => 'datetime',
        'webhook_recebido_em' => 'datetime',
        'info_pagador' => 'array',
        'webhook_dados' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pagamento) {
            if (empty($pagamento->codigo)) {
                $pagamento->codigo = static::generateCode('PIX');
            }
        });
    }

    // Relacionamentos
    public function mensalidade()
    {
        return $this->belongsTo(MensalidadePoco::class);
    }

    public function usuarioPoco()
    {
        return $this->belongsTo(UsuarioPoco::class);
    }

    public function poco()
    {
        return $this->belongsTo(Poco::class);
    }

    public function lider()
    {
        return $this->belongsTo(LiderComunidade::class);
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'pendente' => 'Pendente',
            'pago' => 'Pago',
            'expirado' => 'Expirado',
            'cancelado' => 'Cancelado',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getEstaExpiradoAttribute(): bool
    {
        return $this->data_expiracao && $this->data_expiracao->isPast() && $this->status === 'pendente';
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopePagos($query)
    {
        return $query->where('status', 'pago');
    }

    public function scopeExpirados($query)
    {
        return $query->where('status', 'expirado');
    }

    public function scopePorMensalidade($query, $mensalidadeId)
    {
        return $query->where('mensalidade_id', $mensalidadeId);
    }

    public function scopePorLider($query, $liderId)
    {
        return $query->where('lider_id', $liderId);
    }
}

