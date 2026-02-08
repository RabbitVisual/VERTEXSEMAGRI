<?php

namespace Modules\CAF\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use Modules\CAF\App\Models\CadastroCAF;
use Modules\CAF\App\Models\ConjugeCAF;
use Modules\CAF\App\Models\FamiliarCAF;
use Modules\CAF\App\Models\ImovelCAF;
use Modules\CAF\App\Models\RendaFamiliarCAF;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CadastradorCAFController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('CAF');
    }
    /**
     * Lista de cadastros do cadastrador
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Buscar funcionário vinculado ao usuário
        $funcionario = Funcionario::where('email', $user->email)->first();
        
        $query = CadastroCAF::query()
            ->with(['pessoa', 'localidade', 'conjuge', 'familiares', 'imovel', 'rendaFamiliar'])
            ->latest();

        // Se for funcionário, filtrar apenas seus cadastros
        if ($funcionario) {
            $query->where('funcionario_id', $funcionario->id);
        } else {
            // Se não for funcionário, mostrar apenas os criados por ele
            $query->where('created_by', $user->id);
        }

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome_completo', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('protocolo', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('localidade_id')) {
            $query->where('localidade_id', $request->localidade_id);
        }

        $cadastros = $query->paginate(15)->withQueryString();
        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();

        return view('caf::cadastrador.index', compact('cadastros', 'localidades'));
    }

    /**
     * Buscar pessoas na base municipal (API - similar ao módulo Demandas)
     * Busca por nome, CPF ou NIS
     */
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
                    'data_nascimento' => $pessoa->data_nascimento ? $pessoa->data_nascimento->format('Y-m-d') : null,
                    'data_nascimento_formatada' => $pessoa->data_nascimento ? $pessoa->data_nascimento->format('d/m/Y') : null,
                    'idade' => $pessoa->idade,
                    'sexo' => $pessoa->cod_sexo_pessoa == 1 ? 'M' : ($pessoa->cod_sexo_pessoa == 2 ? 'F' : null),
                    'recebe_pbf' => $pessoa->recebe_pbf,
                    'cod_familiar_fam' => $pessoa->cod_familiar_fam,
                ];
            });

        return response()->json($pessoas);
    }

    /**
     * Obter dados completos de uma pessoa (API)
     */
    public function obterPessoa($id)
    {
        $pessoa = PessoaCad::with('localidade')->findOrFail($id);
        
        // Buscar família (cônjuge e familiares)
        $familia = collect();
        if ($pessoa->cod_familiar_fam) {
            $familia = PessoaCad::where('cod_familiar_fam', $pessoa->cod_familiar_fam)
                ->where('id', '!=', $pessoa->id)
                ->where('ativo', true)
                ->get()
                ->map(function($familiar) {
                    return [
                        'id' => $familiar->id,
                        'nome' => $familiar->nom_pessoa,
                        'cpf' => $familiar->num_cpf_pessoa,
                        'cpf_formatado' => $familiar->cpf_formatado ?? $familiar->num_cpf_pessoa,
                        'data_nascimento' => $familiar->data_nascimento ? $familiar->data_nascimento->format('Y-m-d') : null,
                        'data_nascimento_formatada' => $familiar->data_nascimento ? $familiar->data_nascimento->format('d/m/Y') : null,
                        'idade' => $familiar->idade,
                        'sexo' => $familiar->cod_sexo_pessoa == 1 ? 'M' : ($familiar->cod_sexo_pessoa == 2 ? 'F' : null),
                    ];
                });
        }
        
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
            'data_nascimento' => $pessoa->data_nascimento ? $pessoa->data_nascimento->format('Y-m-d') : null,
            'data_nascimento_formatada' => $pessoa->data_nascimento ? $pessoa->data_nascimento->format('d/m/Y') : null,
            'idade' => $pessoa->idade,
            'sexo' => $pessoa->cod_sexo_pessoa == 1 ? 'M' : ($pessoa->cod_sexo_pessoa == 2 ? 'F' : null),
            'recebe_pbf' => $pessoa->recebe_pbf,
            'cod_familiar_fam' => $pessoa->cod_familiar_fam,
            'familia' => $familia,
        ]);
    }

    /**
     * Criar novo cadastro - Etapa 1: Dados Pessoais
     */
    public function create(Request $request)
    {
        $pessoa = null;
        if ($request->filled('pessoa_id')) {
            $pessoa = PessoaCad::find($request->pessoa_id);
        }

        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();
        $user = auth()->user();
        $funcionario = Funcionario::where('email', $user->email)->first();

        return view('caf::cadastrador.etapa1', compact('pessoa', 'localidades', 'funcionario'));
    }

    /**
     * Salvar Etapa 1: Dados Pessoais
     */
    public function storeEtapa1(Request $request)
    {
        // Preparar dados antes da validação (remover formatação do CPF)
        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf ?? ''),
        ]);

        $validated = $request->validate([
            'pessoa_id' => 'nullable|exists:pessoas_cad,id',
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:cadastros_caf,cpf',
            'rg' => 'nullable|string|max:50',
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F,Outro',
            'estado_civil' => 'nullable|string',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'cep' => 'nullable|string|max:10',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|size:2',
            'localidade_id' => 'nullable|exists:localidades,id',
        ]);

        $user = auth()->user();
        $funcionario = Funcionario::where('email', $user->email)->first();

        DB::beginTransaction();
        try {
            $cadastro = CadastroCAF::create([
                'pessoa_id' => $validated['pessoa_id'] ?? null,
                'funcionario_id' => $funcionario?->id,
                'created_by' => $user->id,
                'nome_completo' => $validated['nome_completo'],
                'cpf' => $validated['cpf'], // Já está sem formatação após prepareForValidation
                'rg' => $validated['rg'] ?? null,
                'data_nascimento' => $validated['data_nascimento'] ?? null,
                'sexo' => $validated['sexo'] ?? null,
                'estado_civil' => $validated['estado_civil'] ?? null,
                'telefone' => $validated['telefone'] ?? null,
                'celular' => $validated['celular'] ?? null,
                'email' => $validated['email'] ?? null,
                'cep' => $validated['cep'] ?? null,
                'logradouro' => $validated['logradouro'] ?? null,
                'numero' => $validated['numero'] ?? null,
                'complemento' => $validated['complemento'] ?? null,
                'bairro' => $validated['bairro'] ?? null,
                'cidade' => $validated['cidade'] ?? null,
                'uf' => $validated['uf'] ?? null,
                'localidade_id' => $validated['localidade_id'] ?? null,
                'status' => 'em_andamento',
            ]);

            // Código e protocolo são gerados automaticamente no boot do model
            DB::commit();

            return redirect()->route('caf.cadastrador.etapa2', $cadastro->id)
                ->with('success', 'Dados pessoais salvos com sucesso! Continue para a próxima etapa.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar cadastro CAF - Etapa 1', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            return back()->withInput()->with('error', 'Erro ao salvar dados. Tente novamente.');
        }
    }

    /**
     * Etapa 2: Dados do Cônjuge
     */
    public function etapa2(CadastroCAF $cadastro)
    {
        $cadastro->load('conjuge', 'pessoa');
        
        // Se for solteiro, pular esta etapa
        if ($cadastro->estado_civil === 'solteiro') {
            return redirect()->route('caf.cadastrador.etapa3', $cadastro->id);
        }

        // Buscar família da pessoa se houver pessoa_id
        $familia = collect();
        if ($cadastro->pessoa_id && $cadastro->pessoa && $cadastro->pessoa->cod_familiar_fam) {
            $familia = PessoaCad::where('cod_familiar_fam', $cadastro->pessoa->cod_familiar_fam)
                ->where('id', '!=', $cadastro->pessoa_id)
                ->where('ativo', true)
                ->get();
        }

        return view('caf::cadastrador.etapa2', compact('cadastro', 'familia'));
    }

    public function storeEtapa2(Request $request, CadastroCAF $cadastro)
    {
        // Se for solteiro, pular
        if ($cadastro->estado_civil === 'solteiro') {
            return redirect()->route('caf.cadastrador.etapa3', $cadastro->id);
        }

        // Preparar dados antes da validação (remover formatação do CPF)
        if ($request->filled('cpf')) {
            $request->merge([
                'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            ]);
        }

        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11',
            'rg' => 'nullable|string|max:50',
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F,Outro',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'profissao' => 'nullable|string|max:255',
            'renda_mensal' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $cadastro->conjuge()->updateOrCreate(
                ['cadastro_caf_id' => $cadastro->id],
                $validated
            );

            DB::commit();

            return redirect()->route('caf.cadastrador.etapa3', $cadastro->id)
                ->with('success', 'Dados do cônjuge salvos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar cônjuge CAF', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao salvar dados do cônjuge.');
        }
    }

    /**
     * Etapa 3: Familiares
     */
    public function etapa3(CadastroCAF $cadastro)
    {
        $cadastro->load('familiares', 'pessoa');
        
        // Buscar família da pessoa se houver pessoa_id
        $familia = collect();
        if ($cadastro->pessoa_id && $cadastro->pessoa && $cadastro->pessoa->cod_familiar_fam) {
            $familia = PessoaCad::where('cod_familiar_fam', $cadastro->pessoa->cod_familiar_fam)
                ->where('id', '!=', $cadastro->pessoa_id)
                ->where('ativo', true)
                ->get();
        }
        
        return view('caf::cadastrador.etapa3', compact('cadastro', 'familia'));
    }

    public function storeEtapa3(Request $request, CadastroCAF $cadastro)
    {
        // Preparar dados antes da validação (remover formatação dos CPFs dos familiares)
        if ($request->filled('familiares')) {
            $familiares = $request->familiares;
            foreach ($familiares as $key => $familiar) {
                if (isset($familiar['cpf']) && !empty($familiar['cpf'])) {
                    $familiares[$key]['cpf'] = preg_replace('/[^0-9]/', '', $familiar['cpf']);
                }
            }
            $request->merge(['familiares' => $familiares]);
        }

        $validated = $request->validate([
            'familiares' => 'required|array|min:1',
            'familiares.*.nome_completo' => 'required|string|max:255',
            'familiares.*.cpf' => 'nullable|string|size:11',
            'familiares.*.rg' => 'nullable|string|max:50',
            'familiares.*.data_nascimento' => 'nullable|date',
            'familiares.*.sexo' => 'nullable|in:M,F,Outro',
            'familiares.*.parentesco' => 'required|string',
            'familiares.*.escolaridade' => 'nullable|string',
            'familiares.*.trabalha' => 'boolean',
            'familiares.*.renda_mensal' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Remover familiares existentes
            $cadastro->familiares()->delete();

            // Criar novos familiares
            foreach ($validated['familiares'] as $familiar) {
                $cadastro->familiares()->create($familiar);
            }

            DB::commit();

            return redirect()->route('caf.cadastrador.etapa4', $cadastro->id)
                ->with('success', 'Familiares salvos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar familiares CAF', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao salvar familiares.');
        }
    }

    /**
     * Etapa 4: Dados do Imóvel
     */
    public function etapa4(CadastroCAF $cadastro)
    {
        $cadastro->load('imovel');
        $localidades = Localidade::where('ativo', true)->orderBy('nome')->get();
        return view('caf::cadastrador.etapa4', compact('cadastro', 'localidades'));
    }

    public function storeEtapa4(Request $request, CadastroCAF $cadastro)
    {
        $validated = $request->validate([
            'tipo_posse' => 'required|string',
            'tipo_posse_outro' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:10',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|size:2',
            'localidade_id' => 'nullable|exists:localidades,id',
            'area_total_hectares' => 'nullable|numeric|min:0',
            'area_agricultavel_hectares' => 'nullable|numeric|min:0',
            'area_pastagem_hectares' => 'nullable|numeric|min:0',
            'area_reserva_legal_hectares' => 'nullable|numeric|min:0',
            'producao_vegetal' => 'boolean',
            'producao_animal' => 'boolean',
            'extrativismo' => 'boolean',
            'aquicultura' => 'boolean',
            'atividades_descricao' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $cadastro->imovel()->updateOrCreate(
                ['cadastro_caf_id' => $cadastro->id],
                $validated
            );

            DB::commit();

            return redirect()->route('caf.cadastrador.etapa5', $cadastro->id)
                ->with('success', 'Dados do imóvel salvos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar imóvel CAF', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao salvar dados do imóvel.');
        }
    }

    /**
     * Etapa 5: Renda Familiar
     */
    public function etapa5(CadastroCAF $cadastro)
    {
        $cadastro->load('rendaFamiliar', 'familiares', 'conjuge');
        
        // Calcular número de membros
        $numeroMembros = 1; // O próprio agricultor
        if ($cadastro->conjuge) $numeroMembros++;
        $numeroMembros += $cadastro->familiares()->count();

        return view('caf::cadastrador.etapa5', compact('cadastro', 'numeroMembros'));
    }

    public function storeEtapa5(Request $request, CadastroCAF $cadastro)
    {
        $validated = $request->validate([
            'numero_membros' => 'required|integer|min:1',
            'renda_agricultura' => 'nullable|numeric|min:0',
            'renda_pecuaria' => 'nullable|numeric|min:0',
            'renda_extrativismo' => 'nullable|numeric|min:0',
            'renda_aposentadoria' => 'nullable|numeric|min:0',
            'renda_bolsa_familia' => 'nullable|numeric|min:0',
            'renda_outros' => 'nullable|numeric|min:0',
            'renda_outros_descricao' => 'nullable|string',
            'recebe_bolsa_familia' => 'boolean',
            'recebe_aposentadoria' => 'boolean',
            'recebe_bpc' => 'boolean',
            'recebe_outros' => 'boolean',
            'beneficios_descricao' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Calcular renda total e per capita
            $rendaTotal = (float) (
                ($validated['renda_agricultura'] ?? 0) +
                ($validated['renda_pecuaria'] ?? 0) +
                ($validated['renda_extrativismo'] ?? 0) +
                ($validated['renda_aposentadoria'] ?? 0) +
                ($validated['renda_bolsa_familia'] ?? 0) +
                ($validated['renda_outros'] ?? 0)
            );

            $rendaPerCapita = $rendaTotal / ($validated['numero_membros'] > 0 ? $validated['numero_membros'] : 1);

            $rendaFamiliar = $cadastro->rendaFamiliar()->updateOrCreate(
                ['cadastro_caf_id' => $cadastro->id],
                array_merge($validated, [
                    'renda_total_mensal' => $rendaTotal,
                    'renda_per_capita' => $rendaPerCapita,
                ])
            );

            // Marcar cadastro como completo
            $cadastro->update(['status' => 'completo']);

            DB::commit();

            return redirect()->route('caf.cadastrador.etapa6', $cadastro->id)
                ->with('success', 'Renda familiar salva! Cadastro completo. Revise os dados antes de finalizar.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar renda familiar CAF', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao salvar renda familiar.');
        }
    }

    /**
     * Etapa 6: Revisão e Finalização
     */
    public function etapa6(CadastroCAF $cadastro)
    {
        $cadastro->load(['pessoa', 'conjuge', 'familiares', 'imovel', 'rendaFamiliar', 'localidade']);
        return view('caf::cadastrador.etapa6', compact('cadastro'));
    }

    /**
     * Visualizar cadastro completo
     */
    public function show(CadastroCAF $cadastro)
    {
        $cadastro->load(['pessoa', 'conjuge', 'familiares', 'imovel', 'rendaFamiliar', 'localidade', 'funcionario', 'cadastrador']);
        return view('caf::cadastrador.show', compact('cadastro'));
    }

    /**
     * Gerar PDF do formulário
     */
    public function pdf(CadastroCAF $cadastro)
    {
        $cadastro->load(['pessoa', 'conjuge', 'familiares', 'imovel', 'rendaFamiliar', 'localidade', 'funcionario']);
        
        // Usar DomPDF para gerar PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('caf::cadastrador.pdf', compact('cadastro'));
        
        $nomeArquivo = 'CAF-' . ($cadastro->protocolo ?? $cadastro->codigo) . '.pdf';
        return $pdf->download($nomeArquivo);
    }
}

