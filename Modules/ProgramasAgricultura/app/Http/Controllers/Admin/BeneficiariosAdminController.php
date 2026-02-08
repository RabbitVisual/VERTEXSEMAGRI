<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\ProgramasAgricultura\App\Models\Beneficiario;
use Modules\ProgramasAgricultura\App\Models\Programa;
use Modules\Localidades\App\Models\Localidade;
use Modules\Pessoas\App\Models\PessoaCad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BeneficiariosAdminController extends Controller
{
    /**
     * Lista todos os beneficiários
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'programa_id', 'status', 'localidade_id']);
        
        $query = Beneficiario::with(['programa', 'pessoa', 'localidade']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('cpf', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pessoa', function($p) use ($request) {
                      $p->where('nom_pessoa', 'like', '%' . $request->search . '%')
                        ->orWhere('num_cpf_pessoa', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('programa_id')) {
            $query->where('programa_id', $request->programa_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('localidade_id')) {
            $query->where('localidade_id', $request->localidade_id);
        }

        $beneficiarios = $query->orderBy('data_inscricao', 'desc')->paginate(15);

        $programas = Programa::orderBy('nome')->get();
        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();

        // Estatísticas
        $estatisticas = [
            'total' => Beneficiario::count(),
            'inscritos' => Beneficiario::where('status', 'inscrito')->count(),
            'aprovados' => Beneficiario::where('status', 'aprovado')->count(),
            'beneficiados' => Beneficiario::where('status', 'beneficiado')->count(),
            'rejeitados' => Beneficiario::where('status', 'rejeitado')->count(),
        ];

        return view('programasagricultura::admin.beneficiarios.index', compact('beneficiarios', 'programas', 'localidades', 'estatisticas', 'filters'));
    }

    /**
     * Exibe detalhes do beneficiário
     */
    public function show($id)
    {
        $beneficiario = Beneficiario::with(['programa', 'pessoa', 'localidade'])->findOrFail($id);
        return view('programasagricultura::admin.beneficiarios.show', compact('beneficiario'));
    }

    /**
     * Atualiza status do beneficiário
     */
    public function updateStatus(Request $request, $id)
    {
        $beneficiario = Beneficiario::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:inscrito,aprovado,beneficiado,rejeitado',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $beneficiario->status = $validated['status'];
            if ($request->filled('observacoes')) {
                $beneficiario->observacoes = $validated['observacoes'];
            }
            $beneficiario->save();

            // Atualizar contador de vagas do programa
            if ($beneficiario->programa) {
                $programa = $beneficiario->programa;
                $programa->vagas_preenchidas = $programa->beneficiarios()
                    ->whereIn('status', ['aprovado', 'beneficiado'])
                    ->count();
                $programa->save();
            }

            DB::commit();

            Log::info('Status do beneficiário atualizado', [
                'beneficiario_id' => $beneficiario->id,
                'status' => $validated['status'],
                'user_id' => auth()->id()
            ]);

            return redirect()->back()
                ->with('success', 'Status do beneficiário atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar status do beneficiário', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Erro ao atualizar status: ' . $e->getMessage());
        }
    }

    /**
     * Remove beneficiário
     */
    public function destroy($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);

        try {
            DB::beginTransaction();

            $programa = $beneficiario->programa;
            $beneficiario->delete();

            // Atualizar contador de vagas do programa
            if ($programa) {
                $programa->vagas_preenchidas = $programa->beneficiarios()
                    ->whereIn('status', ['aprovado', 'beneficiado'])
                    ->count();
                $programa->save();
            }

            DB::commit();

            Log::info('Beneficiário excluído', ['beneficiario_id' => $id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.beneficiarios.index')
                ->with('success', 'Beneficiário excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir beneficiário', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Erro ao excluir beneficiário: ' . $e->getMessage());
        }
    }
}

