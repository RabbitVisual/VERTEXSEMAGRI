<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\ProgramasAgricultura\App\Models\InscricaoEvento;
use Modules\ProgramasAgricultura\App\Models\Evento;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InscricoesEventosAdminController extends Controller
{
    /**
     * Lista todas as inscrições
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'evento_id', 'status', 'localidade_id']);
        
        $query = InscricaoEvento::with(['evento', 'pessoa', 'localidade']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('cpf', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pessoa', function($p) use ($request) {
                      $p->where('nom_pessoa', 'like', '%' . $request->search . '%')
                        ->orWhere('num_cpf_pessoa', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('evento_id')) {
            $query->where('evento_id', $request->evento_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('localidade_id')) {
            $query->where('localidade_id', $request->localidade_id);
        }

        $inscricoes = $query->orderBy('data_inscricao', 'desc')->paginate(15);

        $eventos = Evento::orderBy('data_inicio', 'desc')->get();
        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();

        // Estatísticas
        $estatisticas = [
            'total' => InscricaoEvento::count(),
            'confirmadas' => InscricaoEvento::where('status', 'confirmada')->count(),
            'presentes' => InscricaoEvento::where('status', 'presente')->count(),
            'ausentes' => InscricaoEvento::where('status', 'ausente')->count(),
            'canceladas' => InscricaoEvento::where('status', 'cancelada')->count(),
        ];

        return view('programasagricultura::admin.inscricoes.index', compact('inscricoes', 'eventos', 'localidades', 'estatisticas', 'filters'));
    }

    /**
     * Exibe detalhes da inscrição
     */
    public function show($id)
    {
        $inscricao = InscricaoEvento::with(['evento', 'pessoa', 'localidade'])->findOrFail($id);
        return view('programasagricultura::admin.inscricoes.show', compact('inscricao'));
    }

    /**
     * Atualiza status da inscrição
     */
    public function updateStatus(Request $request, $id)
    {
        $inscricao = InscricaoEvento::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:confirmada,presente,ausente,cancelada',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $inscricao->status = $validated['status'];
            if ($request->filled('observacoes')) {
                $inscricao->observacoes = $validated['observacoes'];
            }
            $inscricao->save();

            // Atualizar contador de vagas do evento
            if ($inscricao->evento) {
                $evento = $inscricao->evento;
                $evento->vagas_preenchidas = $evento->inscricoes()
                    ->whereIn('status', ['confirmada', 'presente'])
                    ->count();
                $evento->save();
            }

            DB::commit();

            Log::info('Status da inscrição atualizado', [
                'inscricao_id' => $inscricao->id,
                'status' => $validated['status'],
                'user_id' => auth()->id()
            ]);

            return redirect()->back()
                ->with('success', 'Status da inscrição atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar status da inscrição', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Erro ao atualizar status: ' . $e->getMessage());
        }
    }

    /**
     * Remove inscrição
     */
    public function destroy($id)
    {
        $inscricao = InscricaoEvento::findOrFail($id);

        try {
            DB::beginTransaction();

            $evento = $inscricao->evento;
            $inscricao->delete();

            // Atualizar contador de vagas do evento
            if ($evento) {
                $evento->vagas_preenchidas = $evento->inscricoes()
                    ->whereIn('status', ['confirmada', 'presente'])
                    ->count();
                $evento->save();
            }

            DB::commit();

            Log::info('Inscrição excluída', ['inscricao_id' => $id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.inscricoes.index')
                ->with('success', 'Inscrição excluída com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir inscrição', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Erro ao excluir inscrição: ' . $e->getMessage());
        }
    }
}

