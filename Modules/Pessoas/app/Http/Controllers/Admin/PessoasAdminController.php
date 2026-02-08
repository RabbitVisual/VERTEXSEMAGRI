<?php

namespace Modules\Pessoas\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PessoasAdminController extends Controller
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

        return view('pessoas::admin.index', compact('pessoas', 'localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $pessoa = PessoaCad::with([
            'localidade',
            'demandas' => function($query) {
                $query->with(['localidade', 'usuario', 'ordemServico'])->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Estatísticas relacionadas
        $estatisticas = [
            'total_demandas' => $pessoa->demandas()->count() ?? 0,
            'demandas_abertas' => $pessoa->demandas()->where('status', 'aberta')->count() ?? 0,
            'demandas_em_andamento' => $pessoa->demandas()->where('status', 'em_andamento')->count() ?? 0,
            'demandas_concluidas' => $pessoa->demandas()->where('status', 'concluida')->count() ?? 0,
        ];

        // Demandas recentes
        $demandasRecentes = $pessoa->demandas()
            ->with(['localidade', 'usuario', 'ordemServico'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('pessoas::admin.show', compact('pessoa', 'estatisticas', 'demandasRecentes'));
    }
}
