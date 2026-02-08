<?php

namespace Modules\ProgramasAgricultura\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasHistory;

class Beneficiario extends Model
{
    use HasFactory, SoftDeletes, HasHistory;

    protected $fillable = [
        'programa_id',
        'pessoa_id',
        'nome',
        'cpf',
        'telefone',
        'email',
        'localidade_id',
        'status',
        'data_inscricao',
        'data_aprovacao',
        'data_beneficio',
        'observacoes',
        'user_id_inscricao',
    ];

    protected $casts = [
        'data_inscricao' => 'date',
        'data_aprovacao' => 'date',
        'data_beneficio' => 'date',
    ];

    // Relacionamentos
    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(\Modules\Pessoas\App\Models\PessoaCad::class, 'pessoa_id');
    }

    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    public function usuarioInscricao()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id_inscricao');
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'inscrito' => 'Inscrito',
            'aprovado' => 'Aprovado',
            'beneficiado' => 'Beneficiado',
            'cancelado' => 'Cancelado',
            'inativo' => 'Inativo',
        ];

        return $status[$this->status] ?? ucfirst($this->status);
    }

    public function getNomeCompletoAttribute(): string
    {
        if ($this->pessoa) {
            return $this->pessoa->nom_pessoa;
        }

        return $this->nome ?? 'N/A';
    }

    public function getCpfFormatadoAttribute(): string
    {
        $cpf = $this->cpf ?? ($this->pessoa ? $this->pessoa->num_cpf_pessoa : null);
        
        if (!$cpf || strlen($cpf) != 11) {
            return $cpf ?? 'N/A';
        }

        return substr($cpf, 0, 3) . '.' .
               substr($cpf, 3, 3) . '.' .
               substr($cpf, 6, 3) . '-' .
               substr($cpf, 9, 2);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->whereIn('status', ['inscrito', 'aprovado', 'beneficiado']);
    }

    public function scopePorPrograma($query, int $programaId)
    {
        return $query->where('programa_id', $programaId);
    }

    public function scopePorCpf($query, string $cpf)
    {
        $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);
        return $query->where('cpf', $cpfLimpo)
            ->orWhereHas('pessoa', function($q) use ($cpfLimpo) {
                $q->where('num_cpf_pessoa', $cpfLimpo);
            });
    }

    public function scopePorLocalidade($query, int $localidadeId)
    {
        return $query->where('localidade_id', $localidadeId);
    }
}

