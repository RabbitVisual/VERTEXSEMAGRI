<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\ProgramasAgricultura\App\Models\Programa;
use Modules\ProgramasAgricultura\App\Models\Beneficiario;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgramasAdminController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('ProgramasAgricultura');
    }
    /**
     * Lista todos os programas
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tipo', 'status', 'publico']);
        
        $query = Programa::withCount('beneficiarios');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%')
                  ->orWhere('codigo', 'like', '%' . $request->search . '%')
                  ->orWhere('descricao', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('publico')) {
            $query->where('publico', $request->publico === '1');
        }

        $programas = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estatísticas
        $estatisticas = [
            'total' => Programa::count(),
            'ativos' => Programa::where('status', 'ativo')->count(),
            'suspensos' => Programa::where('status', 'suspenso')->count(),
            'publicos' => Programa::where('publico', true)->count(),
            'com_vagas' => Programa::whereColumn('vagas_preenchidas', '<', 'vagas_disponiveis')->count(),
        ];

        return view('programasagricultura::admin.programas.index', compact('programas', 'estatisticas', 'filters'));
    }

    /**
     * Exibe formulário de criação
     */
    public function create()
    {
        return view('programasagricultura::admin.programas.create');
    }

    /**
     * Salva novo programa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:governo_federal,governo_estadual,governo_municipal,parceria,outro',
            'status' => 'required|in:ativo,suspenso,encerrado',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'vagas_disponiveis' => 'nullable|integer|min:0',
            'requisitos' => 'nullable|string',
            'documentos_necessarios' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'orgao_responsavel' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'publico' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $programa = new Programa($validated);
            $programa->codigo = Programa::gerarCodigo();
            $programa->vagas_preenchidas = 0;
            $programa->publico = $request->has('publico');
            $programa->save();

            DB::commit();

            Log::info('Programa criado', ['programa_id' => $programa->id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.programas.index')
                ->with('success', 'Programa criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar programa', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar programa: ' . $e->getMessage());
        }
    }

    /**
     * Exibe detalhes do programa
     */
    public function show($id)
    {
        $programa = Programa::with(['beneficiarios.pessoa', 'beneficiarios.localidade'])
            ->withCount('beneficiarios')
            ->findOrFail($id);

        $beneficiarios = $programa->beneficiarios()
            ->with(['pessoa', 'localidade'])
            ->orderBy('data_inscricao', 'desc')
            ->paginate(10);

        // Estatísticas do programa
        $estatisticas = [
            'total_beneficiarios' => $programa->beneficiarios()->count(),
            'beneficiarios_ativos' => $programa->beneficiariosAtivos()->count(),
            'vagas_restantes' => $programa->vagas_restantes,
            'tem_vagas' => $programa->tem_vagas,
            'esta_ativo' => $programa->esta_ativo,
            'por_status' => [
                'inscrito' => $programa->beneficiarios()->where('status', 'inscrito')->count(),
                'aprovado' => $programa->beneficiarios()->where('status', 'aprovado')->count(),
                'beneficiado' => $programa->beneficiarios()->where('status', 'beneficiado')->count(),
                'cancelado' => $programa->beneficiarios()->where('status', 'cancelado')->count(),
            ],
        ];

        return view('programasagricultura::admin.programas.show', compact('programa', 'beneficiarios', 'estatisticas'));
    }

    /**
     * Exibe formulário de edição
     */
    public function edit($id)
    {
        $programa = Programa::findOrFail($id);
        return view('programasagricultura::admin.programas.edit', compact('programa'));
    }

    /**
     * Atualiza programa
     */
    public function update(Request $request, $id)
    {
        $programa = Programa::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:governo_federal,governo_estadual,governo_municipal,parceria,outro',
            'status' => 'required|in:ativo,suspenso,encerrado',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'vagas_disponiveis' => 'nullable|integer|min:0',
            'requisitos' => 'nullable|string',
            'documentos_necessarios' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'orgao_responsavel' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'publico' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $programa->fill($validated);
            $programa->publico = $request->has('publico');
            $programa->save();

            DB::commit();

            Log::info('Programa atualizado', ['programa_id' => $programa->id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.programas.show', $programa->id)
                ->with('success', 'Programa atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar programa', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar programa: ' . $e->getMessage());
        }
    }

    /**
     * Remove programa
     */
    public function destroy($id)
    {
        $programa = Programa::findOrFail($id);

        try {
            DB::beginTransaction();

            // Verificar se há beneficiários
            if ($programa->beneficiarios()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Não é possível excluir programa com beneficiários cadastrados.');
            }

            $programa->delete();

            DB::commit();

            Log::info('Programa excluído', ['programa_id' => $id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.programas.index')
                ->with('success', 'Programa excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir programa', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Erro ao excluir programa: ' . $e->getMessage());
        }
    }
}

