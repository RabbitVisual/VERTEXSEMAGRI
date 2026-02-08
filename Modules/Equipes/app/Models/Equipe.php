<?php

namespace Modules\Equipes\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Traits\GeneratesCode;

class Equipe extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $fillable = [
        'nome',
        'codigo',
        'tipo', // eletricistas, encanadores, operadores, motoristas, mista
        'descricao',
        'lider_id',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function lider()
    {
        return $this->belongsTo(User::class, 'lider_id');
    }

    public function membros()
    {
        return $this->belongsToMany(User::class, 'equipe_membros', 'equipe_id', 'user_id')
            ->withTimestamps();
    }

    public function funcionarios()
    {
        return $this->belongsToMany(\Modules\Funcionarios\App\Models\Funcionario::class, 'equipe_funcionarios', 'equipe_id', 'funcionario_id')
            ->withTimestamps();
    }

    public function ordensServico()
    {
        return $this->hasMany(\Modules\Ordens\App\Models\OrdemServico::class);
    }

    public function pocos()
    {
        return $this->hasMany(\Modules\Pocos\App\Models\Poco::class, 'equipe_responsavel_id');
    }

    /**
     * Retorna o total de membros (funcionários + users)
     */
    public function getTotalMembrosAttribute(): int
    {
        return $this->funcionarios()->count() + $this->membros()->count();
    }

    /**
     * Verifica se a equipe tem funcionários
     */
    public function temFuncionarios(): bool
    {
        return $this->funcionarios()->count() > 0;
    }

    /**
     * Verifica se o líder é um funcionário da equipe
     */
    public function liderEhFuncionario(): bool
    {
        if (!$this->lider_id) {
            return false;
        }

        $lider = $this->lider;
        if (!$lider || !$lider->email) {
            return false;
        }

        return $this->funcionarios()->where('email', $lider->email)->exists();
    }

    /**
     * Retorna funcionários ativos da equipe
     */
    public function funcionariosAtivos()
    {
        return $this->funcionarios()->where('ativo', true);
    }

    /**
     * Scope para equipes ativas
     */
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para equipes por tipo
     */
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para equipes com funcionários
     */
    public function scopeComFuncionarios($query)
    {
        return $query->has('funcionarios');
    }

    /**
     * Scope para equipes sem funcionários
     */
    public function scopeSemFuncionarios($query)
    {
        return $query->doesntHave('funcionarios');
    }

    /**
     * Retorna o nome formatado do tipo
     */
    public function getTipoFormatadoAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->tipo));
    }

    /**
     * Verifica se a equipe pode ser deletada
     */
    public function podeSerDeletada(): bool
    {
        return $this->ordensServico()->count() === 0;
    }

    /**
     * Retorna estatísticas da equipe
     */
    public function getEstatisticasAttribute(): array
    {
        return [
            'total_funcionarios' => $this->funcionarios()->count(),
            'funcionarios_ativos' => $this->funcionarios()->where('ativo', true)->count(),
            'total_os' => $this->ordensServico()->count(),
            'os_concluidas' => $this->ordensServico()->where('status', 'concluida')->count(),
            'os_pendentes' => $this->ordensServico()->whereIn('status', ['pendente', 'em_execucao'])->count(),
        ];
    }
}

