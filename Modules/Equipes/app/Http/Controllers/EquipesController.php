<?php

namespace Modules\Equipes\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Equipes\App\Models\Equipe;
use App\Models\User;
use Modules\Funcionarios\App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EquipesController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Equipes');
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['tipo', 'ativo', 'search']);
        $query = Equipe::with(['lider', 'funcionarios']);

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

        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo']);
        }

        $equipes = $query->orderBy('nome')->paginate(20);

        // Estatísticas
        $stats = [
            'total' => Equipe::count(),
            'ativas' => Equipe::where('ativo', true)->count(),
            'com_funcionarios' => Equipe::has('funcionarios')->count(),
            'sem_funcionarios' => Equipe::doesntHave('funcionarios')->count(),
        ];

        return view('equipes::index', compact('equipes', 'filters', 'stats'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['tipo', 'ativo', 'search']);
        $query = Equipe::with(['lider', 'funcionarios']);

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

        $equipes = $query->get();

        $columns = [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'lider.name' => 'Líder',
            'ativo' => 'Status',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'equipes_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($equipes, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($equipes, $columns, $filename, 'Relatório de Equipes');
        } else {
            return $this->exportCsv($equipes, $columns, $filename);
        }
    }

    public function create()
    {
        // Buscar funcionários ativos para seleção
        $funcionarios = [];
        if (Schema::hasTable('funcionarios')) {
            $funcionarios = Funcionario::where('ativo', true)
                ->orderBy('nome')
                ->select('id', 'nome', 'funcao', 'codigo')
                ->get();
        }

        // Verificar se há funcionários cadastrados
        $hasFuncionarios = count($funcionarios) > 0;

        // Se não há funcionários, mostrar alerta
        if (!$hasFuncionarios) {
            return redirect()->route('equipes.index')
                ->with('warning', 'É necessário cadastrar pelo menos um funcionário antes de criar uma equipe. <a href="' . route('funcionarios.create') . '" class="alert-link">Cadastrar funcionário</a>');
        }

        // Buscar usuários para líder (opcional)
        $users = User::select('id', 'name')->get();

        return view('equipes::create', compact('funcionarios', 'users', 'hasFuncionarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:eletricistas,encanadores,operadores,motoristas,mista',
            'descricao' => 'nullable|string',
            'lider_id' => 'nullable|exists:users,id',
            'ativo' => 'boolean',
            'funcionarios' => 'required|array|min:1',
            'funcionarios.*' => 'exists:funcionarios,id',
        ], [
            'funcionarios.required' => 'É necessário selecionar pelo menos um funcionário para a equipe.',
            'funcionarios.min' => 'É necessário selecionar pelo menos um funcionário para a equipe.',
        ]);

        // Gera código automaticamente sempre
        $validated['codigo'] = Equipe::generateCode('EQP', $validated['tipo']);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $equipe = Equipe::create($validated);

        // Sincronizar funcionários
        if (isset($validated['funcionarios'])) {
            $equipe->funcionarios()->sync($validated['funcionarios']);
        }

        // Validação: Se o líder foi definido, verificar se é funcionário da equipe
        if ($equipe->lider_id && !$equipe->liderEhFuncionario()) {
            // Aviso (não bloqueia, mas informa)
            return redirect()->route('equipes.show', $equipe)
                ->with('warning', 'Equipe criada com sucesso. Nota: O líder selecionado não é um funcionário desta equipe.')
                ->with('success', 'Equipe criada com sucesso');
        }

        return redirect()->route('equipes.index')
            ->with('success', 'Equipe criada com sucesso');
    }

    public function show($id)
    {
        $equipe = Equipe::with(['lider', 'funcionarios', 'ordensServico'])->findOrFail($id);
        return view('equipes::show', compact('equipe'));
    }

    public function edit($id)
    {
        $equipe = Equipe::with('funcionarios')->findOrFail($id);

        // Buscar funcionários ativos
        $funcionarios = [];
        if (Schema::hasTable('funcionarios')) {
            $funcionarios = Funcionario::where('ativo', true)
                ->orderBy('nome')
                ->select('id', 'nome', 'funcao', 'codigo')
                ->get();
        }

        // Buscar usuários para líder
        $users = User::select('id', 'name')->get();

        return view('equipes::edit', compact('equipe', 'funcionarios', 'users'));
    }

    public function update(Request $request, $id)
    {
        $equipe = Equipe::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:eletricistas,encanadores,operadores,motoristas,mista',
            'descricao' => 'nullable|string',
            'lider_id' => 'nullable|exists:users,id',
            'ativo' => 'boolean',
            'funcionarios' => 'nullable|array',
            'funcionarios.*' => 'exists:funcionarios,id',
        ], [
            'funcionarios.*.exists' => 'Um ou mais funcionários selecionados não existem.',
        ]);

        // Gera código automaticamente se estiver vazio ou não existir
        if (empty($equipe->codigo)) {
            $validated['codigo'] = Equipe::generateCode('EQP', $validated['tipo']);
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $equipe->update($validated);

        // Sincronizar funcionários
        if (isset($validated['funcionarios'])) {
            $equipe->funcionarios()->sync($validated['funcionarios']);
        } else {
            // Se nenhum funcionário foi selecionado, remover todos
            $equipe->funcionarios()->sync([]);
        }

        // Validação: Se o líder foi definido, verificar se é funcionário da equipe
        if ($equipe->lider_id && !$equipe->liderEhFuncionario()) {
            // Aviso (não bloqueia, mas informa)
            return redirect()->route('equipes.show', $equipe)
                ->with('warning', 'Equipe atualizada. Nota: O líder selecionado não é um funcionário desta equipe.')
                ->with('success', 'Equipe atualizada com sucesso');
        }

        return redirect()->route('equipes.show', $equipe)
            ->with('success', 'Equipe atualizada com sucesso');
    }

    public function destroy($id)
    {
        $equipe = Equipe::findOrFail($id);

        // Verificar se pode ser deletada usando método do modelo
        if (!$equipe->podeSerDeletada()) {
            return redirect()->route('equipes.index')
                ->with('error', 'Não é possível deletar esta equipe pois ela possui ordens de serviço vinculadas.');
        }

        $equipe->delete();

        return redirect()->route('equipes.index')
            ->with('success', 'Equipe deletada com sucesso');
    }
}
