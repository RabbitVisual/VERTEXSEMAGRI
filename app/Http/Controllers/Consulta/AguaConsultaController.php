<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Agua\App\Models\RedeAgua;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AguaConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tipo_rede', 'localidade_id', 'search']);
        $query = RedeAgua::with('localidade');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('material', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_rede'])) {
            $query->where('tipo_rede', $filters['tipo_rede']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $redes = $query->orderBy('created_at', 'desc')->paginate(20);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas
        $estatisticas = [
            'total' => RedeAgua::count(),
        ];

        return view('consulta.agua.index', compact('redes', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $rede = RedeAgua::with('localidade')->findOrFail($id);

        return view('consulta.agua.show', compact('rede'));
    }
}

