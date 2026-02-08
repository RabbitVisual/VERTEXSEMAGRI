<?php

namespace Modules\Localidades\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class LocalidadesAdminController extends Controller
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

        return view('localidades::admin.index', compact('localidades', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        $localidade = Localidade::with([
            'pessoas' => function($query) {
                $query->orderBy('nom_pessoa')->limit(10);
            },
            'demandas' => function($query) {
                $query->with(['pessoa', 'usuario', 'ordemServico'])->orderBy('created_at', 'desc')->limit(10);
            }
        ])->findOrFail($id);

        // Estatísticas completas da localidade
        $estatisticas = [
            'total_pessoas' => $localidade->pessoas()->count(),
            'total_demandas' => $localidade->demandas()->count(),
            'demandas_abertas' => $localidade->demandas()->where('status', 'aberta')->count(),
            'demandas_em_andamento' => $localidade->demandas()->where('status', 'em_andamento')->count(),
            'demandas_concluidas' => $localidade->demandas()->where('status', 'concluida')->count(),
            'demandas_por_tipo' => [
                'agua' => $localidade->demandas()->where('tipo', 'agua')->count(),
                'luz' => $localidade->demandas()->where('tipo', 'luz')->count(),
                'estrada' => $localidade->demandas()->where('tipo', 'estrada')->count(),
                'poco' => $localidade->demandas()->where('tipo', 'poco')->count(),
            ],
        ];

        // Infraestrutura relacionada
        $infraestrutura = [
            'pontos_luz' => 0,
            'redes_agua' => 0,
            'pocos' => 0,
            'trechos' => 0,
        ];

        if (Schema::hasTable('pontos_luz')) {
            $infraestrutura['pontos_luz'] = \Modules\Iluminacao\App\Models\PontoLuz::where('localidade_id', $localidade->id)->count();
        }
        if (Schema::hasTable('redes_agua')) {
            $infraestrutura['redes_agua'] = \Modules\Agua\App\Models\RedeAgua::where('localidade_id', $localidade->id)->count();
        }
        if (Schema::hasTable('pocos')) {
            $infraestrutura['pocos'] = \Modules\Pocos\App\Models\Poco::where('localidade_id', $localidade->id)->count();
        }
        if (Schema::hasTable('trechos')) {
            $infraestrutura['trechos'] = \Modules\Estradas\App\Models\Trecho::where('localidade_id', $localidade->id)->count();
        }

        return view('localidades::admin.show', compact('localidade', 'estatisticas', 'infraestrutura'));
    }
}
