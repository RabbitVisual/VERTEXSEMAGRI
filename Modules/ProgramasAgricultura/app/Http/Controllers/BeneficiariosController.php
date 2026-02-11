<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\ProgramasAgricultura\App\Models\Beneficiario;
use Modules\ProgramasAgricultura\App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BeneficiariosController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('ProgramasAgricultura');
    }

    /**
     * Lista todos os beneficiários para Co-Admin
     */
    public function index(Request $request)
    {
        $query = Beneficiario::with(['programa', 'pessoa', 'localidade']);

        if ($request->filled('search')) {
            $query->whereHas('pessoa', function($q) use ($request) {
                $q->where('nom_pessoa', 'like', '%' . $request->search . '%')
                  ->orWhere('num_cpf_pessoa', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('programa_id')) {
            $query->where('programa_id', $request->programa_id);
        }

        $beneficiarios = $query->orderBy('data_inscricao', 'desc')->paginate(15);
        $programas = Programa::orderBy('nome')->get();

        return view('programasagricultura::co-admin.beneficiarios.index', compact('beneficiarios', 'programas'));
    }

    /**
     * Exibe formulário de cadastro de beneficiário
     */
    public function create(Request $request)
    {
        $programas = Programa::ativos()->orderBy('nome')->get();
        $localidades = \Modules\Localidades\App\Models\Localidade::where('ativo', true)->orderBy('nome')->get();
        return view('programasagricultura::co-admin.beneficiarios.create', compact('programas', 'localidades'));
    }

    /**
     * Salva novo beneficiário
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pessoa_id' => 'required|exists:pessoas,id_pessoa',
            'programa_id' => 'required|exists:programas,id',
            'localidade_id' => 'required|exists:localidades,id',
            'data_inscricao' => 'required|date',
            'status' => 'required|in:inscrito,aprovado,beneficiado,rejeitado',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $beneficiario = Beneficiario::create($validated);

            // Atualizar contador de vagas
            $programa = $beneficiario->programa;
            if ($programa) {
                $programa->vagas_preenchidas = $programa->beneficiarios()->whereIn('status', ['aprovado', 'beneficiado'])->count();
                $programa->save();
            }

            DB::commit();

            return redirect()->route('co-admin.beneficiarios.index')->with('success', 'Beneficiário cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar beneficiário co-admin', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Erro ao cadastrar beneficiário.');
        }
    }

    /**
     * Exibe detalhes do beneficiário
     */
    public function show($id)
    {
        $beneficiario = Beneficiario::with(['programa', 'pessoa', 'localidade'])->findOrFail($id);
        return view('programasagricultura::co-admin.beneficiarios.show', compact('beneficiario'));
    }

    /**
     * Remove beneficiário
     */
    public function destroy($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);
        $programa = $beneficiario->programa;
        $beneficiario->delete();

        if ($programa) {
            $programa->vagas_preenchidas = $programa->beneficiarios()->whereIn('status', ['aprovado', 'beneficiado'])->count();
            $programa->save();
        }

        return redirect()->route('co-admin.beneficiarios.index')->with('success', 'Beneficiário removido com sucesso!');
    }
}
