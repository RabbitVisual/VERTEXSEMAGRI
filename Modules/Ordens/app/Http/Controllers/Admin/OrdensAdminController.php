<?php

namespace Modules\Ordens\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Ordens\App\Services\CampoOrdensService;
use Modules\Materiais\App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrdensAdminController extends Controller
{
    protected $campoOrdensService;

    public function __construct(CampoOrdensService $campoOrdensService)
    {
        $this->campoOrdensService = $campoOrdensService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo', 'prioridade', 'equipe_id', 'search']);
        $query = OrdemServico::with(['demanda', 'equipe', 'usuarioAbertura', 'usuarioExecucao']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhereHas('demanda', function($q) use ($search) {
                      $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('solicitante_nome', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }

        if (!empty($filters['prioridade'])) {
            $query->where('prioridade', $filters['prioridade']);
        }

        if (!empty($filters['equipe_id'])) {
            $query->where('equipe_id', $filters['equipe_id']);
        }

        $ordens = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estatísticas
        $estatisticas = [
            'total' => OrdemServico::count(),
            'abertas' => OrdemServico::where('status', 'aberta')->count(),
            'em_andamento' => OrdemServico::where('status', 'em_andamento')->count(),
            'concluidas' => OrdemServico::where('status', 'concluida')->count(),
            'canceladas' => OrdemServico::where('status', 'cancelada')->count(),
        ];

        return view('ordens::admin.index', compact('ordens', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $ordem = OrdemServico::with([
            'demanda.localidade',
            'demanda.pessoa',
            'equipe',
            'usuarioAbertura',
            'usuarioExecucao',
            'materiais.material',
            'funcionario'
        ])->findOrFail($id);

        // Buscar materiais disponíveis
        $materiaisDisponiveis = Material::where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view('ordens::admin.show', compact('ordem', 'materiaisDisponiveis'));
    }

    /**
     * Adiciona material à OS (admin)
     */
    public function adicionarMaterial(Request $request, $id)
    {
        $request->validate([
            'material_id' => 'required|exists:materiais,id',
            'quantidade' => 'required|numeric|min:0.01',
        ]);

        $ordem = OrdemServico::findOrFail($id);

        if (!in_array($ordem->status, ['pendente', 'em_execucao'])) {
            return response()->json([
                'error' => 'Ordem deve estar pendente ou em execução'
            ], 400);
        }

        $material = Material::findOrFail($request->material_id);

        if (!$material->temEstoqueSuficiente($request->quantidade)) {
            return response()->json([
                'error' => 'Estoque insuficiente. Disponível: ' . $material->quantidade_estoque . ' ' . $material->unidade_medida
            ], 400);
        }

        try {
            // Se OS ainda não foi iniciada, iniciar automaticamente
            if ($ordem->status === 'pendente') {
                $ordem->update([
                    'status' => 'em_execucao',
                    'data_inicio' => now(),
                    'user_id_execucao' => Auth::id(),
                ]);
            }

            // Adicionar material à ordem
            \Modules\Ordens\App\Models\OrdemServicoMaterial::create([
                'ordem_servico_id' => $ordem->id,
                'material_id' => $request->material_id,
                'quantidade' => $request->quantidade,
                'valor_unitario' => $material->valor_unitario ?? 0,
                'status_reserva' => 'reservado',
            ]);

            // RESERVAR estoque
            $material->reservarEstoque(
                $request->quantidade,
                $ordem->id,
                "Reserva para ordem de serviço #{$ordem->numero} (Gerenciado por Admin)",
                $material->valor_unitario,
                $ordem->funcionario_id
            );

            return response()->json([
                'success' => true,
                'message' => 'Material reservado com sucesso. A baixa definitiva acontecerá ao concluir a OS.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao adicionar material: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove material da OS (admin)
     */
    public function removerMaterial(Request $request, $id, $materialId)
    {
        $ordem = OrdemServico::findOrFail($id);

        if (!in_array($ordem->status, ['pendente', 'em_execucao'])) {
            return response()->json([
                'error' => 'Ordem deve estar pendente ou em execução'
            ], 400);
        }

        $ordemMaterial = \Modules\Ordens\App\Models\OrdemServicoMaterial::where('ordem_servico_id', $ordem->id)
            ->where('material_id', $materialId)
            ->firstOrFail();

        $material = $ordemMaterial->material;

        try {
            $ordemMaterial->delete();

            // Cancelar reserva (restaura estoque)
            if ($material) {
                $material->cancelarReserva($ordem->id);
            }

            return response()->json([
                'success' => true,
                'message' => 'Material removido e reserva cancelada com sucesso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao remover material: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Finaliza OS (admin)
     */
    public function finalizar(Request $request, $id)
    {
        $request->validate([
            'relatorio_execucao' => 'required|string|min:10',
            'observacoes' => 'nullable|string|max:1000',
            'fotos_depois.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $ordem = OrdemServico::findOrFail($id);

        if ($ordem->status !== 'em_execucao' && $ordem->status !== 'pendente') {
            return redirect()->route('admin.ordens.show', $ordem->id)
                ->with('error', 'Ordem deve estar em execução ou pendente para ser finalizada.');
        }

        // Processar fotos DEPOIS
        if ($request->hasFile('fotos_depois')) {
            $fotosDepois = $ordem->fotos_depois ?? [];

            foreach ($request->file('fotos_depois') as $foto) {
                $path = $foto->store('ordens/' . $ordem->id . '/depois', 'public');
                $fotosDepois[] = $path;
            }

            $ordem->update(['fotos_depois' => $fotosDepois]);
        }

        // Se OS estava pendente, iniciar primeiro
        if ($ordem->status === 'pendente') {
            $ordem->update([
                'status' => 'em_execucao',
                'data_inicio' => now(),
                'user_id_execucao' => Auth::id(),
            ]);
        }

        // Finalizar usando o serviço
        if ($this->campoOrdensService->concluirAtendimento($ordem, Auth::user(), [
            'relatorio_execucao' => $request->relatorio_execucao,
            'observacoes' => $request->observacoes,
        ])) {
            return redirect()->route('admin.ordens.show', $ordem->id)
                ->with('success', 'Ordem de serviço finalizada com sucesso! (Gerenciada por Admin)');
        }

        return redirect()->route('admin.ordens.show', $ordem->id)
            ->with('error', 'Não foi possível finalizar a ordem. Verifique se o relatório foi preenchido corretamente.');
    }
}
