<?php

namespace Modules\CAF\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamiliarCAF extends Model
{
    use HasFactory;

    protected $table = 'familiares_caf';

    protected $fillable = [
        'cadastro_caf_id',
        'nome_completo',
        'cpf',
        'rg',
        'data_nascimento',
        'sexo',
        'parentesco',
        'escolaridade',
        'trabalha',
        'renda_mensal',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'trabalha' => 'boolean',
        'renda_mensal' => 'decimal:2',
    ];

    // Relacionamentos
    public function cadastro()
    {
        return $this->belongsTo(CadastroCAF::class, 'cadastro_caf_id');
    }

    // Accessors
    public function getParentescoTextoAttribute(): string
    {
        return match($this->parentesco) {
            'filho' => 'Filho(a)',
            'filha' => 'Filha',
            'pai' => 'Pai',
            'mae' => 'Mãe',
            'avo' => 'Avô(ó)',
            'neto' => 'Neto(a)',
            'irmao' => 'Irmão(ã)',
            'outro' => 'Outro',
            default => $this->parentesco ?? 'Não informado',
        };
    }
}

