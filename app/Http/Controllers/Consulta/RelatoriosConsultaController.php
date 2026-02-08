<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RelatoriosConsultaController extends Controller
{
    public function index()
    {
        $stats = [
            'pessoas' => [
                'total' => $this->safeCount('pessoas_cad'),
                'beneficiarias_pbf' => DB::table('pessoas_cad')->whereNotNull('ref_pbf')->where('ref_pbf', '>', 0)->whereNull('deleted_at')->count(),
            ],
            'demandas' => [
                'total' => $this->safeCount('demandas'),
                'abertas' => $this->safeCountWhere('demandas', 'status', 'aberta'),
                'em_andamento' => $this->safeCountWhere('demandas', 'status', 'em_andamento'),
                'concluidas' => $this->safeCountWhere('demandas', 'status', 'concluida'),
                'por_tipo' => $this->getDemandasPorTipo(),
            ],
            'ordens' => [
                'total' => $this->safeCount('ordens_servico'),
                'pendentes' => $this->safeCountWhere('ordens_servico', 'status', 'pendente'),
                'em_execucao' => $this->safeCountWhere('ordens_servico', 'status', 'em_execucao'),
                'concluidas' => $this->safeCountWhere('ordens_servico', 'status', 'concluida'),
            ],
            'localidades' => [
                'total' => $this->safeCount('localidades'),
                'ativas' => $this->safeCountWhere('localidades', 'ativo', true),
            ],
            'infraestrutura' => [
                'pontos_luz' => $this->safeCount('pontos_luz'),
                'redes_agua' => $this->safeCount('redes_agua'),
                'pocos' => $this->safeCount('pocos'),
                'trechos' => $this->safeCount('trechos'),
            ],
        ];

        return view('consulta.relatorios.index', compact('stats'));
    }

    private function safeCount(string $table): int
    {
        try {
            if (!Schema::hasTable($table)) {
                return 0;
            }
            return DB::table($table)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function safeCountWhere(string $table, string $column, $value): int
    {
        try {
            if (!Schema::hasTable($table)) {
                return 0;
            }
            return DB::table($table)->where($column, $value)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getDemandasPorTipo()
    {
        return $this->safeQuery('demandas', function($query) {
            return $query->select('tipo', DB::raw('count(*) as total'))
                ->groupBy('tipo')
                ->get()
                ->pluck('total', 'tipo')
                ->toArray();
        }, []);
    }

    private function safeQuery(string $table, callable $callback, $default = null)
    {
        try {
            if (!Schema::hasTable($table)) {
                return $default;
            }
            $query = DB::table($table);
            return $callback($query);
        } catch (\Exception $e) {
            return $default;
        }
    }
}

