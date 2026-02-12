<?php

namespace Modules\Pessoas\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * @property int $created_by
 * @property int $updated_by
 */
class PessoaCad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pessoas_cad';

    // Desabilitar timestamps pois a tabela não tem created_at e updated_at
    public $timestamps = false;

    protected $fillable = [
        'cd_ibge',
        'cod_familiar_fam',
        'nom_pessoa',
        'num_nis_pessoa_atual',
        'nom_apelido_pessoa',
        'cod_sexo_pessoa',
        'dta_nasc_pessoa',
        'nom_completo_mae_pessoa',
        'nom_completo_pai_pessoa',
        'num_cpf_pessoa',
        'ref_cad',
        'ref_pbf',
        'localidade_id',
        'ativo',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'cd_ibge' => 'integer',
        'ref_cad' => 'integer',
        'ref_pbf' => 'integer',
        'dta_nasc_pessoa' => 'date',
        'cod_sexo_pessoa' => 'integer',
    ];

    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(\Modules\Localidades\App\Models\Localidade::class);
    }

    public function familia()
    {
        return $this->where('cod_familiar_fam', $this->cod_familiar_fam)
            ->where('id', '!=', $this->id);
    }

    public function demandas()
    {
        return $this->hasMany(\Modules\Demandas\App\Models\Demanda::class, 'pessoa_id');
    }

    public function liderComunidade()
    {
        return $this->hasOne(\Modules\Pocos\App\Models\LiderComunidade::class, 'pessoa_id');
    }

    public function cadastroCaf()
    {
        return $this->hasOne(\Modules\CAF\App\Models\CadastroCAF::class, 'pessoa_id');
    }

    public function beneficiarios()
    {
        return $this->hasMany(\Modules\ProgramasAgricultura\App\Models\Beneficiario::class, 'pessoa_id');
    }

    // Relacionamentos de auditoria
    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    // Accessors
    public function getDataNascimentoAttribute()
    {
        if ($this->dta_nasc_pessoa instanceof \DateTime || $this->dta_nasc_pessoa instanceof Carbon) {
            return $this->dta_nasc_pessoa instanceof Carbon
                ? $this->dta_nasc_pessoa
                : Carbon::instance($this->dta_nasc_pessoa);
        }

        if (!$this->dta_nasc_pessoa) {
            return null;
        }

        $data = trim((string) $this->dta_nasc_pessoa);

        try {
            if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $data, $matches)) {
                $ano = (int) $matches[1];
                $mes = (int) $matches[2];
                $dia = (int) $matches[3];

                if ($dia > 0 && $mes > 0 && $ano > 0 && checkdate($mes, $dia, $ano)) {
                    return Carbon::create($ano, $mes, $dia);
                }
            }

            if (preg_match('/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/', $data, $matches)) {
                $dia = (int) $matches[1];
                $mes = (int) $matches[2];
                $ano = (int) $matches[3];

                if ($dia > 0 && $mes > 0 && $ano > 0 && checkdate($mes, $dia, $ano)) {
                    return Carbon::create($ano, $mes, $dia);
                }
            }

            if (preg_match('/^(\d{2})[\/\-](\d{2})[\/\-](\d{2})$/', $data, $matches)) {
                $dia = (int) $matches[1];
                $mes = (int) $matches[2];
                $ano = (int) $matches[3];

                if ($ano < 50) {
                    $ano = 2000 + $ano;
                } else {
                    $ano = 1900 + $ano;
                }

                if ($dia > 0 && $mes > 0 && $ano > 0 && checkdate($mes, $dia, $ano)) {
                    return Carbon::create($ano, $mes, $dia);
                }
            }

            $dataSemBarras = str_replace(['/', '-', ' '], '', $data);
            $tamanho = strlen($dataSemBarras);

            if ($tamanho == 6) {
                $dia = (int) substr($dataSemBarras, 0, 2);
                $mes = (int) substr($dataSemBarras, 2, 2);
                $ano = (int) substr($dataSemBarras, 4, 2);

                if ($ano < 50) {
                    $ano = 2000 + $ano;
                } else {
                    $ano = 1900 + $ano;
                }

                if ($dia > 0 && $mes > 0 && $ano > 0 && checkdate($mes, $dia, $ano)) {
                    return Carbon::create($ano, $mes, $dia);
                }
            } elseif ($tamanho == 8) {
                $dia = (int) substr($dataSemBarras, 0, 2);
                $mes = (int) substr($dataSemBarras, 2, 2);
                $ano = (int) substr($dataSemBarras, 4, 4);

                if ($dia > 0 && $mes > 0 && $ano > 0 && checkdate($mes, $dia, $ano)) {
                    return Carbon::create($ano, $mes, $dia);
                }
            } elseif ($tamanho == 8 && preg_match('/^\d{8}$/', $dataSemBarras)) {
                $ano = (int) substr($dataSemBarras, 0, 4);
                $mes = (int) substr($dataSemBarras, 4, 2);
                $dia = (int) substr($dataSemBarras, 6, 2);

                if ($dia > 0 && $mes > 0 && $ano > 0 && checkdate($mes, $dia, $ano)) {
                    return Carbon::create($ano, $mes, $dia);
                }
            }
        } catch (\Exception $e) {
            logger()->error('Erro ao parsear data de nascimento: ' . $e->getMessage() . ' - Data: ' . $data);
            return null;
        }

        return null;
    }

    public function getIdadeAttribute()
    {
        $dataNasc = $this->data_nascimento;
        return $dataNasc ? $dataNasc->age : null;
    }

    public function getSexoTextoAttribute()
    {
        $codigo = (int) $this->cod_sexo_pessoa;

        return match($codigo) {
            1 => 'Masculino',
            2 => 'Feminino',
            default => 'Não informado'
        };
    }

    public function getSexoCorAttribute()
    {
        $codigo = (int) $this->cod_sexo_pessoa;

        return match($codigo) {
            1 => 'primary',
            2 => 'danger',
            default => 'secondary'
        };
    }

    public function getRecebePbfAttribute()
    {
        return !empty($this->ref_pbf) && $this->ref_pbf > 0;
    }

    public function getCpfFormatadoAttribute()
    {
        if (!$this->num_cpf_pessoa || strlen($this->num_cpf_pessoa) != 11) {
            return $this->num_cpf_pessoa;
        }

        return substr($this->num_cpf_pessoa, 0, 3) . '.' .
               substr($this->num_cpf_pessoa, 3, 3) . '.' .
               substr($this->num_cpf_pessoa, 6, 3) . '-' .
               substr($this->num_cpf_pessoa, 9, 2);
    }

    public function getNisFormatadoAttribute()
    {
        if (!$this->num_nis_pessoa_atual || strlen($this->num_nis_pessoa_atual) != 11) {
            return $this->num_nis_pessoa_atual;
        }

        return substr($this->num_nis_pessoa_atual, 0, 3) . '.' .
               substr($this->num_nis_pessoa_atual, 3, 5) . '.' .
               substr($this->num_nis_pessoa_atual, 8, 2) . '-' .
               substr($this->num_nis_pessoa_atual, 10, 1);
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeBeneficiariasPbf($query)
    {
        return $query->whereNotNull('ref_pbf')->where('ref_pbf', '>', 0);
    }

    public function scopePorLocalidade($query, $localidadeId)
    {
        return $query->where('localidade_id', $localidadeId);
    }

    public function scopePorFamilia($query, $codFamiliar)
    {
        return $query->where('cod_familiar_fam', $codFamiliar);
    }

    public function scopePorIbge($query, $cdIbge)
    {
        return $query->where('cd_ibge', $cdIbge);
    }

    // Métodos estáticos para estatísticas
    public static function totalPorLocalidade($localidadeId)
    {
        return self::where('localidade_id', $localidadeId)
            ->where('ativo', true)
            ->count();
    }

    public static function beneficiariasPbfPorLocalidade($localidadeId)
    {
        return self::where('localidade_id', $localidadeId)
            ->whereNotNull('ref_pbf')
            ->where('ref_pbf', '>', 0)
            ->where('ativo', true)
            ->count();
    }
}
