<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;

class LocalidadesConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'ativo']);
        $query = Localidade::query();

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('tipo', 'like', "%{$search}%");
            });
        }

        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo']);
        }

        $localidades = $query->orderBy('nome')->paginate(20);

        // Estatísticas
        $estatisticas = [
            'total' => Localidade::count(),
            'ativas' => Localidade::where('ativo', true)->count(),
            'inativas' => Localidade::where('ativo', false)->count(),
        ];

        return view('consulta.localidades.index', compact('localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $localidade = Localidade::findOrFail($id);

        // Contar relacionamentos
        $estatisticas = [
            'total_pessoas' => $localidade->pessoas()->count(),
            'total_demandas' => $localidade->demandas()->count(),
        ];

        return view('consulta.localidades.show', compact('localidade', 'estatisticas'));
    }
}

