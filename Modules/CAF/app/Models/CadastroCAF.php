<?php

namespace Modules\CAF\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Localidades\App\Models\Localidade;
use App\Models\User;

class CadastroCAF extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'cadastros_caf';

    protected $fillable = [
        'protocolo',
        'codigo',
        'pessoa_id',
        'funcionario_id',
        'created_by',
        'nome_completo',
        'cpf',
        'rg',
        'data_nascimento',
        'sexo',
        'estado_civil',
        'telefone',
        'celular',
        'email',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'localidade_id',
        'status',
        'observacoes',
        'enviado_caf_at',
        'protocolo_caf_oficial',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'enviado_caf_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cadastro) {
            if (empty($cadastro->codigo)) {
                $cadastro->codigo = static::generateCode('CAF');
            }
        });

        static::created(function ($cadastro) {
            if (empty($cadastro->protocolo)) {
                $cadastro->protocolo = 'CAF-' . date('Y') . '-' . str_pad($cadastro->id, 6, '0', STR_PAD_LEFT);
                $cadastro->saveQuietly();
            }
        });
    }

    // Relacionamentos
    public function pessoa()
    {
        return $this->belongsTo(PessoaCad::class, 'pessoa_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    public function cadastrador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function localidade()
    {
        return $this->belongsTo(Localidade::class, 'localidade_id');
    }

    public function conjuge()
    {
        return $this->hasOne(ConjugeCAF::class, 'cadastro_caf_id');
    }

    public function familiares()
    {
        return $this->hasMany(FamiliarCAF::class, 'cadastro_caf_id');
    }

    public function imovel()
    {
        return $this->hasOne(ImovelCAF::class, 'cadastro_caf_id');
    }

    public function rendaFamiliar()
    {
        return $this->hasOne(RendaFamiliarCAF::class, 'cadastro_caf_id');
    }

    /**
     * Relacionamento com beneficiários de programas através da pessoa
     */
    public function beneficiarios()
    {
        if (!$this->pessoa_id) {
            return collect();
        }
        return \Modules\ProgramasAgricultura\App\Models\Beneficiario::where('pessoa_id', $this->pessoa_id);
    }

    /**
     * Relacionamento com programas através dos beneficiários
     */
    public function programas()
    {
        if (!$this->pessoa_id) {
            return collect();
        }
        return \Modules\ProgramasAgricultura\App\Models\Programa::whereHas('beneficiarios', function($q) {
            $q->where('pessoa_id', $this->pessoa_id);
        });
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        return match($this->status) {
            'rascunho' => 'Rascunho',
            'em_andamento' => 'Em Andamento',
            'completo' => 'Completo',
            'aprovado' => 'Aprovado',
            'rejeitado' => 'Rejeitado',
            'enviado_caf' => 'Enviado ao CAF',
            default => 'Desconhecido',
        };
    }

    public function getStatusCorAttribute(): string
    {
        return match($this->status) {
            'rascunho' => 'gray',
            'em_andamento' => 'yellow',
            'completo' => 'blue',
            'aprovado' => 'green',
            'rejeitado' => 'red',
            'enviado_caf' => 'emerald',
            default => 'gray',
        };
    }

    public function getEstadoCivilTextoAttribute(): string
    {
        return match($this->estado_civil) {
            'solteiro' => 'Solteiro(a)',
            'casado' => 'Casado(a)',
            'divorciado' => 'Divorciado(a)',
            'viuvo' => 'Viúvo(a)',
            'uniao_estavel' => 'União Estável',
            default => $this->estado_civil ?? 'Não informado',
        };
    }

    // Scopes
    public function scopeRascunhos($query)
    {
        return $query->where('status', 'rascunho');
    }

    public function scopeEmAndamento($query)
    {
        return $query->where('status', 'em_andamento');
    }

    public function scopeCompletos($query)
    {
        return $query->where('status', 'completo');
    }

    public function scopeAprovados($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopeEnviadosCAF($query)
    {
        return $query->where('status', 'enviado_caf');
    }

    public function scopePorFuncionario($query, $funcionarioId)
    {
        return $query->where('funcionario_id', $funcionarioId);
    }

    public function scopePorLocalidade($query, $localidadeId)
    {
        return $query->where('localidade_id', $localidadeId);
    }

    // Métodos
    public function estaCompleto(): bool
    {
        return $this->status === 'completo' 
            && $this->conjuge !== null 
            && $this->familiares()->count() > 0
            && $this->imovel !== null
            && $this->rendaFamiliar !== null;
    }

    public function podeSerEnviado(): bool
    {
        return $this->status === 'aprovado' && !$this->enviado_caf_at;
    }

    public function gerarProtocolo(): string
    {
        if (!$this->protocolo) {
            $this->protocolo = 'CAF-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
            $this->save();
        }
        return $this->protocolo;
    }

    /**
     * Retorna estatísticas gerais dos cadastros
     */
    public static function getStats(): array
    {
        return self::selectRaw("
            count(*) as total,
            count(case when status = 'rascunho' then 1 end) as rascunhos,
            count(case when status = 'em_andamento' then 1 end) as em_andamento,
            count(case when status = 'completo' then 1 end) as completos,
            count(case when status = 'aprovado' then 1 end) as aprovados,
            count(case when status = 'enviado_caf' then 1 end) as enviados_caf
        ")->first()->toArray();
    }
}
