<?php

namespace Modules\Pocos\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Pocos\App\Models\Poco;
use Modules\Localidades\App\Models\Localidade;
use Modules\Equipes\App\Models\Equipe;
use Modules\Demandas\App\Models\Demanda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PocosController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Pocos');
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['status', 'localidade_id', 'equipe_responsavel_id', 'search']);
        $query = Poco::with(['localidade', 'equipeResponsavel']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('endereco', 'like', "%{$search}%")
                  ->orWhere('tipo_bomba', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }
        if (!empty($filters['equipe_responsavel_id'])) {
            $query->where('equipe_responsavel_id', $filters['equipe_responsavel_id']);
        }

        $pocos = $query->orderBy('codigo')->paginate(20);
        $localidades = collect([]);
        $equipes = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }
        if (Schema::hasTable('equipes')) {
            $equipes = Equipe::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas gerais
        $estatisticas = [
            'total' => Poco::count(),
            'ativos' => Poco::ativos()->count(),
            'em_manutencao' => Poco::emManutencao()->count(),
            'com_problemas' => Poco::comProblemas()->count(),
            'precisam_manutencao' => Poco::whereNotNull('proxima_manutencao')
                ->where('proxima_manutencao', '<=', now())
                ->count(),
        ];

        return view('pocos::index', compact('pocos', 'localidades', 'equipes', 'filters', 'estatisticas'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status', 'localidade_id', 'search']);
        $query = Poco::with(['localidade', 'equipeResponsavel']);

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

        $pocos = $query->get();

        $columns = [
            'codigo' => 'Código',
            'localidade.nome' => 'Localidade',
            'endereco' => 'Endereço',
            'profundidade_metros' => 'Profundidade (m)',
            'vazao_litros_hora' => 'Vazão (L/h)',
            'status' => 'Status',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'pocos_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($pocos, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($pocos, $columns, $filename, 'Relatório de Poços');
        } else {
            return $this->exportCsv($pocos, $columns, $filename);
        }
    }

    public function create()
    {
        $localidades = collect([]);
        $equipes = collect([]);
        $hasLocalidades = false;

        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
            $hasLocalidades = $localidades->count() > 0;
        }
        if (Schema::hasTable('equipes')) {
            $equipes = Equipe::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Se não há localidades, mostrar alerta
        if (!$hasLocalidades) {
            return redirect()->route('pocos.index')
                ->with('warning', 'É necessário cadastrar pelo menos uma localidade antes de criar um poço. <a href="' . route('localidades.create') . '" class="alert-link">Cadastrar localidade</a>');
        }

        return view('pocos::create', compact('localidades', 'equipes', 'hasLocalidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'localidade_id' => 'required|exists:localidades,id',
            'endereco' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nome_mapa' => 'nullable|string|max:255',
            'profundidade_metros' => 'required|numeric|min:0',
            'vazao_litros_hora' => 'nullable|numeric|min:0',
            'data_perfuracao' => 'nullable|date',
            'diametro' => 'nullable|string|max:50',
            'tipo_bomba' => 'nullable|string|max:100',
            'potencia_bomba' => 'nullable|integer|min:0',
            'equipe_responsavel_id' => 'nullable|exists:equipes,id',
            'ultima_manutencao' => 'nullable|date',
            'proxima_manutencao' => 'nullable|date',
            'status' => 'required|in:ativo,inativo,manutencao,bomba_queimada',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente sempre
        $validated['codigo'] = Poco::generateCode('POC', $validated['status'] ?? null);

        Poco::create($validated);

        return redirect()->route('pocos.index')
            ->with('success', 'Poço criado com sucesso');
    }

    public function show($id)
    {
        $poco = Poco::with([
            'localidade',
            'equipeResponsavel',
            'demandas',
            'ordensServico' => function($query) {
                $query->where('ordens_servico.status', 'concluida')->with(['demanda', 'equipe']);
            }
        ])->findOrFail($id);

        // Carregar histórico de manutenções (OS concluídas)
        // Usar o relacionamento ordensServico diretamente, já que o eager loading já filtra por status 'concluida'
        $historicoManutencoes = $poco->ordensServico()->where('ordens_servico.status', 'concluida')->with(['demanda', 'equipe'])->get();

        // Carregar demandas relacionadas com ordem de serviço
        $demandas = $poco->demandas()->with(['ordemServico', 'usuario'])->orderBy('created_at', 'desc')->get();

        // Estatísticas do poço
        $estatisticas = [
            'total_demandas' => $poco->demandas()->count(),
            'demandas_abertas' => $poco->demandas()->where('status', 'aberta')->count(),
            'total_ordens' => $poco->ordensServico()->count(),
            'dias_sem_manutencao' => $poco->diasSemManutencao(),
            'precisa_manutencao' => $poco->precisaManutencao(),
        ];

        return view('pocos::show', compact('poco', 'estatisticas', 'historicoManutencoes', 'demandas'));
    }

    public function edit($id)
    {
        $poco = Poco::findOrFail($id);
        $localidades = collect([]);
        $equipes = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }
        if (Schema::hasTable('equipes')) {
            $equipes = Equipe::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }
        return view('pocos::edit', compact('poco', 'localidades', 'equipes'));
    }

    public function update(Request $request, $id)
    {
        $poco = Poco::findOrFail($id);

        $validated = $request->validate([
            'localidade_id' => 'required|exists:localidades,id',
            'endereco' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nome_mapa' => 'nullable|string|max:255',
            'profundidade_metros' => 'required|numeric|min:0',
            'vazao_litros_hora' => 'nullable|numeric|min:0',
            'data_perfuracao' => 'nullable|date',
            'diametro' => 'nullable|string|max:50',
            'tipo_bomba' => 'nullable|string|max:100',
            'potencia_bomba' => 'nullable|integer|min:0',
            'equipe_responsavel_id' => 'nullable|exists:equipes,id',
            'ultima_manutencao' => 'nullable|date',
            'proxima_manutencao' => 'nullable|date',
            'status' => 'required|in:ativo,inativo,manutencao,bomba_queimada',
            'observacoes' => 'nullable|string',
        ]);

        // Gera código automaticamente se estiver vazio ou não existir
        if (empty($poco->codigo)) {
            $validated['codigo'] = Poco::generateCode('POC', $validated['status'] ?? null);
        }

        // Verificar se o status mudou para algo que requer manutenção
        $statusAnterior = $poco->status;
        $statusNovo = $validated['status'];
        
        $poco->update($validated);

        // Se o status mudou para manutencao ou bomba_queimada, criar demanda automaticamente
        if ($statusAnterior !== $statusNovo && in_array($statusNovo, ['manutencao', 'bomba_queimada'])) {
            $this->criarDemandaAutomatica($poco, $statusNovo);
        }

        return redirect()->route('pocos.index')
            ->with('success', 'Poço atualizado com sucesso');
    }

    public function destroy($id)
    {
        $poco = Poco::findOrFail($id);
        $poco->delete();

        return redirect()->route('pocos.index')
            ->with('success', 'Poço deletado com sucesso');
    }

    public function print($id)
    {
        $poco = Poco::with(['localidade', 'equipeResponsavel', 'demandas', 'ordensServico'])->findOrFail($id);
        return view('pocos::print', compact('poco'));
    }

    /**
     * Cria uma demanda automaticamente quando o poço precisa de manutenção
     */
    protected function criarDemandaAutomatica(Poco $poco, string $status)
    {
        // Verificar se já existe uma demanda aberta para este poço
        $demandaExistente = Demanda::where('poco_id', $poco->id)
            ->whereIn('status', ['aberta', 'em_andamento'])
            ->first();

        if ($demandaExistente) {
            return; // Já existe demanda aberta, não criar outra
        }

        try {
            $motivo = match($status) {
                'manutencao' => "Poço {$poco->codigo} precisa de manutenção",
                'bomba_queimada' => "Bomba queimada no poço {$poco->codigo}",
                default => "Problema reportado no poço {$poco->codigo}"
            };

            $descricao = match($status) {
                'manutencao' => "O poço {$poco->codigo} localizado em {$poco->endereco} está com status de manutenção e precisa de atenção da equipe técnica.",
                'bomba_queimada' => "A bomba do poço {$poco->codigo} localizado em {$poco->endereco} está queimada e precisa ser substituída ou reparada.",
                default => "Problema reportado no poço {$poco->codigo} localizado em {$poco->endereco}."
            };

            // Gera código automaticamente para a demanda
            $codigo = Demanda::generateCode('DEM', 'poco');

            Demanda::create([
                'codigo' => $codigo,
                'localidade_id' => $poco->localidade_id,
                'poco_id' => $poco->id,
                'tipo' => 'poco',
                'prioridade' => $status === 'bomba_queimada' ? 'urgente' : 'alta',
                'motivo' => $motivo,
                'descricao' => $descricao,
                'status' => 'aberta',
                'solicitante_nome' => 'Sistema Automático',
                'user_id' => Auth::id() ?? null,
                'data_abertura' => now(),
            ]);

            Log::info("Demanda criada automaticamente para o poço {$poco->codigo} (Status: {$status})");
        } catch (\Exception $e) {
            Log::error("Erro ao criar demanda automática para poço {$poco->codigo}: " . $e->getMessage());
        }
    }

    /**
     * Reporta um problema no poço criando uma demanda
     */
    public function reportarProblema(Request $request, $id)
    {
        $poco = Poco::with('localidade')->findOrFail($id);

        $validated = $request->validate([
            'motivo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'status_poco' => 'nullable|in:manutencao,bomba_queimada,inativo',
        ]);

        try {
            // Gera código automaticamente para a demanda
            $codigo = Demanda::generateCode('DEM', 'poco');

            // Criar a demanda
            $demanda = Demanda::create([
                'codigo' => $codigo,
                'localidade_id' => $poco->localidade_id,
                'poco_id' => $poco->id,
                'tipo' => 'poco',
                'prioridade' => $validated['prioridade'],
                'motivo' => $validated['motivo'],
                'descricao' => $validated['descricao'] ?? $validated['motivo'],
                'status' => 'aberta',
                'solicitante_nome' => Auth::user()->name ?? 'Usuário do Sistema',
                'solicitante_telefone' => Auth::user()->telefone ?? null,
                'solicitante_email' => Auth::user()->email ?? null,
                'user_id' => Auth::id(),
                'data_abertura' => now(),
            ]);

            // Atualizar status do poço se fornecido
            if (!empty($validated['status_poco'])) {
                $poco->update(['status' => $validated['status_poco']]);
            }

            return redirect()->route('pocos.show', $poco->id)
                ->with('success', 'Problema reportado com sucesso. Uma demanda foi criada para acompanhamento.');
        } catch (\Exception $e) {
            Log::error("Erro ao reportar problema no poço {$poco->codigo}: " . $e->getMessage());
            return redirect()->route('pocos.show', $poco->id)
                ->with('error', 'Erro ao reportar problema: ' . $e->getMessage());
        }
    }
}

