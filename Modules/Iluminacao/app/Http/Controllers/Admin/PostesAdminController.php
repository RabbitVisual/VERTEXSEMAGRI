<?php

namespace Modules\Iluminacao\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Iluminacao\App\Models\Poste;
use Modules\Iluminacao\App\Services\NeoenergiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        $postes = Poste::all();
        $csvFileName = 'audit_neoenergia_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($postes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Codigo', 'Latitude', 'Longitude', 'Tipo Lampada', 'Potencia', 'Logradouro', 'Bairro', 'Trafo', 'Barramento']);

            foreach ($postes as $poste) {
                fputcsv($file, [
                    $poste->codigo,
                    $poste->latitude,
                    $poste->longitude,
                    $this->neoenergiaService->translateToNeoenergia($poste->tipo_lampada),
                    $poste->potencia,
                    $poste->logradouro,
                    $poste->bairro,
                    $poste->trafo,
                    $poste->barramento ? 'Sim' : 'Não'
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
