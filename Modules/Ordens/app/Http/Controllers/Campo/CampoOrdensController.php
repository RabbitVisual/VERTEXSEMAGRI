<?php

namespace Modules\Ordens\App\Http\Controllers\Campo;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Ordens\App\Services\CampoOrdensService;
use Modules\Ordens\App\Services\FotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampoOrdensController extends Controller
{
    use ChecksModuleEnabled;

    protected $campoOrdensService;
    protected $fotoService;
    protected $statusService;

    public function __construct(
        CampoOrdensService $campoOrdensService,
        FotoService $fotoService,
        \Modules\Funcionarios\App\Services\FuncionarioStatusService $statusService = null
    ) {
        $this->ensureModuleEnabled('Ordens');
        $this->campoOrdensService = $campoOrdensService;
        $this->fotoService = $fotoService;
        $this->statusService = $statusService ?? app(\Modules\Funcionarios\App\Services\FuncionarioStatusService::class);
        // Middlewares já aplicados nas rotas em routes/campo.php
    }

    /**
     * Lista ordens do funcionário
     */
    public function index(Request $request)
    {
        $filtros = $request->only(['status', 'prioridade', 'search']);

        $ordens = $this->campoOrdensService->buscarOrdensDoFuncionario(Auth::user(), $filtros)
            ->paginate(15);

        return view('campo.ordens.index', compact('ordens', 'filtros'));
    }

    /**
     * Exibe detalhes de uma ordem
     */
    public function show($id)
    {
        $ordem = OrdemServico::with([
            'demanda.localidade',
            'demanda.pessoa',
            'equipe',
            'funcionario',
            'usuarioAtribuido',
            'usuarioExecucao',
            'materiais.material'
        ])->findOrFail($id);

        // Recarregar a ordem para garantir que está atualizada (evitar cache)
        $ordem->refresh();

        // Verificar se usuário pode acessar
        if (!$ordem->usuarioPodeAcessar(Auth::id())) {
            abort(403, 'Você não tem permissão para acessar esta ordem.');
        }

        // Preparar dados para view
        $fotosAntes = $ordem->fotos_antes ?? [];
        $fotosDepois = $ordem->fotos_depois ?? [];

        // Converter paths para URLs públicas (usando asset() para URLs relativas)
        $fotosAntesUrls = array_map(function($path) {
            return asset('storage/' . $path);
        }, $fotosAntes);

        $fotosDepoisUrls = array_map(function($path) {
            return asset('storage/' . $path);
        }, $fotosDepois);

        // Carregar histórico de auditoria se disponível
        $historico = [];
        if (method_exists($ordem, 'getHistory')) {
            $historico = $ordem->getHistory(20);
        }

        return view('campo.ordens.show', compact(
            'ordem',
            'fotosAntesUrls',
            'fotosDepoisUrls',
            'historico'
        ));
    }

    /**
     * Inicia atendimento de uma ordem
     */
    public function iniciar($id)
    {
        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->usuarioPodeAcessar(Auth::id())) {
            return redirect()->route('campo.ordens.index')
                ->with('error', 'Você não tem permissão para acessar esta ordem.');
        }

        if ($this->campoOrdensService->iniciarAtendimento($ordem, Auth::user())) {
            return redirect()->route('campo.ordens.show', $ordem)
                ->with('success', 'Atendimento iniciado com sucesso.');
        }

        return redirect()->route('campo.ordens.show', $ordem)
            ->with('error', 'Não foi possível iniciar o atendimento. Verifique se a ordem está pendente.');
    }

    /**
     * Upload de fotos antes/depois
     */
    public function uploadFotos(Request $request, $id)
    {
        $request->validate([
            'fotos' => 'required|array|max:10',
            'fotos.*' => 'image|max:5120', // 5MB
            'tipo' => 'required|in:antes,depois',
        ]);

        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->usuarioPodeAcessar(Auth::id())) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        if ($ordem->status !== 'em_execucao') {
            return response()->json(['error' => 'Ordem deve estar em execução'], 400);
        }

        $fotos = $this->fotoService->uploadFotos($request->file('fotos'), $ordem->id, $request->tipo);

        // Adicionar novas fotos às existentes
        $campoFotos = $request->tipo === 'antes' ? 'fotos_antes' : 'fotos_depois';
        $fotosExistentes = $ordem->$campoFotos ?? [];
        $todasFotos = array_merge($fotosExistentes, $fotos);

        $ordem->update([$campoFotos => $todasFotos]);

        return response()->json([
            'success' => true,
            'fotos' => array_map(function($path) {
                return asset('storage/' . $path);
            }, $fotos),
            'message' => count($fotos) . ' foto(s) enviada(s) com sucesso.'
        ]);
    }

    /**
     * Remove uma foto
     */
    public function removerFoto(Request $request, $id)
    {
        $request->validate([
            'path' => 'required|string',
            'tipo' => 'required|in:antes,depois',
        ]);

        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->usuarioPodeAcessar(Auth::id())) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        $campoFotos = $request->tipo === 'antes' ? 'fotos_antes' : 'fotos_depois';
        $fotos = $ordem->$campoFotos ?? [];

        // Remover foto do array
        $fotos = array_filter($fotos, function($path) use ($request) {
            return $path !== $request->path;
        });

        // Remover do storage
        $this->fotoService->removerFotos([$request->path]);

        $ordem->update([$campoFotos => array_values($fotos)]);

        return response()->json(['success' => true, 'message' => 'Foto removida com sucesso.']);
    }

    /**
     * Atualiza relatório de execução
     */
    public function atualizarRelatorio(Request $request, $id)
    {
        $request->validate([
            'relatorio_execucao' => 'required|string|min:10',
        ]);

        $ordem = OrdemServico::findOrFail($id);

        if ($this->campoOrdensService->atualizarRelatorio($ordem, Auth::user(), $request->relatorio_execucao)) {
            return response()->json([
                'success' => true,
                'message' => 'Relatório atualizado com sucesso.'
            ]);
        }

        return response()->json(['error' => 'Não foi possível atualizar o relatório.'], 400);
    }

    /**
     * Adiciona material utilizado
     */
    public function adicionarMaterial(Request $request, $id)
    {
        $request->validate([
            'material_id' => 'required|exists:materiais,id',
            'quantidade' => 'required|numeric|min:0.01',
        ]);

        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->usuarioPodeAcessar(Auth::id())) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        if ($ordem->status !== 'em_execucao') {
            return response()->json(['error' => 'Ordem deve estar em execução'], 400);
        }

        // Buscar material
        $material = \Modules\Materiais\App\Models\Material::findOrFail($request->material_id);

        // Verificar estoque
        if (!$material->temEstoqueSuficiente($request->quantidade)) {
            return response()->json([
                'error' => 'Estoque insuficiente. Disponível: ' . $material->quantidade_estoque . ' ' . $material->unidade_medida
            ], 400);
        }

        // Identificar funcionário a partir do usuário autenticado
        $funcionarioId = null;
        $user = Auth::user();
        if ($user && $user->email) {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();
            if ($funcionario) {
                $funcionarioId = $funcionario->id;
            }
        }

        try {
            // Adicionar material à ordem
            $ordemMaterial = \Modules\Ordens\App\Models\OrdemServicoMaterial::create([
                'ordem_servico_id' => $ordem->id,
                'material_id' => $request->material_id,
                'quantidade' => $request->quantidade,
                'valor_unitario' => $material->valor_unitario ?? 0,
                'status_reserva' => 'reservado',
            ]);

            // RESERVAR estoque (não baixar definitivamente ainda)
            $material->reservarEstoque(
                $request->quantidade,
                $ordem->id,
                "Reserva para ordem de serviço #{$ordem->numero}",
                $material->valor_unitario,
                $funcionarioId
            );

            // Recarregar o material com relacionamento
            $ordemMaterial->load('material');

            return response()->json([
                'success' => true,
                'message' => 'Material reservado com sucesso. A baixa definitiva acontecerá ao concluir a OS.',
                'material' => [
                    'id' => $ordemMaterial->material_id,
                    'nome' => $material->nome,
                    'codigo' => $material->codigo,
                    'quantidade' => $ordemMaterial->quantidade,
                    'unidade_medida' => $material->unidade_medida,
                    'valor_unitario' => $ordemMaterial->valor_unitario,
                    'valor_total' => ($ordemMaterial->valor_unitario ?? 0) * $ordemMaterial->quantidade,
                    'status_reserva' => $ordemMaterial->status_reserva,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao adicionar material: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove material utilizado
     */
    public function removerMaterial(Request $request, $id, $materialId)
    {
        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->usuarioPodeAcessar(Auth::id())) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        if ($ordem->status !== 'em_execucao') {
            return response()->json(['error' => 'Ordem deve estar em execução'], 400);
        }

        $ordemMaterial = \Modules\Ordens\App\Models\OrdemServicoMaterial::where('ordem_servico_id', $ordem->id)
            ->where('material_id', $materialId)
            ->first();

        if (!$ordemMaterial) {
            return response()->json([
                'error' => 'Material não encontrado nesta ordem de serviço.'
            ], 404);
        }

        $quantidade = $ordemMaterial->quantidade;
        $material = $ordemMaterial->material;

        if (!$material) {
            return response()->json([
                'error' => 'Material não encontrado no sistema.'
            ], 404);
        }

        // Identificar funcionário a partir do usuário autenticado
        $funcionarioId = null;
        $user = Auth::user();
        if ($user && $user->email) {
            $funcionario = \Modules\Funcionarios\App\Models\Funcionario::where('email', $user->email)->first();
            if ($funcionario) {
                $funcionarioId = $funcionario->id;
            }
        }

        try {
            // Remover material da ordem
            $ordemMaterial->delete();

            // Cancelar reserva (restaura estoque)
            $material->cancelarReserva($ordem->id);

            return response()->json([
                'success' => true,
                'message' => 'Material removido e reserva cancelada. O estoque foi restaurado.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao remover material: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marca ordem como "sem necessidade de material"
     */
    public function semMaterial(Request $request, $id)
    {
        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->usuarioPodeAcessar(Auth::id())) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        if ($ordem->status !== 'em_execucao') {
            return response()->json(['error' => 'Ordem deve estar em execução'], 400);
        }

        $semMaterial = $request->boolean('sem_material');

        $ordem->update(['sem_material' => $semMaterial]);

        return response()->json([
            'success' => true,
            'sem_material' => $semMaterial,
            'message' => $semMaterial ? 'Marcado como serviço sem material' : 'Desmarcado serviço sem material'
        ]);
    }

    /**
     * Conclui atendimento
     */
    public function concluir(Request $request, $id)
    {
        $request->validate([
            'relatorio_execucao' => 'required|string|min:10',
            'observacoes' => 'nullable|string|max:1000',
            'fotos_depois.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $ordem = OrdemServico::findOrFail($id);

        // Processar fotos DEPOIS enviadas no formulário de conclusão
        if ($request->hasFile('fotos_depois')) {
            $fotosDepois = $ordem->fotos_depois ?? [];

            foreach ($request->file('fotos_depois') as $foto) {
                $path = $foto->store('ordens/' . $ordem->id . '/depois', 'public');
                $fotosDepois[] = $path;
            }

            $ordem->update(['fotos_depois' => $fotosDepois]);
        }

        if ($this->campoOrdensService->concluirAtendimento($ordem, Auth::user(), [
            'relatorio_execucao' => $request->relatorio_execucao,
            'observacoes' => $request->observacoes,
        ])) {
            return redirect()->route('campo.ordens.index')
                ->with('success', 'Ordem de serviço concluída com sucesso!');
        }

        return redirect()->route('campo.ordens.show', $ordem)
            ->with('error', 'Não foi possível concluir a ordem. Verifique se está em execução e o relatório foi preenchido.');
    }
}

