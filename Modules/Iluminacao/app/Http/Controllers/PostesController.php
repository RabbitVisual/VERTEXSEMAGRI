<?php

namespace Modules\Iluminacao\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Iluminacao\App\Models\Poste;
use Illuminate\Http\Request;

class PostesController extends Controller
{
    public function index(Request $request)
    {
        $query = Poste::query();
        if ($request->has('search')) {
            $query->where('codigo', 'like', "%{$request->search}%")
                  ->orWhere('logradouro', 'like', "%{$request->search}%")
                  ->orWhere('bairro', 'like', "%{$request->search}%");
        }
        $postes = $query->latest()->paginate(20);
        return view('iluminacao::postes.index', compact('postes'));
    }

    public function create()
    {
        return view('iluminacao::postes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:postes,codigo',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'tipo_lampada' => 'nullable|string',
            'potencia' => 'nullable|integer',
            'logradouro' => 'nullable|string',
            'bairro' => 'nullable|string',
            'condicao' => 'nullable|string|in:bom,regular,ruim,critico',
            'tipo_poste' => 'nullable|string',
            'trafo' => 'nullable|string',
            'barramento' => 'boolean',
            'observacoes' => 'nullable|string',
        ]);

        Poste::create($validated);
        return redirect()->route('co-admin.iluminacao.postes.index')
            ->with('success', 'Poste cadastrado com sucesso no inventário.');
    }

    public function show($id)
    {
        $poste = Poste::findOrFail($id);
        return view('iluminacao::postes.show', compact('poste'));
    }

    public function edit($id)
    {
        $poste = Poste::findOrFail($id);
        return view('iluminacao::postes.edit', compact('poste'));
    }

    public function update(Request $request, $id)
    {
        $poste = Poste::findOrFail($id);
        $validated = $request->validate([
            'codigo' => 'required|unique:postes,codigo,' . $id,
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'tipo_lampada' => 'nullable|string',
            'potencia' => 'nullable|integer',
            'logradouro' => 'nullable|string',
            'bairro' => 'nullable|string',
            'condicao' => 'nullable|string|in:bom,regular,ruim,critico',
            'tipo_poste' => 'nullable|string',
            'trafo' => 'nullable|string',
            'barramento' => 'boolean',
            'observacoes' => 'nullable|string',
        ]);

        $poste->update($validated);
        return redirect()->route('co-admin.iluminacao.postes.index')
            ->with('success', 'Registro do poste atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $poste = Poste::findOrFail($id);
        $poste->delete();
        return redirect()->route('co-admin.iluminacao.postes.index')
            ->with('success', 'Poste removido permanentemente do inventário.');
    }
}
