<?php

namespace Modules\Localidades\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localidade extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'localidades';

    protected $fillable = [
        'nome',
        'codigo',
        'tipo',
        'cidade',
        'estado',
        'ativo',
        'latitude',
        'longitude',
    ];

    protected static function newFactory()
    {
        return \Modules\Localidades\Database\Factories\LocalidadeFactory::new();
    }

    // Relacionamentos
    public function pessoas()
    {
        return $this->hasMany(\Modules\Pessoas\App\Models\PessoaCad::class, 'localidade_id', 'id');
    }

    public function demandas()
    {
        return $this->hasMany(\Modules\Demandas\App\Models\Demanda::class);
    }
}
