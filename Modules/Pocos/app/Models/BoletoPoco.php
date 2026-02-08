<?php

namespace Modules\Pocos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BoletoPoco extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'boletos_poco';

    protected $fillable = [
        'codigo_barras',
        'numero_boleto',
        'mensalidade_id',
        'usuario_poco_id',
        'poco_id',
        'valor',
        'data_vencimento',
        'data_emissao',
        'status',
        'caminho_pdf',
        'numero_parcela',
        'instrucoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_emissao' => 'date',
        'status' => 'string',
        'numero_parcela' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($boleto) {
            if (empty($boleto->numero_boleto)) {
                $boleto->numero_boleto = self::gerarNumeroBoleto();
            }
            if (empty($boleto->codigo_barras)) {
                $boleto->codigo_barras = self::gerarCodigoBarras();
            }
            if (empty($boleto->data_emissao)) {
                $boleto->data_emissao = now();
            }
        });
    }

    // Relacionamentos
    public function mensalidade()
    {
        return $this->belongsTo(MensalidadePoco::class, 'mensalidade_id');
    }

    public function usuarioPoco()
    {
        return $this->belongsTo(UsuarioPoco::class, 'usuario_poco_id');
    }

    public function solicitacoesBaixa()
    {
        return $this->hasMany(SolicitacaoBaixaPoco::class, 'boleto_poco_id');
    }

    public function poco()
    {
        return $this->belongsTo(Poco::class);
    }

    // Accessors
    public function getStatusTextoAttribute(): string
    {
        $status = [
            'aberto' => 'Aberto',
            'pago' => 'Pago',
            'vencido' => 'Vencido',
            'cancelado' => 'Cancelado',
        ];
        return $status[$this->status] ?? $this->status;
    }

    public function getEstaVencidoAttribute(): bool
    {
        return $this->data_vencimento->isPast() && $this->status === 'aberto';
    }

    public function getDiasVencidoAttribute(): ?int
    {
        if (!$this->esta_vencido) {
            return null;
        }
        return now()->diffInDays($this->data_vencimento);
    }

    // Métodos auxiliares
    public static function gerarNumeroBoleto(): string
    {
        do {
            $numero = 'POCO' . str_pad(rand(1, 999999), 10, '0', STR_PAD_LEFT);
        } while (self::where('numero_boleto', $numero)->exists());

        return $numero;
    }

    public static function gerarCodigoBarras(): string
    {
        do {
            // Gerar código de barras de 20 dígitos usando random_int para evitar problemas com números grandes
            $codigo = '';
            for ($i = 0; $i < 20; $i++) {
                $codigo .= random_int(0, 9);
            }
        } while (self::where('codigo_barras', $codigo)->exists());

        return $codigo;
    }

    public function marcarComoPago()
    {
        $this->update(['status' => 'pago']);
    }

    public function marcarComoVencido()
    {
        if ($this->status === 'aberto' && $this->data_vencimento->isPast()) {
            $this->update(['status' => 'vencido']);
        }
    }

    // Scopes
    public function scopeAbertos($query)
    {
        return $query->where('status', 'aberto');
    }

    public function scopePagos($query)
    {
        return $query->where('status', 'pago');
    }

    public function scopeVencidos($query)
    {
        return $query->where('status', 'vencido')
            ->orWhere(function($q) {
                $q->where('status', 'aberto')
                  ->where('data_vencimento', '<', now());
            });
    }

    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_poco_id', $usuarioId);
    }

    public function scopePorMensalidade($query, $mensalidadeId)
    {
        return $query->where('mensalidade_id', $mensalidadeId);
    }
}

