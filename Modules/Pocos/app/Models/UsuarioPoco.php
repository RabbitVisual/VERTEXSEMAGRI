<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use Illuminate\Support\Str;

class UsuarioPoco extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'usuarios_poco';

    protected $fillable = [
        'codigo',
        'poco_id',
        'pessoa_id',
        'nome',
        'cpf',
        'telefone',
        'email',
        'endereco',
        'numero_casa',
        'codigo_acesso',
        'status',
        'data_cadastro',
        'observacoes',
    ];

    protected $casts = [
        'data_cadastro' => 'date',
        'status' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($usuario) {
            if (empty($usuario->codigo)) {
                $usuario->codigo = static::generateCode('UP');
            }
            if (empty($usuario->codigo_acesso)) {
                $usuario->codigo_acesso = self::gerarCodigoAcesso();
            }
        });
    }

    // Relacionamentos
    public function poco()
    {
        return $this->belongsTo(Poco::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(\Modules\Pessoas\App\Models\PessoaCad::class, 'pessoa_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(PagamentoPoco::class, 'usuario_poco_id');
    }

    public function boletos()
    {
        return $this->hasMany(BoletoPoco::class, 'usuario_poco_id');
    }

    public function solicitacoesBaixa()
    {
        return $this->hasMany(SolicitacaoBaixaPoco::class, 'usuario_poco_id');
    }

    public function mensalidades()
    {
        return $this->hasManyThrough(
            MensalidadePoco::class,
            PagamentoPoco::class,
            'usuario_poco_id',
            'id',
            'id',
            'mensalidade_id'
        );
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'ativo' => 'Ativo',
            'inativo' => 'Inativo',
            'suspenso' => 'Suspenso',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getCpfFormatadoAttribute(): string
    {
        if (!$this->cpf || strlen($this->cpf) !== 11) {
            return $this->cpf ?? '';
        }
        return substr($this->cpf, 0, 3) . '.' . substr($this->cpf, 3, 3) . '.' . substr($this->cpf, 6, 3) . '-' . substr($this->cpf, 9, 2);
    }

    // Métodos auxiliares
    public static function gerarCodigoAcesso(): string
    {
        do {
            $codigo = strtoupper(Str::random(8));
        } while (self::where('codigo_acesso', $codigo)->exists());

        return $codigo;
    }

    public function temPagamentoPendente($mensalidadeId): bool
    {
        return !$this->pagamentos()
            ->where('mensalidade_id', $mensalidadeId)
            ->where('status', 'confirmado')
            ->exists();
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopePorPoco($query, $pocoId)
    {
        return $query->where('poco_id', $pocoId);
    }

    public function scopePorCodigoAcesso($query, $codigo)
    {
        return $query->where('codigo_acesso', $codigo);
    }
}

