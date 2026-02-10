<?php

namespace Modules\Demandas\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\Demandas\App\Models\Demanda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class PublicDemandaController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Demandas');
    }
    /**
     * Exibe a página de consulta pública
     */
    public function index()
    {
        // Registrar acesso à página de consulta (LGPD - apenas estatísticas)
        $this->logPublicAccess('consulta_page', null, request()->ip());
        
        return view('demandas::public.consulta');
    }

    /**
     * Busca e exibe a demanda pelo código/protocolo
     */
    public function consultar(Request $request)
    {
        if ($request->has('codigo')) { $request->merge(['codigo' => strtoupper(trim($request->codigo))]); }

        $request->validate([
            'codigo' => 'required|string|max:50|regex:/^[A-Z0-9\-]+$/',
        ], [
            'codigo.required' => 'Por favor, informe o código/protocolo da demanda.',
            'codigo.regex' => 'O código deve conter apenas letras maiúsculas, números e hífens.',
        ]);

        $codigo = strtoupper(trim($request->codigo));
        
        // Rate limiting para prevenir abuso
        $cacheKey = 'consulta_demanda_' . md5($codigo . request()->ip());
        $attempts = Cache::get($cacheKey, 0);
        
        if ($attempts >= 10) {
            Log::warning('Tentativas excessivas de consulta de demanda', [
                'codigo' => $codigo,
                'ip' => request()->ip(),
                'attempts' => $attempts
            ]);
            
            return redirect()
                ->route('demandas.public.consulta')
                ->with('error', 'Muitas tentativas. Por favor, aguarde alguns minutos antes de tentar novamente.')
                ->withInput();
        }
        
        Cache::put($cacheKey, $attempts + 1, now()->addMinutes(15));
        
        try {
            $demanda = Demanda::with([
                'localidade',
                'ordemServico.equipe',
                'ordemServico.usuarioAbertura',
                'ordemServico.usuarioExecucao',
                'ordemServico.funcionario',
                'pessoa' // Relacionamento com pessoa do CadÚnico
            ])
            ->where('codigo', $codigo)
            ->first();

            if (!$demanda) {
                // Registrar tentativa de consulta inválida (LGPD - sem dados pessoais)
                $this->logPublicAccess('consulta_invalida', null, request()->ip(), ['codigo' => $codigo]);
                
                return redirect()
                    ->route('demandas.public.consulta')
                    ->with('error', 'Demanda não encontrada. Verifique o código/protocolo informado.')
                    ->withInput();
            }

            // Registrar acesso válido (LGPD - apenas estatísticas)
            $this->logPublicAccess('consulta_valida', $demanda->id, request()->ip());

            // Carregar histórico de auditoria se disponível
            $historico = collect([]);
            if (method_exists($demanda, 'getHistory')) {
                $historico = $demanda->getHistory(20);
            }

            // Calcular estatísticas adicionais
            $estatisticas = [
                'dias_aberta' => $demanda->diasAberta(),
                'tem_os' => $demanda->temOS(),
                'pode_criar_os' => $demanda->podeCriarOS(),
                'pode_cancelar' => $demanda->podeCancelar(),
            ];

            return view('demandas::public.resultado', compact('demanda', 'historico', 'estatisticas'));
            
        } catch (\Exception $e) {
            Log::error('Erro ao consultar demanda pública', [
                'codigo' => $codigo,
                'ip' => request()->ip(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()
                ->route('demandas.public.consulta')
                ->with('error', 'Ocorreu um erro ao processar sua consulta. Por favor, tente novamente mais tarde.')
                ->withInput();
        }
    }

    /**
     * Exibe diretamente a demanda pelo código (para links diretos)
     */
    public function show($codigo)
    {
        $codigo = strtoupper(trim($codigo));
        
        // Validação básica do código
        if (!preg_match('/^[A-Z0-9\-]+$/', $codigo)) {
            return redirect()
                ->route('demandas.public.consulta')
                ->with('error', 'Código inválido.');
        }
        
        try {
            $demanda = Demanda::with([
                'localidade',
                'ordemServico.equipe',
                'ordemServico.usuarioAbertura',
                'ordemServico.usuarioExecucao',
                'ordemServico.funcionario',
                'pessoa'
            ])
            ->where('codigo', $codigo)
            ->first();

            if (!$demanda) {
                $this->logPublicAccess('consulta_invalida', null, request()->ip(), ['codigo' => $codigo]);
                
                return redirect()
                    ->route('demandas.public.consulta')
                    ->with('error', 'Demanda não encontrada. Verifique o código/protocolo informado.');
            }

            // Registrar acesso válido
            $this->logPublicAccess('consulta_valida', $demanda->id, request()->ip());

            // Carregar histórico
            $historico = collect([]);
            if (method_exists($demanda, 'getHistory')) {
                $historico = $demanda->getHistory(20);
            }

            // Estatísticas
            $estatisticas = [
                'dias_aberta' => $demanda->diasAberta(),
                'tem_os' => $demanda->temOS(),
                'pode_criar_os' => $demanda->podeCriarOS(),
                'pode_cancelar' => $demanda->podeCancelar(),
            ];

            return view('demandas::public.resultado', compact('demanda', 'historico', 'estatisticas'));
            
        } catch (\Exception $e) {
            Log::error('Erro ao exibir demanda pública', [
                'codigo' => $codigo,
                'ip' => request()->ip(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()
                ->route('demandas.public.consulta')
                ->with('error', 'Ocorreu um erro ao processar sua consulta. Por favor, tente novamente mais tarde.');
        }
    }

    /**
     * API endpoint para atualização em tempo real (polling)
     * Retorna apenas dados necessários para atualização sem expor dados sensíveis
     */
    public function status($codigo)
    {
        // Validar código diretamente (vem da URL)
        $codigo = strtoupper(trim($codigo));
        
        // Validação básica do formato
        if (!preg_match('/^[A-Z0-9\-]+$/', $codigo) || strlen($codigo) > 50) {
            return response()->json([
                'error' => 'Código inválido'
            ], 422);
        }
        
        try {
            $demanda = Demanda::with(['ordemServico'])
                ->where('codigo', $codigo)
                ->select([
                    'id',
                    'codigo',
                    'status',
                    'data_abertura',
                    'data_conclusao',
                    'updated_at'
                ])
                ->first();

            if (!$demanda) {
                return response()->json([
                    'error' => 'Demanda não encontrada'
                ], 404);
            }

            // Retornar apenas dados necessários para atualização (LGPD)
            return response()->json([
                'status' => $demanda->status,
                'status_texto' => $demanda->status_texto,
                'data_conclusao' => $demanda->data_conclusao ? $demanda->data_conclusao->format('d/m/Y H:i') : null,
                'tem_os' => $demanda->temOS(),
                'os_status' => $demanda->ordemServico ? $demanda->ordemServico->status : null,
                'os_status_texto' => $demanda->ordemServico ? ($demanda->ordemServico->status_texto ?? null) : null,
                'updated_at' => $demanda->updated_at->toIso8601String(),
                'dias_aberta' => $demanda->diasAberta(),
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar status da demanda', [
                'codigo' => $codigo,
                'ip' => request()->ip(),
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'error' => 'Erro ao processar solicitação'
            ], 500);
        }
    }

    /**
     * Registra acesso público (LGPD compliant - apenas estatísticas)
     */
    private function logPublicAccess(string $action, ?int $demandaId, string $ip, array $metadata = []): void
    {
        try {
            // Log apenas para auditoria e estatísticas, sem dados pessoais
            Log::channel('public_access')->info('Acesso público à consulta de demandas', [
                'action' => $action,
                'demanda_id' => $demandaId,
                'ip' => $ip,
                'user_agent' => substr(request()->userAgent(), 0, 200), // Limitar tamanho
                'timestamp' => now()->toIso8601String(),
                'metadata' => $metadata,
            ]);
        } catch (\Exception $e) {
            // Não falhar se o log não funcionar
            Log::warning('Erro ao registrar acesso público', ['error' => $e->getMessage()]);
        }
    }
}

