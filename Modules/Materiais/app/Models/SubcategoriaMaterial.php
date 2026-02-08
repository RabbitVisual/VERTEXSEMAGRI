<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcategoriaMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcategorias_materiais';

    protected $fillable = [
        'categoria_id',
        'nome',
        'slug',
        'descricao',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    // Relacionamentos
    public function categoria()
    {
        return $this->belongsTo(CategoriaMaterial::class, 'categoria_id');
    }

    public function campos()
    {
        return $this->hasMany(CampoCategoriaMaterial::class, 'subcategoria_id')
            ->where('ativo', true)
            ->orderBy('ordem');
    }

    public function camposTodos()
    {
        return $this->hasMany(CampoCategoriaMaterial::class, 'subcategoria_id')
            ->orderBy('ordem');
    }

    public function materiais()
    {
        return $this->hasMany(Material::class, 'subcategoria_id');
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    // Accessors
    public function getTotalCamposAttribute(): int
    {
        return $this->campos()->count();
    }

    public function getTotalMateriaisAttribute(): int
    {
        return $this->materiais()->count();
    }
}

