<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\ProgramasAgricultura\App\Models\Programa;
use Illuminate\Http\Request;

class ProgramasAgriculturaConsultaController extends Controller
{
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

        return view('consulta.programas.index', compact('programas', 'estatisticas', 'filters'));
    }

    public function show($id)
    {
        $programa = Programa::with(['beneficiarios.pessoa', 'beneficiarios.localidade'])
            ->withCount('beneficiarios')
            ->findOrFail($id);

        $beneficiarios = $programa->beneficiarios()
            ->with(['pessoa', 'localidade'])
            ->orderBy('data_inscricao', 'desc')
            ->paginate(10);

        return view('consulta.programas.show', compact('programa', 'beneficiarios'));
    }
}

