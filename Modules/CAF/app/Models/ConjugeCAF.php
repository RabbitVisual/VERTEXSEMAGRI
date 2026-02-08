<?php

namespace Modules\CAF\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConjugeCAF extends Model
{
    use HasFactory;

    protected $table = 'conjuges_caf';

    protected $fillable = [
        'cadastro_caf_id',
        'nome_completo',
        'cpf',
        'rg',
        'data_nascimento',
        'sexo',
        'telefone',
        'celular',
        'email',
        'profissao',
        'renda_mensal',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'renda_mensal' => 'decimal:2',
    ];

    // Relacionamentos
    public function cadastro()
    {
        return $this->belongsTo(CadastroCAF::class, 'cadastro_caf_id');
    }
}

