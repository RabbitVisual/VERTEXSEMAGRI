<?php

namespace Modules\Iluminacao\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Iluminacao\App\Models\PontoLuz;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class IluminacaoController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Iluminacao');
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['status', 'tipo_lampada', 'localidade_id', 'search']);
        $query = PontoLuz::with('localidade');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('endereco', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_lampada'])) {
            $query->where('tipo_lampada', $filters['tipo_lampada']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $pontos = $query->orderBy('created_at', 'desc')->paginate(20);
        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome')->orderBy('nome')->get();
        }

        return view('iluminacao::index', compact('pontos', 'localidades', 'filters'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status', 'tipo_lampada', 'localidade_id', 'search']);
        $query = PontoLuz::with('localidade');

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

        $pontos = $query->get();

        $columns = [
            'codigo' => 'Código',
            'localidade.nome' => 'Localidade',
            'endereco' => 'Endereço',
            'tipo_lampada' => 'Tipo Lâmpada',
            'potencia' => 'Potência',
            'status' => 'Status',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'pontos_luz_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($pontos, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($pontos, $columns, $filename, 'Relatório de Pontos de Luz');
        } else {
            return $this->exportCsv($pontos, $columns, $filename);
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
            return redirect()->route('iluminacao.index')
                ->with('warning', 'É necessário cadastrar pelo menos uma localidade antes de criar um ponto de luz. <a href="' . route('localidades.create') . '" class="alert-link">Cadastrar localidade</a>');
        }

        return view('iluminacao::create', compact('localidades', 'hasLocalidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'localidade_id' => 'required|exists:localidades,id',
            'endereco' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nome_mapa' => 'nullable|string|max:255',
            'tipo_lampada' => 'nullable|string|max:100',
            'potencia' => 'nullable|integer',
            'tipo_poste' => 'nullable|string|max:100',
            'altura_poste' => 'nullable|numeric|min:0',
            'tipo_fiacao' => 'nullable|string|max:100',
            'data_instalacao' => 'nullable|date',
            'ultima_manutencao' => 'nullable|date',
            'status' => 'required|in:funcionando,com_defeito,desligado',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente sempre
        $validated['codigo'] = PontoLuz::generateCode('PL', $validated['tipo_lampada'] ?? null);

        PontoLuz::create($validated);

        return redirect()->route('iluminacao.index')
            ->with('success', 'Ponto de luz criado com sucesso');
    }

    public function show($id)
    {
        $ponto = PontoLuz::with(['localidade'])->findOrFail($id);
        return view('iluminacao::show', compact('ponto'));
    }

    public function edit($id)
    {
        $ponto = PontoLuz::findOrFail($id);
        $localidades = [];
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::select('id', 'nome')->get();
        }
        return view('iluminacao::edit', compact('ponto', 'localidades'));
    }

    public function update(Request $request, $id)
    {
        $ponto = PontoLuz::findOrFail($id);

        $validated = $request->validate([
            'localidade_id' => 'required|exists:localidades,id',
            'endereco' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nome_mapa' => 'nullable|string|max:255',
            'tipo_lampada' => 'nullable|string|max:100',
            'potencia' => 'nullable|integer',
            'tipo_poste' => 'nullable|string|max:100',
            'altura_poste' => 'nullable|numeric|min:0',
            'tipo_fiacao' => 'nullable|string|max:100',
            'data_instalacao' => 'nullable|date',
            'ultima_manutencao' => 'nullable|date',
            'status' => 'required|in:funcionando,com_defeito,desligado',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente se estiver vazio ou não existir
        if (empty($ponto->codigo)) {
            $validated['codigo'] = PontoLuz::generateCode('PL', $validated['tipo_lampada'] ?? null);
        }

        $ponto->update($validated);

        return redirect()->route('iluminacao.index')
            ->with('success', 'Ponto de luz atualizado com sucesso');
    }

    public function destroy($id)
    {
        $ponto = PontoLuz::findOrFail($id);
        $ponto->delete();

        return redirect()->route('iluminacao.index')
            ->with('success', 'Ponto de luz deletado com sucesso');
    }
}
