<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampoCategoriaMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'campos_categoria_material';

    protected $fillable = [
        'subcategoria_id',
        'nome',
        'slug',
        'tipo',
        'opcoes',
        'placeholder',
        'descricao',
        'obrigatorio',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'opcoes' => 'array',
        'obrigatorio' => 'boolean',
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    // Relacionamentos
    public function subcategoria()
    {
        return $this->belongsTo(SubcategoriaMaterial::class, 'subcategoria_id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorSubcategoria($query, $subcategoriaId)
    {
        return $query->where('subcategoria_id', $subcategoriaId);
    }

    public function scopeObrigatorios($query)
    {
        return $query->where('obrigatorio', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    // Accessors
    public function getOpcoesArrayAttribute(): array
    {
        if (is_string($this->opcoes)) {
            return json_decode($this->opcoes, true) ?? [];
        }
        return $this->opcoes ?? [];
    }

    public function getTipoTextoAttribute(): string
    {
        $tipos = [
            'text' => 'Texto',
            'number' => 'Número',
            'select' => 'Seleção',
            'textarea' => 'Área de Texto',
            'date' => 'Data',
            'boolean' => 'Sim/Não',
        ];
        return $tipos[$this->tipo] ?? ucfirst($this->tipo);
    }
}

