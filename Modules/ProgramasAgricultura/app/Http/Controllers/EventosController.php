<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\ProgramasAgricultura\App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventosController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('ProgramasAgricultura');
    }

    /**
     * Lista todos os eventos para Co-Admin
     */
    public function index(Request $request)
    {
        $query = Evento::with(['localidade'])->withCount('inscricoes');

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%')
                  ->orWhere('codigo', 'like', '%' . $request->search . '%');
        }

        $eventos = $query->orderBy('data_inicio', 'desc')->paginate(15);

        return view('programasagricultura::co-admin.eventos.index', compact('eventos'));
    }

    /**
     * Exibe formulário de criação
     */
    public function create()
    {
        $localidades = \Modules\Localidades\App\Models\Localidade::where('ativo', true)->orderBy('nome')->get();
        return view('programasagricultura::co-admin.eventos.create', compact('localidades'));
    }

    /**
     * Salva novo evento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:capacitacao,palestra,feira,workshop,outro',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'localidade_id' => 'nullable|exists:localidades,id',
            'endereco' => 'nullable|string|max:255',
            'vagas_totais' => 'nullable|integer|min:0',
            'status' => 'required|in:agendado,em_andamento,concluido,cancelado',
            'publico' => 'boolean',
            'inscricao_aberta' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $evento = new Evento($validated);
            $evento->codigo = Evento::gerarCodigo();
            $evento->vagas_preenchidas = 0;
            $evento->publico = $request->has('publico');
            $evento->inscricao_aberta = $request->has('inscricao_aberta');
            $evento->user_id_criador = auth()->id();
            $evento->save();

            DB::commit();

            return redirect()->route('co-admin.eventos.index')->with('success', 'Evento criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar evento co-admin', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Erro ao criar evento.');
        }
    }

    /**
     * Exibe detalhes do evento
     */
    public function show($id)
    {
        $evento = Evento::with(['localidade', 'inscricoes.pessoa'])->findOrFail($id);
        return view('programasagricultura::co-admin.eventos.show', compact('evento'));
    }

    /**
     * Exibe formulário de edição
     */
    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $localidades = \Modules\Localidades\App\Models\Localidade::where('ativo', true)->orderBy('nome')->get();
        return view('programasagricultura::co-admin.eventos.edit', compact('evento', 'localidades'));
    }

    /**
     * Atualiza evento
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|in:capacitacao,palestra,feira,workshop,outro',
            'data_inicio' => 'required|date',
            'status' => 'required|in:agendado,em_andamento,concluido,cancelado',
        ]);

        $evento->update($validated);
        $evento->publico = $request->has('publico');
        $evento->inscricao_aberta = $request->has('inscricao_aberta');
        $evento->save();

        return redirect()->route('co-admin.eventos.index')->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove evento
     */
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);

        if ($evento->inscricoes()->exists()) {
            return redirect()->back()->with('error', 'Não é possível excluir um evento que possui inscrições.');
        }

        $evento->delete();
        return redirect()->route('co-admin.eventos.index')->with('success', 'Evento excluído com sucesso!');
    }
}
