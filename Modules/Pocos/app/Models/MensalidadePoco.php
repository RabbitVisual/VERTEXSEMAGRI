<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use Carbon\Carbon;

class MensalidadePoco extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'mensalidades_poco';

    protected $fillable = [
        'codigo',
        'poco_id',
        'lider_id',
        'mes',
        'ano',
        'valor_mensalidade',
        'data_vencimento',
        'data_criacao',
        'observacoes',
        'status',
        'forma_recebimento',
        'chave_pix',
    ];

    protected $casts = [
        'mes' => 'integer',
        'ano' => 'integer',
        'valor_mensalidade' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_criacao' => 'date',
        'status' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mensalidade) {
            if (empty($mensalidade->codigo)) {
                $mensalidade->codigo = static::generateCode('MEN');
            }
        });
    }

    // Relacionamentos
    public function poco()
    {
        return $this->belongsTo(Poco::class);
    }

    public function lider()
    {
        return $this->belongsTo(LiderComunidade::class, 'lider_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(PagamentoPoco::class, 'mensalidade_id');
    }

    public function pagamentosPix()
    {
        return $this->hasMany(PagamentoPixPoco::class, 'mensalidade_id');
    }

    public function boletos()
    {
        return $this->hasMany(BoletoPoco::class, 'mensalidade_id');
    }

    public function usuarios()
    {
        return $this->hasManyThrough(
            UsuarioPoco::class,
            PagamentoPoco::class,
            'mensalidade_id',
            'id',
            'id',
            'usuario_poco_id'
        );
    }

    // Accessors
    public function getMesAnoAttribute(): string
    {
        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];
        return $meses[$this->mes] . '/' . $this->ano;
    }

    public function getStatusTextoAttribute(): string
    {
        $status = [
            'aberta' => 'Aberta',
            'fechada' => 'Fechada',
            'cancelada' => 'Cancelada',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getTotalArrecadadoAttribute(): float
    {
        return $this->pagamentos()
            ->where('status', 'confirmado')
            ->sum('valor_pago');
    }

    public function getTotalPendenteAttribute(): float
    {
        $totalUsuarios = $this->poco->usuariosPoco()->where('status', 'ativo')->count();
        $totalArrecadado = $this->total_arrecadado;
        $totalEsperado = $totalUsuarios * $this->valor_mensalidade;
        return max(0, $totalEsperado - $totalArrecadado);
    }

    public function getTotalUsuariosAttribute(): int
    {
        return $this->poco->usuariosPoco()->where('status', 'ativo')->count();
    }

    public function getUsuariosPagantesAttribute(): int
    {
        return $this->pagamentos()
            ->where('status', 'confirmado')
            ->distinct('usuario_poco_id')
            ->count('usuario_poco_id');
    }

    public function getUsuariosPendentesAttribute(): int
    {
        return $this->total_usuarios - $this->usuarios_pagantes;
    }

    // Métodos auxiliares
    public function estaVencida(): bool
    {
        return $this->data_vencimento->isPast() && $this->status === 'aberta';
    }

    public function podeSerFechada(): bool
    {
        return $this->status === 'aberta' && $this->data_vencimento->isPast();
    }

    // Scopes
    public function scopeAbertas($query)
    {
        return $query->where('status', 'aberta');
    }

    public function scopeFechadas($query)
    {
        return $query->where('status', 'fechada');
    }

    public function scopePorPoco($query, $pocoId)
    {
        return $query->where('poco_id', $pocoId);
    }

    public function scopePorMesAno($query, $mes, $ano)
    {
        return $query->where('mes', $mes)->where('ano', $ano);
    }

    public function scopeVencidas($query)
    {
        return $query->where('status', 'aberta')
            ->where('data_vencimento', '<', now());
    }
}

