<?php

namespace Modules\Materiais\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Materiais\App\Models\Material;
use Modules\Materiais\App\Models\CategoriaMaterial;
use Illuminate\Http\Request;

class MateriaisAdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['subcategoria_id', 'categoria_id', 'ativo', 'baixo_estoque', 'search']);
        $query = Material::with('subcategoria.categoria');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nome', 'like', "%{$search}%")
                  ->orWhereHas('subcategoria', function($sq) use ($search) {
                      $sq->where('nome', 'like', "%{$search}%");
                  })
                  ->orWhereHas('subcategoria.categoria', function($cq) use ($search) {
                      $cq->where('nome', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['subcategoria_id'])) {
            $query->where('subcategoria_id', $filters['subcategoria_id']);
        } elseif (!empty($filters['categoria_id'])) {
            $query->whereHas('subcategoria', function($q) use ($filters) {
                $q->where('categoria_id', $filters['categoria_id']);
            });
        }

        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo']);
        }

        if (isset($filters['baixo_estoque']) && $filters['baixo_estoque'] == '1') {
            $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
        }

        $materiais = $query->orderBy('nome')->paginate(20);
        
        // Carregar categorias para o filtro
        $categorias = CategoriaMaterial::with('subcategorias')->where('ativo', true)->ordenadas()->get();

        // Estatísticas
        $estatisticas = [
            'total' => Material::count(),
            'ativos' => Material::where('ativo', true)->count(),
            'baixo_estoque' => Material::baixoEstoque()->count(),
            'sem_estoque' => Material::semEstoque()->count(),
        ];

        return view('materiais::admin.index', compact('materiais', 'filters', 'estatisticas', 'categorias'));
    }

    public function show($id)
    {
        $material = Material::with([
            'subcategoria.categoria',
            'subcategoria.campos',
            'movimentacoes' => function($query) {
                $query->with(['ordemServico', 'usuario'])->orderBy('created_at', 'desc')->limit(20);
            },
            'ordensServico' => function($query) {
                $query->with(['demanda', 'equipe'])->orderBy('created_at', 'desc')->limit(10);
            }
        ])->findOrFail($id);

        // Estatísticas do material (usando accessor)
        $estatisticas = $material->estatisticas;
        $estatisticas['total_movimentacoes'] = $material->movimentacoes()->count();
        $estatisticas['entradas'] = $material->movimentacoes()->where('tipo', 'entrada')->count();
        $estatisticas['saidas'] = $material->movimentacoes()->where('tipo', 'saida')->count();
        $estatisticas['baixo_estoque'] = $material->quantidade_estoque <= $material->quantidade_minima;
        $estatisticas['sem_estoque'] = $material->quantidade_estoque <= 0;

        // Ordens recentes
        $ordensRecentes = $material->ordensServico()
            ->with(['demanda', 'equipe'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('materiais::admin.show', compact('material', 'estatisticas', 'ordensRecentes'));
    }
}

