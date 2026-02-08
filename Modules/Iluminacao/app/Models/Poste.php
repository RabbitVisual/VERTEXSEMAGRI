<?php

namespace Modules\Iluminacao\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poste extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'latitude',
        'longitude',
        'logradouro',
        'bairro',
        'cep',
        'tipo_poste',
        'condicao',
        'tipo_lampada',
        'potencia',
        'trafo',
        'barramento',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'barramento' => 'boolean',
        'ativo' => 'boolean',
        'potencia' => 'integer',
    ];
}
