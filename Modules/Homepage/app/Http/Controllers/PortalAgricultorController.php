<?php

namespace Modules\Homepage\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Localidades\App\Models\Localidade;

class PortalAgricultorController extends Controller
{
    /**
     * Verifica se o módulo ProgramasAgricultura está ativo
     */
    private function isModuleEnabled(): bool
    {
        return Module::isEnabled('ProgramasAgricultura') && class_exists(\Modules\ProgramasAgricultura\App\Models\Programa::class);
    }

    /**
     * Exibe a página principal do Portal do Agricultor
     */
    public function index()
    {
        if (!$this->isModuleEnabled()) {
            return view('homepage::public.portal-agricultor-desativado');
        }

        $Programa = \Modules\ProgramasAgricultura\App\Models\Programa::class;
        $Evento = \Modules\ProgramasAgricultura\App\Models\Evento::class;
        $Beneficiario = \Modules\ProgramasAgricultura\App\Models\Beneficiario::class;

        // Programas ativos e públicos
        $programas = $Programa::publicos()
            ->disponiveis()
            ->orderBy('nome')
            ->limit(6)
            ->get();

        // Próximos eventos
        $eventos = $Evento::publicos()
            ->disponiveis()
            ->orderBy('data_inicio')
            ->limit(6)
            ->get();

        // Estatísticas públicas
        $estatisticas = [
            'total_programas_ativos' => $Programa::publicos()->disponiveis()->count(),
            'total_eventos_proximos' => $Evento::publicos()->proximos(30)->count(),
            'total_beneficiarios' => $Beneficiario::ativos()->count(),
        ];

        return view('homepage::public.portal-agricultor', compact('programas', 'eventos', 'estatisticas'));
    }

