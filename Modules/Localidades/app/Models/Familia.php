<?php

namespace Modules\Localidades\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Familia extends Model
{
    use HasFactory;

    protected $fillable = [
        'localidade_id',
        'nome_responsavel',
        'cpf_responsavel',
        'telefone',
        'numero_membros',
        'renda_familiar',
        'beneficios_sociais',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'numero_membros' => 'integer',
        'renda_familiar' => 'decimal:2',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(Localidade::class);
    }
}

