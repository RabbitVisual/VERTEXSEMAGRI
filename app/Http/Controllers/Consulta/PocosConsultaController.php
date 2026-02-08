<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Models\Poco;
use Modules\Localidades\App\Models\Localidade;
use Modules\Equipes\App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PocosConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'localidade_id', 'equipe_responsavel_id', 'search']);
        $query = Poco::with(['localidade', 'equipeResponsavel']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('endereco', 'like', "%{$search}%")
                  ->orWhere('tipo_bomba', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }
        if (!empty($filters['equipe_responsavel_id'])) {
            $query->where('equipe_responsavel_id', $filters['equipe_responsavel_id']);
        }

        $pocos = $query->orderBy('codigo')->paginate(20);

        $localidades = collect([]);
        $equipes = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }
        if (Schema::hasTable('equipes')) {
            $equipes = Equipe::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas
        $estatisticas = [
            'total' => Poco::count(),
            'ativos' => Poco::ativos()->count(),
            'em_manutencao' => Poco::emManutencao()->count(),
            'com_problemas' => Poco::comProblemas()->count(),
        ];

        return view('consulta.pocos.index', compact('pocos', 'localidades', 'equipes', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $poco = Poco::with(['localidade', 'equipeResponsavel'])->findOrFail($id);

        return view('consulta.pocos.show', compact('poco'));
    }
}

