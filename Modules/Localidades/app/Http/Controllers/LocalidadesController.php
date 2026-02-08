<?php

namespace Modules\Localidades\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;

class LocalidadesController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Localidades');
    }
    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['tipo', 'ativo', 'cidade', 'search']);
        $query = Localidade::query();

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%")
                  ->orWhere('bairro', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }
        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo']);
        }
        if (!empty($filters['cidade'])) {
            $query->where('cidade', 'like', '%' . $filters['cidade'] . '%');
        }

        // Ordenar por tipo primeiro, depois por nome para melhor organização
        $localidades = $query->orderBy('tipo')->orderBy('nome')->paginate(50);

        // Estatísticas por tipo (apenas se não houver filtros aplicados)
        $estatisticas = [];
        if (empty($filters['tipo']) && empty($filters['search']) && empty($filters['cidade'])) {
            $estatisticas = Localidade::selectRaw('tipo, COUNT(*) as total')
                ->where('ativo', true)
                ->groupBy('tipo')
                ->orderBy('tipo')
                ->pluck('total', 'tipo')
                ->toArray();
        }

        $totalGeral = Localidade::where('ativo', true)->count();

        return view('localidades::index', compact('localidades', 'filters', 'estatisticas', 'totalGeral'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['tipo', 'ativo', 'cidade', 'search']);
        $query = Localidade::query();

        // Aplicar mesmos filtros
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }
        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo']);
        }

        $localidades = $query->get();

        $columns = [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'numero_moradores' => 'Moradores',
            'ativo' => 'Status',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'localidades_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($localidades, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($localidades, $columns, $filename, 'Relatório de Localidades');
        } else {
            return $this->exportCsv($localidades, $columns, $filename);
        }
    }

    public function create()
    {
        return view('localidades::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:alameda,avenida,bairro,beco,comunidade,distrito,estrada,fazenda,jardim,povoado,praca,rua,sitio,zona_rural,outro',
            'cep' => 'nullable|string|max:10',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nome_mapa' => 'nullable|string|max:255',
            'lider_comunitario' => 'nullable|string|max:255',
            'telefone_lider' => 'nullable|string|max:20',
            'numero_moradores' => 'nullable|integer|min:0',
            'infraestrutura_disponivel' => 'nullable|string',
            'problemas_recorrentes' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        // Gera código automaticamente sempre
        $validated['codigo'] = Localidade::generateCode('LOC', $validated['tipo']);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        // Garantir valores padrão para campos nullable
        if (!isset($validated['numero_moradores']) || $validated['numero_moradores'] === null) {
            $validated['numero_moradores'] = 0;
        }

        Localidade::create($validated);

        return redirect()->route('localidades.index')
            ->with('success', 'Localidade criada com sucesso');
    }

    public function show($id)
    {
        $localidade = Localidade::with(['familias', 'demandas', 'pessoas'])->findOrFail($id);

        // Estatísticas de pessoas
        $estatisticasPessoas = [
            'total' => $localidade->total_pessoas,
            'beneficiarias_pbf' => $localidade->total_beneficiarias_pbf,
        ];

        return view('localidades::show', compact('localidade', 'estatisticasPessoas'));
    }

    public function getDados($id)
    {
        $localidade = Localidade::findOrFail($id);

        return response()->json([
            'id' => $localidade->id,
            'nome' => $localidade->nome,
            'latitude' => $localidade->latitude,
            'longitude' => $localidade->longitude,
            'endereco' => $localidade->endereco,
            'numero' => $localidade->numero,
            'complemento' => $localidade->complemento,
            'bairro' => $localidade->bairro,
            'cidade' => $localidade->cidade,
            'estado' => $localidade->estado,
            'cep' => $localidade->cep,
        ]);
    }

    public function edit($id)
    {
        $localidade = Localidade::findOrFail($id);
        return view('localidades::edit', compact('localidade'));
    }

    public function update(Request $request, $id)
    {
        $localidade = Localidade::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:alameda,avenida,bairro,beco,comunidade,distrito,estrada,fazenda,jardim,povoado,praca,rua,sitio,zona_rural,outro',
            'cep' => 'nullable|string|max:10',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nome_mapa' => 'nullable|string|max:255',
            'lider_comunitario' => 'nullable|string|max:255',
            'telefone_lider' => 'nullable|string|max:20',
            'numero_moradores' => 'nullable|integer|min:0',
            'infraestrutura_disponivel' => 'nullable|string',
            'problemas_recorrentes' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        // Gera código automaticamente se estiver vazio ou não existir
        if (empty($localidade->codigo)) {
            $validated['codigo'] = Localidade::generateCode('LOC', $validated['tipo']);
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        // Garantir valores padrão para campos nullable
        if (!isset($validated['numero_moradores']) || $validated['numero_moradores'] === null) {
            $validated['numero_moradores'] = 0;
        }

        $localidade->update($validated);

        return redirect()->route('localidades.index')
            ->with('success', 'Localidade atualizada com sucesso');
    }

    public function destroy($id)
    {
        $localidade = Localidade::findOrFail($id);

        // Verificar se há demandas relacionadas
        if ($localidade->demandas && $localidade->demandas->count() > 0) {
            return redirect()->route('localidades.index')
                ->with('error', 'Não é possível deletar esta localidade pois existem ' . $localidade->demandas->count() . ' demanda(s) vinculada(s).');
        }

        $localidade->delete();

        return redirect()->route('localidades.index')
            ->with('success', 'Localidade deletada com sucesso');
    }
}
