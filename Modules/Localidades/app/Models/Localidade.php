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
    ];
}
