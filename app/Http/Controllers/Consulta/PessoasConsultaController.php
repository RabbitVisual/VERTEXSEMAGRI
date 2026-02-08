<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PessoasConsultaController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'localidade_id', 'recebe_pbf']);
        $query = PessoaCad::with('localidade');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nom_pessoa', 'like', "%{$search}%")
                  ->orWhere('nom_apelido_pessoa', 'like', "%{$search}%")
                  ->orWhere('num_nis_pessoa_atual', 'like', "%{$search}%")
                  ->orWhere('num_cpf_pessoa', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        if (isset($filters['recebe_pbf']) && $filters['recebe_pbf'] !== '') {
            if ($filters['recebe_pbf'] == '1') {
                $query->whereNotNull('ref_pbf')->where('ref_pbf', '>', 0);
            } else {
                $query->where(function($q) {
                    $q->whereNull('ref_pbf')->orWhere('ref_pbf', '<=', 0);
                });
            }
        }

        $pessoas = $query->orderBy('nom_pessoa')->paginate(20);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas
        $estatisticas = [
            'total' => PessoaCad::count(),
            'com_localidade' => PessoaCad::whereNotNull('localidade_id')->count(),
            'sem_localidade' => PessoaCad::whereNull('localidade_id')->count(),
            'recebem_pbf' => PessoaCad::beneficiariasPbf()->count(),
        ];

        return view('consulta.pessoas.index', compact('pessoas', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $pessoa = PessoaCad::with('localidade')->findOrFail($id);

        // Estatísticas relacionadas
        $estatisticas = [
            'total_demandas' => $pessoa->demandas()->count() ?? 0,
        ];

        return view('consulta.pessoas.show', compact('pessoa', 'estatisticas'));
    }
}

