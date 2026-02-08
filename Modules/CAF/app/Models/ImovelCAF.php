<?php

namespace Modules\CAF\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Localidades\App\Models\Localidade;

class ImovelCAF extends Model
{
    use HasFactory;

    protected $table = 'imoveis_caf';

    protected $fillable = [
        'cadastro_caf_id',
        'tipo_posse',
        'tipo_posse_outro',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'localidade_id',
        'area_total_hectares',
        'area_agricultavel_hectares',
        'area_pastagem_hectares',
        'area_reserva_legal_hectares',
        'producao_vegetal',
        'producao_animal',
        'extrativismo',
        'aquicultura',
        'atividades_descricao',
    ];

    protected $casts = [
        'area_total_hectares' => 'decimal:2',
        'area_agricultavel_hectares' => 'decimal:2',
        'area_pastagem_hectares' => 'decimal:2',
        'area_reserva_legal_hectares' => 'decimal:2',
        'producao_vegetal' => 'boolean',
        'producao_animal' => 'boolean',
        'extrativismo' => 'boolean',
        'aquicultura' => 'boolean',
    ];

    // Relacionamentos
    public function cadastro()
    {
        return $this->belongsTo(CadastroCAF::class, 'cadastro_caf_id');
    }

    public function localidade()
    {
        return $this->belongsTo(Localidade::class, 'localidade_id');
    }

    // Accessors
    public function getTipoPosseTextoAttribute(): string
    {
        return match($this->tipo_posse) {
            'proprio' => 'Próprio',
            'arrendado' => 'Arrendado',
            'cedido' => 'Cedido',
            'ocupacao' => 'Ocupação',
            'outro' => $this->tipo_posse_outro ?? 'Outro',
            default => 'Não informado',
        };
    }
}

