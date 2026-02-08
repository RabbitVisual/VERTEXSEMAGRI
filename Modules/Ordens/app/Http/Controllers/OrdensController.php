<?php

namespace Modules\Ordens\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Demandas\App\Models\Demanda;
use Modules\Equipes\App\Models\Equipe;
use Modules\Materiais\App\Models\Material;
use Modules\Pocos\App\Models\Poco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdensController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Ordens');
    }
    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['status', 'tipo_servico', 'equipe_id', 'demanda_id', 'prioridade', 'search']);
        $query = OrdemServico::with(['demanda.localidade', 'demanda.pessoa', 'equipe', 'usuarioAbertura', 'usuarioExecucao']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('tipo_servico', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhereHas('demanda', function($q) use ($search) {
                      $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('solicitante_nome', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['tipo_servico'])) {
            $query->where('tipo_servico', $filters['tipo_servico']);
        }

        if (!empty($filters['equipe_id'])) {
            $query->where('equipe_id', $filters['equipe_id']);
        }

        if (!empty($filters['demanda_id'])) {
            $query->where('demanda_id', $filters['demanda_id']);
        }

        if (!empty($filters['prioridade'])) {
            $query->where('prioridade', $filters['prioridade']);
        }

        $ordens = $query->orderBy('created_at', 'desc')->paginate(20);

        $equipes = collect([]);
        if (Schema::hasTable('equipes')) {
            $equipes = Equipe::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        $demandas = collect([]);
        if (Schema::hasTable('demandas')) {
            $demandas = Demanda::select('id', 'codigo', 'solicitante_nome', 'tipo')
                ->orderBy('created_at', 'desc')
                ->limit(100)
                ->get();
        }

        // Estatísticas gerais
        $estatisticas = [
            'total' => OrdemServico::count(),
            'pendentes' => OrdemServico::pendentes()->count(),
            'em_execucao' => OrdemServico::emExecucao()->count(),
            'concluidas' => OrdemServico::concluidas()->count(),
            'urgentes' => OrdemServico::urgentes()->count(),
        ];

        return view('ordens::index', compact('ordens', 'equipes', 'demandas', 'filters', 'estatisticas'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status', 'tipo_servico', 'equipe_id', 'search']);
        $query = OrdemServico::with(['demanda', 'equipe', 'usuarioAbertura']);

        // Aplicar mesmos filtros
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('tipo_servico', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo_servico'])) {
            $query->where('tipo_servico', $filters['tipo_servico']);
        }
        if (!empty($filters['equipe_id'])) {
            $query->where('equipe_id', $filters['equipe_id']);
        }

        $ordens = $query->get();

        $columns = [
            'numero' => 'Número',
            'demanda.codigo' => 'Demanda',
            'tipo_servico' => 'Tipo de Serviço',
            'equipe.nome' => 'Equipe',
            'prioridade' => 'Prioridade',
            'status' => 'Status',
            'data_abertura' => 'Data Abertura',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'ordens_servico_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($ordens, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($ordens, $columns, $filename, 'Relatório de Ordens de Serviço');
        } else {
            return $this->exportCsv($ordens, $columns, $filename);
        }
    }

    public function create(Request $request)
    {
        // Verificar dependências
        if (!$this->isModuleEnabled('Demandas') || !$this->tableExists('demandas')) {
            return redirect()->route('ordens.index')
                ->with('error', 'O módulo Demandas precisa estar habilitado para criar ordens de serviço.');
        }

        if (!$this->isModuleEnabled('Equipes') || !$this->tableExists('equipes')) {
            return redirect()->route('ordens.index')
                ->with('error', 'O módulo Equipes precisa estar habilitado para criar ordens de serviço.');
        }

        $demandas = collect([]);
        $equipes = collect([]);
        $materiais = collect([]);
        $demandaSelecionada = null;

        if ($this->isModuleEnabled('Demandas') && $this->tableExists('demandas')) {
            $demandas = Demanda::whereIn('status', ['aberta', 'em_andamento'])
                ->select('id', 'codigo', 'solicitante_nome', 'tipo', 'localidade_id')
                ->orderBy('created_at', 'desc')
                ->get();

            // Se veio de uma demanda específica
            if ($request->has('demanda_id')) {
                $demandaSelecionada = Demanda::find($request->demanda_id);
            }
        }

        if ($this->isModuleEnabled('Equipes') && $this->tableExists('equipes')) {
            // Buscar equipes ativas (sem soft-deleted)
            // O modelo Equipe usa SoftDeletes, então soft-deleted são automaticamente excluídos
            // O cast 'boolean' no modelo converte true/false para 1/0 no banco
            // Usar where('ativo', true) que é o padrão usado em todo o sistema
            $equipes = Equipe::where('ativo', true)
                ->select('id', 'nome', 'codigo')
                ->orderBy('nome')
                ->get();
        }

        if ($this->isModuleEnabled('Materiais') && $this->tableExists('materiais')) {
            $materiais = Material::where('ativo', true)
                ->select('id', 'nome', 'codigo', 'quantidade_estoque', 'quantidade_minima')
                ->orderBy('nome')
                ->get();
        }

        // Validações
        if ($demandas->isEmpty()) {
            return redirect()->route('ordens.index')
                ->with('warning', 'É necessário ter pelo menos uma demanda aberta ou em andamento para criar uma OS. <a href="' . route('demandas.create') . '" class="font-medium underline hover:no-underline inline-flex items-center gap-1 ml-1">Criar demanda <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg></a>');
        }

        // Verificar se há equipes ativas
        if ($equipes->isEmpty()) {
            // Verificar se há equipes no banco (incluindo inativas e soft-deleted)
            $totalEquipes = 0;
            $equipesAtivas = 0;
            $equipesInativas = 0;

            if ($this->isModuleEnabled('Equipes') && $this->tableExists('equipes')) {
                try {
                    $totalEquipes = Equipe::withTrashed()->count();
                    // Verificar equipes ativas (usando true como no resto do sistema)
                    $equipesAtivas = Equipe::where('ativo', true)->count();
                    // Verificar equipes inativas
                    $equipesInativas = Equipe::where('ativo', false)->count();
                } catch (\Exception $e) {
                    // Se houver erro, assumir que não há equipes
                    \Log::error('Erro ao verificar equipes: ' . $e->getMessage());
                }
            }

            // Mensagem mais informativa baseada na situação
            if ($totalEquipes == 0) {
                $mensagem = 'É necessário criar pelo menos uma equipe para criar uma OS. <a href="' . route('equipes.create') . '" class="font-medium underline hover:no-underline inline-flex items-center gap-1 ml-1">Criar equipe <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg></a>';
            } elseif ($equipesAtivas == 0 && $equipesInativas > 0) {
                $mensagem = 'Todas as equipes estão inativas. É necessário ativar pelo menos uma equipe para criar uma OS. <a href="' . route('equipes.index') . '" class="font-medium underline hover:no-underline inline-flex items-center gap-1 ml-1">Gerenciar equipes <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg></a>';
            } else {
                $mensagem = 'É necessário ter pelo menos uma equipe ativa para criar uma OS. <a href="' . route('equipes.create') . '" class="font-medium underline hover:no-underline inline-flex items-center gap-1 ml-1">Criar equipe <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg></a>';
            }

            // Se veio de uma demanda específica, redirecionar de volta para a demanda
            if ($request->has('demanda_id') && $demandaSelecionada) {
                return redirect()->route('demandas.show', $demandaSelecionada->id)
                    ->with('warning', $mensagem);
            }

            return redirect()->route('ordens.index')
                ->with('warning', $mensagem);
        }

        return view('ordens::create', compact('demandas', 'equipes', 'materiais', 'demandaSelecionada'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'demanda_id' => 'nullable|exists:demandas,id',
            'equipe_id' => 'required|exists:equipes,id',
            'funcionario_id' => 'nullable|exists:funcionarios,id',
            'user_id_atribuido' => 'nullable|exists:users,id',
            'tipo_servico' => 'required|string|max:255',
            'descricao' => 'required|string|max:500',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'numero' => 'nullable|string|max:50|unique:ordens_servico,numero',
            'materiais' => 'nullable|array',
            'materiais.*.material_id' => 'required_with:materiais|exists:materiais,id',
            'materiais.*.quantidade' => 'required_with:materiais|numeric|min:0.01',
        ]);

        // Validar que funcionário pertence à equipe se fornecido
        if (!empty($validated['funcionario_id']) && !empty($validated['equipe_id'])) {
            $funcionarioPertenceEquipe = DB::table('equipe_funcionarios')
                ->where('equipe_id', $validated['equipe_id'])
                ->where('funcionario_id', $validated['funcionario_id'])
                ->exists();

            if (!$funcionarioPertenceEquipe) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'O funcionário selecionado não pertence à equipe escolhida.');
            }
        }

        // Se demanda foi informada, buscar dados da demanda
        $demanda = null;
        $materiaisIndisponiveis = [];
        if (!empty($validated['demanda_id'])) {
            $demanda = Demanda::find($validated['demanda_id']);
            if ($demanda) {
                // Se não informado tipo de serviço, usar da demanda
                if (empty($validated['tipo_servico']) || $validated['tipo_servico'] === '') {
                    $validated['tipo_servico'] = ucfirst($demanda->tipo);
                }

                // Verificar materiais necessários (se houver materiais previstos)
                if (!empty($materiaisPrevistos) && $this->isModuleEnabled('Materiais') && $this->tableExists('materiais')) {
                    foreach ($materiaisPrevistos as $materialData) {
                        $material = Material::find($materialData['material_id']);
                        if ($material && !$material->temEstoqueSuficiente($materialData['quantidade'])) {
                            $materiaisIndisponiveis[] = [
                                'nome' => $material->nome,
                                'quantidade_solicitada' => $materialData['quantidade'],
                                'quantidade_disponivel' => $material->quantidade_estoque,
                                'unidade' => $material->unidade_medida,
                            ];
                        }
                    }
                }

                // Atualizar status da demanda para "em_andamento"
                if ($demanda->status === 'aberta') {
                    $demanda->update(['status' => 'em_andamento']);
                }
            }
        }

        // Gerar número automaticamente se não fornecido
        if (empty($validated['numero'])) {
            $validated['numero'] = OrdemServico::generateCode('OS', $validated['tipo_servico'] ?? null);
        }

        $validated['status'] = 'pendente';
        $validated['user_id_abertura'] = auth()->id();
        $validated['data_abertura'] = now();

        DB::beginTransaction();

        try {
            // Remover materiais do array validado antes de criar a OS
            $materiaisPrevistos = $validated['materiais'] ?? [];
            unset($validated['materiais']);

            $ordem = OrdemServico::create($validated);

            // Processar materiais previstos
            if (!empty($materiaisPrevistos)) {
                foreach ($materiaisPrevistos as $materialData) {
                    $material = Material::find($materialData['material_id']);

                    if ($material) {
                        // Verificar estoque disponível
                        if (!$material->temEstoqueSuficiente($materialData['quantidade'])) {
                            // Não bloquear criação, mas adicionar à lista de indisponíveis
                            $materiaisIndisponiveis[] = [
                                'nome' => $material->nome,
                                'quantidade_solicitada' => $materialData['quantidade'],
                                'quantidade_disponivel' => $material->quantidade_estoque,
                                'unidade' => $material->unidade_medida,
                            ];
                            continue; // Pular este material
                        }

                        // Criar registro do material na OS
                        \Modules\Ordens\App\Models\OrdemServicoMaterial::create([
                            'ordem_servico_id' => $ordem->id,
                            'material_id' => $materialData['material_id'],
                            'quantidade' => $materialData['quantidade'],
                            'valor_unitario' => $material->valor_unitario ?? 0,
                        ]);

                        // RESERVAR estoque (não baixar definitivamente)
                        $material->reservarEstoque(
                            $materialData['quantidade'],
                            $ordem->id,
                            "Reserva para OS #{$ordem->numero}",
                            $material->valor_unitario,
                            null
                        );
                    }
                }
            }

            DB::commit();

            $mensagemSucesso = 'Ordem de serviço criada com sucesso';

            // Se houver materiais indisponíveis, adicionar aviso
            if (!empty($materiaisIndisponiveis)) {
                $mensagemSucesso .= '. <strong>Atenção:</strong> Alguns materiais não estão disponíveis em estoque. Solicite os materiais necessários antes de iniciar a OS.';
            }

            if (!empty($materiaisPrevistos)) {
                $mensagemSucesso .= '. ' . count($materiaisPrevistos) . ' material(is) reservado(s) do estoque.';
            }

            return redirect()->route('ordens.show', $ordem)
                ->with('success', $mensagemSucesso);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar OS: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar ordem de serviço: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $ordem = OrdemServico::with([
            'demanda.localidade',
            'demanda.pessoa',
            'demanda.usuario',
            'equipe',
            'usuarioAbertura',
            'usuarioExecucao',
            'materiais.material'
        ])->findOrFail($id);

        // Estatísticas da OS
        $estatisticas = [
            'pode_iniciar' => $ordem->podeIniciar(),
            'pode_concluir' => $ordem->podeConcluir(),
            'pode_cancelar' => $ordem->podeCancelar(),
            'tempo_decorrido' => $ordem->data_inicio ? now()->diffInMinutes($ordem->data_inicio) : null,
        ];

        return view('ordens::show', compact('ordem', 'estatisticas'));
    }

    public function edit($id)
    {
        $ordem = OrdemServico::findOrFail($id);
        $demandas = [];
        $equipes = [];

        if (Schema::hasTable('demandas')) {
            $demandas = Demanda::select('id', 'codigo', 'solicitante_nome', 'tipo')
                ->where(function($query) use ($ordem) {
                    $query->whereIn('status', ['aberta', 'em_andamento']);
                    if ($ordem->demanda_id) {
                        $query->orWhere('id', $ordem->demanda_id);
                    }
                })
                ->orderBy('created_at', 'desc')
                ->limit(200)
                ->get();
        }
        if (Schema::hasTable('equipes')) {
            $equipes = Equipe::where('ativo', true)
                ->select('id', 'nome', 'codigo')
                ->orderBy('nome')
                ->get();
        }

        return view('ordens::edit', compact('ordem', 'demandas', 'equipes'));
    }

    public function update(Request $request, $id)
    {
        $ordem = OrdemServico::findOrFail($id);
        $oldStatus = $ordem->status;

        $validated = $request->validate([
            'demanda_id' => 'nullable|exists:demandas,id',
            'equipe_id' => 'required|exists:equipes,id',
            'funcionario_id' => 'nullable|exists:funcionarios,id',
            'user_id_atribuido' => 'nullable|exists:users,id',
            'tipo_servico' => 'required|string|max:255',
            'descricao' => 'required|string|max:500',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'status' => 'required|in:pendente,em_execucao,concluida,cancelada',
            'relatorio_execucao' => 'nullable|string|max:600',
            'observacoes' => 'nullable|string|max:400',
        ]);

        // Validar que funcionário pertence à equipe se fornecido
        if (!empty($validated['funcionario_id']) && !empty($validated['equipe_id'])) {
            $funcionarioPertenceEquipe = DB::table('equipe_funcionarios')
                ->where('equipe_id', $validated['equipe_id'])
                ->where('funcionario_id', $validated['funcionario_id'])
                ->exists();

            if (!$funcionarioPertenceEquipe) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'O funcionário selecionado não pertence à equipe escolhida.');
            }
        }

        // Se está iniciando execução
        if ($validated['status'] === 'em_execucao' && $oldStatus !== 'em_execucao') {
            $validated['data_inicio'] = now();
            $validated['user_id_execucao'] = auth()->id();
        }

        // Se está finalizando
        if ($validated['status'] === 'concluida' && $oldStatus !== 'concluida') {
            $validated['data_conclusao'] = now();
            if ($ordem->data_inicio) {
                $validated['tempo_execucao'] = abs(now()->diffInMinutes($ordem->data_inicio));
            }

            // Confirmar reservas de materiais (converter reservas em saídas definitivas)
            if ($ordem->materiais()->count() > 0) {
                foreach ($ordem->materiais as $ordemMaterial) {
                    $material = $ordemMaterial->material;
                    if ($material) {
                        try {
                            // Confirmar a reserva no estoque (baixa definitiva)
                            $material->confirmarReserva($ordem->id);

                            // Atualizar o status_reserva na tabela ordem_servico_materiais
                            if ($ordemMaterial->status_reserva === 'reservado') {
                                $ordemMaterial->update(['status_reserva' => 'confirmado']);
                            }
                        } catch (\Exception $e) {
                            \Log::warning("Erro ao confirmar reserva de material {$material->id} na OS {$ordem->numero}: " . $e->getMessage());
                        }
                    }
                }
            }

            // Atualizar status da demanda relacionada automaticamente
            if ($ordem->demanda_id && Schema::hasTable('demandas')) {
                $demanda = Demanda::find($ordem->demanda_id);
                if ($demanda && $demanda->status !== 'concluida') {
                    $demanda->update([
                        'status' => 'concluida',
                        'data_conclusao' => now(),
                    ]);
                }
            }
        }

        // Se está cancelando
        if ($validated['status'] === 'cancelada' && $oldStatus !== 'cancelada') {
            // Atualizar status da demanda relacionada para "aberta" se estava em andamento
            if ($ordem->demanda_id && Schema::hasTable('demandas')) {
                $demanda = Demanda::find($ordem->demanda_id);
                if ($demanda && $demanda->status === 'em_andamento') {
                    $demanda->update(['status' => 'aberta']);
                }
            }
        }

        $ordem->update($validated);

        return redirect()->route('ordens.index')
            ->with('success', 'Ordem de serviço atualizada com sucesso');
    }

    public function destroy($id)
    {
        try {
            $ordem = OrdemServico::withTrashed()->findOrFail($id);
            $ordemId = $ordem->id;

            DB::beginTransaction();

            // Excluir materiais relacionados à OS (se a tabela existir)
            if (Schema::hasTable('ordem_servico_materiais')) {
                DB::table('ordem_servico_materiais')
                    ->where('ordem_servico_id', $ordemId)
                    ->delete();
            }

            // Se a OS tinha demanda vinculada, reabrir a demanda se estava em_andamento
            if ($ordem->demanda_id && Schema::hasTable('demandas')) {
                $demanda = Demanda::find($ordem->demanda_id);
                if ($demanda && $demanda->status === 'em_andamento') {
                    $demanda->update(['status' => 'aberta']);
                }
            }

            // Excluir permanentemente a OS do banco (exclusão física)
            DB::table('ordens_servico')->where('id', $ordemId)->delete();

            DB::commit();

            // Limpar cache do dashboard
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats_today');
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats_week');
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats_month');

            return redirect()->route('ordens.index')
                ->with('success', 'Ordem de serviço excluída permanentemente com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao excluir ordem de serviço ID ' . $id . ': ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Erro ao excluir ordem de serviço: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        $ordem = OrdemServico::with([
            'demanda.localidade',
            'demanda.pessoa',
            'demanda.usuario',
            'equipe',
            'usuarioAbertura',
            'usuarioExecucao',
            'materiais.material'
        ])->findOrFail($id);

        return view('ordens::print', compact('ordem'));
    }

    public function iniciar($id)
    {
        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->podeIniciar()) {
            return redirect()->route('ordens.show', $ordem)
                ->with('error', 'Não é possível iniciar esta ordem de serviço. Verifique se está pendente e tem equipe atribuída.');
        }

        $ordem->update([
            'status' => 'em_execucao',
            'data_inicio' => now(),
            'user_id_execucao' => auth()->id(),
        ]);

        // Atualizar status da demanda relacionada
        if ($ordem->demanda_id && Schema::hasTable('demandas')) {
            $demanda = Demanda::find($ordem->demanda_id);
            if ($demanda && $demanda->status === 'aberta') {
                $demanda->update(['status' => 'em_andamento']);
            }
        }

        return redirect()->route('ordens.show', $ordem)
            ->with('success', 'Ordem de serviço iniciada com sucesso');
    }

    public function concluir($id)
    {
        $ordem = OrdemServico::findOrFail($id);

        if (!$ordem->podeConcluir()) {
            return redirect()->route('ordens.show', $ordem)
                ->with('error', 'Não é possível concluir esta ordem de serviço. Ela precisa estar em execução.');
        }

        $tempoExecucao = $ordem->data_inicio ? abs(now()->diffInMinutes($ordem->data_inicio)) : null;

        $ordem->update([
            'status' => 'concluida',
            'data_conclusao' => now(),
            'tempo_execucao' => $tempoExecucao,
        ]);

        // Confirmar reservas de materiais (converter reservas em saídas definitivas)
        if ($ordem->materiais()->count() > 0) {
            foreach ($ordem->materiais as $ordemMaterial) {
                $material = $ordemMaterial->material;
                if ($material) {
                    try {
                        // Confirmar a reserva no estoque (baixa definitiva)
                        $material->confirmarReserva($ordem->id);

                        // Atualizar o status_reserva na tabela ordem_servico_materiais
                        if ($ordemMaterial->status_reserva === 'reservado') {
                            $ordemMaterial->update(['status_reserva' => 'confirmado']);
                        }
                    } catch (\Exception $e) {
                        \Log::warning("Erro ao confirmar reserva de material {$material->id} na OS {$ordem->numero}: " . $e->getMessage());
                    }
                }
            }
        }

        // Atualizar status da demanda relacionada
        if ($ordem->demanda_id && Schema::hasTable('demandas')) {
            $demanda = Demanda::with('poco')->find($ordem->demanda_id);
            if ($demanda && $demanda->status !== 'concluida') {
                $demanda->update([
                    'status' => 'concluida',
                    'data_conclusao' => now(),
                ]);
            }

            // Se a demanda está relacionada a um poço, atualizar o status do poço
            if ($demanda && $demanda->poco_id && $demanda->tipo === 'poco' && $demanda->poco) {
                $poco = $demanda->poco;

                // Atualizar status do poço para 'ativo' se estava em manutenção
                if (in_array($poco->status, ['manutencao', 'bomba_queimada'])) {
                    $poco->update([
                        'status' => 'ativo',
                        'ultima_manutencao' => now(),
                    ]);

                    \Log::info("Status do poço {$poco->codigo} atualizado para 'ativo' após conclusão da OS {$ordem->numero}");
                } elseif ($poco->status === 'inativo') {
                    // Se estava inativo, manter inativo mas atualizar última manutenção
                    $poco->update([
                        'ultima_manutencao' => now(),
                    ]);
                } else {
                    // Se já estava ativo, apenas atualizar última manutenção
                    $poco->update([
                        'ultima_manutencao' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('ordens.show', $ordem)
            ->with('success', 'Ordem de serviço concluída com sucesso');
    }

    /**
     * Gera relatório em PDF de demandas do dia (OS concluídas)
     */
    public function relatorioDemandasDiaPdf(Request $request)
    {
        // Data do dia (pode ser passada como parâmetro ou usar hoje)
        $data = $request->has('data') ? \Carbon\Carbon::parse($request->data) : now();
        $dataInicio = $data->copy()->startOfDay();
        $dataFim = $data->copy()->endOfDay();

        // Buscar OS concluídas no dia
        $ordens = OrdemServico::with([
            'demanda.localidade',
            'demanda.pessoa',
            'equipe',
            'usuarioAbertura',
            'usuarioExecucao',
            'materiais.material'
        ])
        ->where('status', 'concluida')
        ->whereBetween('data_conclusao', [$dataInicio, $dataFim])
        ->orderBy('data_conclusao', 'asc')
        ->get();

        // Agrupar demandas por localidade e tipo
        $demandasPorLocalidade = $ordens->groupBy(function($ordem) {
            return $ordem->demanda && $ordem->demanda->localidade
                ? $ordem->demanda->localidade->nome
                : 'Sem localidade';
        });

        $demandasPorTipo = $ordens->groupBy(function($ordem) {
            return $ordem->demanda ? $ordem->demanda->tipo : 'N/A';
        });

        // Estatísticas
        $estatisticas = [
            'total_os' => $ordens->count(),
            'total_demandas' => $ordens->pluck('demanda_id')->unique()->count(),
            'por_localidade' => $demandasPorLocalidade->map->count(),
            'por_tipo' => $demandasPorTipo->map->count(),
            'tempo_total' => $ordens->sum('tempo_execucao'),
            'tempo_medio' => $ordens->avg('tempo_execucao'),
        ];

        // Dados para o PDF
        $dataPdf = [
            'ordens' => $ordens,
            'demandas' => $ordens->map->demanda->filter(),
            'estatisticas' => $estatisticas,
            'data' => $data,
            'data_geracao' => now(),
            'usuario' => auth()->user(),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ordens::pdf.relatorio-demandas-dia', $dataPdf);
        $pdf->setPaper('A4', 'landscape');

        $filename = 'Relatorio_Demandas_Dia_' . $data->format('Ymd') . '.pdf';
        return $pdf->stream($filename);
    }
}
