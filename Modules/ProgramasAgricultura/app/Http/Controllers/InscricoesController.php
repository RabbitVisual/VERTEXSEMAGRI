<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\ProgramasAgricultura\App\Models\InscricaoEvento;
use Modules\ProgramasAgricultura\App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InscricoesController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('ProgramasAgricultura');
    }

    /**
     * Lista todas as inscrições para Co-Admin
     */
    public function index(Request $request)
    {
        $query = InscricaoEvento::with(['evento', 'pessoa', 'localidade']);

        if ($request->filled('search')) {
            $query->whereHas('pessoa', function($q) use ($request) {
                $q->where('nom_pessoa', 'like', '%' . $request->search . '%')
                  ->orWhere('num_cpf_pessoa', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('evento_id')) {
            $query->where('evento_id', $request->evento_id);
        }

        $inscricoes = $query->orderBy('data_inscricao', 'desc')->paginate(15);
        $eventos = Evento::orderBy('data_inicio', 'desc')->get();

        return view('programasagricultura::co-admin.inscricoes.index', compact('inscricoes', 'eventos'));
    }

    /**
     * Cria uma nova inscrição
     */
    public function create(Request $request)
    {
        $eventos = Evento::agendados()->orderBy('data_inicio')->get();
        $localidades = \Modules\Localidades\App\Models\Localidade::where('ativo', true)->orderBy('nome')->get();
        return view('programasagricultura::co-admin.inscricoes.create', compact('eventos', 'localidades'));
    }

    /**
     * Salva nova inscrição
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pessoa_id' => 'required|exists:pessoas,id_pessoa',
            'evento_id' => 'required|exists:eventos,id',
            'localidade_id' => 'required|exists:localidades,id',
            'data_inscricao' => 'required|date',
            'status' => 'required|in:confirmada,presente,ausente,cancelada',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $inscricao = InscricaoEvento::create($validated);

            // Atualizar vagas do evento
            $evento = $inscricao->evento;
            if ($evento) {
                $evento->vagas_preenchidas = $evento->inscricoes()->whereIn('status', ['confirmada', 'presente'])->count();
                $evento->save();
            }

            DB::commit();

            return redirect()->route('co-admin.inscricoes.index')->with('success', 'Inscrição realizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar inscrição co-admin', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Erro ao realizar inscrição.');
        }
    }

    /**
     * Exibe detalhes da inscrição
     */
    public function show($id)
    {
        $inscricao = InscricaoEvento::with(['evento', 'pessoa', 'localidade'])->findOrFail($id);
        return view('programasagricultura::co-admin.inscricoes.show', compact('inscricao'));
    }

    /**
     * Remove inscrição
     */
    public function destroy($id)
    {
        $inscricao = InscricaoEvento::findOrFail($id);
        $evento = $inscricao->evento;
        $inscricao->delete();

        if ($evento) {
            $evento->vagas_preenchidas = $evento->inscricoes()->whereIn('status', ['confirmada', 'presente'])->count();
            $evento->save();
        }

        return redirect()->route('co-admin.inscricoes.index')->with('success', 'Inscrição removida com sucesso!');
    }
}
