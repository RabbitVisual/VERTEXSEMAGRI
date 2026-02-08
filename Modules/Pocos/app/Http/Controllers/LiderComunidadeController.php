<?php

namespace Modules\Pocos\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Models\LiderComunidade;
use Modules\Pocos\App\Models\Poco;
use Modules\Pocos\App\Models\UsuarioPoco;
use Modules\Pocos\App\Models\MensalidadePoco;
use Modules\Pocos\App\Models\PagamentoPoco;
use Modules\Pocos\App\Models\BoletoPoco;
use Modules\Pocos\App\Models\SolicitacaoBaixaPoco;
use Modules\Localidades\App\Models\Localidade;
use Modules\Pessoas\App\Models\PessoaCad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LiderComunidadeController extends Controller
{
    /**
     * Dashboard do líder
     */
    public function dashboard()
    {
        $lider = $this->getLiderAutenticado();

        if (!$lider) {
            return redirect()->route('login')->with('error', 'Acesso negado. Você precisa ser um líder de comunidade.');
        }

        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->route('lider-comunidade.pocos.index')
                ->with('warning', 'Você precisa estar vinculado a um poço para acessar o painel.');
        }

        // Estatísticas do mês atual
        $mesAtual = now()->month;
        $anoAtual = now()->year;

        $mensalidadeAtual = MensalidadePoco::where('poco_id', $poco->id)
            ->where('mes', $mesAtual)
            ->where('ano', $anoAtual)
            ->first();

        $stats = [
            'total_usuarios' => $poco->usuariosPoco()->where('status', 'ativo')->count(),
            'total_mensalidades' => $poco->mensalidades()->count(),
            'mensalidade_atual' => $mensalidadeAtual,
            'total_arrecadado_mes' => $mensalidadeAtual ? $mensalidadeAtual->total_arrecadado : 0,
            'total_pendente_mes' => $mensalidadeAtual ? $mensalidadeAtual->total_pendente : 0,
            'usuarios_pagantes' => $mensalidadeAtual ? $mensalidadeAtual->usuarios_pagantes : 0,
            'usuarios_pendentes' => $mensalidadeAtual ? $mensalidadeAtual->usuarios_pendentes : 0,
            'pagamentos_hoje' => PagamentoPoco::where('poco_id', $poco->id)
                ->whereDate('data_pagamento', today())
                ->where('status', 'confirmado')
                ->count(),
        ];

        // Últimos pagamentos
        $ultimosPagamentos = PagamentoPoco::where('poco_id', $poco->id)
            ->with(['usuarioPoco', 'mensalidade'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Mensalidades recentes
        $mensalidadesRecentes = MensalidadePoco::where('poco_id', $poco->id)
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->limit(6)
            ->get();

        // Solicitações de baixa pendentes
        $solicitacoesPendentes = SolicitacaoBaixaPoco::where('poco_id', $poco->id)
            ->where('status', 'pendente')
            ->count();

        return view('pocos::lider-comunidade.dashboard', compact(
            'lider',
            'poco',
            'stats',
            'ultimosPagamentos',
            'mensalidadesRecentes',
            'mensalidadeAtual',
            'solicitacoesPendentes'
        ));
    }

    /**
     * Lista de usuários do poço
     */
    public function usuariosIndex(Request $request)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Você precisa estar vinculado a um poço.');
        }

        $query = UsuarioPoco::where('poco_id', $poco->id);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('codigo_acesso', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $usuarios = $query->orderBy('nome')->paginate(20);

        return view('pocos::lider-comunidade.usuarios.index', compact('usuarios', 'poco', 'lider'));
    }

    public function usuariosCreate()
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Você precisa estar vinculado a um poço.');
        }

        return view('pocos::lider-comunidade.usuarios.create', compact('poco'));
    }

    /**
     * Buscar pessoas do CadÚnico (AJAX)
     */
    public function buscarPessoas(Request $request)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return response()->json([]);
        }

        $search = $request->get('search', '');

        // Buscar pessoas na base do cadastro único
        $pessoas = PessoaCad::with('localidade')
            ->where('ativo', true)
            ->where(function($query) use ($search) {
                // Remover formatação para busca numérica
                $cleanSearch = preg_replace('/[^0-9]/', '', $search);

                $query->where('nom_pessoa', 'like', "%{$search}%")
                    ->orWhere('num_nis_pessoa_atual', 'like', "%{$search}%")
                    ->orWhere('num_cpf_pessoa', 'like', "%{$search}%")
                    ->orWhere('nom_apelido_pessoa', 'like', "%{$search}%");

                if (!empty($cleanSearch)) {
                    $query->orWhere('num_nis_pessoa_atual', 'like', "%{$cleanSearch}%")
                          ->orWhere('num_cpf_pessoa', 'like', "%{$cleanSearch}%");
                }
            })
            ->orderBy('nom_pessoa')
            ->limit(20)
            ->get();

        return response()->json($pessoas->map(function($pessoa) {
            return [
                'id' => $pessoa->id,
                'nome' => $pessoa->nom_pessoa,
                'apelido' => $pessoa->nom_apelido_pessoa,
                'nis' => $pessoa->num_nis_pessoa_atual,
                'cpf' => $pessoa->num_cpf_pessoa,
                'cpf_formatado' => $pessoa->cpf_formatado ?? null,
                'nis_formatado' => $pessoa->nis_formatado ?? null,
                'localidade' => $pessoa->localidade ? $pessoa->localidade->nome : null,
                'localidade_id' => $pessoa->localidade_id,
                'idade' => $pessoa->idade ?? null,
            ];
        }));
    }

    /**
     * Obter dados de uma pessoa específica (AJAX)
     */
    public function obterPessoa($id)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return response()->json(['error' => 'Poço não encontrado'], 404);
        }

        $pessoa = PessoaCad::with('localidade')->findOrFail($id);

        // Montar endereço da localidade
        $endereco = '';
        if ($pessoa->localidade) {
            $localidade = $pessoa->localidade;
            $endereco = $localidade->endereco ?? '';
            if ($localidade->numero) {
                $endereco .= ($endereco ? ', ' : '') . $localidade->numero;
            }
            if ($localidade->complemento) {
                $endereco .= ($endereco ? ' - ' : '') . $localidade->complemento;
            }
            if ($localidade->bairro) {
                $endereco .= ($endereco ? ', ' : '') . $localidade->bairro;
            }
            if ($localidade->cidade) {
                $endereco .= ($endereco ? ' - ' : '') . $localidade->cidade;
                if ($localidade->estado) {
                    $endereco .= '/' . $localidade->estado;
                }
            }
            if ($localidade->cep) {
                $endereco .= ($endereco ? ' - CEP: ' : '') . $localidade->cep;
            }
            if (!$endereco) {
                $endereco = $localidade->nome; // Fallback
            }
        }

        return response()->json([
            'id' => $pessoa->id,
            'nome' => $pessoa->nom_pessoa,
            'apelido' => $pessoa->nom_apelido_pessoa,
            'cpf' => $pessoa->num_cpf_pessoa,
            'cpf_formatado' => $pessoa->cpf_formatado ?? null,
            'nis_formatado' => $pessoa->nis_formatado ?? null,
            'localidade_id' => $pessoa->localidade_id,
            'localidade_nome' => $pessoa->localidade ? $pessoa->localidade->nome : null,
            'idade' => $pessoa->idade ?? null,
            'telefone' => $pessoa->num_telefone_contato ?? null,
            'endereco' => $endereco,
        ]);
    }

    /**
     * Salvar novo usuário
     */
    public function usuariosStore(Request $request)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->back()->with('error', 'Você precisa estar vinculado a um poço.');
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'required|string',
            'numero_casa' => 'nullable|string|max:20',
            'status' => 'required|in:ativo,inativo,suspenso',
            'observacoes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $validated['poco_id'] = $poco->id;
            $validated['data_cadastro'] = now();

            // Remover formatação do CPF
            if (!empty($validated['cpf'])) {
                $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
            }

            $usuario = UsuarioPoco::create($validated);

            DB::commit();

            return redirect()->route('lider-comunidade.usuarios.index')
                ->with('success', 'Usuário cadastrado com sucesso! Código de acesso: ' . $usuario->codigo_acesso);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Lista de mensalidades
     */
    public function mensalidadesIndex(Request $request)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Você precisa estar vinculado a um poço.');
        }

        $query = MensalidadePoco::where('poco_id', $poco->id);

        // Filtros
        if ($request->filled('mes')) {
            $query->where('mes', $request->mes);
        }

        if ($request->filled('ano')) {
            $query->where('ano', $request->ano);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $mensalidades = $query->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->paginate(20);

        return view('pocos::lider-comunidade.mensalidades.index', compact('mensalidades', 'poco', 'lider'));
    }

    /**
     * Criar nova mensalidade
     */
    public function mensalidadesCreate()
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Você precisa estar vinculado a um poço.');
        }

        // Verificar se já existe mensalidade para o mês atual
        $mesAtual = now()->month;
        $anoAtual = now()->year;

        $mensalidadeExistente = MensalidadePoco::where('poco_id', $poco->id)
            ->where('mes', $mesAtual)
            ->where('ano', $anoAtual)
            ->first();

        if ($mensalidadeExistente) {
            return redirect()->route('lider-comunidade.mensalidades.show', $mensalidadeExistente)
                ->with('info', 'Já existe uma mensalidade para este mês.');
        }

        return view('pocos::lider-comunidade.mensalidades.create', compact('poco'));
    }

    /**
     * Salvar nova mensalidade
     */
    public function mensalidadesStore(Request $request)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->back()->with('error', 'Você precisa estar vinculado a um poço.');
        }

        $validated = $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020|max:2100',
            'valor_mensalidade' => 'required|numeric|min:0.01',
            'data_vencimento' => 'required|date',
            'forma_recebimento' => 'required|in:maos,pix',
            'chave_pix' => 'required_if:forma_recebimento,pix|nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        // Verificar se já existe mensalidade para este mês/ano
        $mensalidadeExistente = MensalidadePoco::where('poco_id', $poco->id)
            ->where('mes', $validated['mes'])
            ->where('ano', $validated['ano'])
            ->first();

        if ($mensalidadeExistente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Já existe uma mensalidade para ' . $validated['mes'] . '/' . $validated['ano']);
        }

        DB::beginTransaction();
        try {
            $validated['poco_id'] = $poco->id;
            $validated['lider_id'] = $lider->id;
            $validated['data_criacao'] = now();
            $validated['status'] = 'aberta';

            $mensalidade = MensalidadePoco::create($validated);

            // Gerar boletos para todos os usuários ativos
            $usuarios = UsuarioPoco::where('poco_id', $poco->id)
                ->where('status', 'ativo')
                ->get();

            foreach ($usuarios as $usuario) {
                BoletoPoco::create([
                    'mensalidade_id' => $mensalidade->id,
                    'usuario_poco_id' => $usuario->id,
                    'poco_id' => $poco->id,
                    'valor' => $mensalidade->valor_mensalidade,
                    'data_vencimento' => $mensalidade->data_vencimento,
                    'status' => 'aberto',
                ]);
            }

            DB::commit();

            return redirect()->route('lider-comunidade.mensalidades.show', $mensalidade)
                ->with('success', 'Mensalidade criada com sucesso! ' . $usuarios->count() . ' boletos gerados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar mensalidade: ' . $e->getMessage());
        }
    }

    /**
     * Detalhes da mensalidade
     */
    public function mensalidadesShow($id)
    {
        $lider = $this->getLiderAutenticado();
        $mensalidade = MensalidadePoco::with(['poco', 'lider', 'pagamentos.usuarioPoco'])
            ->findOrFail($id);

        // Verificar se a mensalidade pertence ao poço do líder
        if ($mensalidade->poco_id !== $lider->poco_id) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Acesso negado.');
        }

        // Lista de usuários com status de pagamento
        $usuarios = UsuarioPoco::where('poco_id', $mensalidade->poco_id)
            ->where('status', 'ativo')
            ->get()
            ->map(function($usuario) use ($mensalidade) {
                $pagamento = PagamentoPoco::where('mensalidade_id', $mensalidade->id)
                    ->where('usuario_poco_id', $usuario->id)
                    ->where('status', 'confirmado')
                    ->first();

                $usuario->pagou = $pagamento !== null;
                $usuario->pagamento = $pagamento;
                return $usuario;
            });

        return view('pocos::lider-comunidade.mensalidades.show', compact('mensalidade', 'usuarios', 'lider'));
    }

    /**
     * Atualizar forma de recebimento da mensalidade
     */
    public function mensalidadesUpdateRecebimento(Request $request, $id)
    {
        $lider = $this->getLiderAutenticado();
        $mensalidade = MensalidadePoco::findOrFail($id);

        // Verificar se a mensalidade pertence ao poço do líder
        if ($mensalidade->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        $validated = $request->validate([
            'forma_recebimento' => 'required|in:maos,pix',
            'chave_pix' => 'required_if:forma_recebimento,pix|nullable|string|max:255',
        ]);

        $mensalidade->update($validated);

        return redirect()->back()->with('success', 'Configuração de recebimento atualizada com sucesso!');
    }

    /**
     * Registrar pagamento
     */
    public function pagamentosStore(Request $request)
    {
        $lider = $this->getLiderAutenticado();

        $validated = $request->validate([
            'mensalidade_id' => 'required|exists:mensalidades_poco,id',
            'usuario_poco_id' => 'required|exists:usuarios_poco,id',
            'data_pagamento' => 'required|date',
            'valor_pago' => 'required|numeric|min:0.01',
            'forma_pagamento' => 'required|in:dinheiro,pix,transferencia,outro',
            'observacoes' => 'nullable|string',
        ]);

        $mensalidade = MensalidadePoco::findOrFail($validated['mensalidade_id']);

        // Verificar se o pagamento pertence ao poço do líder
        if ($mensalidade->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        // Verificar se há solicitação de baixa pendente para este usuário nesta mensalidade
        $solicitacaoPendente = SolicitacaoBaixaPoco::where('mensalidade_id', $mensalidade->id)
            ->where('usuario_poco_id', $validated['usuario_poco_id'])
            ->where('status', 'pendente')
            ->first();

        if ($solicitacaoPendente) {
            return redirect()->back()->with('error', 'Este usuário possui uma solicitação de baixa pendente. Por favor, analise a solicitação primeiro em "Solicitações de Baixa" ou rejeite-a antes de registrar o pagamento manualmente.');
        }

        // Verificar se já existe pagamento
        $pagamentoExistente = PagamentoPoco::where('mensalidade_id', $validated['mensalidade_id'])
            ->where('usuario_poco_id', $validated['usuario_poco_id'])
            ->where('status', 'confirmado')
            ->first();

        if ($pagamentoExistente) {
            return redirect()->back()->with('error', 'Este usuário já possui pagamento registrado para esta mensalidade.');
        }

        DB::beginTransaction();
        try {
            $validated['poco_id'] = $mensalidade->poco_id;
            $validated['lider_id'] = $lider->id;
            $validated['status'] = 'confirmado';

            $pagamento = PagamentoPoco::create($validated);

            // Atualizar status do boleto
            $boleto = BoletoPoco::where('mensalidade_id', $mensalidade->id)
                ->where('usuario_poco_id', $validated['usuario_poco_id'])
                ->first();

            if ($boleto) {
                $boleto->marcarComoPago();
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Pagamento registrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao registrar pagamento: ' . $e->getMessage());
        }
    }

    /**
     * Relatórios
     */
    public function relatorios(Request $request)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Você precisa estar vinculado a um poço.');
        }

        $dataInicio = $request->get('data_inicio', now()->startOfYear()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', now()->format('Y-m-d'));

        $pagamentos = PagamentoPoco::where('poco_id', $poco->id)
            ->whereBetween('data_pagamento', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->with(['usuarioPoco', 'mensalidade'])
            ->orderBy('data_pagamento', 'desc')
            ->get();

        $totalArrecadado = $pagamentos->sum('valor_pago');
        $totalPagamentos = $pagamentos->count();

        return view('pocos::lider-comunidade.relatorios.index', compact(
            'pagamentos',
            'totalArrecadado',
            'totalPagamentos',
            'dataInicio',
            'dataFim',
            'poco'
        ));
    }

    /**
     * Mostrar usuário
     */
    public function usuariosShow($id)
    {
        $lider = $this->getLiderAutenticado();
        $usuario = UsuarioPoco::with(['poco', 'pagamentos.mensalidade'])->findOrFail($id);

        if ($usuario->poco_id !== $lider->poco_id) {
            return redirect()->route('lider-comunidade.dashboard')->with('error', 'Acesso negado.');
        }

        return view('pocos::lider-comunidade.usuarios.show', compact('usuario', 'lider'));
    }

    /**
     * Editar usuário
     */
    public function usuariosEdit($id)
    {
        $lider = $this->getLiderAutenticado();
        $usuario = UsuarioPoco::findOrFail($id);

        if ($usuario->poco_id !== $lider->poco_id) {
            return redirect()->route('lider-comunidade.dashboard')->with('error', 'Acesso negado.');
        }

        $pessoas = PessoaCad::where('localidade_id', $usuario->poco->localidade_id)
            ->where('ativo', true)
            ->orderBy('nom_pessoa')
            ->get();

        return view('pocos::lider-comunidade.usuarios.edit', compact('usuario', 'pessoas'));
    }

    /**
     * Atualizar usuário
     */
    public function usuariosUpdate(Request $request, $id)
    {
        $lider = $this->getLiderAutenticado();
        $usuario = UsuarioPoco::findOrFail($id);

        if ($usuario->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'required|string',
            'numero_casa' => 'nullable|string|max:20',
            'status' => 'required|in:ativo,inativo,suspenso',
            'observacoes' => 'nullable|string',
        ]);

        if (!empty($validated['cpf'])) {
            $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
        }

        $usuario->update($validated);

        return redirect()->route('lider-comunidade.usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Deletar usuário
     */
    public function usuariosDestroy($id)
    {
        $lider = $this->getLiderAutenticado();
        $usuario = UsuarioPoco::findOrFail($id);

        if ($usuario->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        $usuario->delete();

        return redirect()->route('lider-comunidade.usuarios.index')
            ->with('success', 'Usuário removido com sucesso!');
    }

    /**
     * Fechar mensalidade
     */
    public function mensalidadesFechar($id)
    {
        $lider = $this->getLiderAutenticado();
        $mensalidade = MensalidadePoco::findOrFail($id);

        if ($mensalidade->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        if ($mensalidade->status !== 'aberta') {
            return redirect()->back()->with('error', 'Esta mensalidade já está fechada ou cancelada.');
        }

        $mensalidade->update(['status' => 'fechada']);

        return redirect()->back()->with('success', 'Mensalidade fechada com sucesso!');
    }

    /**
     * Atualizar pagamento
     */
    public function pagamentosUpdate(Request $request, $id)
    {
        $lider = $this->getLiderAutenticado();
        $pagamento = PagamentoPoco::findOrFail($id);

        if ($pagamento->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        $validated = $request->validate([
            'data_pagamento' => 'required|date',
            'valor_pago' => 'required|numeric|min:0.01',
            'forma_pagamento' => 'required|in:dinheiro,pix,transferencia,outro',
            'observacoes' => 'nullable|string',
        ]);

        $pagamento->update($validated);

        return redirect()->back()->with('success', 'Pagamento atualizado com sucesso!');
    }

    /**
     * Deletar pagamento
     */
    public function pagamentosDestroy($id)
    {
        $lider = $this->getLiderAutenticado();
        $pagamento = PagamentoPoco::findOrFail($id);

        if ($pagamento->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        // Atualizar boleto para aberto novamente
        $boleto = BoletoPoco::where('mensalidade_id', $pagamento->mensalidade_id)
            ->where('usuario_poco_id', $pagamento->usuario_poco_id)
            ->first();

        if ($boleto) {
            $boleto->update(['status' => 'aberto']);
        }

        $pagamento->delete();

        return redirect()->back()->with('success', 'Pagamento removido com sucesso!');
    }

    /**
     * Exportar relatórios
     */
    public function relatoriosExport(Request $request)
    {
        $lider = $this->getLiderAutenticado();
        $poco = $lider->poco;

        if (!$poco) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Você precisa estar vinculado a um poço.');
        }

        $dataInicio = $request->get('data_inicio', now()->startOfYear()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', now()->format('Y-m-d'));

        $pagamentos = PagamentoPoco::where('poco_id', $poco->id)
            ->whereBetween('data_pagamento', [$dataInicio, $dataFim])
            ->where('status', 'confirmado')
            ->with(['usuarioPoco', 'mensalidade'])
            ->orderBy('data_pagamento', 'desc')
            ->get();

        $format = $request->get('format', 'csv');

        if ($format === 'excel') {
            // Implementar exportação Excel se necessário
            return response()->json(['message' => 'Exportação Excel em desenvolvimento'], 501);
        } else {
            // CSV
            $filename = 'relatorio_pagamentos_' . date('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($pagamentos) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Data', 'Usuário', 'Mensalidade', 'Valor', 'Forma de Pagamento']);

                foreach ($pagamentos as $pagamento) {
                    fputcsv($file, [
                        $pagamento->data_pagamento->format('d/m/Y'),
                        $pagamento->usuarioPoco->nome,
                        $pagamento->mensalidade->mes . '/' . $pagamento->mensalidade->ano,
                        number_format($pagamento->valor_pago, 2, ',', '.'),
                        $pagamento->forma_pagamento_texto,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }

    /**
     * Listar solicitações de baixa
     */
    public function solicitacoesBaixaIndex(Request $request)
    {
        $lider = $this->getLiderAutenticado();

        if (!$lider || !$lider->poco_id) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Você precisa estar vinculado a um poço.');
        }

        $query = SolicitacaoBaixaPoco::with(['boleto', 'usuarioPoco', 'mensalidade'])
            ->where('poco_id', $lider->poco_id);

        // Filtros
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $solicitacoes = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('pocos::lider-comunidade.solicitacoes-baixa.index', compact('solicitacoes', 'lider'));
    }

    /**
     * Detalhes de uma solicitação de baixa
     */
    public function solicitacoesBaixaShow($id)
    {
        $lider = $this->getLiderAutenticado();

        if (!$lider || !$lider->poco_id) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Acesso negado.');
        }

        $solicitacao = SolicitacaoBaixaPoco::with(['boleto', 'usuarioPoco', 'mensalidade', 'poco'])
            ->findOrFail($id);

        // Verificar se a solicitação pertence ao poço do líder
        if ($solicitacao->poco_id !== $lider->poco_id) {
            return redirect()->route('lider-comunidade.solicitacoes-baixa.index')
                ->with('error', 'Acesso negado.');
        }

        return view('pocos::lider-comunidade.solicitacoes-baixa.show', compact('solicitacao', 'lider'));
    }

    /**
     * Aprovar solicitação de baixa
     */
    public function solicitacoesBaixaAprovar(Request $request, $id)
    {
        $lider = $this->getLiderAutenticado();

        if (!$lider || !$lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        $solicitacao = SolicitacaoBaixaPoco::with(['boleto', 'mensalidade'])->findOrFail($id);

        // Verificar se a solicitação pertence ao poço do líder
        if ($solicitacao->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        // Verificar se pode ser aprovada
        if (!$solicitacao->podeSerAprovada()) {
            return redirect()->back()->with('error', 'Esta solicitação não pode ser aprovada.');
        }

        DB::beginTransaction();
        try {
            // Atualizar solicitação
            $solicitacao->update([
                'status' => 'aprovada',
                'aprovado_por' => Auth::id(),
                'aprovado_em' => now(),
            ]);

            // Criar registro de pagamento
            PagamentoPoco::create([
                'mensalidade_id' => $solicitacao->mensalidade_id,
                'usuario_poco_id' => $solicitacao->usuario_poco_id,
                'poco_id' => $solicitacao->poco_id,
                'data_pagamento' => $solicitacao->data_pagamento,
                'valor_pago' => $solicitacao->valor_pago,
                'forma_pagamento' => $solicitacao->forma_pagamento,
                'observacoes' => $solicitacao->observacoes . ' (Aprovado via solicitação de baixa)',
                'status' => 'confirmado',
            ]);

            // Atualizar status do boleto
            $solicitacao->boleto->update(['status' => 'pago']);

            DB::commit();

            return redirect()->route('lider-comunidade.solicitacoes-baixa.show', $solicitacao->id)
                ->with('success', 'Solicitação aprovada e pagamento registrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao aprovar solicitação: ' . $e->getMessage());
        }
    }

    /**
     * Rejeitar solicitação de baixa
     */
    public function solicitacoesBaixaRejeitar(Request $request, $id)
    {
        $lider = $this->getLiderAutenticado();

        if (!$lider || !$lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        $validated = $request->validate([
            'motivo_rejeicao' => 'required|string|max:500',
        ]);

        $solicitacao = SolicitacaoBaixaPoco::findOrFail($id);

        // Verificar se a solicitação pertence ao poço do líder
        if ($solicitacao->poco_id !== $lider->poco_id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        // Verificar se pode ser rejeitada
        if (!$solicitacao->podeSerRejeitada()) {
            return redirect()->back()->with('error', 'Esta solicitação não pode ser rejeitada.');
        }

        $solicitacao->update([
            'status' => 'rejeitada',
            'motivo_rejeicao' => $validated['motivo_rejeicao'],
            'aprovado_por' => Auth::id(),
            'aprovado_em' => now(),
        ]);

        return redirect()->route('lider-comunidade.solicitacoes-baixa.show', $solicitacao->id)
            ->with('success', 'Solicitação rejeitada.');
    }

    /**
     * Obter líder autenticado
     */
    protected function getLiderAutenticado()
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        // Buscar líder pelo user_id ou por CPF/email
        $lider = LiderComunidade::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->orWhere('cpf', $user->cpf)
            ->first();

        return $lider;
    }
}
