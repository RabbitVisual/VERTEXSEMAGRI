<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SolicitacaoMaterialCampo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'solicitacoes_materiais_campo';

    protected $fillable = [
        'user_id',
        'ordem_servico_id',
        'material_id',
        'material_nome',
        'material_codigo',
        'quantidade',
        'unidade_medida',
        'justificativa',
        'status',
        'processado_por',
        'solicitacao_material_id',
        'observacoes',
    ];

    protected $casts = [
        'quantidade' => 'decimal:2',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function ordemServico()
    {
        return $this->belongsTo(\Modules\Ordens\App\Models\OrdemServico::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function processadoPor()
    {
        return $this->belongsTo(\App\Models\User::class, 'processado_por');
    }

    public function solicitacaoMaterial()
    {
        return $this->belongsTo(SolicitacaoMaterial::class, 'solicitacao_material_id');
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeProcessadas($query)
    {
        return $query->where('status', 'processada');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('status', 'cancelada');
    }

    public function scopePorUsuario($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'pendente' => 'Pendente',
            'processada' => 'Processada',
            'cancelada' => 'Cancelada',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getStatusCorAttribute(): string
    {
        $cores = [
            'pendente' => 'warning',
            'processada' => 'success',
            'cancelada' => 'danger',
        ];
        return $cores[$this->status] ?? 'secondary';
    }
}

