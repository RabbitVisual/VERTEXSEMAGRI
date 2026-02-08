<?php

namespace Modules\Materiais\App\Http\Controllers\Campo;

use App\Http\Controllers\Controller;
use Modules\Materiais\App\Models\SolicitacaoMaterialCampo;
use Modules\Materiais\App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitarMaterialCampoController extends Controller
{
    /**
     * Lista solicitações do funcionário
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status']);
        $query = SolicitacaoMaterialCampo::where('user_id', Auth::id())
            ->with(['ordemServico', 'material', 'solicitacaoMaterial']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $solicitacoes = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('campo.materiais.solicitacoes.index', compact('solicitacoes', 'filters'));
    }

    /**
     * Cria nova solicitação de material
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'nullable|exists:materiais,id',
            'material_nome' => 'required|string|max:255',
            'material_codigo' => 'nullable|string|max:50',
            'quantidade' => 'required|numeric|min:0.01',
            'unidade_medida' => 'required|string|max:50',
            'justificativa' => 'required|string|max:500',
            'ordem_servico_id' => 'nullable|exists:ordens_servico,id',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $solicitacao = SolicitacaoMaterialCampo::create([
            'user_id' => Auth::id(),
            'ordem_servico_id' => $validated['ordem_servico_id'] ?? null,
            'material_id' => $validated['material_id'] ?? null,
            'material_nome' => $validated['material_nome'],
            'material_codigo' => $validated['material_codigo'] ?? null,
            'quantidade' => $validated['quantidade'],
            'unidade_medida' => $validated['unidade_medida'],
            'justificativa' => $validated['justificativa'],
            'status' => 'pendente',
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Solicitação enviada com sucesso! O administrador será notificado.',
            'solicitacao' => $solicitacao,
        ]);
    }
}

