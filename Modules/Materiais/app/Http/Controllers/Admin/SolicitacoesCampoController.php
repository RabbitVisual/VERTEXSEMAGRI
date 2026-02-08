<?php

namespace Modules\Materiais\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Materiais\App\Models\SolicitacaoMaterialCampo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitacoesCampoController extends Controller
{
    /**
     * Lista todas as solicitações do campo
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'user_id', 'search']);
        $query = SolicitacaoMaterialCampo::with(['user', 'ordemServico', 'material', 'processadoPor']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('material_nome', 'like', "%{$search}%")
                  ->orWhere('material_codigo', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $solicitacoes = $query->orderBy('created_at', 'desc')->paginate(20);
        $usuarios = \App\Models\User::whereHas('solicitacoesMateriaisCampo')->orderBy('name')->get();

        return view('materiais::admin.solicitacoes-campo.index', compact('solicitacoes', 'filters', 'usuarios'));
    }

    /**
     * Processa uma solicitação (redireciona para criar solicitação oficial)
     */
    public function processar($id)
    {
        $solicitacao = SolicitacaoMaterialCampo::findOrFail($id);
        
        if ($solicitacao->status !== 'pendente') {
            return redirect()->route('admin.materiais.solicitacoes-campo.index')
                ->with('error', 'Esta solicitação já foi processada ou cancelada.');
        }

        // Redirecionar para criar solicitação oficial com dados pré-preenchidos
        return redirect()->route('admin.materiais.solicitar.create', [
            'solicitacao_campo_id' => $solicitacao->id,
            'material_nome' => $solicitacao->material_nome,
            'material_codigo' => $solicitacao->material_codigo,
            'quantidade' => $solicitacao->quantidade,
            'unidade_medida' => $solicitacao->unidade_medida,
            'justificativa' => $solicitacao->justificativa,
            'observacoes' => "Solicitado por {$solicitacao->user->name} via painel campo" . ($solicitacao->ordemServico ? " - OS #{$solicitacao->ordemServico->numero}" : ''),
        ]);
    }

    /**
     * Cancela uma solicitação
     */
    public function cancelar(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'nullable|string|max:500',
        ]);

        $solicitacao = SolicitacaoMaterialCampo::findOrFail($id);
        
        if ($solicitacao->status !== 'pendente') {
            return redirect()->route('admin.materiais.solicitacoes-campo.index')
                ->with('error', 'Esta solicitação já foi processada ou cancelada.');
        }

        $solicitacao->update([
            'status' => 'cancelada',
            'processado_por' => Auth::id(),
            'observacoes' => ($solicitacao->observacoes ? $solicitacao->observacoes . "\n\n" : '') . 'Cancelado por: ' . Auth::user()->name . ($request->motivo ? "\nMotivo: {$request->motivo}" : ''),
        ]);

        return redirect()->route('admin.materiais.solicitacoes-campo.index')
            ->with('success', 'Solicitação cancelada com sucesso.');
    }
}

