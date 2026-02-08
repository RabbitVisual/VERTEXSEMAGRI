<?php

namespace Modules\Funcionarios\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ExportsData;
use App\Traits\ChecksModuleEnabled;
use Illuminate\Http\Request;
use Modules\Funcionarios\App\Models\Funcionario;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FuncionariosController extends Controller
{
    use ExportsData, ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Funcionarios');
    }

    public function index(Request $request)
    {
        // Verificar se há exportação solicitada
        if ($request->has('format')) {
            return $this->export($request);
        }

        $filters = $request->only(['funcao', 'ativo', 'search', 'com_equipe']);
        $query = Funcionario::with('equipes');

        // Busca
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por função
        if (!empty($filters['funcao'])) {
            $query->where('funcao', $filters['funcao']);
        }

        // Filtro por status
        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo'] === '1');
        }

        // Filtro por equipe
        if (isset($filters['com_equipe']) && $filters['com_equipe'] !== '') {
            if ($filters['com_equipe'] === '1') {
                $query->has('equipes');
            } else {
                $query->doesntHave('equipes');
            }
        }

        $funcionarios = $query->orderBy('nome')->paginate(15);

        // Estatísticas
        $stats = [
            'total' => Funcionario::count(),
            'ativos' => Funcionario::where('ativo', true)->count(),
            'com_equipe' => Funcionario::has('equipes')->count(),
            'sem_equipe' => Funcionario::doesntHave('equipes')->count(),
        ];

        return view('funcionarios::index', compact('funcionarios', 'filters', 'stats'));
    }

    public function create()
    {
        return view('funcionarios::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:funcionarios,cpf',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'funcao' => 'required|in:eletricista,encanador,operador,motorista,supervisor,tecnico,outro',
            'data_admissao' => 'nullable|date',
            'data_demissao' => 'nullable|date|after:data_admissao',
            'ativo' => 'boolean',
            'observacoes' => 'nullable|string',
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema. Por favor, verifique se o funcionário já existe ou use um CPF diferente.',
            'cpf.max' => 'O CPF deve ter no máximo 14 caracteres.',
            'email.email' => 'O email informado não é válido.',
            'funcao.required' => 'O campo Função é obrigatório.',
            'funcao.in' => 'A função selecionada não é válida.',
            'data_demissao.after' => 'A data de demissão deve ser posterior à data de admissão.',
        ]);

        // Gera código automaticamente sempre
        $validated['codigo'] = Funcionario::generateCode('FUNC', $validated['funcao']);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        \Illuminate\Support\Facades\Log::info('📝 CRIANDO FUNCIONÁRIO VIA CONTROLLER', [
            'dados' => $validated,
            'request_ativo' => $request->has('ativo'),
            'request_ativo_value' => $request->input('ativo'),
            'ativo_final' => $validated['ativo'],
            'tipo_ativo_final' => gettype($validated['ativo']),
            'email' => $validated['email'] ?? null,
            'timestamp' => now()->toDateTimeString(),
        ]);

        $funcionario = Funcionario::create($validated);

        \Illuminate\Support\Facades\Log::info('✅ FUNCIONÁRIO CRIADO NO BANCO', [
            'funcionario_id' => $funcionario->id,
            'nome' => $funcionario->nome,
            'email' => $funcionario->email,
            'ativo' => $funcionario->ativo,
            'tipo_ativo_banco' => gettype($funcionario->ativo),
            'codigo' => $funcionario->codigo,
        ]);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário criado com sucesso');
    }

    public function show($id)
    {
        $funcionario = Funcionario::with('equipes')->findOrFail($id);
        return view('funcionarios::show', compact('funcionario'));
    }

    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionarios::edit', compact('funcionario'));
    }

    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'funcao' => 'required|in:eletricista,encanador,operador,motorista,supervisor,tecnico,outro',
            'data_admissao' => 'nullable|date',
            'data_demissao' => 'nullable|date|after:data_admissao',
            'ativo' => 'boolean',
            'observacoes' => 'nullable|string',
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado para outro funcionário. Por favor, verifique o CPF informado.',
            'cpf.max' => 'O CPF deve ter no máximo 14 caracteres.',
            'email.email' => 'O email informado não é válido.',
            'funcao.required' => 'O campo Função é obrigatório.',
            'funcao.in' => 'A função selecionada não é válida.',
            'data_demissao.after' => 'A data de demissão deve ser posterior à data de admissão.',
        ]);

        // Gera código automaticamente se estiver vazio ou não existir
        if (empty($funcionario->codigo)) {
            $validated['codigo'] = Funcionario::generateCode('FUNC', $validated['funcao']);
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $funcionario->update($validated);

        return redirect()->route('funcionarios.show', $funcionario)
            ->with('success', 'Funcionário atualizado com sucesso');
    }

    public function destroy($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        // Verificar se pode ser deletado usando método do modelo
        if (!$funcionario->podeSerDeletado()) {
            return redirect()->route('funcionarios.index')
                ->with('error', 'Não é possível deletar este funcionário pois ele está vinculado a uma ou mais equipes.');
        }

        $funcionario->delete();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário deletado com sucesso');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['funcao', 'ativo', 'search', 'com_equipe']);
        $query = Funcionario::with('equipes');

        // Aplicar mesmos filtros do index
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['funcao'])) {
            $query->where('funcao', $filters['funcao']);
        }

        if (isset($filters['ativo']) && $filters['ativo'] !== '') {
            $query->where('ativo', $filters['ativo'] === '1');
        }

        if (isset($filters['com_equipe']) && $filters['com_equipe'] !== '') {
            if ($filters['com_equipe'] === '1') {
                $query->has('equipes');
            } else {
                $query->doesntHave('equipes');
            }
        }

        $funcionarios = $query->orderBy('nome')->get();

        $columns = [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'cpf' => 'CPF',
            'email' => 'Email',
            'telefone' => 'Telefone',
            'funcao' => 'Função',
            'data_admissao' => 'Data Admissão',
            'data_demissao' => 'Data Demissão',
            'ativo' => 'Status',
            'equipes_count' => 'Total de Equipes',
        ];

        // Adicionar contagem de equipes
        $funcionarios = $funcionarios->map(function($funcionario) {
            $funcionario->equipes_count = $funcionario->equipes->count();
            $funcionario->ativo = $funcionario->ativo ? 'Ativo' : 'Inativo';
            return $funcionario;
        });

        $format = $request->get('format', 'csv');
        $filename = 'funcionarios_' . date('Ymd_His');

        if ($format === 'excel') {
            return $this->exportExcel($funcionarios, $columns, $filename);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($funcionarios, $columns, $filename, 'Relatório de Funcionários');
        } else {
            return $this->exportCsv($funcionarios, $columns, $filename);
        }
    }

    /**
     * Reenvia o email de credenciais para o funcionário
     */
    public function reenviarEmail(Funcionario $funcionario)
    {
        $funcionario->load(['equipes']);

        \Illuminate\Support\Facades\Log::info('Iniciando reenvio de email de credenciais', [
            'funcionario_id' => $funcionario->id,
            'codigo' => $funcionario->codigo,
            'email' => $funcionario->email,
            'usuario' => auth()->user()->name ?? 'Sistema',
        ]);

        if (!$funcionario->email) {
            \Illuminate\Support\Facades\Log::warning('Tentativa de reenvio sem email cadastrado', [
                'funcionario_id' => $funcionario->id,
                'codigo' => $funcionario->codigo,
            ]);
            return redirect()->back()
                ->with('error', 'Este funcionário não possui email cadastrado para reenvio.');
        }

        // Validar email antes de enviar
        if (!filter_var($funcionario->email, FILTER_VALIDATE_EMAIL)) {
            \Illuminate\Support\Facades\Log::warning('Tentativa de reenvio com email inválido', [
                'funcionario_id' => $funcionario->id,
                'codigo' => $funcionario->codigo,
                'email' => $funcionario->email,
            ]);
            return redirect()->back()
                ->with('error', 'O email cadastrado neste funcionário não é válido.');
        }

        // Garantir que existe um usuário para o funcionário
        $user = \App\Models\User::where('email', $funcionario->email)->first();
        if (!$user) {
            \Illuminate\Support\Facades\Log::warning('Tentativa de reenvio sem usuário criado', [
                'funcionario_id' => $funcionario->id,
                'email' => $funcionario->email,
            ]);

            // Criar usuário se não existir
            $senhaTemporaria = \Illuminate\Support\Str::random(12);

            try {
                $user = \App\Models\User::create([
                    'name' => $funcionario->nome,
                    'email' => $funcionario->email,
                    'password' => \Illuminate\Support\Facades\Hash::make($senhaTemporaria),
                    'active' => $funcionario->ativo,
                ]);

                // Atribuir role 'campo'
                $roleCampo = \Spatie\Permission\Models\Role::where('name', 'campo')->first();
                if ($roleCampo) {
                    $user->assignRole('campo');
                }

                \Illuminate\Support\Facades\Log::info('Usuário criado durante reenvio de email', [
                    'funcionario_id' => $funcionario->id,
                    'user_id' => $user->id,
                    'email' => $funcionario->email,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erro ao criar usuário durante reenvio', [
                    'funcionario_id' => $funcionario->id,
                    'email' => $funcionario->email,
                    'error' => $e->getMessage(),
                ]);
                return redirect()->back()
                    ->with('error', 'Erro ao preparar credenciais do usuário.');
            }
        }

        // Verificar se existe senha temporária armazenada
        $senhaTemporaria = null;
        $senhaRecord = DB::table('funcionario_senhas')
            ->where('funcionario_id', $funcionario->id)
            ->where('visualizada', false)
            ->first();

        if ($senhaRecord) {
            try {
                $senhaTemporaria = \Illuminate\Support\Facades\Crypt::decryptString($senhaRecord->senha_temporaria);
                \Illuminate\Support\Facades\Log::info('Senha temporária existente recuperada', [
                    'funcionario_id' => $funcionario->id,
                    'email' => $funcionario->email,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Erro ao descriptografar senha existente - gerando nova', [
                    'funcionario_id' => $funcionario->id,
                    'email' => $funcionario->email,
                    'error' => $e->getMessage(),
                ]);
                $senhaTemporaria = null;
            }
        }

        // Se não tem senha temporária armazenada ou houve erro, gera uma nova
        if (!$senhaTemporaria) {
            $senhaTemporaria = \Illuminate\Support\Str::random(12);

            \Illuminate\Support\Facades\Log::info('Gerando nova senha temporária', [
                'funcionario_id' => $funcionario->id,
                'email' => $funcionario->email,
            ]);

            // Atualizar ou criar registro de senha
            DB::table('funcionario_senhas')->updateOrInsert(
                ['funcionario_id' => $funcionario->id],
                [
                    'user_id' => $user->id,
                    'senha_temporaria' => \Illuminate\Support\Facades\Crypt::encryptString($senhaTemporaria),
                    'visualizada' => false,
                    'updated_at' => now(),
                ]
            );
        }

        try {
            // Carregar relacionamentos necessários
            if (!$funcionario->relationLoaded('equipes')) {
                $funcionario->load('equipes');
            }

            \Illuminate\Support\Facades\Log::info('Enviando email de credenciais', [
                'funcionario_id' => $funcionario->id,
                'codigo' => $funcionario->codigo,
                'email' => $funcionario->email,
                'login_url' => route('login'),
            ]);

            // Enviar email com credenciais
            \Illuminate\Support\Facades\Mail::to($funcionario->email)
                ->send(new \Modules\Funcionarios\App\Mail\FuncionarioCriado($funcionario, $senhaTemporaria));

            \Illuminate\Support\Facades\Log::info('Email de credenciais reenviado com sucesso', [
                'funcionario_id' => $funcionario->id,
                'codigo' => $funcionario->codigo,
                'email' => $funcionario->email,
                'usuario' => auth()->user()->name ?? 'Sistema',
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->back()
                ->with('success', "Email de credenciais reenviado com sucesso para {$funcionario->email}.");

        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface | \Swift_TransportException $e) {
            \Illuminate\Support\Facades\Log::error('Erro de transporte ao reenviar email de credenciais do funcionário', [
                'funcionario_id' => $funcionario->id,
                'codigo' => $funcionario->codigo,
                'email' => $funcionario->email,
                'error' => $e->getMessage(),
                'error_code' => method_exists($e, 'getCode') ? $e->getCode() : 0,
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao reenviar email. Verifique as configurações de email do sistema.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao reenviar email de credenciais do funcionário', [
                'funcionario_id' => $funcionario->id,
                'codigo' => $funcionario->codigo,
                'email' => $funcionario->email,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao reenviar email: ' . $e->getMessage());
        }
    }
}
