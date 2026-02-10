<?php

namespace Modules\Funcionarios\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Funcionarios\App\Services\FuncionarioStatusService;
use Illuminate\Support\Facades\DB;

class FuncionarioStatusAdminController extends Controller
{
    protected $statusService;

    public function __construct(FuncionarioStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Painel de monitoramento em tempo real
     */
    public function index()
    {
        $estatisticas = $this->statusService->getEstatisticas();

        $orderBy = "CASE status_campo
            WHEN 'em_atendimento' THEN 1
            WHEN 'disponivel' THEN 2
            WHEN 'pausado' THEN 3
            WHEN 'offline' THEN 4
            ELSE 5
        END";

        $funcionarios = Funcionario::where('ativo', true)
            ->with(['ordemServicoAtual.demanda.localidade', 'equipes'])
            ->orderByRaw($orderBy)
            ->orderBy('nome')
            ->get();

        // Determinar qual view usar baseado na rota atual
        $routePrefix = request()->route()->getPrefix();

        if (str_contains($routePrefix, 'co-admin')) {
            return view('funcionarios::co-admin.status.index', compact('estatisticas', 'funcionarios'));
        }

        return view('funcionarios::admin.status.index', compact('estatisticas', 'funcionarios'));
    }

    /**
     * API para atualização em tempo real (AJAX)
     */
    public function atualizar()
    {
        $estatisticas = $this->statusService->getEstatisticas();
        $funcionariosEmAtendimento = $this->statusService->getFuncionariosEmAtendimento();

        $orderBy = "CASE status_campo
            WHEN 'em_atendimento' THEN 1
            WHEN 'disponivel' THEN 2
            WHEN 'pausado' THEN 3
            WHEN 'offline' THEN 4
            ELSE 5
        END";

        $funcionarios = Funcionario::where('ativo', true)
            ->with(['ordemServicoAtual.demanda.localidade'])
            ->orderByRaw($orderBy)
            ->orderBy('nome')
            ->get()
            ->map(function($f) {
                return [
                    'id' => $f->id,
                    'nome' => $f->nome,
                    'funcao' => $f->funcao,
                    'status_campo' => $f->status_campo,
                    'status_campo_texto' => $f->status_campo_texto,
                    'status_campo_cor' => $f->status_campo_cor,
                    'ordem_atual' => $f->ordemServicoAtual ? [
                        'id' => $f->ordemServicoAtual->id,
                        'numero' => $f->ordemServicoAtual->numero,
                        'tipo_servico' => $f->ordemServicoAtual->tipo_servico,
                        'localidade' => $f->ordemServicoAtual->demanda->localidade->nome ?? 'N/A',
                    ] : null,
                    'tempo_atendimento' => $f->tempo_atendimento,
                    'iniciado_em' => $f->atendimento_iniciado_em?->format('d/m/Y H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'estatisticas' => $estatisticas,
            'funcionarios' => $funcionarios,
            'funcionarios_em_atendimento' => $funcionariosEmAtendimento,
            'timestamp' => now()->format('H:i:s'),
        ]);
    }

    /**
     * Força liberação de funcionário (Admin)
     */
    public function forcarLiberacao(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        $resultado = $this->statusService->forcarLiberacao($id, $request->motivo);

        if ($resultado['success']) {
            return redirect()
                ->route('admin.funcionarios.status.index')
                ->with('success', $resultado['message']);
        }

        return redirect()
            ->back()
            ->with('error', $resultado['message']);
    }

    /**
     * Atualiza status do funcionário manualmente
     */
    public function atualizarStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disponivel,pausado,offline',
        ]);

        $resultado = $this->statusService->atualizarStatus($id, $request->status);

        return response()->json($resultado);
    }

    /**
     * Detalhes do funcionário em atendimento
     */
    public function detalhes($id)
    {
        $funcionario = Funcionario::with([
            'ordemServicoAtual.demanda.localidade',
            'ordemServicoAtual.materiais.material',
            'equipes'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'funcionario' => [
                'id' => $funcionario->id,
                'codigo' => $funcionario->codigo,
                'nome' => $funcionario->nome,
                'funcao' => $funcionario->funcao_formatada,
                'email' => $funcionario->email,
                'telefone' => $funcionario->telefone,
                'status' => $funcionario->status_campo_texto,
                'status_cor' => $funcionario->status_campo_cor,
                'tempo_atendimento' => $funcionario->tempo_atendimento,
                'ordem_atual' => $funcionario->ordemServicoAtual ? [
                    'id' => $funcionario->ordemServicoAtual->id,
                    'numero' => $funcionario->ordemServicoAtual->numero,
                    'tipo_servico' => $funcionario->ordemServicoAtual->tipo_servico,
                    'descricao' => $funcionario->ordemServicoAtual->descricao,
                    'localidade' => $funcionario->ordemServicoAtual->demanda->localidade->nome ?? 'N/A',
                    'prioridade' => $funcionario->ordemServicoAtual->prioridade_texto,
                    'materiais_count' => $funcionario->ordemServicoAtual->materiais->count(),
                    'iniciado_em' => $funcionario->ordemServicoAtual->data_inicio?->format('d/m/Y H:i'),
                ] : null,
                'equipes' => $funcionario->equipes->map(function($e) {
                    return [
                        'id' => $e->id,
                        'nome' => $e->nome,
                    ];
                }),
            ],
        ]);
    }
}
