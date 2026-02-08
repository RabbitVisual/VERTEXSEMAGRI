<?php

namespace Modules\Materiais\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Materiais\App\Models\Material;
use Modules\Materiais\App\Models\MaterialMovimentacao;
use Modules\Materiais\App\Models\CategoriaMaterial;
use Modules\Materiais\App\Models\SubcategoriaMaterial;
use Modules\Notificacoes\App\Traits\SendsNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class MateriaisController extends Controller
{
    use ExportsData, ChecksModuleEnabled, SendsNotifications;

    public function __construct()
    {
        $this->ensureModuleEnabled('Materiais');
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

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

        $materiais = $query->with('subcategoria.categoria')->orderBy('nome')->paginate(20);

        // Carregar categorias para o filtro
        $categorias = CategoriaMaterial::with('subcategorias')->where('ativo', true)->ordenadas()->get();

        // Estatísticas
        // Estatísticas
        $stats = [
            'total' => Material::count(),
            'ativos' => Material::where('ativo', true)->count(),
            'baixo_estoque' => Material::baixoEstoque()->count(),
            'sem_estoque' => Material::semEstoque()->count(),
            'valor_total_estoque' => Material::where('ativo', true)
                ->whereNotNull('valor_unitario')
                ->get()
                ->sum(function($material) {
                    return $material->valor_total_estoque;
                }),
        ];

        return view('materiais::index', compact('materiais', 'filters', 'stats', 'categorias'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['subcategoria_id', 'categoria_id', 'ativo', 'baixo_estoque', 'search']);
        $query = Material::with('subcategoria.categoria');

        // Aplicar mesmos filtros
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

        if (isset($filters['baixo_estoque']) && $filters['baixo_estoque'] == '1') {
            $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
        }

        $materiais = $query->get();

        $columns = [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'categoria' => 'Categoria',
            'subcategoria' => 'Subcategoria',
            'unidade_medida' => 'Unidade',
            'quantidade_estoque' => 'Estoque',
            'quantidade_minima' => 'Mínimo',
            'valor_unitario' => 'Valor Unitário',
            'valor_total_estoque' => 'Valor Total Estoque',
            'fornecedor' => 'Fornecedor',
            'ativo' => 'Status',
        ];

        // Adicionar valor total do estoque e formatar
        $materiais = $materiais->map(function($material) {
            $material->valor_total_estoque = $material->valor_total_estoque;
            $material->ativo = $material->ativo ? 'Ativo' : 'Inativo';
            if ($material->subcategoria) {
                $material->categoria = $material->subcategoria->categoria->nome ?? '';
                $material->subcategoria = $material->subcategoria->nome;
            } else {
                $material->categoria = $material->categoria_formatada;
                $material->subcategoria = '';
            }
            return $material;
        });

        $format = $request->get('format', 'csv');
        $filename = 'materiais_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($materiais, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($materiais, $columns, $filename, 'Relatório de Materiais');
        } else {
            return $this->exportCsv($materiais, $columns, $filename);
        }
    }

    public function create()
    {
        $categorias = CategoriaMaterial::with(['subcategorias' => function($q) {
            $q->with(['campos' => function($query) {
                $query->where('ativo', true)->orderBy('ordem');
            }])->where('ativo', true)->orderBy('ordem');
        }])
        ->where('ativo', true)
        ->ordenadas()
        ->get();

        return view('materiais::create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'subcategoria_id' => 'required|exists:subcategorias_materiais,id',
            'unidade_medida' => 'required|string|max:20',
            'quantidade_estoque' => 'required|numeric|min:0',
            'quantidade_minima' => 'required|numeric|min:0',
            'valor_unitario' => 'nullable|numeric|min:0',
            'fornecedor' => 'nullable|string|max:255',
            'localizacao_estoque' => 'nullable|string|max:255',
            'ativo' => 'boolean',
            'campos_especificos' => 'nullable|array',
        ]);

        // Obter subcategoria para gerar código
        $subcategoria = SubcategoriaMaterial::findOrFail($validated['subcategoria_id']);
        $validated['categoria'] = $subcategoria->slug; // Manter compatibilidade
        $validated['codigo'] = Material::generateCode('MAT', $subcategoria->slug);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        // Processar campos específicos
        if ($request->has('campos_especificos') && is_array($request->campos_especificos)) {
            $validated['campos_especificos'] = array_filter($request->campos_especificos, function($value) {
                return $value !== null && $value !== '';
            });
        }

        $material = Material::create($validated);

        // Verificar se estoque está baixo ao criar
        $this->verificarEstoqueBaixo($material, 0);

        return redirect()->route('materiais.index')
            ->with('success', 'Material criado com sucesso');
    }

    public function show($id)
    {
        $material = Material::with([
            'subcategoria.categoria',
            'subcategoria.campos',
            'movimentacoes.usuario',
            'movimentacoes.ordemServico',
            'ordensServico'
        ])->findOrFail($id);
        return view('materiais::show', compact('material'));
    }

    public function edit($id)
    {
        $material = Material::with('subcategoria.categoria', 'subcategoria.campos')->findOrFail($id);

        $categorias = CategoriaMaterial::with(['subcategorias' => function($q) {
            $q->with(['campos' => function($query) {
                $query->where('ativo', true)->orderBy('ordem');
            }])->where('ativo', true)->orderBy('ordem');
        }])
        ->where('ativo', true)
        ->ordenadas()
        ->get();

        return view('materiais::edit', compact('material', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $oldEstoque = $material->quantidade_estoque;

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'subcategoria_id' => 'required|exists:subcategorias_materiais,id',
            'unidade_medida' => 'required|string|max:20',
            'quantidade_estoque' => 'required|numeric|min:0',
            'quantidade_minima' => 'required|numeric|min:0',
            'valor_unitario' => 'nullable|numeric|min:0',
            'fornecedor' => 'nullable|string|max:255',
            'localizacao_estoque' => 'nullable|string|max:255',
            'campos_especificos' => 'nullable|array',
            'ativo' => 'boolean',
        ]);

        // Obter subcategoria para gerar código
        $subcategoria = SubcategoriaMaterial::findOrFail($validated['subcategoria_id']);
        $validated['categoria'] = $subcategoria->slug; // Manter compatibilidade
        if (empty($material->codigo)) {
            $validated['codigo'] = Material::generateCode('MAT', $subcategoria->slug);
        }

        // Processar campos específicos
        if ($request->has('campos_especificos') && is_array($request->campos_especificos)) {
            $validated['campos_especificos'] = array_filter($request->campos_especificos, function($value) {
                return !empty($value);
            });
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        // Registrar movimentação se estoque mudou
        if ($validated['quantidade_estoque'] != $oldEstoque && Schema::hasTable('material_movimentacoes')) {
            $diferenca = $validated['quantidade_estoque'] - $oldEstoque;

            if ($diferenca > 0) {
                $material->adicionarEstoque(abs($diferenca), 'Ajuste manual de estoque');
            } else {
                try {
                    $material->removerEstoque(abs($diferenca), 'Ajuste manual de estoque');
                } catch (\Exception $e) {
                    // Se não houver estoque suficiente, apenas atualizar sem movimentação
                }
            }
        }

        $material->update($validated);

        // Verificar se estoque está baixo após atualização
        $material->refresh();
        $this->verificarEstoqueBaixo($material, $oldEstoque);

        return redirect()->route('materiais.index')
            ->with('success', 'Material atualizado com sucesso');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);

        // Verificar se pode ser deletado
        if (!$material->podeSerDeletado()) {
            return redirect()->route('materiais.index')
                ->with('error', 'Não é possível deletar este material pois ele possui movimentações ou está vinculado a ordens de serviço.');
        }

        $material->delete();

        return redirect()->route('materiais.index')
            ->with('success', 'Material deletado com sucesso');
    }

    /**
     * Adiciona estoque ao material
     */
    public function adicionarEstoque(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $oldEstoque = $material->quantidade_estoque;

        $validated = $request->validate([
            'quantidade' => 'required|numeric|min:0.01',
            'motivo' => 'required|string|max:255',
            'valor_unitario' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string',
        ]);

        try {
            $movimentacao = $material->adicionarEstoque(
                $validated['quantidade'],
                $validated['motivo'],
                null,
                $validated['valor_unitario'] ?? null
            );

            if (!empty($validated['observacoes'])) {
                $movimentacao->update(['observacoes' => $validated['observacoes']]);
            }

            // Verificar se ainda está com estoque baixo após adicionar
            $material->refresh();
            $this->verificarEstoqueBaixo($material, $oldEstoque);

            return redirect()->route('materiais.show', $material)
                ->with('success', 'Estoque adicionado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao adicionar estoque: ' . $e->getMessage());
        }
    }

    /**
     * Remove estoque do material
     */
    public function removerEstoque(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $oldEstoque = $material->quantidade_estoque;

        $validated = $request->validate([
            'quantidade' => 'required|numeric|min:0.01',
            'motivo' => 'required|string|max:255',
            'valor_unitario' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string',
        ]);

        try {
            $movimentacao = $material->removerEstoque(
                $validated['quantidade'],
                $validated['motivo'],
                null,
                $validated['valor_unitario'] ?? null
            );

            if (!empty($validated['observacoes'])) {
                $movimentacao->update(['observacoes' => $validated['observacoes']]);
            }

            // Verificar se estoque ficou baixo após remover
            $material->refresh();
            $this->verificarEstoqueBaixo($material, $oldEstoque);

            return redirect()->route('materiais.show', $material)
                ->with('success', 'Estoque removido com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao remover estoque: ' . $e->getMessage());
        }
    }

    /**
     * Verifica se o estoque está baixo e envia notificação se necessário
     */
    protected function verificarEstoqueBaixo(Material $material, float $oldEstoque): void
    {
        try {
            // Verificar se está com estoque baixo agora
            $estaBaixoAgora = $material->estaComEstoqueBaixo();
            $estavaBaixoAntes = $oldEstoque <= $material->quantidade_minima;

            // Só enviar notificação se:
            // 1. Está baixo agora E não estava baixo antes (acabou de ficar baixo)
            // 2. OU está baixo agora E não foi enviado alerta nas últimas 24 horas
            if ($estaBaixoAgora && (!$estavaBaixoAntes || !$material->ultimo_alerta_estoque || $material->ultimo_alerta_estoque->lt(now()->subHours(24)))) {
                $tipoNotificacao = $material->quantidade_estoque <= 0 ? 'error' : 'warning';
                $mensagem = $material->quantidade_estoque <= 0
                    ? "O material {$material->nome} ({$material->codigo}) está SEM ESTOQUE!"
                    : "O material {$material->nome} ({$material->codigo}) está com estoque baixo: {$material->quantidade_estoque} {$material->unidade_medida} (mínimo: {$material->quantidade_minima} {$material->unidade_medida})";

                // Notificar admins
                $this->notifyRole(
                    'admin',
                    $tipoNotificacao,
                    $material->quantidade_estoque <= 0 ? 'Material Sem Estoque' : 'Material com Estoque Baixo',
                    $mensagem,
                    route('admin.materiais.show', $material->id),
                    [
                        'material_id' => $material->id,
                        'codigo' => $material->codigo,
                        'nome' => $material->nome,
                        'quantidade_estoque' => $material->quantidade_estoque,
                        'quantidade_minima' => $material->quantidade_minima,
                        'categoria' => $material->categoria,
                    ],
                    'Materiais',
                    Material::class,
                    $material->id
                );

                // Atualizar timestamp do último alerta
                $material->update(['ultimo_alerta_estoque' => now()]);
            }
        } catch (\Exception $e) {
            // Log do erro mas não interrompe o fluxo
            Log::warning('Erro ao verificar estoque baixo: ' . $e->getMessage(), [
                'material_id' => $material->id,
                'error' => $e->getTraceAsString(),
            ]);
        }
    }
}

