<?php

namespace Modules\ProgramasAgricultura\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscricaoEvento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscricoes_eventos';

    protected $fillable = [
        'evento_id',
        'pessoa_id',
        'nome',
        'cpf',
        'telefone',
        'email',
        'localidade_id',
        'status',
        'data_inscricao',
        'data_confirmacao',
        'observacoes',
    ];

    protected $casts = [
        'data_inscricao' => 'date',
        'data_confirmacao' => 'date',
    ];

    // Relacionamentos
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(\Modules\Pessoas\App\Models\PessoaCad::class, 'pessoa_id');
    }

    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'inscrito' => 'Inscrito',
            'confirmado' => 'Confirmado',
            'presente' => 'Presente',
            'ausente' => 'Ausente',
            'cancelado' => 'Cancelado',
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
    public function scopeConfirmadas($query)
    {
        return $query->whereIn('status', ['inscrito', 'confirmado', 'presente']);
    }

    public function scopePorEvento($query, int $eventoId)
    {
        return $query->where('evento_id', $eventoId);
    }

    public function scopePorCpf($query, string $cpf)
    {
        $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);
        return $query->where('cpf', $cpfLimpo)
            ->orWhereHas('pessoa', function($q) use ($cpfLimpo) {
                $q->where('num_cpf_pessoa', $cpfLimpo);
            });
    }
}

