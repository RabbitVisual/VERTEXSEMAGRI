<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias_materiais';

    protected $fillable = [
        'nome',
        'slug',
        'icone',
        'descricao',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    // Relacionamentos
    public function subcategorias()
    {
        return $this->hasMany(SubcategoriaMaterial::class, 'categoria_id')
            ->where('ativo', true)
            ->orderBy('ordem');
    }

    public function subcategoriasTodas()
    {
        return $this->hasMany(SubcategoriaMaterial::class, 'categoria_id')
            ->orderBy('ordem');
    }

    public function materiais()
    {
        return $this->hasManyThrough(
            Material::class,
            SubcategoriaMaterial::class,
            'categoria_id',
            'subcategoria_id',
            'id',
            'id'
        );
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    // Accessors
    public function getTotalSubcategoriasAttribute(): int
    {
        return $this->subcategorias()->count();
    }

    public function getTotalMateriaisAttribute(): int
    {
        return $this->materiais()->count();
    }
}

