<?php

namespace Modules\ProgramasAgricultura\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Illuminate\Http\Request;

class ProgramasAgriculturaController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('ProgramasAgricultura');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \Modules\ProgramasAgricultura\App\Models\Programa::query();

        if ($request->filled('search')) {
            $query->where('nome', 'like', '%' . $request->search . '%')
                  ->orWhere('codigo', 'like', '%' . $request->search . '%');
        }

        $programas = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('programasagricultura::co-admin.programas.index', compact('programas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('programasagricultura::co-admin.programas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|string',
            'status' => 'required|in:ativo,suspenso,encerrado',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'vagas_disponiveis' => 'nullable|integer|min:0',
            'publico' => 'boolean',
        ]);

        $programa = \Modules\ProgramasAgricultura\App\Models\Programa::create($validated);

        return redirect()->route('co-admin.programas.index')->with('success', 'Programa criado com sucesso!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $programa = \Modules\ProgramasAgricultura\App\Models\Programa::withCount('beneficiarios')->findOrFail($id);
        return view('programasagricultura::co-admin.programas.show', compact('programa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $programa = \Modules\ProgramasAgricultura\App\Models\Programa::findOrFail($id);
        return view('programasagricultura::co-admin.programas.edit', compact('programa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $programa = \Modules\ProgramasAgricultura\App\Models\Programa::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tipo' => 'required|string',
            'status' => 'required|in:ativo,suspenso,encerrado',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'vagas_disponiveis' => 'nullable|integer|min:0',
            'publico' => 'boolean',
        ]);

        $programa->update($validated);

        return redirect()->route('co-admin.programas.index')->with('success', 'Programa atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $programa = \Modules\ProgramasAgricultura\App\Models\Programa::findOrFail($id);

        if ($programa->beneficiarios()->exists()) {
            return redirect()->back()->with('error', 'Não é possível excluir um programa que possui beneficiários.');
        }

        $programa->delete();
        return redirect()->route('co-admin.programas.index')->with('success', 'Programa excluído com sucesso!');
    }
}
