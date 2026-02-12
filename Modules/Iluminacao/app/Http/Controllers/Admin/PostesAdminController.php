<?php

namespace Modules\Iluminacao\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Iluminacao\App\Models\Poste;
use Modules\Iluminacao\App\Services\NeoenergiaService;
use Modules\Iluminacao\Exports\PostesExport;
use Illuminate\Http\Request;

class PostesAdminController extends Controller
{
    protected $neoenergiaService;

    public function __construct(NeoenergiaService $neoenergiaService)
    {
        $this->neoenergiaService = $neoenergiaService;
    }

    public function index(Request $request)
    {
        $query = Poste::query();
        if ($request->has('search')) {
            $query->where('codigo', 'like', "%{$request->search}%")
                  ->orWhere('logradouro', 'like', "%{$request->search}%");
        }
        $postes = $query->paginate(20);
        return view('iluminacao::admin.postes.index', compact('postes'));
    }

    public function create()
    {
        return view('iluminacao::admin.postes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:postes,codigo',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tipo_lampada' => 'nullable|string',
            'potencia' => 'nullable|integer',
            'logradouro' => 'nullable|string',
            'bairro' => 'nullable|string',
            'trafo' => 'nullable|string',
            'barramento' => 'boolean',
        ]);

        Poste::create($validated);
        return redirect()->route('admin.iluminacao.postes.index')->with('success', 'Poste criado com sucesso.');
    }

    public function show($id)
    {
        // Assuming relationship 'movimentacoes' or via orders
        // For now, simple show
        $poste = Poste::findOrFail($id);
        return view('iluminacao::admin.postes.show', compact('poste'));
    }

    public function export()
    {
        $fileName = 'inventario_neoenergia_' . date('Ymd_His') . '.xlsx';
        $export = new PostesExport();
        return $export->download($fileName);
    }
}
