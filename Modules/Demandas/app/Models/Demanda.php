<?php

namespace Modules\Demandas\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Traits\GeneratesCode;
use App\Traits\HasHistory;

class Demanda extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode, HasHistory;

    protected $fillable = [
        'codigo',
        'solicitante_nome',
        'solicitante_apelido', // Apelido do solicitante (importante para localização)
        'solicitante_telefone',
        'solicitante_email',
        'localidade_id',
        'pessoa_id', // Pessoa do CadÚnico (opcional)
        'poco_id', // Poço relacionado (opcional, quando tipo é 'poco')
        'tipo', // agua, luz, estrada, poco
        'prioridade', // baixa, media, alta, urgente
        'motivo',
        'descricao',
        'status', // aberta, em_andamento, concluida, cancelada
        'fotos',
        'user_id', // quem abriu
        'data_abertura',
        'data_conclusao',
        'observacoes',
        'total_interessados', // Contador de pessoas interessadas/afetadas
        'score_similaridade_max', // Maior score de similaridade encontrado
        'palavras_chave', // Cache de palavras-chave para busca rápida
    ];

    protected $casts = [
        'fotos' => 'array',
        'data_abertura' => 'datetime',
        'data_conclusao' => 'datetime',
        'total_interessados' => 'integer',
        'score_similaridade_max' => 'decimal:2',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(\Modules\Pessoas\App\Models\PessoaCad::class, 'pessoa_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ordemServico()
    {
        return $this->hasOne(\Modules\Ordens\App\Models\OrdemServico::class);
    }

    public function poco()
    {
        return $this->belongsTo(\Modules\Pocos\App\Models\Poco::class);
    }

    /**
     * Interessados/afetados vinculados a esta demanda
     */
    public function interessados()
    {
        return $this->hasMany(DemandaInteressado::class);
    }

    /**
     * Interessados que desejam ser notificados
     */
    public function interessadosNotificaveis()
    {
        return $this->hasMany(DemandaInteressado::class)->where('notificar', true);
    }

    // Accessors
    public function getStatusTextoAttribute()
    {
        $status = [
            'aberta' => 'Aberta',
            'em_andamento' => 'Em Andamento',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getStatusCorAttribute()
    {
        $cores = [
            'aberta' => 'info',
            'em_andamento' => 'warning',
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

    /**
     * Retorna texto formatado do total de interessados
     */
    public function getTotalInteressadosTextoAttribute(): string
    {
        $total = $this->total_interessados ?? 1;

        if ($total === 1) {
            return '1 pessoa afetada';
        }

        return "{$total} pessoas afetadas";
    }

    /**
     * Verifica se a demanda tem múltiplos interessados
     */
    public function getTemMultiplosInteressadosAttribute(): bool
    {
        return ($this->total_interessados ?? 1) > 1;
    }

    /**
     * Retorna a lista de emails de todos os interessados para notificação
     */
    public function getEmailsInteressadosAttribute(): array
    {
        $emails = [];

        // Email do solicitante original
        if ($this->solicitante_email) {
            $emails[] = $this->solicitante_email;
        }

        // Emails dos interessados vinculados
        $this->interessadosNotificaveis->each(function($interessado) use (&$emails) {
            if ($interessado->email && !in_array($interessado->email, $emails)) {
                $emails[] = $interessado->email;
            }
        });

        return $emails;
    }

    public function getTipoTextoAttribute()
    {
        $tipos = [
            'agua' => 'Água',
            'luz' => 'Iluminação',
            'estrada' => 'Estrada',
            'poco' => 'Poço',
        ];
        return $tipos[$this->tipo] ?? ucfirst($this->tipo);
    }

    // Scopes
    public function scopeAbertas($query)
    {
        return $query->where('status', 'aberta');
    }

    public function scopeEmAndamento($query)
    {
        return $query->where('status', 'em_andamento');
    }

    public function scopeConcluidas($query)
    {
        return $query->where('status', 'concluida');
    }

    public function scopeUrgentes($query)
    {
        return $query->where('prioridade', 'urgente');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Métodos auxiliares
    public function podeCriarOS()
    {
        return in_array($this->status, ['aberta', 'em_andamento']) && !$this->ordemServico;
    }

    public function temOS()
    {
        return $this->ordemServico !== null;
    }

    public function podeConcluir()
    {
        return in_array($this->status, ['aberta', 'em_andamento']);
    }

    public function podeCancelar()
    {
        return in_array($this->status, ['aberta', 'em_andamento']);
    }

    /**
     * Verifica se uma pessoa já está vinculada como interessada
     */
    public function pessoaJaVinculada(?int $pessoaId = null, ?string $cpf = null, ?string $email = null): bool
    {
        if (!$pessoaId && !$cpf && !$email) {
            return false;
        }

        return $this->interessados()
            ->where(function($query) use ($pessoaId, $cpf, $email) {
                if ($pessoaId) {
                    $query->where('pessoa_id', $pessoaId);
                }
                if ($cpf) {
                    $query->orWhere('cpf', $cpf);
                }
                if ($email) {
                    $query->orWhere('email', $email);
                }
            })
            ->exists();
    }

    /**
     * Adiciona o solicitante original como primeiro interessado
     */
    public function criarInteressadoOriginal(): ?DemandaInteressado
    {
        // Verificar se já existe
        if ($this->interessados()->where('metodo_vinculo', 'solicitante_original')->exists()) {
            return null;
        }

        return DemandaInteressado::create([
            'demanda_id' => $this->id,
            'pessoa_id' => $this->pessoa_id,
            'nome' => $this->solicitante_nome,
            'apelido' => $this->solicitante_apelido,
            'telefone' => $this->solicitante_telefone,
            'email' => $this->solicitante_email,
            'user_id' => $this->user_id,
            'ip_address' => request()->ip(),
            'notificar' => true,
            'confirmado' => true,
            'metodo_vinculo' => 'solicitante_original',
            'data_vinculo' => $this->data_abertura ?? now(),
        ]);
    }

    /**
     * Recalcula o total de interessados
     */
    public function recalcularTotalInteressados(): int
    {
        $total = $this->interessados()->count();

        // Mínimo 1 (o solicitante original)
        $total = max(1, $total);

        $this->update(['total_interessados' => $total]);

        return $total;
    }

    public function diasAberta()
    {
        if (!$this->data_abertura) {
            return null;
        }

        // Garantir que a data de abertura não seja no futuro
        if ($this->data_abertura->isFuture()) {
            return 0;
        }

        // Calcular diferença em dias completos (sem decimais)
        // diffInDays com false retorna apenas dias completos, sem considerar horas
        $dias = now()->startOfDay()->diffInDays($this->data_abertura->startOfDay(), false);

        // Se for negativo (data no futuro), retornar 0
        return max(0, (int) $dias);
    }

    /**
     * Retorna dados públicos da demanda (LGPD compliant)
     * Remove informações sensíveis para consulta pública
     */
    public function toPublicArray(): array
    {
        return [
            'id' => $this->id,
            'codigo' => $this->codigo,
            'status' => $this->status,
            'status_texto' => $this->status_texto,
            'prioridade' => $this->prioridade,
            'prioridade_texto' => $this->prioridade_texto,
            'tipo' => $this->tipo,
            'tipo_texto' => $this->tipo_texto,
            'motivo' => $this->motivo,
            'descricao' => $this->descricao,
            'data_abertura' => $this->data_abertura ? $this->data_abertura->format('d/m/Y H:i') : null,
            'data_conclusao' => $this->data_conclusao ? $this->data_conclusao->format('d/m/Y H:i') : null,
            'dias_aberta' => $this->diasAberta(),
            'tem_os' => $this->temOS(),
            'localidade' => $this->localidade ? [
                'id' => $this->localidade->id,
                'nome' => $this->localidade->nome,
                'codigo' => $this->localidade->codigo,
            ] : null,
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }

    /**
     * Verifica se a demanda pode ser consultada publicamente
     */
    public function podeSerConsultadaPublicamente(): bool
    {
        // A demanda sempre pode ser consultada se tiver código
        return !empty($this->codigo);
    }

    /**
     * Obtém dados da OS para exibição pública (sem dados sensíveis)
     */
    public function getOrdemServicoPublica(): ?array
    {
        if (!$this->ordemServico) {
            return null;
        }

        $os = $this->ordemServico;

        return [
            'numero' => $os->numero,
            'status' => $os->status,
            'status_texto' => $os->status_texto,
            'data_inicio' => $os->data_inicio ? $os->data_inicio->format('d/m/Y H:i') : null,
            'data_conclusao' => $os->data_conclusao ? $os->data_conclusao->format('d/m/Y H:i') : null,
            'tempo_execucao_formatado' => $os->tempo_execucao_formatado,
            'relatorio_execucao' => $os->relatorio_execucao,
            'fotos_antes' => $os->fotos_antes,
            'fotos_depois' => $os->fotos_depois,
            'equipe' => $os->equipe ? [
                'id' => $os->equipe->id,
                'nome' => $os->equipe->nome,
            ] : null,
        ];
    }
}

