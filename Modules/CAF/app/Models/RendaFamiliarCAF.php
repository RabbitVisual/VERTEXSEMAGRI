<?php

namespace Modules\CAF\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RendaFamiliarCAF extends Model
{
    use HasFactory;

    protected $table = 'rendas_familiares_caf';

    protected $fillable = [
        'cadastro_caf_id',
        'renda_total_mensal',
        'renda_per_capita',
        'numero_membros',
        'renda_agricultura',
        'renda_pecuaria',
        'renda_extrativismo',
        'renda_aposentadoria',
        'renda_bolsa_familia',
        'renda_outros',
        'renda_outros_descricao',
        'recebe_bolsa_familia',
        'recebe_aposentadoria',
        'recebe_bpc',
        'recebe_outros',
        'beneficios_descricao',
    ];

    protected $casts = [
        'renda_total_mensal' => 'decimal:2',
        'renda_per_capita' => 'decimal:2',
        'numero_membros' => 'integer',
        'renda_agricultura' => 'decimal:2',
        'renda_pecuaria' => 'decimal:2',
        'renda_extrativismo' => 'decimal:2',
        'renda_aposentadoria' => 'decimal:2',
        'renda_bolsa_familia' => 'decimal:2',
        'renda_outros' => 'decimal:2',
        'recebe_bolsa_familia' => 'boolean',
        'recebe_aposentadoria' => 'boolean',
        'recebe_bpc' => 'boolean',
        'recebe_outros' => 'boolean',
    ];

    // Relacionamentos
    public function cadastro()
    {
        return $this->belongsTo(CadastroCAF::class, 'cadastro_caf_id');
    }

    // Métodos
    public function calcularRendaTotal(): float
    {
        return (float) (
            ($this->renda_agricultura ?? 0) +
            ($this->renda_pecuaria ?? 0) +
            ($this->renda_extrativismo ?? 0) +
            ($this->renda_aposentadoria ?? 0) +
            ($this->renda_bolsa_familia ?? 0) +
            ($this->renda_outros ?? 0)
        );
    }

    public function calcularRendaPerCapita(): float
    {
        $membros = $this->numero_membros > 0 ? $this->numero_membros : 1;
        return $this->calcularRendaTotal() / $membros;
    }
}

