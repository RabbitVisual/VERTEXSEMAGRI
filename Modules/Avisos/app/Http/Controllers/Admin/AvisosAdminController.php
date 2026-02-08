<?php

namespace Modules\Avisos\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Avisos\App\Models\Aviso;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvisosAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Aviso::query()->with('usuario');

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('posicao')) {
            $query->where('posicao', $request->posicao);
        }

        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo === '1');
        }

        $avisos = $query->orderBy('ordem', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Estatísticas
        $estatisticas = [
            'total' => Aviso::count(),
            'ativos' => Aviso::ativos()->count(),
            'inativos' => Aviso::where('ativo', false)->count(),
            'por_tipo' => Aviso::selectRaw('tipo, count(*) as total')
                ->groupBy('tipo')
                ->pluck('total', 'tipo')
                ->toArray(),
            'por_posicao' => Aviso::selectRaw('posicao, count(*) as total')
                ->groupBy('posicao')
                ->pluck('total', 'posicao')
                ->toArray(),
        ];

        return view('avisos::admin.index', compact('avisos', 'estatisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('avisos::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'conteudo' => 'nullable|string',
            'tipo' => 'required|in:info,success,warning,danger,promocao,novidade,anuncio',
            'posicao' => 'required|in:topo,meio,rodape,flutuante',
            'estilo' => 'required|in:banner,announcement,cta,modal,toast',
            'cor_primaria' => 'nullable|string|max:50',
            'cor_secundaria' => 'nullable|string|max:50',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'url_acao' => 'nullable|url|max:500',
            'texto_botao' => 'nullable|string|max:100',
            'botao_exibir' => 'boolean',
            'dismissivel' => 'boolean',
            'ativo' => 'boolean',
            'destacar' => 'boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'ordem' => 'nullable|integer|min:0',
            'configuracoes' => 'nullable|array',
        ]);

        // Upload de imagem
        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('avisos', 'public');
        }

        $validated['user_id'] = auth()->id();

        $aviso = Aviso::create($validated);

        return redirect()
            ->route('admin.avisos.show', $aviso)
            ->with('success', 'Aviso criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aviso $aviso)
    {
        $aviso->load('usuario');

        // Estatísticas do aviso
        $diasRestantes = null;
        if ($aviso->data_fim) {
            $diferenca = now()->diffInDays($aviso->data_fim, false);
            // Se a diferença for negativa, já expirou
            if ($diferenca < 0) {
                $diasRestantes = 0;
            } else {
                // Arredondar para baixo para mostrar apenas dias completos
                $diasRestantes = floor($diferenca);
            }
        }

        $estatisticas = [
            'visualizacoes' => $aviso->visualizacoes,
            'cliques' => $aviso->cliques,
            'taxa_clique' => $aviso->visualizacoes > 0 
                ? number_format(round(($aviso->cliques / $aviso->visualizacoes) * 100, 2), 2, ',', '.') 
                : '0,00',
            'esta_ativo' => $aviso->estaAtivo(),
            'dias_restantes' => $diasRestantes,
        ];

        return view('avisos::admin.show', compact('aviso', 'estatisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aviso $aviso)
    {
        return view('avisos::admin.edit', compact('aviso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aviso $aviso)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'conteudo' => 'nullable|string',
            'tipo' => 'required|in:info,success,warning,danger,promocao,novidade,anuncio',
            'posicao' => 'required|in:topo,meio,rodape,flutuante',
            'estilo' => 'required|in:banner,announcement,cta,modal,toast',
            'cor_primaria' => 'nullable|string|max:50',
            'cor_secundaria' => 'nullable|string|max:50',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'url_acao' => 'nullable|url|max:500',
            'texto_botao' => 'nullable|string|max:100',
            'botao_exibir' => 'boolean',
            'dismissivel' => 'boolean',
            'ativo' => 'boolean',
            'destacar' => 'boolean',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'ordem' => 'nullable|integer|min:0',
            'configuracoes' => 'nullable|array',
            'remover_imagem' => 'boolean',
        ]);

        // Remover imagem se solicitado
        if ($request->boolean('remover_imagem') && $aviso->imagem) {
            Storage::disk('public')->delete($aviso->imagem);
            $validated['imagem'] = null;
        }

        // Upload de nova imagem
        if ($request->hasFile('imagem')) {
            // Remove imagem antiga
            if ($aviso->imagem) {
                Storage::disk('public')->delete($aviso->imagem);
            }
            $validated['imagem'] = $request->file('imagem')->store('avisos', 'public');
        } else {
            unset($validated['imagem']);
        }

        $aviso->update($validated);

        return redirect()
            ->route('admin.avisos.show', $aviso)
            ->with('success', 'Aviso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aviso $aviso)
    {
        // Remove imagem se existir
        if ($aviso->imagem) {
            Storage::disk('public')->delete($aviso->imagem);
        }

        $aviso->delete();

        return redirect()
            ->route('admin.avisos.index')
            ->with('success', 'Aviso excluído com sucesso!');
    }

    /**
     * Toggle ativo/inativo
     */
    public function toggleAtivo(Aviso $aviso)
    {
        $aviso->update(['ativo' => !$aviso->ativo]);

        return back()->with('success', 
            $aviso->ativo ? 'Aviso ativado com sucesso!' : 'Aviso desativado com sucesso!'
        );
    }
}

