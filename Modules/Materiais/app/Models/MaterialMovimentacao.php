<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class MaterialMovimentacao extends Model
{
    use HasFactory;

    protected $table = 'material_movimentacoes';

    protected $fillable = [
        'material_id',
        'tipo',
        'status', // reservado, confirmado, cancelado
        'quantidade',
        'valor_unitario',
        'motivo',
        'ordem_servico_id',
        'user_id',
        'funcionario_id',
        'observacoes',
    ];

    protected $casts = [
        'quantidade' => 'decimal:2',
        'valor_unitario' => 'decimal:2',
    ];

    // Relacionamentos
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function ordemServico()
    {
        return $this->belongsTo(\Modules\Ordens\App\Models\OrdemServico::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(\Modules\Funcionarios\App\Models\Funcionario::class);
    }

    // Scopes
    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'entrada');
    }

    public function scopeSaidas($query)
    {
        return $query->where('tipo', 'saida');
    }

    public function scopeReservadas($query)
    {
        return $query->where('status', 'reservado');
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('status', 'cancelado');
    }

    public function scopePorMaterial($query, int $materialId)
    {
        return $query->where('material_id', $materialId);
    }

    public function scopePorOrdemServico($query, int $ordemServicoId)
    {
        return $query->where('ordem_servico_id', $ordemServicoId);
    }

    // Métodos auxiliares
    /**
     * Retorna o valor total da movimentação
     */
    public function getValorTotalAttribute(): float
    {
        if (!$this->valor_unitario) {
            return 0;
        }
        return $this->quantidade * $this->valor_unitario;
    }

    /**
     * Retorna o tipo formatado
     */
    public function getTipoFormatadoAttribute(): string
    {
        return ucfirst($this->tipo);
    }
}

