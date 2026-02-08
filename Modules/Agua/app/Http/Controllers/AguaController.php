<?php

namespace Modules\Agua\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Agua\App\Models\RedeAgua;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AguaController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Agua');
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['status', 'tipo_rede', 'localidade_id', 'search']);
        $query = RedeAgua::with('localidade');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('material', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_rede'])) {
            $query->where('tipo_rede', $filters['tipo_rede']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $redes = $query->orderBy('created_at', 'desc')->paginate(20);
        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome')->orderBy('nome')->get();
        }

        return view('agua::index', compact('redes', 'localidades', 'filters'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status', 'tipo_rede', 'localidade_id', 'search']);
        $query = RedeAgua::with('localidade');

        // Aplicar mesmos filtros
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_rede'])) {
            $query->where('tipo_rede', $filters['tipo_rede']);
        }

        $redes = $query->get();

        $columns = [
            'codigo' => 'Código',
            'localidade.nome' => 'Localidade',
            'tipo_rede' => 'Tipo',
            'diametro' => 'Diâmetro',
            'extensao_metros' => 'Extensão (m)',
            'status' => 'Status',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'redes_agua_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($redes, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($redes, $columns, $filename, 'Relatório de Redes de Água');
        } else {
            return $this->exportCsv($redes, $columns, $filename);
        }
    }

    public function create()
    {
        $localidades = collect([]);
        $hasLocalidades = false;
        
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
            $hasLocalidades = $localidades->count() > 0;
        }

        // Se não há localidades, mostrar alerta
        if (!$hasLocalidades) {
            return redirect()->route('agua.index')
                ->with('warning', 'É necessário cadastrar pelo menos uma localidade antes de criar uma rede de água. <a href="' . route('localidades.create') . '" class="alert-link">Cadastrar localidade</a>');
        }

        return view('agua::create', compact('localidades', 'hasLocalidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'localidade_id' => 'required|exists:localidades,id',
            'tipo_rede' => 'required|in:principal,secundaria,ramal',
            'diametro' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'extensao_metros' => 'nullable|numeric|min:0',
            'data_instalacao' => 'nullable|date',
            'status' => 'required|in:funcionando,com_vazamento,interrompida',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente sempre
        $validated['codigo'] = RedeAgua::generateCode('RED', $validated['tipo_rede']);

        RedeAgua::create($validated);

        return redirect()->route('agua.index')
            ->with('success', 'Rede de água criada com sucesso');
    }

    public function show($id)
    {
        $rede = RedeAgua::with(['localidade', 'pontosDistribuicao'])->findOrFail($id);
        return view('agua::show', compact('rede'));
    }

    public function edit($id)
    {
        $rede = RedeAgua::findOrFail($id);
        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }
        return view('agua::edit', compact('rede', 'localidades'));
    }

    public function update(Request $request, $id)
    {
        $rede = RedeAgua::findOrFail($id);
        
        $validated = $request->validate([
            'localidade_id' => 'required|exists:localidades,id',
            'tipo_rede' => 'required|in:principal,secundaria,ramal',
            'diametro' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'extensao_metros' => 'nullable|numeric|min:0',
            'data_instalacao' => 'nullable|date',
            'status' => 'required|in:funcionando,com_vazamento,interrompida',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente se estiver vazio ou não existir
        if (empty($rede->codigo)) {
            $validated['codigo'] = RedeAgua::generateCode('RED', $validated['tipo_rede']);
        }

        $rede->update($validated);

        return redirect()->route('agua.index')
            ->with('success', 'Rede de água atualizada com sucesso');
    }

    public function destroy($id)
    {
        $rede = RedeAgua::findOrFail($id);
        $rede->delete();

        return redirect()->route('agua.index')
            ->with('success', 'Rede de água deletada com sucesso');
    }
}
