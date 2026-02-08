<?php

namespace Modules\ProgramasAgricultura\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;
use App\Traits\HasHistory;
use Carbon\Carbon;

class Evento extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode, HasHistory;

    protected $fillable = [
        'codigo',
        'titulo',
        'descricao',
        'tipo',
        'data_inicio',
        'data_fim',
        'hora_inicio',
        'hora_fim',
        'localidade_id',
        'endereco',
        'latitude',
        'longitude',
        'vagas_totais',
        'vagas_preenchidas',
        'status',
        'publico_alvo',
        'conteudo_programatico',
        'instrutor_palestrante',
        'materiais_necessarios',
        'publico',
        'inscricao_aberta',
        'data_limite_inscricao',
        'observacoes',
        'user_id_criador',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'data_limite_inscricao' => 'date',
        'hora_inicio' => 'datetime',
        'hora_fim' => 'datetime',
        'vagas_totais' => 'integer',
        'vagas_preenchidas' => 'integer',
        'publico' => 'boolean',
        'inscricao_aberta' => 'boolean',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    public function inscricoes()
    {
        return $this->hasMany(InscricaoEvento::class);
    }

    public function inscricoesConfirmadas()
    {
        return $this->hasMany(InscricaoEvento::class)
            ->whereIn('status', ['inscrito', 'confirmado', 'presente']);
    }

    public function usuarioCriador()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id_criador');
    }

    // Accessors
    public function getTipoTextoAttribute(): string
    {
        $tipos = [
            'capacitacao' => 'Capacitação',
            'palestra' => 'Palestra',
            'feira' => 'Feira',
            'dia_campo' => 'Dia de Campo',
            'visita_tecnica' => 'Visita Técnica',
            'reuniao' => 'Reunião',
            'outro' => 'Outro',
        ];

        return $tipos[$this->tipo] ?? ucfirst(str_replace('_', ' ', $this->tipo));
    }

    public function getStatusTextoAttribute(): string
    {
        $status = [
            'agendado' => 'Agendado',
            'em_andamento' => 'Em Andamento',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
        ];

        return $status[$this->status] ?? ucfirst($this->status);
    }

    public function getVagasRestantesAttribute(): ?int
    {
        if ($this->vagas_totais === null) {
            return null;
        }

        return max(0, $this->vagas_totais - $this->vagas_preenchidas);
    }

    public function getTemVagasAttribute(): bool
    {
        if ($this->vagas_totais === null) {
            return true;
        }

        return $this->vagas_restantes > 0;
    }

    public function getPodeInscreverAttribute(): bool
    {
        if (!$this->publico || !$this->inscricao_aberta) {
            return false;
        }

        if ($this->status === 'cancelado' || $this->status === 'concluido') {
            return false;
        }

        if ($this->data_limite_inscricao && $this->data_limite_inscricao->isPast()) {
            return false;
        }

        if (!$this->tem_vagas) {
            return false;
        }

        return true;
    }

    public function getDataHoraInicioAttribute(): ?Carbon
    {
        if (!$this->data_inicio) {
            return null;
        }

        $data = Carbon::instance($this->data_inicio);
        
        if ($this->hora_inicio) {
            $hora = Carbon::parse($this->hora_inicio);
            $data->setTime($hora->hour, $hora->minute, $hora->second);
        }

        return $data;
    }

    public function getDataHoraFimAttribute(): ?Carbon
    {
        $dataFim = $this->data_fim ?? $this->data_inicio;
        
        if (!$dataFim) {
            return null;
        }

        $data = Carbon::instance($dataFim);
        
        if ($this->hora_fim) {
            $hora = Carbon::parse($this->hora_fim);
            $data->setTime($hora->hour, $hora->minute, $hora->second);
        }

        return $data;
    }

    // Scopes
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    public function scopeInscricaoAberta($query)
    {
        return $query->where('inscricao_aberta', true);
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeProximos($query, int $dias = 30)
    {
        $hoje = now()->startOfDay();
        $limite = now()->addDays($dias)->endOfDay();
        
        return $query->where('data_inicio', '>=', $hoje)
            ->where('data_inicio', '<=', $limite)
            ->where('status', '!=', 'cancelado');
    }

    public function scopeDisponiveis($query)
    {
        $hoje = now()->startOfDay();
        
        return $query->where('publico', true)
            ->where('inscricao_aberta', true)
            ->where('status', '!=', 'cancelado')
            ->where(function($q) use ($hoje) {
                $q->whereNull('data_limite_inscricao')
                  ->orWhere('data_limite_inscricao', '>=', $hoje);
            })
            ->where(function($q) {
                $q->whereNull('vagas_totais')
                  ->orWhereRaw('vagas_totais > vagas_preenchidas');
            });
    }
}

