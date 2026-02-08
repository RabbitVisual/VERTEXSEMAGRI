<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Iluminacao\App\Models\PontoLuz;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class IluminacaoConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo_lampada', 'localidade_id', 'search']);
        $query = PontoLuz::with('localidade');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('endereco', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_lampada'])) {
            $query->where('tipo_lampada', $filters['tipo_lampada']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $pontos = $query->orderBy('created_at', 'desc')->paginate(20);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas
        $estatisticas = [
            'total' => PontoLuz::count(),
        ];

        return view('consulta.iluminacao.index', compact('pontos', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $ponto = PontoLuz::with('localidade')->findOrFail($id);

        return view('consulta.iluminacao.show', compact('ponto'));
    }
}

