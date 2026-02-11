<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\ProgramasAgricultura\App\Models\Evento;
use Modules\ProgramasAgricultura\App\Models\InscricaoEvento;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventosAdminController extends Controller
{
    /**
     * Lista todos os eventos
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tipo', 'status', 'publico', 'data_inicio', 'data_fim']);

        $query = Evento::with(['localidade'])
            ->withCount('inscricoes');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->search . '%')
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

        if ($request->filled('data_inicio')) {
            $query->where('data_inicio', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('data_fim', '<=', $request->data_fim);
        }

        $eventos = $query->orderBy('data_inicio', 'desc')->paginate(15);

        // Estatísticas
        $estatisticas = [
            'total' => Evento::count(),
            'agendados' => Evento::where('status', 'agendado')->count(),
            'em_andamento' => Evento::where('status', 'em_andamento')->count(),
            'concluidos' => Evento::where('status', 'concluido')->count(),
            'publicos' => Evento::where('publico', true)->count(),
            'com_inscricoes' => Evento::where('vagas_preenchidas', '>', 0)->count(),
        ];

        return view('programasagricultura::admin.eventos.index', compact('eventos', 'estatisticas', 'filters'));
    }

    /**
     * Exibe formulário de criação
     */
    public function create()
    {
        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();
        return view('programasagricultura::admin.eventos.create', compact('localidades'));
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
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i|after:hora_inicio',
            'localidade_id' => 'nullable|exists:localidades,id',
            'endereco' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'vagas_totais' => 'nullable|integer|min:0',
            'status' => 'required|in:agendado,em_andamento,concluido,cancelado',
            'publico_alvo' => 'nullable|string',
            'conteudo_programatico' => 'nullable|string',
            'instrutor_palestrante' => 'nullable|string|max:255',
            'materiais_necessarios' => 'nullable|string',
            'publico' => 'boolean',
            'inscricao_aberta' => 'boolean',
            'data_limite_inscricao' => 'nullable|date|before_or_equal:data_inicio',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $evento = new Evento($validated);
            $evento->codigo = Evento::generateCode('EVT');
            $evento->vagas_preenchidas = 0;
            $evento->publico = $request->has('publico');
            $evento->inscricao_aberta = $request->has('inscricao_aberta');
            $evento->user_id_criador = auth()->id();

            // Converter hora_inicio e hora_fim para datetime
            if ($request->filled('hora_inicio')) {
                $evento->hora_inicio = $request->data_inicio . ' ' . $request->hora_inicio . ':00';
            }
            if ($request->filled('hora_fim')) {
                $evento->hora_fim = $request->data_fim ?? $request->data_inicio . ' ' . $request->hora_fim . ':00';
            }

            $evento->save();

            DB::commit();

            Log::info('Evento criado', ['evento_id' => $evento->id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.programas-agricultura.eventos.index')
                ->with('success', 'Evento criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar evento', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar evento: ' . $e->getMessage());
        }
    }

    /**
     * Exibe detalhes do evento
     */
    public function show($id)
    {
        $evento = Evento::with(['localidade', 'inscricoes.pessoa', 'inscricoes.localidade'])
            ->withCount('inscricoes')
            ->findOrFail($id);

        $inscricoes = $evento->inscricoes()
            ->with(['pessoa', 'localidade'])
            ->orderBy('data_inscricao', 'desc')
            ->paginate(10);

        return view('programasagricultura::admin.eventos.show', compact('evento', 'inscricoes'));
    }

    /**
     * Exibe formulário de edição
     */
    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();
        return view('programasagricultura::admin.eventos.edit', compact('evento', 'localidades'));
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
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i|after:hora_inicio',
            'localidade_id' => 'nullable|exists:localidades,id',
            'endereco' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'vagas_totais' => 'nullable|integer|min:0',
            'status' => 'required|in:agendado,em_andamento,concluido,cancelado',
            'publico_alvo' => 'nullable|string',
            'conteudo_programatico' => 'nullable|string',
            'instrutor_palestrante' => 'nullable|string|max:255',
            'materiais_necessarios' => 'nullable|string',
            'publico' => 'boolean',
            'inscricao_aberta' => 'boolean',
            'data_limite_inscricao' => 'nullable|date|before_or_equal:data_inicio',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $evento->fill($validated);
            $evento->publico = $request->has('publico');
            $evento->inscricao_aberta = $request->has('inscricao_aberta');

            // Converter hora_inicio e hora_fim para datetime
            if ($request->filled('hora_inicio')) {
                $evento->hora_inicio = $request->data_inicio . ' ' . $request->hora_inicio . ':00';
            }
            if ($request->filled('hora_fim')) {
                $evento->hora_fim = ($request->data_fim ?? $request->data_inicio) . ' ' . $request->hora_fim . ':00';
            }

            $evento->save();

            DB::commit();

            Log::info('Evento atualizado', ['evento_id' => $evento->id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.programas-agricultura.eventos.show', $evento->id)
                ->with('success', 'Evento atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar evento', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar evento: ' . $e->getMessage());
        }
    }

    /**
     * Remove evento
     */
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);

        try {
            DB::beginTransaction();

            // Verificar se há inscrições
            if ($evento->inscricoes()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Não é possível excluir evento com inscrições cadastradas.');
            }

            $evento->delete();

            DB::commit();

            Log::info('Evento excluído', ['evento_id' => $id, 'user_id' => auth()->id()]);

            return redirect()->route('admin.programas-agricultura.eventos.index')
                ->with('success', 'Evento excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir evento', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Erro ao excluir evento: ' . $e->getMessage());
        }
    }
}
