<?php

namespace Modules\Estradas\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Estradas\App\Models\Trecho;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EstradasController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Estradas');
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['tipo', 'condicao', 'localidade_id', 'search']);
        $query = Trecho::with('localidade');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nome', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }
        if (!empty($filters['condicao'])) {
            $query->where('condicao', $filters['condicao']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $trechos = $query->orderBy('nome')->paginate(20);
        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome')->orderBy('nome')->get();
        }

        return view('estradas::index', compact('trechos', 'localidades', 'filters'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['tipo', 'condicao', 'localidade_id', 'search']);
        $query = Trecho::with('localidade');

        // Aplicar mesmos filtros
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nome', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }
        if (!empty($filters['condicao'])) {
            $query->where('condicao', $filters['condicao']);
        }

        $trechos = $query->get();

        $columns = [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'localidade.nome' => 'Localidade',
            'tipo' => 'Tipo',
            'extensao_km' => 'Extensão (km)',
            'condicao' => 'Condição',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'estradas_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($trechos, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($trechos, $columns, $filename, 'Relatório de Estradas');
        } else {
            return $this->exportCsv($trechos, $columns, $filename);
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
            return redirect()->route('estradas.index')
                ->with('warning', 'É necessário cadastrar pelo menos uma localidade antes de criar um trecho. <a href="' . route('localidades.create') . '" class="alert-link">Cadastrar localidade</a>');
        }

        return view('estradas::create', compact('localidades', 'hasLocalidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'localidade_id' => 'required|exists:localidades,id',
            'tipo' => 'required|in:vicinal,principal,secundaria',
            'extensao_km' => 'nullable|numeric|min:0',
            'largura_metros' => 'nullable|numeric|min:0',
            'tipo_pavimento' => 'nullable|in:asfalto,cascalho,terra',
            'condicao' => 'required|in:boa,regular,ruim,pessima',
            'tem_ponte' => 'boolean',
            'numero_pontes' => 'nullable|integer|min:0',
            'ultima_manutencao' => 'nullable|date',
            'proxima_manutencao' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente sempre
        $validated['codigo'] = Trecho::generateCode('EST', $validated['tipo']);

        $validated['tem_ponte'] = $request->has('tem_ponte') ? true : false;

        Trecho::create($validated);

        return redirect()->route('estradas.index')
            ->with('success', 'Trecho criado com sucesso');
    }

    public function show($id)
    {
        $trecho = Trecho::with([
            'localidade',
            'historicoManutencoes',
            'demandas.ordemServico',
            'ordensServico.equipe',
            'ordensServico.usuarioAbertura'
        ])->findOrFail($id);

        // Estatísticas do trecho
        $estatisticas = [
            'total_demandas' => $trecho->demandas->count(),
            'demandas_abertas' => $trecho->demandas->where('status', 'aberta')->count(),
            'total_ordens' => $trecho->ordensServico->count(),
            'ordens_pendentes' => $trecho->ordensServico->where('status', 'pendente')->count(),
            'ordens_em_execucao' => $trecho->ordensServico->where('status', 'em_execucao')->count(),
            'ordens_concluidas' => $trecho->ordensServico->where('status', 'concluida')->count(),
            'dias_sem_manutencao' => $trecho->diasSemManutencao(),
            'precisa_manutencao' => $trecho->precisaManutencao(),
        ];

        return view('estradas::show', compact('trecho', 'estatisticas'));
    }

    public function edit($id)
    {
        $trecho = Trecho::findOrFail($id);
        $localidades = [];
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::select('id', 'nome')->get();
        }
        return view('estradas::edit', compact('trecho', 'localidades'));
    }

    public function update(Request $request, $id)
    {
        $trecho = Trecho::findOrFail($id);
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'localidade_id' => 'required|exists:localidades,id',
            'tipo' => 'required|in:vicinal,principal,secundaria',
            'extensao_km' => 'nullable|numeric|min:0',
            'largura_metros' => 'nullable|numeric|min:0',
            'tipo_pavimento' => 'nullable|in:asfalto,cascalho,terra',
            'condicao' => 'required|in:boa,regular,ruim,pessima',
            'tem_ponte' => 'boolean',
            'numero_pontes' => 'nullable|integer|min:0',
            'ultima_manutencao' => 'nullable|date',
            'proxima_manutencao' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente se estiver vazio ou não existir
        if (empty($trecho->codigo)) {
            $validated['codigo'] = Trecho::generateCode('EST', $validated['tipo']);
        }

        $validated['tem_ponte'] = $request->has('tem_ponte') ? true : false;

        $trecho->update($validated);

        return redirect()->route('estradas.index')
            ->with('success', 'Trecho atualizado com sucesso');
    }

    public function destroy($id)
    {
        $trecho = Trecho::findOrFail($id);
        $trecho->delete();

        return redirect()->route('estradas.index')
            ->with('success', 'Trecho deletado com sucesso');
    }
}
