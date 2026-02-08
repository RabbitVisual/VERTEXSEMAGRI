<?php

namespace Modules\CAF\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\CAF\App\Models\CadastroCAF;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminCAFController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('CAF');
    }
    /**
     * Lista todos os cadastros (Admin)
     */
    public function index(Request $request)
    {
        $query = CadastroCAF::query()
            ->with(['pessoa', 'localidade', 'funcionario', 'cadastrador'])
            ->latest();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome_completo', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('protocolo', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('localidade_id')) {
            $query->where('localidade_id', $request->localidade_id);
        }

        if ($request->filled('funcionario_id')) {
            $query->where('funcionario_id', $request->funcionario_id);
        }

        $cadastros = $query->paginate(20)->withQueryString();
        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();

        // Estatísticas
        $stats = CadastroCAF::selectRaw("
            count(*) as total,
            count(case when status = 'rascunho' then 1 end) as rascunhos,
            count(case when status = 'em_andamento' then 1 end) as em_andamento,
            count(case when status = 'completo' then 1 end) as completos,
            count(case when status = 'aprovado' then 1 end) as aprovados,
            count(case when status = 'enviado_caf' then 1 end) as enviados_caf
        ")->first()->toArray();

        return view('caf::admin.index', compact('cadastros', 'localidades', 'stats'));
    }

    /**
     * Visualizar cadastro completo
     */
    public function show(CadastroCAF $cadastro)
    {
        $cadastro->load([
            'pessoa', 
            'conjuge', 
            'familiares', 
            'imovel', 
            'rendaFamiliar', 
            'localidade', 
            'funcionario', 
            'cadastrador'
        ]);
        
        // Estatísticas do cadastro
        $estatisticas = [
            'total_familiares' => $cadastro->familiares()->count(),
            'tem_conjuge' => $cadastro->conjuge ? 1 : 0,
            'tem_imovel' => $cadastro->imovel ? 1 : 0,
            'tem_renda' => $cadastro->rendaFamiliar ? 1 : 0,
            'esta_completo' => $cadastro->estaCompleto(),
            'pode_enviar' => $cadastro->podeSerEnviado(),
        ];
        
        return view('caf::admin.show', compact('cadastro', 'estatisticas'));
    }

    /**
     * Aprovar cadastro
     */
    public function aprovar(CadastroCAF $cadastro)
    {
        try {
            if (!$cadastro->estaCompleto()) {
                return back()->with('error', 'Cadastro não está completo. Não é possível aprovar.');
            }

            $cadastro->update(['status' => 'aprovado']);

            Log::info('Cadastro CAF aprovado', [
                'cadastro_id' => $cadastro->id,
                'protocolo' => $cadastro->protocolo,
                'user_id' => auth()->id(),
            ]);

            return back()->with('success', 'Cadastro aprovado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao aprovar cadastro CAF', [
                'cadastro_id' => $cadastro->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao aprovar cadastro.');
        }
    }

    /**
     * Rejeitar cadastro
     */
    public function rejeitar(Request $request, CadastroCAF $cadastro)
    {
        $validated = $request->validate([
            'observacoes' => 'required|string|max:1000',
        ]);

        try {
            $cadastro->update([
                'status' => 'rejeitado',
                'observacoes' => $validated['observacoes'],
            ]);

            Log::info('Cadastro CAF rejeitado', [
                'cadastro_id' => $cadastro->id,
                'protocolo' => $cadastro->protocolo,
                'user_id' => auth()->id(),
            ]);

            return back()->with('success', 'Cadastro rejeitado.');
        } catch (\Exception $e) {
            Log::error('Erro ao rejeitar cadastro CAF', [
                'cadastro_id' => $cadastro->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao rejeitar cadastro.');
        }
    }

    /**
     * Marcar como enviado ao CAF oficial
     */
    public function enviarCAF(Request $request, CadastroCAF $cadastro)
    {
        $validated = $request->validate([
            'protocolo_caf_oficial' => 'nullable|string|max:100',
        ]);

        try {
            if ($cadastro->status !== 'aprovado') {
                return back()->with('error', 'Apenas cadastros aprovados podem ser enviados ao CAF oficial.');
            }

            $cadastro->update([
                'status' => 'enviado_caf',
                'enviado_caf_at' => now(),
                'protocolo_caf_oficial' => $validated['protocolo_caf_oficial'] ?? null,
            ]);

            Log::info('Cadastro CAF enviado ao sistema oficial', [
                'cadastro_id' => $cadastro->id,
                'protocolo' => $cadastro->protocolo,
                'protocolo_caf_oficial' => $cadastro->protocolo_caf_oficial,
                'user_id' => auth()->id(),
            ]);

            return back()->with('success', 'Cadastro marcado como enviado ao CAF oficial.');
        } catch (\Exception $e) {
            Log::error('Erro ao enviar cadastro CAF', [
                'cadastro_id' => $cadastro->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao marcar como enviado.');
        }
    }

    /**
     * Deletar cadastro
     */
    public function destroy(CadastroCAF $cadastro)
    {
        try {
            // Só permite deletar se não estiver enviado ao CAF
            if ($cadastro->status === 'enviado_caf') {
                return back()->with('error', 'Não é possível deletar cadastros já enviados ao CAF oficial.');
            }

            $cadastro->delete();

            Log::info('Cadastro CAF deletado', [
                'cadastro_id' => $cadastro->id,
                'protocolo' => $cadastro->protocolo,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.caf.index')
                ->with('success', 'Cadastro deletado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar cadastro CAF', [
                'cadastro_id' => $cadastro->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Erro ao deletar cadastro.');
        }
    }
}

