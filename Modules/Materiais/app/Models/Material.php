<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use Illuminate\Support\Facades\DB;

class Material extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $table = 'materiais';

    protected $fillable = [
        'nome',
        'codigo',
        'ncm_id', // Novo campo para vinculação com NCM
        'categoria', // Mantido por compatibilidade
        'subcategoria_id', // Nova referência à subcategoria
        'unidade_medida', // unidade, metro, litro, kg
        'quantidade_estoque',
        'quantidade_minima',
        'valor_unitario',
        'fornecedor',
        'localizacao_estoque',
        'campos_especificos', // JSON com campos específicos por categoria
        'ultimo_alerta_estoque', // Timestamp do último alerta de estoque baixo
        'ativo',
    ];

    protected $casts = [
        'quantidade_estoque' => 'decimal:2',
        'quantidade_minima' => 'decimal:2',
        'valor_unitario' => 'decimal:2',
        'ativo' => 'boolean',
        'campos_especificos' => 'array',
        'ultimo_alerta_estoque' => 'datetime',
    ];

    // Relacionamentos
    public function movimentacoes()
    {
        return $this->hasMany(\Modules\Materiais\App\Models\MaterialMovimentacao::class);
    }

    public function ordensServico()
    {
        return $this->belongsToMany(\Modules\Ordens\App\Models\OrdemServico::class, 'ordem_servico_materiais')
            ->withPivot('quantidade', 'valor_unitario')
            ->withTimestamps();
    }

    public function subcategoria()
    {
        return $this->belongsTo(SubcategoriaMaterial::class, 'subcategoria_id');
    }

    public function ncm()
    {
        return $this->belongsTo(Ncm::class, 'ncm_id');
    }

    public function categoria()
    {
        return $this->hasOneThrough(
            CategoriaMaterial::class,
            SubcategoriaMaterial::class,
            'id',
            'id',
            'subcategoria_id',
            'categoria_id'
        );
    }

    // Scopes
    public function scopeBaixoEstoque($query)
    {
        return $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }


    public function scopeComEstoque($query)
    {
        return $query->where('quantidade_estoque', '>', 0);
    }

    public function scopeSemEstoque($query)
    {
        return $query->where('quantidade_estoque', '<=', 0);
    }

    // Métodos auxiliares
    /**
     * Verifica se o material está com estoque baixo
     */
    public function estaComEstoqueBaixo(): bool
    {
        return $this->quantidade_estoque <= $this->quantidade_minima;
    }

    /**
     * Verifica se há estoque suficiente para uma quantidade
     */
    public function temEstoqueSuficiente(float $quantidade): bool
    {
        return $this->quantidade_estoque >= $quantidade;
    }

    /**
     * Calcula o estoque disponível (quantidade_estoque já descontando reservas)
     * Como as reservas já decrementam quantidade_estoque, o estoque disponível é simplesmente quantidade_estoque
     */
    public function getEstoqueDisponivelAttribute(): float
    {
        return max(0, $this->quantidade_estoque);
    }

    /**
     * Verifica se há estoque suficiente para uma reserva
     * Considera que quantidade_estoque já reflete o estoque disponível (já descontando reservas)
     */
    public function temEstoqueSuficienteParaReserva(float $quantidade): bool
    {
        return $this->quantidade_estoque >= $quantidade;
    }

    /**
     * Retorna o valor total do estoque
     */
    public function getValorTotalEstoqueAttribute(): float
    {
        if (!$this->valor_unitario) {
            return 0;
        }
        return $this->quantidade_estoque * $this->valor_unitario;
    }

    /**
     * Retorna o percentual de estoque em relação ao mínimo
     */
    public function getPercentualEstoqueAttribute(): float
    {
        if ($this->quantidade_minima <= 0) {
            return $this->quantidade_estoque > 0 ? 100 : 0;
        }
        return min(($this->quantidade_estoque / $this->quantidade_minima) * 100, 100);
    }


    /**
     * Retorna a categoria formatada
     */
    public function getCategoriaFormatadaAttribute(): string
    {
        if ($this->subcategoria) {
            return $this->subcategoria->nome;
        }

        // Fallback caso não tenha subcategoria (não deveria acontecer após migração)
        return $this->categoria ? ucfirst(str_replace('_', ' ', $this->categoria)) : 'Sem categoria';
    }

    /**
     * Retorna os campos específicos da categoria
     */
    public function getCamposEspecificosAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    /**
     * Define os campos específicos da categoria
     */
    public function setCamposEspecificosAttribute($value)
    {
        $this->attributes['campos_especificos'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Adiciona quantidade ao estoque e registra movimentação
     */
    public function adicionarEstoque(float $quantidade, string $motivo, ?int $ordemServicoId = null, ?float $valorUnitario = null, ?int $funcionarioId = null): MaterialMovimentacao
    {
        DB::beginTransaction();
        try {
            // Lock the record for update to prevent race conditions
            $material = Material::lockForUpdate()->find($this->id);

            $material->increment('quantidade_estoque', $quantidade);

            $movimentacao = MaterialMovimentacao::create([
                'material_id' => $material->id,
                'tipo' => 'entrada',
                'status' => 'confirmado',
                'quantidade' => $quantidade,
                'valor_unitario' => $valorUnitario ?? $material->valor_unitario,
                'motivo' => $motivo,
                'ordem_servico_id' => $ordemServicoId,
                'user_id' => auth()->id(),
                'funcionario_id' => $funcionarioId,
            ]);

            // Atualiza a instância atual para refletir o novo estoque
            $this->quantidade_estoque = $material->quantidade_estoque;

            DB::commit();
            return $movimentacao;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove quantidade do estoque e registra movimentação
     */
    public function removerEstoque(float $quantidade, string $motivo, ?int $ordemServicoId = null, ?float $valorUnitario = null, ?int $funcionarioId = null): MaterialMovimentacao
    {
        DB::beginTransaction();
        try {
            // Lock the record for update to prevent race conditions
            $material = Material::lockForUpdate()->find($this->id);

            if (!$material->temEstoqueSuficiente($quantidade)) {
                throw new \Exception("Estoque insuficiente. Disponível: {$material->quantidade_estoque}, Solicitado: {$quantidade}");
            }

            $material->decrement('quantidade_estoque', $quantidade);

            $movimentacao = MaterialMovimentacao::create([
                'material_id' => $material->id,
                'tipo' => 'saida',
                'status' => 'confirmado',
                'quantidade' => $quantidade,
                'valor_unitario' => $valorUnitario ?? $material->valor_unitario,
                'motivo' => $motivo,
                'ordem_servico_id' => $ordemServicoId,
                'user_id' => auth()->id(),
                'funcionario_id' => $funcionarioId,
            ]);

            // Atualiza a instância atual
            $this->quantidade_estoque = $material->quantidade_estoque;

            DB::commit();
            return $movimentacao;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reserva quantidade do estoque (diminui estoque disponível, mas pode ser cancelada)
     */
    public function reservarEstoque(float $quantidade, int $ordemServicoId, string $motivo, ?float $valorUnitario = null, ?int $funcionarioId = null): MaterialMovimentacao
    {
        DB::beginTransaction();
        try {
            // Lock the record for update
            $material = Material::lockForUpdate()->find($this->id);

            if (!$material->temEstoqueSuficiente($quantidade)) {
                throw new \Exception("Estoque insuficiente. Disponível: {$material->quantidade_estoque}, Solicitado: {$quantidade}");
            }

            $material->decrement('quantidade_estoque', $quantidade);

            $movimentacao = MaterialMovimentacao::create([
                'material_id' => $material->id,
                'tipo' => 'saida',
                'status' => 'reservado',
                'quantidade' => $quantidade,
                'valor_unitario' => $valorUnitario ?? $material->valor_unitario,
                'motivo' => $motivo,
                'ordem_servico_id' => $ordemServicoId,
                'user_id' => auth()->id(),
                'funcionario_id' => $funcionarioId,
            ]);

            // Atualiza a instância atual
            $this->quantidade_estoque = $material->quantidade_estoque;

            DB::commit();
            return $movimentacao;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Confirma reserva (converte reserva em saída definitiva)
     */
    public function confirmarReserva(int $ordemServicoId): void
    {
        DB::beginTransaction();
        try {
            // Lock just to be safe
            $material = Material::lockForUpdate()->find($this->id);

            $reservas = MaterialMovimentacao::where('material_id', $material->id)
                ->where('ordem_servico_id', $ordemServicoId)
                ->where('status', 'reservado')
                ->where('tipo', 'saida')
                ->get();

            foreach ($reservas as $reserva) {
                $reserva->update(['status' => 'confirmado']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Cancela reserva (restaura estoque)
     */
    public function cancelarReserva(int $ordemServicoId): void
    {
        DB::beginTransaction();
        try {
            $material = Material::lockForUpdate()->find($this->id);

            $reservas = MaterialMovimentacao::where('material_id', $material->id)
                ->where('ordem_servico_id', $ordemServicoId)
                ->where('status', 'reservado')
                ->where('tipo', 'saida')
                ->get();

            foreach ($reservas as $reserva) {
                $material->increment('quantidade_estoque', $reserva->quantidade);
                $reserva->update(['status' => 'cancelado']);
            }

            // Atualiza a instância atual
            $this->quantidade_estoque = $material->quantidade_estoque;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Retorna estatísticas do material
     */
    public function getEstatisticasAttribute(): array
    {
        $entradas = $this->movimentacoes()->where('tipo', 'entrada')->sum('quantidade');
        $saidas = $this->movimentacoes()->where('tipo', 'saida')->sum('quantidade');
        $totalOS = $this->ordensServico()->count();

        return [
            'entradas_total' => $entradas,
            'saidas_total' => $saidas,
            'saldo_atual' => $this->quantidade_estoque,
            'total_os' => $totalOS,
            'valor_total_estoque' => $this->valor_total_estoque,
            'percentual_estoque' => $this->percentual_estoque,
            'estoque_baixo' => $this->estaComEstoqueBaixo(),
        ];
    }

    /**
     * Verifica se o material pode ser deletado
     */
    public function podeSerDeletado(): bool
    {
        return $this->ordensServico()->count() === 0 && $this->movimentacoes()->count() === 0;
    }
}