    /**
     * Consulta de programas e benefícios por CPF
     */
    public function consultar(Request $request)
    {
        if (!$this->isModuleEnabled()) {
            return back()->withErrors(['cpf' => 'O módulo de Programas de Agricultura está temporariamente desativado.'])->withInput();
        }

        $Beneficiario = \Modules\ProgramasAgricultura\App\Models\Beneficiario::class;
        $InscricaoEvento = \Modules\ProgramasAgricultura\App\Models\InscricaoEvento::class;

        $validator = Validator::make($request->all(), [
            'cpf' => ['required', 'string', 'regex:/^[\d\.\-\s]+$/'],
        ], [
            'cpf.required' => 'Por favor, informe o CPF.',
            'cpf.regex' => 'CPF inválido. Use apenas números, pontos e traços.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cpfLimpo = preg_replace('/[^0-9]/', '', $request->cpf);

        if (strlen($cpfLimpo) != 11) {
            return back()->withErrors(['cpf' => 'CPF deve conter 11 dígitos.'])->withInput();
        }

        // Log de acesso (LGPD)
        $this->logPublicAccess('consulta_cpf', null, $request->ip(), [
            'cpf_consultado' => substr($cpfLimpo, 0, 3) . '.***.***-**' // Mascarado
        ]);

        try {
            // Buscar pessoa no cadastro
            $pessoa = PessoaCad::where('num_cpf_pessoa', $cpfLimpo)
                ->where('ativo', true)
                ->first();

            // Buscar beneficiários (com ou sem pessoa cadastrada)
            $beneficiarios = $Beneficiario::where('cpf', $cpfLimpo)
                ->orWhereHas('pessoa', function($q) use ($cpfLimpo) {
                    $q->where('num_cpf_pessoa', $cpfLimpo);
                })
                ->with(['programa', 'localidade'])
                ->orderBy('data_inscricao', 'desc')
                ->get();

            // Buscar inscrições em eventos
            $inscricoesEventos = $InscricaoEvento::where('cpf', $cpfLimpo)
                ->orWhereHas('pessoa', function($q) use ($cpfLimpo) {
                    $q->where('num_cpf_pessoa', $cpfLimpo);
                })
                ->with(['evento', 'localidade'])
                ->orderBy('data_inscricao', 'desc')
                ->get();

            return view('homepage::public.portal-agricultor-resultado', compact(
                'pessoa',
                'beneficiarios',
                'inscricoesEventos',
                'cpfLimpo'
            ));
        } catch (\Exception $e) {
            Log::channel('public_access')->error('Erro ao consultar CPF no Portal do Agricultor', [
                'cpf' => substr($cpfLimpo, 0, 3) . '.***',
                'ip' => $request->ip(),
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['cpf' => 'Ocorreu um erro ao consultar. Tente novamente mais tarde.'])->withInput();
        }
    }

    /**
     * Lista todos os programas disponíveis
     */
    public function programas()
    {
        if (!$this->isModuleEnabled()) {
            abort(503, 'O módulo de Programas de Agricultura está temporariamente desativado.');
        }

        $Programa = \Modules\ProgramasAgricultura\App\Models\Programa::class;
        $programas = $Programa::publicos()
            ->disponiveis()
            ->orderBy('nome')
            ->paginate(12);

        return view('homepage::public.portal-agricultor-programas', compact('programas'));
    }

    /**
     * Detalhes de um programa específico
     */
    public function programa($id)
    {
        if (!$this->isModuleEnabled()) {
            abort(503, 'O módulo de Programas de Agricultura está temporariamente desativado.');
        }

        $Programa = \Modules\ProgramasAgricultura\App\Models\Programa::class;
        $programa = $Programa::publicos()->findOrFail($id);

        return view('homepage::public.portal-agricultor-programa', compact('programa'));
    }

    /**
     * Lista todos os eventos disponíveis
     */
    public function eventos()
    {
        if (!$this->isModuleEnabled()) {
            abort(503, 'O módulo de Programas de Agricultura está temporariamente desativado.');
        }

        $Evento = \Modules\ProgramasAgricultura\App\Models\Evento::class;
        $eventos = $Evento::publicos()
            ->disponiveis()
            ->orderBy('data_inicio')
            ->paginate(12);

        return view('homepage::public.portal-agricultor-eventos', compact('eventos'));
    }

    /**
     * Detalhes de um evento específico
     */
    public function evento($id)
    {
        if (!$this->isModuleEnabled()) {
            abort(503, 'O módulo de Programas de Agricultura está temporariamente desativado.');
        }

        $Evento = \Modules\ProgramasAgricultura\App\Models\Evento::class;
        $evento = $Evento::publicos()->findOrFail($id);

        return view('homepage::public.portal-agricultor-evento', compact('evento'));
    }

    /**
     * Calendário de eventos
     */
    public function calendario()
    {
        if (!$this->isModuleEnabled()) {
            abort(503, 'O módulo de Programas de Agricultura está temporariamente desativado.');
        }

        $Evento = \Modules\ProgramasAgricultura\App\Models\Evento::class;
        $eventos = $Evento::publicos()
            ->proximos(90)
            ->orderBy('data_inicio')
            ->get()
            ->groupBy(function($evento) {
                return $evento->data_inicio->format('Y-m');
            });

        return view('homepage::public.portal-agricultor-calendario', compact('eventos'));
    }

    /**
     * API para dados públicos de programas
     */
    public function apiProgramas()
    {
        if (!$this->isModuleEnabled()) {
            return response()->json(['error' => 'Módulo desativado.'], 503);
        }

        try {
            $Programa = \Modules\ProgramasAgricultura\App\Models\Programa::class;
            $programas = $Programa::publicos()
                ->disponiveis()
                ->select([
                    'id',
                    'codigo',
                    'nome',
                    'tipo',
                    'status',
                    'vagas_disponiveis',
                    'vagas_preenchidas',
                    'data_inicio',
                    'data_fim'
                ])
                ->get()
                ->map(function($programa) {
                    return [
                        'id' => $programa->id,
                        'codigo' => $programa->codigo,
                        'nome' => $programa->nome,
                        'tipo' => $programa->tipo_texto,
                        'status' => $programa->status_texto,
                        'vagas_restantes' => $programa->vagas_restantes,
                        'tem_vagas' => $programa->tem_vagas,
                    ];
                });

            return response()->json($programas);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar programas para API pública: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao carregar programas.'], 500);
        }
    }

    /**
     * API para dados públicos de eventos
     */
    public function apiEventos()
    {
        if (!$this->isModuleEnabled()) {
            return response()->json(['error' => 'Módulo desativado.'], 503);
        }

        try {
            $Evento = \Modules\ProgramasAgricultura\App\Models\Evento::class;
            $eventos = $Evento::publicos()
                ->disponiveis()
                ->select([
                    'id',
                    'codigo',
                    'titulo',
                    'tipo',
                    'data_inicio',
                    'data_fim',
                    'hora_inicio',
                    'hora_fim',
                    'localidade_id',
                    'endereco',
                    'vagas_totais',
                    'vagas_preenchidas',
                    'status'
                ])
                ->with('localidade:id,nome')
                ->get()
                ->map(function($evento) {
                    return [
                        'id' => $evento->id,
                        'codigo' => $evento->codigo,
                        'titulo' => $evento->titulo,
                        'tipo' => $evento->tipo_texto,
                        'data_inicio' => $evento->data_inicio->format('d/m/Y'),
                        'hora_inicio' => $evento->hora_inicio ? $evento->hora_inicio->format('H:i') : null,
                        'localidade' => $evento->localidade ? $evento->localidade->nome : null,
                        'endereco' => $evento->endereco,
                        'vagas_restantes' => $evento->vagas_restantes,
                        'pode_inscrever' => $evento->pode_inscrever,
                    ];
                });

            return response()->json($eventos);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar eventos para API pública: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao carregar eventos.'], 500);
        }
    }

    /**
     * Log de acesso público (LGPD)
     */
    private function logPublicAccess(string $acao, ?int $registroId, string $ip, array $dadosAdicionais = [])
    {
        Log::channel('public_access')->info('Portal do Agricultor - Acesso público', [
            'acao' => $acao,
            'registro_id' => $registroId,
            'ip' => $ip,
            'timestamp' => now()->toIso8601String(),
            'dados' => $dadosAdicionais,
        ]);
    }
}

