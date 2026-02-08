<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use App\Models\User;

class LiderComunidade extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'lideres_comunidade';

    protected $fillable = [
        'codigo',
        'nome',
        'cpf',
        'telefone',
        'email',
        'chave_pix',
        'tipo_chave_pix',
        'pix_ativo',
        'localidade_id',
        'user_id',
        'pessoa_id',
        'poco_id',
        'endereco',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lider) {
            if (empty($lider->codigo)) {
                $lider->codigo = static::generateCode('LC');
            }
        });
    }

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(\Modules\Pessoas\App\Models\PessoaCad::class, 'pessoa_id');
    }

    public function poco()
    {
        return $this->belongsTo(Poco::class);
    }

    public function mensalidades()
    {
        return $this->hasMany(MensalidadePoco::class, 'lider_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(PagamentoPoco::class, 'lider_id');
    }

    public function pagamentosPix()
    {
        return $this->hasMany(PagamentoPixPoco::class, 'lider_id');
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        return $this->status === 'ativo' ? 'Ativo' : 'Inativo';
    }

    public function getCpfFormatadoAttribute(): string
    {
        if (!$this->cpf || strlen($this->cpf) !== 11) {
            return $this->cpf;
        }
        return substr($this->cpf, 0, 3) . '.' . substr($this->cpf, 3, 3) . '.' . substr($this->cpf, 6, 3) . '-' . substr($this->cpf, 9, 2);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopePorLocalidade($query, $localidadeId)
    {
        return $query->where('localidade_id', $localidadeId);
    }

    public function scopePorPoco($query, $pocoId)
    {
        return $query->where('poco_id', $pocoId);
    }
}

