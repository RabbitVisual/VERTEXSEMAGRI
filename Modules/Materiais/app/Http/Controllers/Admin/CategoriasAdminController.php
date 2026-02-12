<?php

namespace Modules\Materiais\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Materiais\App\Models\CategoriaMaterial;
use Modules\Materiais\App\Models\SubcategoriaMaterial;
use Modules\Materiais\App\Models\CampoCategoriaMaterial;
use Illuminate\Http\Request;

class CategoriasAdminController extends Controller
{
    // ========== CATEGORIAS ==========

    public function index()
    {
        $categorias = CategoriaMaterial::with(['subcategorias' => function($q) {
            $q->withCount('materiais')->orderBy('ordem');
        }])
        ->withCount(['materiais', 'subcategorias'])
        ->ordenadas()
        ->get();

        return view('materiais::admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('materiais::admin.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categorias_materiais,slug',
            'icone' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['nome']);
        }

        CategoriaMaterial::create($validated);

        return redirect()->route('admin.materiais.categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(CategoriaMaterial $categoria)
    {
        return view('materiais::admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, CategoriaMaterial $categoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categorias_materiais,slug,' . $categoria->id,
            'icone' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['nome']);
        }

        $categoria->update($validated);

        return redirect()->route('admin.materiais.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(CategoriaMaterial $categoria)
    {
        if ($categoria->materiais()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir categoria que possui materiais cadastrados.');
        }

        $categoria->delete();

        return redirect()->route('admin.materiais.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }

    // ========== SUBCATEGORIAS ==========

    public function subcategoriasIndex($categoriaId)
    {
        $categoria = CategoriaMaterial::findOrFail($categoriaId);
        $subcategorias = SubcategoriaMaterial::where('categoria_id', $categoriaId)
            ->withCount('materiais')
            ->withCount('campos as total_campos')
            ->ordenadas()
            ->get();

        return view('materiais::admin.categorias.subcategorias.index', compact('categoria', 'subcategorias'));
    }

    public function subcategoriasCreate($categoriaId)
    {
        $categoria = CategoriaMaterial::findOrFail($categoriaId);
        return view('materiais::admin.categorias.subcategorias.create', compact('categoria'));
    }

    public function subcategoriasStore(Request $request, $categoriaId)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategorias_materiais,slug',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['nome']);
        }

        $validated['categoria_id'] = $categoriaId;
        SubcategoriaMaterial::create($validated);

        return redirect()->route('admin.materiais.categorias.subcategorias.index', $categoriaId)
            ->with('success', 'Subcategoria criada com sucesso!');
    }

    public function subcategoriasEdit($categoriaId, SubcategoriaMaterial $subcategoria)
    {
        $categoria = CategoriaMaterial::findOrFail($categoriaId);
        return view('materiais::admin.categorias.subcategorias.edit', compact('categoria', 'subcategoria'));
    }

    public function subcategoriasUpdate(Request $request, $categoriaId, SubcategoriaMaterial $subcategoria)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategorias_materiais,slug,' . $subcategoria->id,
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['nome']);
        }

        $subcategoria->update($validated);

        return redirect()->route('admin.materiais.categorias.subcategorias.index', $categoriaId)
            ->with('success', 'Subcategoria atualizada com sucesso!');
    }

    public function subcategoriasDestroy($categoriaId, SubcategoriaMaterial $subcategoria)
    {
        if ($subcategoria->materiais()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir subcategoria que possui materiais cadastrados.');
        }

        $subcategoria->delete();

        return redirect()->route('admin.materiais.categorias.subcategorias.index', $categoriaId)
            ->with('success', 'Subcategoria excluída com sucesso!');
    }

    // ========== CAMPOS ==========

    public function camposIndex($categoriaId, $subcategoriaId)
    {
        $categoria = CategoriaMaterial::findOrFail($categoriaId);
        $subcategoria = SubcategoriaMaterial::findOrFail($subcategoriaId);
        $campos = CampoCategoriaMaterial::where('subcategoria_id', $subcategoriaId)
            ->ordenados()
            ->get();

        return view('materiais::admin.categorias.campos.index', compact('categoria', 'subcategoria', 'campos'));
    }

    public function camposCreate($categoriaId, $subcategoriaId)
    {
        $categoria = CategoriaMaterial::findOrFail($categoriaId);
        $subcategoria = SubcategoriaMaterial::findOrFail($subcategoriaId);
        return view('materiais::admin.categorias.campos.create', compact('categoria', 'subcategoria'));
    }

    public function camposStore(Request $request, $categoriaId, $subcategoriaId)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'tipo' => 'required|in:text,number,select,textarea,date,boolean',
            'opcoes' => 'nullable|string', // JSON string
            'placeholder' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'obrigatorio' => 'boolean',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['nome']);
        }

        if (!empty($validated['opcoes']) && is_string($validated['opcoes'])) {
            // Converter string separada por vírgulas ou quebras de linha em array
            $opcoes = array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $validated['opcoes']))));
            $validated['opcoes'] = json_encode($opcoes);
        }

        $validated['subcategoria_id'] = $subcategoriaId;
        CampoCategoriaMaterial::create($validated);

        return redirect()->route('admin.materiais.categorias.subcategorias.campos.index', [$categoriaId, $subcategoriaId])
            ->with('success', 'Campo criado com sucesso!');
    }

    public function camposEdit($categoriaId, $subcategoriaId, CampoCategoriaMaterial $campo)
    {
        $categoria = CategoriaMaterial::findOrFail($categoriaId);
        $subcategoria = SubcategoriaMaterial::findOrFail($subcategoriaId);
        return view('materiais::admin.categorias.campos.edit', compact('categoria', 'subcategoria', 'campo'));
    }

    public function camposUpdate(Request $request, $categoriaId, $subcategoriaId, CampoCategoriaMaterial $campo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'tipo' => 'required|in:text,number,select,textarea,date,boolean',
            'opcoes' => 'nullable|string',
            'placeholder' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'obrigatorio' => 'boolean',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['nome']);
        }

        if (!empty($validated['opcoes']) && is_string($validated['opcoes'])) {
            $opcoes = array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $validated['opcoes']))));
            $validated['opcoes'] = json_encode($opcoes);
        }

        $campo->update($validated);

        return redirect()->route('admin.materiais.categorias.subcategorias.campos.index', [$categoriaId, $subcategoriaId])
            ->with('success', 'Campo atualizado com sucesso!');
    }

    public function camposDestroy($categoriaId, $subcategoriaId, CampoCategoriaMaterial $campo)
    {
        $campo->delete();

        return redirect()->route('admin.materiais.categorias.subcategorias.campos.index', [$categoriaId, $subcategoriaId])
            ->with('success', 'Campo excluído com sucesso!');
    }
}
