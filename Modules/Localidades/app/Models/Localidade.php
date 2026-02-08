<?php

namespace Modules\Localidades\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;
use Modules\Localidades\Database\Factories\LocalidadeFactory;
use App\Traits\GeneratesCode;

class Localidade extends Model
{
    use HasFactory, GeneratesCode;

    protected $fillable = [
        'nome',
        'codigo',
        'tipo', // comunidade, bairro, distrito, etc
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'latitude',
        'longitude',
        'nome_mapa',
        'lider_comunitario',
        'telefone_lider',
        'numero_moradores',
        'infraestrutura_disponivel',
        'problemas_recorrentes',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'numero_moradores' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    protected static function newFactory()
    {
        return LocalidadeFactory::new();
    }

    // Relacionamentos
    public function familias()
    {
        return $this->hasMany(Familia::class);
    }

    public function demandas()
    {
        return $this->hasMany(\Modules\Demandas\App\Models\Demanda::class);
    }

    public function pessoas()
    {
        return $this->hasMany(\Modules\Pessoas\App\Models\PessoaCad::class, 'localidade_id');
    }

    public function redesAgua()
    {
        return $this->hasMany(\Modules\Agua\App\Models\RedeAgua::class);
    }

    public function pontosLuz()
    {
        return $this->hasMany(\Modules\Iluminacao\App\Models\PontoLuz::class);
    }

    public function trechos()
    {
        return $this->hasMany(\Modules\Estradas\App\Models\Trecho::class);
    }

    public function pocos()
    {
        return $this->hasMany(\Modules\Pocos\App\Models\Poco::class);
    }

    // Métodos para estatísticas
    public function getTotalPessoasAttribute()
    {
        if (!Schema::hasTable('pessoas_cad')) {
            return 0;
        }
        return $this->pessoas()->where('ativo', true)->count();
    }

    public function getTotalBeneficiariasPbfAttribute()
    {
        if (!Schema::hasTable('pessoas_cad')) {
            return 0;
        }
        return $this->pessoas()->whereNotNull('ref_pbf')->where('ref_pbf', '>', 0)->where('ativo', true)->count();
    }
}

