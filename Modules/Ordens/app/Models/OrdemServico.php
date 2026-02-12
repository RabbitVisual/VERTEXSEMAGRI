<?php

namespace Modules\Ordens\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Traits\GeneratesCode;
use App\Traits\HasHistory;

/**
 * @property float $total
 * @property string $data
 * @property-read \Modules\Demandas\App\Models\Demanda $demanda
 */
class OrdemServico extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode, HasHistory;

    protected $table = 'ordens_servico';

    /**
     * Campo usado para código gerado (a tabela usa 'numero', não 'codigo')
     */
    protected static string $codeField = 'numero';

    protected $fillable = [
        'numero',
        'demanda_id',
        'equipe_id',
        'funcionario_id',
        'user_id_atribuido',
        'tipo_servico',
        'descricao',
        'prioridade',
        'status', // pendente, em_execucao, concluida, cancelada
        'data_abertura',
        'data_inicio',
        'data_conclusao',
        'tempo_execucao',
        'fotos_antes',
        'fotos_depois',
        'relatorio_execucao',
        'observacoes',
        'user_id_abertura',
        'user_id_execucao',
        'sem_material', // Indica se o serviço foi realizado sem uso de materiais
    ];

    protected $casts = [
        'fotos_antes' => 'array',
        'fotos_depois' => 'array',
        'data_abertura' => 'datetime',
        'data_inicio' => 'datetime',
        'data_conclusao' => 'datetime',
        'tempo_execucao' => 'integer', // em minutos
        'sem_material' => 'boolean',
    ];

    // Relacionamentos
    public function demanda()
    {
        return $this->belongsTo(\Modules\Demandas\App\Models\Demanda::class);
    }

    public function equipe()
    {
        return $this->belongsTo(\Modules\Equipes\App\Models\Equipe::class);
    }

    public function usuarioAbertura()
    {
        return $this->belongsTo(User::class, 'user_id_abertura');
    }

    public function usuarioExecucao()
    {
        return $this->belongsTo(User::class, 'user_id_execucao');
    }

    public function funcionario()
    {
        return $this->belongsTo(\Modules\Funcionarios\App\Models\Funcionario::class, 'funcionario_id');
    }

    public function usuarioAtribuido()
    {
        return $this->belongsTo(User::class, 'user_id_atribuido');
    }

    public function materiais()
    {
        return $this->hasMany(\Modules\Ordens\App\Models\OrdemServicoMaterial::class);
    }

    /**
     * Retorna o total de materiais utilizados na ordem
     */
    public function getTotalMateriaisAttribute(): int
    {
        return $this->materiais()->count();
    }

    /**
     * Retorna o valor total dos materiais utilizados
     */
    public function getValorTotalMateriaisAttribute(): float
    {
        return $this->materiais()->get()->sum(function($item) {
            return $item->quantidade * ($item->valor_unitario ?? 0);
        });
    }

    /**
     * Retorna o custo total da ordem de serviço (alias para uso em relatórios/auditoria)
     */
    public function getCustoTotalAttribute(): float
    {
        // Futuramente pode incluir mão de obra, deslocamento, etc.
        return $this->valor_total_materiais;
    }

    /**
     * Verifica se a ordem tem materiais
     */
    public function temMateriais(): bool
    {
        return $this->materiais()->count() > 0;
    }

    // Relacionamentos dinâmicos com infraestrutura baseado no tipo da demanda
    public function poco()
    {
        if ($this->demanda && $this->demanda->tipo === 'poco' && $this->demanda->localidade_id) {
            return \Modules\Pocos\App\Models\Poco::where('localidade_id', $this->demanda->localidade_id)
                ->where('status', 'ativo')
                ->first();
        }
        return null;
    }

    public function redeAgua()
    {
        if ($this->demanda && $this->demanda->tipo === 'agua' && $this->demanda->localidade_id) {
            return \Modules\Agua\App\Models\RedeAgua::where('localidade_id', $this->demanda->localidade_id)
                ->where('status', 'funcionando')
                ->first();
        }
        return null;
    }

    // Accessors
    public function getStatusTextoAttribute()
    {
        $status = [
            'pendente' => 'Pendente',
            'em_execucao' => 'Em Execução',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getStatusCorAttribute()
    {
        $cores = [
            'pendente' => 'warning',
            'em_execucao' => 'info',
            'concluida' => 'success',
            'cancelada' => 'danger',
        ];
        return $cores[$this->status] ?? 'secondary';
    }

    public function getPrioridadeTextoAttribute()
    {
        $prioridade = [
            'baixa' => 'Baixa',
            'media' => 'Média',
            'alta' => 'Alta',
            'urgente' => 'Urgente',
        ];
        return $prioridade[$this->prioridade] ?? $this->prioridade;
    }

    public function getPrioridadeCorAttribute()
    {
        $cores = [
            'baixa' => 'secondary',
            'media' => 'info',
            'alta' => 'warning',
            'urgente' => 'danger',
        ];
        return $cores[$this->prioridade] ?? 'secondary';
    }

    public function getTempoExecucaoFormatadoAttribute()
    {
        if (!$this->tempo_execucao || $this->tempo_execucao <= 0) {
            // Calcular dinamicamente se não houver valor salvo
            if ($this->data_inicio && $this->data_conclusao) {
                $minutos = abs($this->data_inicio->diffInMinutes($this->data_conclusao));
                if ($minutos > 0) {
                    $horas = floor($minutos / 60);
                    $mins = $minutos % 60;
                    return $horas > 0 ? "{$horas}h {$mins}min" : "{$mins}min";
                }
            }
            return null;
        }

        // Garantir valor positivo
        $tempoMinutos = abs($this->tempo_execucao);
        $horas = floor($tempoMinutos / 60);
        $minutos = $tempoMinutos % 60;

        if ($horas > 0) {
            return "{$horas}h {$minutos}min";
        }
        return "{$minutos}min";
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeEmExecucao($query)
    {
        return $query->where('status', 'em_execucao');
    }

    public function scopeConcluidas($query)
    {
        return $query->where('status', 'concluida');
    }

    public function scopeUrgentes($query)
    {
        return $query->where('prioridade', 'urgente');
    }

    public function scopePorEquipe($query, $equipeId)
    {
        return $query->where('equipe_id', $equipeId);
    }

    public function scopePorFuncionario($query, $funcionarioId)
    {
        return $query->where('funcionario_id', $funcionarioId);
    }

    /**
     * Scope para buscar ordens da equipe do funcionário (seja atribuída diretamente ou da equipe)
     * GARANTE PRIVACIDADE: Apenas mostra ordens que o funcionário tem permissão de ver
     */
    public function scopeMinhasOrdens($query, $userId)
    {
        // Buscar equipes que o usuário pertence (via equipe_membros)
        $equipeIds = DB::table('equipe_membros')
            ->where('user_id', $userId)
            ->pluck('equipe_id')
            ->toArray();

        // Buscar funcionário do usuário (via email)
        $user = User::find($userId);
        $funcionarioId = null;
        if ($user && $user->email) {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();
            if ($funcionario) {
                $funcionarioId = $funcionario->id;
                // Buscar também equipes do funcionário
                $funcionarioEquipeIds = DB::table('equipe_funcionarios')
                    ->where('funcionario_id', $funcionarioId)
                    ->pluck('equipe_id')
                    ->toArray();
                $equipeIds = array_unique(array_merge($equipeIds, $funcionarioEquipeIds));
            }
        }

        // Se não encontrou nenhuma equipe e nenhum funcionário, retornar query vazia (segurança)
        if (empty($equipeIds) && !$funcionarioId && !$userId) {
            return $query->whereRaw('1 = 0'); // Query que retorna nada
        }

        return $query->where(function($q) use ($equipeIds, $userId, $funcionarioId) {
            // Ordens da equipe do usuário/funcionário
            if (!empty($equipeIds)) {
                $q->whereIn('equipe_id', $equipeIds);
            }

            // OU ordens atribuídas diretamente ao usuário (user_id_atribuido)
            if ($userId) {
                if (!empty($equipeIds)) {
                    $q->orWhere('user_id_atribuido', $userId);
                } else {
                    $q->where('user_id_atribuido', $userId);
                }
            }

            // OU ordens atribuídas ao funcionário do usuário (funcionario_id)
            if ($funcionarioId) {
                if (!empty($equipeIds) || $userId) {
                    $q->orWhere('funcionario_id', $funcionarioId);
                } else {
                    $q->where('funcionario_id', $funcionarioId);
                }
            }

            // OU ordens que o usuário está executando (user_id_execucao)
            if ($userId) {
                $q->orWhere('user_id_execucao', $userId);
            }
        });
    }

    // Métodos auxiliares
    public function podeIniciar()
    {
        return $this->status === 'pendente' && $this->equipe_id !== null;
    }

    public function podeConcluir()
    {
        // Deve estar em execução
        if ($this->status !== 'em_execucao') {
            return false;
        }

        // Deve ter data de início
        if (!$this->data_inicio) {
            return false;
        }

        // Deve ter equipe atribuída
        if (!$this->equipe_id) {
            return false;
        }

        return true;
    }

    public function podeCancelar()
    {
        return in_array($this->status, ['pendente', 'em_execucao']);
    }

    /**
     * Verifica se a ordem está atribuída a um funcionário específico
     */
    public function estaAtribuidaA($funcionarioId): bool
    {
        return $this->funcionario_id === $funcionarioId;
    }

    /**
     * Verifica se a ordem está atribuída a um usuário específico
     */
    public function estaAtribuidaAoUsuario($userId): bool
    {
        return $this->user_id_atribuido === $userId;
    }

    /**
     * Verifica se o usuário pode acessar esta ordem (pertence à equipe ou está atribuída a ele)
     * GARANTE PRIVACIDADE: Apenas permite acesso se o usuário tem relação com a ordem
     */
    public function usuarioPodeAcessar($userId): bool
    {
        // Se está atribuída diretamente ao usuário (user_id_atribuido)
        if ($this->user_id_atribuido === $userId) {
            return true;
        }

        // Se o usuário está executando a ordem (user_id_execucao)
        if ($this->user_id_execucao === $userId) {
            return true;
        }

        // Verificar se usuário pertence à equipe
        $equipeIds = DB::table('equipe_membros')
            ->where('user_id', $userId)
            ->pluck('equipe_id');

        if ($equipeIds->contains($this->equipe_id)) {
            return true;
        }

        // Verificar se funcionário do usuário está na equipe ou atribuído
        $user = User::find($userId);
        if ($user && $user->email) {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();
            if ($funcionario) {
                // Verificar se funcionário está atribuído diretamente à ordem
                if ($this->funcionario_id === $funcionario->id) {
                    return true;
                }

                // Verificar se funcionário pertence à equipe da ordem
                $funcionarioEquipeIds = DB::table('equipe_funcionarios')
                    ->where('funcionario_id', $funcionario->id)
                    ->pluck('equipe_id');

                if ($funcionarioEquipeIds->contains($this->equipe_id)) {
                    return true;
                }
            }
        }

        return false;
    }

    // Gerar número automaticamente se não fornecido
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ordem) {
            if (empty($ordem->numero)) {
                $ordem->numero = OrdemServico::generateCode('OS', $ordem->tipo_servico ?? null);
            }
        });
    }
}
