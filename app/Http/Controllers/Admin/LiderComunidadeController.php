<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Models\LiderComunidade;
use Modules\Pocos\App\Models\Poco;
use Modules\Pocos\App\Models\PagamentoPoco;
use Modules\Localidades\App\Models\Localidade;
use Modules\Pessoas\App\Models\PessoaCad;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LiderComunidadeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'localidade_id', 'poco_id', 'status']);

        $query = LiderComunidade::with(['localidade', 'poco', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('localidade_id')) {
            $query->where('localidade_id', $request->localidade_id);
        }

        if ($request->filled('poco_id')) {
            $query->where('poco_id', $request->poco_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $lideres = $query->orderBy('nome')->paginate(20);
        $localidades = Localidade::orderBy('nome')->get();
        $pocos = Poco::orderBy('nome_mapa')->get();

        return view('admin.lideres-comunidade.index', compact('lideres', 'localidades', 'pocos', 'filters'));
    }

    public function create()
    {
        $localidades = Localidade::orderBy('nome')->get();
        $pocos = Poco::orderBy('nome_mapa')->get();
        $users = User::whereDoesntHave('liderComunidade')->where('active', true)->orderBy('name')->get();
        $roleLider = Role::where('name', 'lider-comunidade')->first();

        return view('admin.lideres-comunidade.create', compact('localidades', 'pocos', 'users', 'roleLider'));
    }

    public function buscarPessoa($id)
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
            'data_nascimento' => $pessoa->dta_nasc_pessoa ? $pessoa->dta_nasc_pessoa->format('d/m/Y') : null,
            'idade' => $pessoa->idade ?? null,
            'recebe_pbf' => $pessoa->recebe_pbf ?? false,
        ]);
    }

    public function buscarPessoas(Request $request)
    {
        $search = $request->get('search', '');
        $localidadeId = $request->get('localidade_id');

        $query = PessoaCad::with('localidade')
            ->where('ativo', true);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom_pessoa', 'like', "%{$search}%")
                  ->orWhere('nom_apelido_pessoa', 'like', "%{$search}%")
                  ->orWhere('num_nis_pessoa_atual', 'like', "%{$search}%")
                  ->orWhere('num_cpf_pessoa', 'like', "%{$search}%");
            });
        }

        if ($localidadeId) {
            $query->where('localidade_id', $localidadeId);
        }

        $pessoas = $query->orderBy('nom_pessoa')->limit(20)->get();

        return response()->json($pessoas->map(function($pessoa) {
            return [
                'id' => $pessoa->id,
                'nome' => $pessoa->nom_pessoa,
                'apelido' => $pessoa->nom_apelido_pessoa,
                'nis' => $pessoa->num_nis_pessoa_atual,
                'cpf' => $pessoa->num_cpf_pessoa,
                'localidade' => $pessoa->localidade ? $pessoa->localidade->nome : null,
                'localidade_id' => $pessoa->localidade_id,
            ];

        }));
    }

    public function store(Request $request)
    {
        // Remover formatação do CPF
        if ($request->has('cpf')) {
            $cpfClean = preg_replace('/[^0-9]/', '', $request->cpf ?? '');
            $request->merge(['cpf' => !empty($cpfClean) ? $cpfClean : null]);
        }

        // Converter criar_usuario - pode ser 'pessoa', '1' ou '0'
        $criarUsuario = $request->input('criar_usuario');
        if ($criarUsuario === 'pessoa') {
            // Se for pessoa, não precisa validar user_id
            $request->merge(['criar_usuario' => 'pessoa']);
        } elseif ($criarUsuario === '1' || $criarUsuario === 1 || $criarUsuario === true) {
            $request->merge(['criar_usuario' => true]);
        } else {
            $request->merge(['criar_usuario' => false]);
        }

        $validated = $request->validate([
            // Dados do Líder
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11|unique:lideres_comunidade,cpf',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'localidade_id' => [
                'required',
                'integer',
                'exists:localidades,id'
            ],
            'poco_id' => [
                'required',
                'integer',
                'exists:pocos,id'
            ],
            'endereco' => 'nullable|string',
            'status' => 'required|in:ativo,inativo',
            'observacoes' => 'nullable|string',

            // Opção: Criar usuário, vincular existente ou vincular pessoa do CadÚnico
            'criar_usuario' => 'required|in:0,1,true,false,pessoa',
            'pessoa_id' => [
                'required_if:criar_usuario,pessoa',
                'nullable',
                'integer',
                'exists:pessoas_cad,id'
            ],
            'user_id' => [
                'required_without:pessoa_id',
                'required_if:criar_usuario,0',
                'nullable',
                'integer',
                'exists:users,id'
            ],

            // Dados do usuário (se criar novo)
            'user_name' => 'required_if:criar_usuario,1|required_if:criar_usuario,true|nullable|string|max:255',
            'user_email' => 'required_if:criar_usuario,1|required_if:criar_usuario,true|nullable|email|max:255|unique:users,email',
            'user_password' => 'required_if:criar_usuario,1|required_if:criar_usuario,true|nullable|string|min:8|confirmed',
        ], [
            'localidade_id.required' => 'A localidade é obrigatória.',
            'localidade_id.exists' => 'A localidade selecionada não existe.',
            'poco_id.required' => 'O poço é obrigatório.',
            'poco_id.exists' => 'O poço selecionado não existe.',
            'pessoa_id.exists' => 'A pessoa do CadÚnico selecionada não existe.',
            'user_id.required_without' => 'É necessário selecionar um usuário do sistema ou uma pessoa do CadÚnico.',
            'user_id.required_if' => 'É necessário selecionar um usuário quando não está criando um novo.',
            'user_id.exists' => 'O usuário selecionado não existe.',
        ]);

        DB::beginTransaction();
        try {
            $user = null;
            $pessoa = null;

            // Se foi selecionada uma pessoa do CadÚnico
            if (!empty($validated['pessoa_id'])) {
                $pessoa = PessoaCad::findOrFail($validated['pessoa_id']);

                // Preencher dados do líder com dados da pessoa se não foram preenchidos
                if (empty($validated['nome'])) {
                    $validated['nome'] = $pessoa->nom_pessoa;
                }
                if (empty($validated['cpf']) && $pessoa->num_cpf_pessoa) {
                    $validated['cpf'] = preg_replace('/[^0-9]/', '', $pessoa->num_cpf_pessoa);
                }
                if (empty($validated['localidade_id']) && $pessoa->localidade_id) {
                    $validated['localidade_id'] = $pessoa->localidade_id;
                }

                // Se foi selecionada pessoa E não foi selecionada opção de criar usuário, criar automaticamente
                if ($validated['criar_usuario'] === 'pessoa') {
                    // Criar usuário automaticamente para permitir acesso ao painel
                    $emailUsuario = $validated['email'] ?? ($pessoa->num_cpf_pessoa ? $pessoa->num_cpf_pessoa . '@lider.comunidade' : 'lider' . $pessoa->id . '@comunidade');

                    // Verificar se já existe usuário com esse email
                    $userExistente = User::where('email', $emailUsuario)->first();
                    if ($userExistente) {
                        $user = $userExistente;
                    } else {
                        // Gerar senha temporária (CPF sem formatação ou data de nascimento)
                        $senhaTemporaria = $pessoa->num_cpf_pessoa ? substr($pessoa->num_cpf_pessoa, 0, 6) : '12345678';

                        $user = User::create([
                            'name' => $pessoa->nom_pessoa,
                            'email' => $emailUsuario,
                            'password' => Hash::make($senhaTemporaria),
                            'active' => true,
                        ]);
                    }

                    // Atribuir role de líder
                    $roleLider = Role::where('name', 'lider-comunidade')->first();
                    if ($roleLider && !$user->hasRole('lider-comunidade')) {
                        $user->assignRole($roleLider);
                    }
                }
            }

            // Criar ou vincular usuário (se não foi selecionada pessoa OU se foi selecionada mas não é opção "pessoa")
            if (empty($validated['pessoa_id']) || ($validated['criar_usuario'] !== 'pessoa' && !empty($validated['pessoa_id']))) {
                $criarUsuario = ($validated['criar_usuario'] === '1' || $validated['criar_usuario'] === 1 || $validated['criar_usuario'] === true);
                if ($criarUsuario) {
                    $user = User::create([
                        'name' => $validated['user_name'],
                        'email' => $validated['user_email'],
                        'password' => Hash::make($validated['user_password']),
                        'active' => true,
                    ]);

                    // Atribuir role de líder
                    $roleLider = Role::where('name', 'lider-comunidade')->first();
                    if ($roleLider) {
                        $user->assignRole($roleLider);
                    }
                } else {
                    $user = User::findOrFail($validated['user_id']);

                    // Garantir que tem a role
                    $roleLider = Role::where('name', 'lider-comunidade')->first();
                    if ($roleLider && !$user->hasRole('lider-comunidade')) {
                        $user->assignRole($roleLider);
                    }
                }
            }

            // Se foi selecionada pessoa mas não foi criado usuário, criar automaticamente
            if ($pessoa && !$user && $validated['criar_usuario'] === 'pessoa') {
                // Criar usuário automaticamente para permitir acesso ao painel
                $emailUsuario = $validated['email'] ?? ($pessoa->num_cpf_pessoa ? $pessoa->num_cpf_pessoa . '@lider.comunidade' : 'lider' . $pessoa->id . '@comunidade');

                // Verificar se já existe usuário com esse email
                $userExistente = User::where('email', $emailUsuario)->first();
                if ($userExistente) {
                    $user = $userExistente;
                } else {
                    // Gerar senha temporária (CPF sem formatação ou padrão)
                    $senhaTemporaria = $pessoa->num_cpf_pessoa ? substr($pessoa->num_cpf_pessoa, 0, 6) : '12345678';

                    $user = User::create([
                        'name' => $pessoa->nom_pessoa,
                        'email' => $emailUsuario,
                        'password' => Hash::make($senhaTemporaria),
                        'active' => true,
                    ]);
                }

                // Atribuir role de líder
                $roleLider = Role::where('name', 'lider-comunidade')->first();
                if ($roleLider && !$user->hasRole('lider-comunidade')) {
                    $user->assignRole($roleLider);
                }
            }

            // Garantir que o endereço está preenchido (usar o da localidade se não foi fornecido)
            $enderecoFinal = $validated['endereco'] ?? '';
            if (empty($enderecoFinal) && !empty($validated['localidade_id'])) {
                $localidade = \Modules\Localidades\App\Models\Localidade::find($validated['localidade_id']);
                if ($localidade) {
                    $enderecoCompleto = $localidade->endereco ?? '';
                    if ($localidade->numero) {
                        $enderecoCompleto .= ($enderecoCompleto ? ', ' : '') . $localidade->numero;
                    }
                    if ($localidade->complemento) {
                        $enderecoCompleto .= ($enderecoCompleto ? ' - ' : '') . $localidade->complemento;
                    }
                    if ($localidade->bairro) {
                        $enderecoCompleto .= ($enderecoCompleto ? ', ' : '') . $localidade->bairro;
                    }
                    if ($localidade->cidade) {
                        $enderecoCompleto .= ($enderecoCompleto ? ' - ' : '') . $localidade->cidade;
                        if ($localidade->estado) {
                            $enderecoCompleto .= '/' . $localidade->estado;
                        }
                    }
                    if ($localidade->cep) {
                        $enderecoCompleto .= ($enderecoCompleto ? ' - CEP: ' : '') . $localidade->cep;
                    }
                    // Se não tem endereço na localidade, usar pelo menos o nome
                    $enderecoFinal = $enderecoCompleto ?: $localidade->nome;
                }
            }

            // Fallback: se ainda não tem endereço, usar o nome da localidade
            if (empty($enderecoFinal) && !empty($validated['localidade_id'])) {
                $localidade = \Modules\Localidades\App\Models\Localidade::find($validated['localidade_id']);
                if ($localidade) {
                    $enderecoFinal = $localidade->nome;
                }
            }

            // Criar líder de comunidade
            $lider = LiderComunidade::create([
                'nome' => $validated['nome'],
                'cpf' => $validated['cpf'] ?? null,
                'telefone' => $validated['telefone'] ?? null,
                'email' => $validated['email'] ?? ($pessoa ? ($user ? $user->email : null) : ($user ? $user->email : null)),
                'localidade_id' => $validated['localidade_id'],
                'poco_id' => $validated['poco_id'],
                'user_id' => $user ? $user->id : null,
                'pessoa_id' => $pessoa ? $pessoa->id : null,
                'endereco' => $enderecoFinal,
                'status' => $validated['status'],
                'observacoes' => $validated['observacoes'] ?? null,
            ]);

            DB::commit();

            // Mensagem de sucesso com informações de acesso
            $mensagem = "Líder de comunidade {$lider->nome} cadastrado com sucesso!";

            // Se foi criado usuário automaticamente, informar sobre as credenciais
            if ($pessoa && $user && $validated['criar_usuario'] === 'pessoa') {
                $senhaTemporaria = $pessoa->num_cpf_pessoa ? substr($pessoa->num_cpf_pessoa, 0, 6) : '12345678';
                $mensagem .= " Usuário criado automaticamente para acesso ao painel. Email: {$user->email} | Senha temporária: {$senhaTemporaria} (recomendamos alterar no primeiro acesso)";
            }

            return redirect()->route('admin.lideres-comunidade.index')
                ->with('success', $mensagem);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar líder: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $lider = LiderComunidade::with(['localidade', 'poco', 'user', 'pessoa', 'mensalidades.pagamentos', 'pagamentos'])->findOrFail($id);

        // Calcular estatísticas através das mensalidades do líder
        // Isso é mais confiável pois os pagamentos estão sempre vinculados às mensalidades
        $mensalidadesIds = $lider->mensalidades()->pluck('id');

        $totalArrecadado = PagamentoPoco::whereIn('mensalidade_id', $mensalidadesIds)
            ->where('status', 'confirmado')
            ->sum('valor_pago') ?? 0;

        $totalPagamentos = PagamentoPoco::whereIn('mensalidade_id', $mensalidadesIds)
            ->where('status', 'confirmado')
            ->count();

        $estatisticas = [
            'total_mensalidades' => $lider->mensalidades()->count(),
            'total_pagamentos' => $totalPagamentos,
            'total_arrecadado' => $totalArrecadado,
        ];

        return view('admin.lideres-comunidade.show', compact('lider', 'estatisticas'));
    }

    public function edit($id)
    {
        $lider = LiderComunidade::with(['localidade', 'poco', 'user', 'pessoa'])->findOrFail($id);
        $localidades = Localidade::orderBy('nome')->get();
        $pocos = Poco::orderBy('nome_mapa')->get();
        $users = User::where(function($q) use ($lider) {
            $q->whereDoesntHave('liderComunidade')
              ->orWhere('id', $lider->user_id);
        })->where('active', true)->orderBy('name')->get();

        return view('admin.lideres-comunidade.edit', compact('lider', 'localidades', 'pocos', 'users'));
    }

    public function update(Request $request, $id)
    {
        $lider = LiderComunidade::findOrFail($id);

        // Remover formatação do CPF
        if ($request->has('cpf')) {
            $cpfClean = preg_replace('/[^0-9]/', '', $request->cpf ?? '');
            $request->merge(['cpf' => !empty($cpfClean) ? $cpfClean : null]);
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11|unique:lideres_comunidade,cpf,' . $lider->id,
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'localidade_id' => 'required|exists:localidades,id',
            'poco_id' => 'required|exists:pocos,id',
            'user_id' => 'nullable|exists:users,id',
            'endereco' => 'nullable|string',
            'status' => 'required|in:ativo,inativo',
            'observacoes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Garantir que o endereço está preenchido (usar o da localidade se não foi fornecido)
            $enderecoFinal = $validated['endereco'] ?? '';
            if (empty($enderecoFinal) && !empty($validated['localidade_id'])) {
                $localidade = \Modules\Localidades\App\Models\Localidade::find($validated['localidade_id']);
                if ($localidade) {
                    $enderecoCompleto = $localidade->endereco ?? '';
                    if ($localidade->numero) {
                        $enderecoCompleto .= ($enderecoCompleto ? ', ' : '') . $localidade->numero;
                    }
                    if ($localidade->complemento) {
                        $enderecoCompleto .= ($enderecoCompleto ? ' - ' : '') . $localidade->complemento;
                    }
                    if ($localidade->bairro) {
                        $enderecoCompleto .= ($enderecoCompleto ? ', ' : '') . $localidade->bairro;
                    }
                    if ($localidade->cidade) {
                        $enderecoCompleto .= ($enderecoCompleto ? ' - ' : '') . $localidade->cidade;
                        if ($localidade->estado) {
                            $enderecoCompleto .= '/' . $localidade->estado;
                        }
                    }
                    if ($localidade->cep) {
                        $enderecoCompleto .= ($enderecoCompleto ? ' - CEP: ' : '') . $localidade->cep;
                    }
                    if ($enderecoCompleto) {
                        $enderecoFinal = $enderecoCompleto;
                    } else {
                        $enderecoFinal = $localidade->nome;
                    }
                }
            }

            // Se ainda não tem endereço, usar o nome da localidade como fallback
            if (empty($enderecoFinal) && !empty($validated['localidade_id'])) {
                $localidade = \Modules\Localidades\App\Models\Localidade::find($validated['localidade_id']);
                if ($localidade) {
                    $enderecoFinal = $localidade->nome;
                }
            }

            $validated['endereco'] = $enderecoFinal;

            $lider->update($validated);

            // Atualizar role do usuário se mudou (apenas se não foi selecionada pessoa)
            if (empty($validated['pessoa_id']) && $validated['user_id'] && $validated['user_id'] != $lider->user_id) {
                $userAnterior = User::find($lider->user_id);
                if ($userAnterior) {
                    $userAnterior->removeRole('lider-comunidade');
                }

                $userNovo = User::findOrFail($validated['user_id']);
                $roleLider = Role::where('name', 'lider-comunidade')->first();
                if ($roleLider && !$userNovo->hasRole('lider-comunidade')) {
                    $userNovo->assignRole($roleLider);
                }
            } elseif (!empty($validated['pessoa_id']) && $lider->user_id) {
                // Se foi selecionada pessoa, remover role do usuário anterior
                $userAnterior = User::find($lider->user_id);
                if ($userAnterior) {
                    $userAnterior->removeRole('lider-comunidade');
                }
            }

            DB::commit();

            return redirect()->route('admin.lideres-comunidade.index')
                ->with('success', "Líder de comunidade atualizado com sucesso!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar líder: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $lider = LiderComunidade::findOrFail($id);

        DB::beginTransaction();
        try {

            // Remover role do usuário
            if ($lider->user_id) {
                $user = User::find($lider->user_id);
                if ($user) {
                    $user->removeRole('lider-comunidade');
                }
            }

            $lider->delete();

            DB::commit();

            return redirect()->route('admin.lideres-comunidade.index')
                ->with('success', "Líder de comunidade removido com sucesso!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao remover líder: ' . $e->getMessage());
        }
    }
}
