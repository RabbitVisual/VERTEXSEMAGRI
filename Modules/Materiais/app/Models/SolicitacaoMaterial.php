<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SolicitacaoMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'solicitacoes_materiais';

    protected $fillable = [
        'numero_oficio',
        'numero_sequencial',
        'ano',
        'cidade',
        'data',
        'secretario_nome',
        'secretario_cargo',
        'servidor_nome',
        'servidor_cargo',
        'servidor_telefone',
        'servidor_email',
        'materiais',
        'observacoes',
        'user_id',
        'hash_documento',
        'caminho_pdf',
    ];

    protected $casts = [
        'data' => 'date',
        'materiais' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopePorAno($query, $ano)
    {
        return $query->where('ano', $ano);
    }

    public function scopeRecentes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Métodos auxiliares
    public function getMateriaisFormatadosAttribute()
    {
        $materiais = [];
        foreach ($this->materiais as $item) {
            if ($item['is_customizado'] ?? false) {
                $materiais[] = [
                    'tipo' => 'customizado',
                    'nome' => $item['nome_customizado'],
                    'especificacao' => $item['especificacao_customizada'] ?? '',
                    'quantidade' => $item['quantidade'],
                    'unidade' => $item['unidade_medida_customizada'],
                    'justificativa' => $item['justificativa'],
                ];
            } else {
                $material = Material::find($item['material_id'] ?? null);
                if ($material) {
                    $materiais[] = [
                        'tipo' => 'sistema',
                        'material_id' => $material->id,
                        'nome' => $material->nome,
                        'codigo' => $material->codigo,
                        'categoria' => $material->categoria_formatada,
                        'quantidade' => $item['quantidade'],
                        'unidade' => $material->unidade_medida,
                        'justificativa' => $item['justificativa'],
                    ];
                }
            }
        }
        return $materiais;
    }

    /**
     * Gera o próximo número de ofício único
     */
    public static function gerarProximoNumero($ano = null)
    {
        $ano = $ano ?? date('Y');

        // Buscar o último número sequencial do ano
        $ultimaSolicitacao = self::where('ano', $ano)
            ->orderBy('numero_sequencial', 'desc')
            ->first();

        $proximoNumero = $ultimaSolicitacao ? $ultimaSolicitacao->numero_sequencial + 1 : 1;

        // Formatar número (ex: 001, 002, etc.)
        $numeroFormatado = str_pad($proximoNumero, 3, '0', STR_PAD_LEFT);

        return [
            'numero_sequencial' => $proximoNumero,
            'numero_oficio' => "{$numeroFormatado}/{$ano}-SI/SA",
            'ano' => $ano,
        ];
    }

    /**
     * Gera hash para garantir integridade do documento
     */
    public function gerarHash()
    {
        $dados = [
            'id' => $this->id ?? 0,
            'numero_oficio' => $this->numero_oficio,
            'data' => $this->data ? $this->data->format('Y-m-d') : now()->format('Y-m-d'),
            'materiais' => $this->materiais ?? [],
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
        ];

        return hash('sha256', json_encode($dados) . config('app.key'));
    }

    /**
     * Verifica integridade do documento
     */
    public function verificarIntegridade()
    {
        return $this->hash_documento === $this->gerarHash();
    }
}

