<?php

namespace Modules\Demandas\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Modules\Demandas\App\Models\Demanda;
use Modules\Demandas\App\Models\DemandaInteressado;
use Modules\Demandas\App\Mail\DemandaStatusChanged;
use Modules\Demandas\App\Services\SimilaridadeDemandaService;
use Modules\Localidades\App\Models\Localidade;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Notificacoes\App\Traits\SendsNotifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DemandasController extends Controller
{
    use ExportsData, ChecksModuleEnabled, SendsNotifications;

    protected SimilaridadeDemandaService $similaridadeService;

    public function __construct(SimilaridadeDemandaService $similaridadeService)
    {
        $this->ensureModuleEnabled('Demandas');
        $this->similaridadeService = $similaridadeService;
    }
    public function syncData(Request $request)
    {
        $demands = Demanda::with([
                "localidade",
                "pessoa",
                "ordemServico",
                "ordemServico.materiais"
            ])
            ->whereIn("status", ["aberta", "em_andamento"])
            ->get();

        $materials = [];
        if ($this->isModuleEnabled("Materiais") && Schema::hasTable("materiais")) {
             $materials = DB::table("materiais")
                ->where("ativo", true)
                ->select("id", "nome", "unidade_medida as unidade", "codigo", "ncm_id")
                ->get();
        }

        return response()->json([
            "demands" => $demands,
            "materials" => $materials,
            "timestamp" => now()->toIso8601String()
        ]);
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['status', 'tipo', 'prioridade', 'localidade_id', 'search']);
        $query = Demanda::with(['localidade', 'pessoa', 'usuario', 'ordemServico']);

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('solicitante_nome', 'like', "%{$search}%")
                  ->orWhere('solicitante_apelido', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('motivo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhereHas('pessoa', function($q) use ($search) {
                      $q->where('nom_pessoa', 'like', "%{$search}%")
                        ->orWhere('nom_apelido_pessoa', 'like', "%{$search}%")
                        ->orWhere('num_cpf_pessoa', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }

        if (!empty($filters['prioridade'])) {
            $query->where('prioridade', $filters['prioridade']);
        }

        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $demandas = $query->orderBy('created_at', 'desc')->paginate(20);

        $localidades = collect([]);
        if ($this->isModuleEnabled('Localidades') && $this->tableExists('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        // Estatísticas gerais
        try {
            $estatisticas = Demanda::getDashboardStats();
        } catch (\Exception $e) {
            Log::error('Erro ao calcular estatísticas de demandas: ' . $e->getMessage());
            $estatisticas = [
                'total' => 0,
                'abertas' => 0,
                'em_andamento' => 0,
                'concluidas' => 0,
                'urgentes' => 0,
                'sem_os' => 0,
                'por_tipo' => [
                    'agua' => 0,
                    'luz' => 0,
                    'estrada' => 0,
                    'poco' => 0,
                ],
            ];
        }

        return view('demandas::index', compact('demandas', 'localidades', 'filters', 'estatisticas'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status', 'tipo', 'prioridade', 'localidade_id', 'search']);
        $query = Demanda::with(['localidade', 'pessoa', 'usuario']);

        // Aplicar mesmos filtros
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('solicitante_nome', 'like', "%{$search}%")
                  ->orWhere('solicitante_apelido', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('motivo', 'like', "%{$search}%")
                  ->orWhereHas('pessoa', function($q) use ($search) {
                      $q->where('nom_pessoa', 'like', "%{$search}%")
                        ->orWhere('nom_apelido_pessoa', 'like', "%{$search}%");
                  });
            });
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['tipo'])) {
            $query->where('tipo', $filters['tipo']);
        }
        if (!empty($filters['prioridade'])) {
            $query->where('prioridade', $filters['prioridade']);
        }
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        $demandas = $query->get();

        $columns = [
            'codigo' => 'Código',
            'solicitante_nome' => 'Solicitante',
            'solicitante_apelido' => 'Apelido',
            'localidade.nome' => 'Localidade',
            'tipo' => 'Tipo',
            'prioridade' => 'Prioridade',
            'status' => 'Status',
            'data_abertura' => 'Data Abertura',
        ];

        $format = $request->get('format', 'csv');
        $filename = 'demandas_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($demandas, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($demandas, $columns, $filename, 'Relatório de Demandas');
        } else {
            return $this->exportCsv($demandas, $columns, $filename);
        }
    }

    public function create()
    {
        $localidades = [];
        $hasLocalidades = false;

        if ($this->isModuleEnabled('Localidades') && $this->tableExists('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
            $hasLocalidades = $localidades->count() > 0;
        }

        // Se não há localidades, mostrar alerta
        if (!$hasLocalidades) {
            return redirect()->route('demandas.index')
                ->with('warning', 'É necessário cadastrar pelo menos uma localidade antes de criar uma demanda. <a href="' . route('localidades.create') . '" class="alert-link">Cadastrar localidade</a>');
        }

        return view('demandas::create', compact('localidades', 'hasLocalidades'));
    }

    public function buscarPessoa(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $pessoas = PessoaCad::with('localidade')
            ->where('ativo', true)
            ->where(function($q) use ($query) {
                $q->where('nom_pessoa', 'like', "%{$query}%")
                  ->orWhere('nom_apelido_pessoa', 'like', "%{$query}%")
                  ->orWhere('num_nis_pessoa_atual', 'like', "%{$query}%")
                  ->orWhere('num_cpf_pessoa', 'like', "%{$query}%");
            })
            ->limit(15)
            ->get()
            ->map(function($pessoa) {
                return [
                    'id' => $pessoa->id,
                    'nome' => $pessoa->nom_pessoa,
                    'apelido' => $pessoa->nom_apelido_pessoa,
                    'nis' => $pessoa->num_nis_pessoa_atual,
                    'nis_formatado' => $pessoa->nis_formatado ?? $pessoa->num_nis_pessoa_atual,
                    'cpf' => $pessoa->num_cpf_pessoa,
                    'cpf_formatado' => $pessoa->cpf_formatado ?? $pessoa->num_cpf_pessoa,
                    'localidade_id' => $pessoa->localidade_id,
                    'localidade_nome' => $pessoa->localidade ? $pessoa->localidade->nome : null,
                    'data_nascimento' => $pessoa->data_nascimento ? $pessoa->data_nascimento->format('d/m/Y') : null,
                    'idade' => $pessoa->idade,
                    'recebe_pbf' => $pessoa->recebe_pbf,
                ];
            });

        return response()->json($pessoas);
    }

    public function obterPessoa($id)
    {
        $pessoa = PessoaCad::with('localidade')->findOrFail($id);

        return response()->json([
            'id' => $pessoa->id,
            'nome' => $pessoa->nom_pessoa,
            'apelido' => $pessoa->nom_apelido_pessoa,
            'nis' => $pessoa->num_nis_pessoa_atual,
            'nis_formatado' => $pessoa->nis_formatado ?? $pessoa->num_nis_pessoa_atual,
            'cpf' => $pessoa->num_cpf_pessoa,
            'cpf_formatado' => $pessoa->cpf_formatado ?? $pessoa->num_cpf_pessoa,
            'localidade_id' => $pessoa->localidade_id,
            'localidade_nome' => $pessoa->localidade ? $pessoa->localidade->nome : null,
            'data_nascimento' => $pessoa->data_nascimento ? $pessoa->data_nascimento->format('d/m/Y') : null,
            'idade' => $pessoa->idade,
            'recebe_pbf' => $pessoa->recebe_pbf,
            'telefone' => null, // Campo não existe na tabela pessoas_cad, mas mantido para compatibilidade
            'email' => null, // Campo não existe na tabela pessoas_cad, mas mantido para compatibilidade
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pessoa_id' => 'nullable|exists:pessoas_cad,id',
            'solicitante_nome' => 'required|string|max:255',
            'solicitante_apelido' => 'nullable|string|max:100',
            'solicitante_telefone' => 'required|string|max:20',
            'solicitante_email' => 'required|email|max:255',
            'localidade_id' => 'required|exists:localidades,id',
            'tipo' => 'required|in:agua,luz,estrada,poco',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'motivo' => 'required|string|max:255',
            'descricao' => 'required|string|min:20',
            'observacoes' => 'nullable|string',
            // Campos para vincular a demanda existente
            'vincular_demanda_id' => 'nullable|exists:demandas,id',
            'forcar_criar_nova' => 'nullable|boolean',
        ], [
            'solicitante_telefone.required' => 'O campo Telefone/WhatsApp é obrigatório.',
            'solicitante_email.required' => 'O campo E-mail é obrigatório para receber a confirmação e acompanhamento da demanda.',
            'solicitante_email.email' => 'O e-mail informado não é válido.',
            'descricao.required' => 'O campo Descrição é obrigatório.',
            'descricao.min' => 'A descrição deve ter no mínimo 20 caracteres para ajudar a identificar e localizar o problema de forma precisa.',
        ]);

        // Se pessoa_id foi informado, buscar dados da pessoa
        $pessoa = null;
        if (!empty($validated['pessoa_id'])) {
            $pessoa = PessoaCad::find($validated['pessoa_id']);
            if ($pessoa) {
                $validated['solicitante_nome'] = $pessoa->nom_pessoa;
                // Preencher apelido se não foi informado manualmente e a pessoa tem apelido
                if (empty($validated['solicitante_apelido']) && $pessoa->nom_apelido_pessoa) {
                    $validated['solicitante_apelido'] = $pessoa->nom_apelido_pessoa;
                }
                // Se a pessoa tem localidade, usar ela (sobrescreve se não foi informada)
                if ($pessoa->localidade_id) {
                    $validated['localidade_id'] = $pessoa->localidade_id;
                }
            }
        }

        // ========== VERIFICAR SE DEVE VINCULAR A DEMANDA EXISTENTE ==========
        if (!empty($validated['vincular_demanda_id'])) {
            return $this->vincularADemandaExistente($validated, $pessoa);
        }

        // ========== DETECÇÃO AVANÇADA DE DUPLICATAS ==========
        // Se não está forçando criar nova, verificar similaridade
        if (empty($validated['forcar_criar_nova'])) {
            $duplicata = $this->similaridadeService->verificarDuplicata($validated);

            if ($duplicata) {
                // Armazenar dados na sessão para o modal
                session()->flash('demandas_similares', [
                    'duplicata' => $duplicata,
                    'dados_nova' => $validated,
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('warning_similaridade', true)
                    ->with('demanda_similar', $duplicata['demanda'])
                    ->with('score_similaridade', $duplicata['score'])
                    ->with('confianca_similaridade', $duplicata['confianca'])
                    ->with('mensagem_similaridade', $duplicata['mensagem']);
            }
        }

        // ========== VERIFICAÇÃO TRADICIONAL DE DUPLICATA EXATA ==========
        // Verificar se já existe uma demanda similar (duplicata) criada nas últimas 24 horas
        $demandaSimilar = Demanda::where('solicitante_nome', $validated['solicitante_nome'])
            ->where('tipo', $validated['tipo'])
            ->where('localidade_id', $validated['localidade_id'])
            ->where('status', 'aberta')
            ->where('created_at', '>=', now()->subHours(24))
            ->first();

        if ($demandaSimilar) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Já existe uma demanda aberta para este solicitante, do mesmo tipo e localidade, criada nas últimas 24 horas. <a href="' . route('demandas.show', $demandaSimilar->id) . '" class="font-semibold underline">Ver demanda existente</a>');
        }

        // Se pessoa_id foi informado, verificar também por pessoa_id
        if (!empty($validated['pessoa_id'])) {
            $demandaSimilarPorPessoa = Demanda::where('pessoa_id', $validated['pessoa_id'])
                ->where('tipo', $validated['tipo'])
                ->where('localidade_id', $validated['localidade_id'])
                ->where('status', 'aberta')
                ->where('created_at', '>=', now()->subHours(24))
                ->first();

            if ($demandaSimilarPorPessoa) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Já existe uma demanda aberta para esta pessoa, do mesmo tipo e localidade, criada nas últimas 24 horas. <a href="' . route('demandas.show', $demandaSimilarPorPessoa->id) . '" class="font-semibold underline">Ver demanda existente</a>');
            }
        }

        $validated['status'] = 'aberta';
        $validated['user_id'] = auth()->id();
        $validated['data_abertura'] = now();
        $validated['total_interessados'] = 1; // Solicitante original

        // Gera código automaticamente para a demanda
        $validated['codigo'] = Demanda::generateCode('DEM', $validated['tipo']);

        $demanda = Demanda::create($validated);

        // Criar o solicitante original como primeiro interessado
        $demanda->criarInteressadoOriginal();

        // Gerar cache de palavras-chave para busca futura
        $this->similaridadeService->gerarCachePalavrasChave($demanda);

        // Se pessoa foi vinculada e não tem localidade, vincular a localidade da demanda
        if ($pessoa && !$pessoa->localidade_id && !empty($validated['localidade_id'])) {
            $pessoa->localidade_id = $validated['localidade_id'];
            $pessoa->save();

            Log::info('Localidade vinculada automaticamente à pessoa ao criar demanda', [
                'pessoa_id' => $pessoa->id,
                'pessoa_nome' => $pessoa->nom_pessoa,
                'localidade_id' => $validated['localidade_id'],
                'demanda_id' => $demanda->id,
            ]);
        }

        // Enviar notificação para admins sobre nova demanda criada
        try {
            $tipoTexto = match($demanda->tipo) {
                'agua' => 'Água',
                'luz' => 'Iluminação',
                'estrada' => 'Estrada',
                'poco' => 'Poço',
                default => ucfirst($demanda->tipo),
            };

            $prioridadeTexto = match($demanda->prioridade) {
                'baixa' => 'Baixa',
                'media' => 'Média',
                'alta' => 'Alta',
                'urgente' => 'Urgente',
                default => ucfirst($demanda->prioridade),
            };

            $tipoNotificacao = $demanda->prioridade === 'urgente' ? 'alert' : ($demanda->prioridade === 'alta' ? 'warning' : 'info');

            $this->notifyRole(
                'admin',
                $tipoNotificacao,
                'Nova Demanda Criada',
                "Uma nova demanda de {$tipoTexto} foi criada: {$demanda->codigo} - {$demanda->motivo} (Prioridade: {$prioridadeTexto})",
                route('admin.demandas.show', $demanda->id),
                [
                    'demanda_id' => $demanda->id,
                    'codigo' => $demanda->codigo,
                    'tipo' => $demanda->tipo,
                    'prioridade' => $demanda->prioridade,
                    'localidade_id' => $demanda->localidade_id,
                ],
                'Demandas',
                Demanda::class,
                $demanda->id
            );

            // Se a demanda é urgente, notificar também co-admins
            if ($demanda->prioridade === 'urgente') {
                $this->notifyRole(
                    'co-admin',
                    'alert',
                    'Demanda Urgente Criada',
                    "Uma demanda URGENTE foi criada: {$demanda->codigo} - {$demanda->motivo}",
                    route('co-admin.demandas.show', $demanda->id),
                    [
                        'demanda_id' => $demanda->id,
                        'codigo' => $demanda->codigo,
                        'tipo' => $demanda->tipo,
                        'prioridade' => $demanda->prioridade,
                    ],
                    'Demandas',
                    Demanda::class,
                    $demanda->id
                );
            }
        } catch (\Exception $e) {
            // Log do erro mas não interrompe o fluxo
            Log::warning('Erro ao enviar notificação de nova demanda: ' . $e->getMessage(), [
                'demanda_id' => $demanda->id,
                'error' => $e->getTraceAsString(),
            ]);
        }

        // Enviar email de confirmação (backup caso o Observer falhe)
        // O Observer também tenta enviar, mas fazemos aqui como garantia
        if ($demanda->solicitante_email && $demanda->codigo) {
            try {
                // Carregar relacionamentos se necessário
                if (!$demanda->relationLoaded('localidade')) {
                    $demanda->load('localidade');
                }
                if (!$demanda->relationLoaded('pessoa')) {
                    $demanda->load('pessoa');
                }

                // Validar email
                if (filter_var($demanda->solicitante_email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($demanda->solicitante_email)
                        ->send(new \Modules\Demandas\App\Mail\DemandaCriada($demanda));

                    Log::info('Email de confirmação de demanda enviado via Controller (backup)', [
                        'demanda_id' => $demanda->id,
                        'codigo' => $demanda->codigo,
                        'email' => $demanda->solicitante_email,
                    ]);
                }
            } catch (\Exception $e) {
                // Log do erro mas não interrompe o fluxo
                Log::error('Erro ao enviar email de confirmação via Controller (backup)', [
                    'demanda_id' => $demanda->id,
                    'codigo' => $demanda->codigo,
                    'email' => $demanda->solicitante_email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('demandas.index')
            ->with('success', 'Demanda criada com sucesso' . ($demanda->solicitante_email ? '. Um email de confirmação foi enviado para ' . $demanda->solicitante_email : ''));
    }

    /**
     * Vincula o solicitante a uma demanda existente como interessado
     */
    protected function vincularADemandaExistente(array $dados, ?PessoaCad $pessoa): \Illuminate\Http\RedirectResponse
    {
        try {
            $demanda = Demanda::findOrFail($dados['vincular_demanda_id']);

            // Verificar se já não está vinculado
            if ($demanda->pessoaJaVinculada(
                $dados['pessoa_id'] ?? null,
                null, // CPF não está no form padrão
                $dados['solicitante_email'] ?? null
            )) {
                return redirect()->route('demandas.show', $demanda->id)
                    ->with('info', 'Você já está vinculado a esta demanda. Acompanhe o andamento abaixo.');
            }

            // Vincular como interessado
            $interessado = $this->similaridadeService->vincularInteressado($demanda, [
                'pessoa_id' => $dados['pessoa_id'] ?? null,
                'nome' => $dados['solicitante_nome'],
                'apelido' => $dados['solicitante_apelido'] ?? null,
                'telefone' => $dados['solicitante_telefone'] ?? null,
                'email' => $dados['solicitante_email'] ?? null,
                'descricao_adicional' => $dados['descricao'] ?? null,
                'notificar' => true,
            ], null, 'sugestao_aceita');

            Log::info('Interessado vinculado a demanda existente', [
                'demanda_id' => $demanda->id,
                'interessado_id' => $interessado->id,
                'nome' => $dados['solicitante_nome'],
            ]);

            return redirect()->route('demandas.show', $demanda->id)
                ->with('success', 'Você foi vinculado à demanda existente com sucesso! Agora você receberá atualizações sobre o andamento. Total de pessoas afetadas: ' . $demanda->fresh()->total_interessados);

        } catch (\Exception $e) {
            Log::error('Erro ao vincular interessado a demanda', [
                'demanda_id' => $dados['vincular_demanda_id'] ?? null,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao vincular à demanda existente. Por favor, tente novamente.');
        }
    }

    /**
     * API: Verifica demandas similares antes de criar (AJAX)
     */
    public function verificarSimilares(Request $request)
    {
        $validated = $request->validate([
            'localidade_id' => 'required|exists:localidades,id',
            'tipo' => 'required|in:agua,luz,estrada,poco',
            'motivo' => 'required|string|max:255',
            'descricao' => 'required|string|min:10',
        ]);

        $similares = $this->similaridadeService->buscarSimilares($validated, 5);

        if ($similares->isEmpty()) {
            return response()->json([
                'encontrou' => false,
                'mensagem' => 'Nenhuma demanda similar encontrada.',
            ]);
        }

        $resultados = $similares->map(function($item) {
            $demanda = $item['demanda'];
            return [
                'id' => $demanda->id,
                'codigo' => $demanda->codigo,
                'motivo' => $demanda->motivo,
                'descricao' => Str::limit($demanda->descricao, 150),
                'localidade' => $demanda->localidade?->nome,
                'tipo' => $demanda->tipo_texto,
                'status' => $demanda->status_texto,
                'prioridade' => $demanda->prioridade_texto,
                'data_abertura' => $demanda->data_abertura?->format('d/m/Y'),
                'total_interessados' => $demanda->total_interessados ?? 1,
                'score' => $item['score'],
                'nivel_similaridade' => $this->similaridadeService->classificarSimilaridade($item['score']),
                'cor_similaridade' => $this->similaridadeService->getCorSimilaridade($item['score']),
                'detalhes' => $item['detalhes'],
                'url' => route('demandas.show', $demanda->id),
            ];
        });

        $melhorMatch = $similares->first();

        return response()->json([
            'encontrou' => true,
            'total' => $similares->count(),
            'melhor_match' => [
                'score' => $melhorMatch['score'],
                'nivel' => $this->similaridadeService->classificarSimilaridade($melhorMatch['score']),
                'recomendacao' => $melhorMatch['score'] >= 70
                    ? 'Recomendamos vincular-se à demanda existente'
                    : 'Você pode criar uma nova demanda ou vincular-se a uma existente',
            ],
            'demandas' => $resultados,
        ]);
    }

    /**
     * Exibe os interessados de uma demanda
     */
    public function interessados($id)
    {
        $demanda = Demanda::with(['interessados.pessoa', 'interessados.usuario', 'localidade'])
            ->findOrFail($id);

        return view('demandas::interessados', compact('demanda'));
    }

    /**
     * Remove um interessado de uma demanda
     */
    public function removerInteressado(Request $request, $demandaId, $interessadoId)
    {
        $demanda = Demanda::findOrFail($demandaId);
        $interessado = DemandaInteressado::where('demanda_id', $demandaId)
            ->where('id', $interessadoId)
            ->firstOrFail();

        // Não permitir remover o solicitante original
        if ($interessado->metodo_vinculo === 'solicitante_original') {
            return redirect()->back()
                ->with('error', 'Não é possível remover o solicitante original da demanda.');
        }

        $nome = $interessado->nome;
        $interessado->delete();

        // Recalcular total
        $demanda->recalcularTotalInteressados();

        return redirect()->back()
            ->with('success', "Interessado '{$nome}' removido da demanda com sucesso.");
    }

    public function show($id)
    {
        $demanda = Demanda::with([
            'localidade',
            'pessoa.localidade',
            'usuario',
            'ordemServico.equipe',
            'ordemServico.usuarioAbertura',
            'ordemServico.usuarioExecucao',
            'ordemServico.materiais.material',
            'interessados.pessoa',
            'interessados.usuario'
        ])->findOrFail($id);

        // Estatísticas da demanda
        $estatisticas = [
            'dias_aberta' => $demanda->diasAberta(),
            'tem_os' => $demanda->temOS(),
            'pode_criar_os' => $demanda->podeCriarOS(),
            'pode_concluir' => $demanda->podeConcluir(),
            'pode_cancelar' => $demanda->podeCancelar(),
        ];

        return view('demandas::show', compact('demanda', 'estatisticas'));
    }

    public function print($id)
    {
        $demanda = Demanda::with(['localidade', 'pessoa', 'usuario', 'ordemServico'])->findOrFail($id);
        return view('demandas::print', compact('demanda'));
    }

    /**
     * Gera PDF com relação de demandas em aberto
     */
    public function relatorioAbertasPdf(Request $request)
    {
        $query = Demanda::with(['localidade', 'pessoa', 'usuario'])
            ->where('status', 'aberta')
            ->orderBy('prioridade', 'desc')
            ->orderBy('created_at', 'asc');

        // Aplicar filtros opcionais
        if ($request->has('localidade_id') && $request->localidade_id) {
            $query->where('localidade_id', $request->localidade_id);
        }

        if ($request->has('tipo') && $request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        $demandas = $query->get();

        // Estatísticas
        $estatisticas = [
            'total' => $demandas->count(),
            'por_tipo' => $demandas->groupBy('tipo')->map->count(),
            'por_prioridade' => $demandas->groupBy('prioridade')->map->count(),
            'por_localidade' => $demandas->groupBy(function($item) {
                return $item->localidade ? $item->localidade->nome : 'Sem localidade';
            })->map->count(),
        ];

        // Dados para o PDF
        $data = [
            'demandas' => $demandas,
            'estatisticas' => $estatisticas,
            'data_geracao' => now(),
            'usuario' => auth()->user(),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('demandas::pdf.relatorio-abertas', $data);
        $pdf->setPaper('A4', 'landscape');

        $filename = 'Relacao_Demandas_Abertas_' . date('Ymd_His') . '.pdf';
        return $pdf->stream($filename);
    }

    public function edit($id)
    {
        $demanda = Demanda::findOrFail($id);
        $localidades = [];
        if ($this->isModuleEnabled('Localidades') && $this->tableExists('localidades')) {
            $localidades = Localidade::where('ativo', true)->select('id', 'nome', 'codigo')->orderBy('nome')->get();
        }

        return view('demandas::edit', compact('demanda', 'localidades'));
    }

    public function update(Request $request, $id)
    {
        $demanda = Demanda::findOrFail($id);
        $oldStatus = $demanda->status;

        $validated = $request->validate([
            'pessoa_id' => 'nullable|exists:pessoas_cad,id',
            'solicitante_nome' => 'required|string|max:255',
            'solicitante_apelido' => 'nullable|string|max:100',
            'solicitante_telefone' => 'required|string|max:20',
            'solicitante_email' => 'nullable|email|max:255',
            'localidade_id' => 'required|exists:localidades,id',
            'tipo' => 'required|in:agua,luz,estrada,poco',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'motivo' => 'required|string|max:255',
            'descricao' => 'required|string|min:20',
            'status' => 'required|in:aberta,em_andamento,concluida,cancelada',
            'observacoes' => 'nullable|string',
        ], [
            'solicitante_telefone.required' => 'O campo Telefone/WhatsApp é obrigatório.',
            'descricao.required' => 'O campo Descrição é obrigatório.',
            'descricao.min' => 'A descrição deve ter no mínimo 20 caracteres para ajudar a identificar e localizar o problema de forma precisa.',
        ]);

        // Se a demanda foi finalizada, atualiza data_conclusao
        if ($validated['status'] === 'concluida' && $oldStatus !== 'concluida') {
            $validated['data_conclusao'] = now();

            // Se a OS relacionada existe e não está concluída, concluir automaticamente
            if ($demanda->ordemServico && $demanda->ordemServico->status !== 'concluida') {
                $demanda->ordemServico->update([
                    'status' => 'concluida',
                    'data_conclusao' => now(),
                    'tempo_execucao' => $demanda->ordemServico->data_inicio ? now()->diffInMinutes($demanda->ordemServico->data_inicio) : null,
                ]);
            }
        }

        // Se pessoa_id foi informado, buscar dados da pessoa
        if (!empty($validated['pessoa_id'])) {
            $pessoa = PessoaCad::find($validated['pessoa_id']);
            if ($pessoa) {
                // Se a pessoa tem localidade, usar ela (sobrescreve se não foi informada)
                if ($pessoa->localidade_id) {
                    $validated['localidade_id'] = $pessoa->localidade_id;
                }
            }
        }

        $demanda->update($validated);
        // O Observer cuida do envio de email automaticamente

        return redirect()->route('demandas.show', $demanda)
            ->with('success', 'Demanda atualizada com sucesso');
    }

    public function destroy($id)
    {
        try {
            // Buscar demanda (incluindo soft deleted se existir)
            $demanda = Demanda::withTrashed()->findOrFail($id);
            $demandaId = $demanda->id;

            DB::beginTransaction();

            // Excluir permanentemente a ordem de serviço relacionada se existir
            $ordemServico = $demanda->ordemServico;
            if ($ordemServico) {
                $ordemServicoId = $ordemServico->id;

                // Excluir materiais relacionados à OS (exclusão física)
                if (Schema::hasTable('ordem_servico_materiais')) {
                    DB::table('ordem_servico_materiais')
                        ->where('ordem_servico_id', $ordemServicoId)
                        ->delete();
                }

                // Excluir permanentemente a OS do banco (exclusão física)
                DB::table('ordens_servico')->where('id', $ordemServicoId)->delete();
            }

            // Excluir permanentemente a demanda do banco de dados (exclusão física)
            // Usar DELETE direto para garantir que remove do banco, ignorando soft deletes
            $deleted = DB::table('demandas')->where('id', $demandaId)->delete();

            if ($deleted === 0) {
                throw new \Exception('Demanda não foi encontrada ou já foi excluída');
            }

            DB::commit();

            // Limpar TODOS os caches do dashboard
            $periods = ['today', 'week', 'month'];
            foreach ($periods as $period) {
                \Illuminate\Support\Facades\Cache::forget("dashboard_stats_{$period}");
            }

            // Limpar cache geral também
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats');

            return redirect()->route('demandas.index')
                ->with('success', 'Demanda e todos os dados relacionados foram excluídos permanentemente do banco de dados');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir demanda ID ' . $id . ': ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Erro ao excluir demanda: ' . $e->getMessage());
        }
    }

    /**
     * Reenviar email de confirmação da demanda
     */
    public function reenviarEmail(Demanda $demanda)
    {
        $demanda->load(['localidade', 'pessoa']);

        if (!$demanda->solicitante_email) {
            return redirect()->back()
                ->with('error', 'Esta demanda não possui email cadastrado para reenvio.');
        }

        // Validar email antes de enviar
        if (!filter_var($demanda->solicitante_email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->with('error', 'O email cadastrado nesta demanda não é válido.');
        }

        try {
            // Carregar relacionamentos se necessário
            if (!$demanda->relationLoaded('localidade')) {
                $demanda->load('localidade');
            }
            if (!$demanda->relationLoaded('pessoa')) {
                $demanda->load('pessoa');
            }

            // Enviar email de confirmação
            Mail::to($demanda->solicitante_email)
                ->send(new \Modules\Demandas\App\Mail\DemandaCriada($demanda));

            Log::info('Email de confirmação de demanda reenviado manualmente', [
                'demanda_id' => $demanda->id,
                'codigo' => $demanda->codigo,
                'email' => $demanda->solicitante_email,
                'usuario' => auth()->user()->name ?? 'Sistema',
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->back()
                ->with('success', "Email de confirmação reenviado com sucesso para {$demanda->solicitante_email}.");

        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface | \Swift_TransportException $e) {
            Log::error('Erro de transporte ao reenviar email de confirmação de demanda', [
                'demanda_id' => $demanda->id,
                'codigo' => $demanda->codigo,
                'email' => $demanda->solicitante_email,
                'error' => $e->getMessage(),
                'error_code' => method_exists($e, 'getCode') ? $e->getCode() : 0,
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao reenviar email. Verifique as configurações de email do sistema.');

        } catch (\Exception $e) {
            Log::error('Erro ao reenviar email de confirmação de demanda', [
                'demanda_id' => $demanda->id,
                'codigo' => $demanda->codigo,
                'email' => $demanda->solicitante_email,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao reenviar email: ' . $e->getMessage());
        }
    }
}
