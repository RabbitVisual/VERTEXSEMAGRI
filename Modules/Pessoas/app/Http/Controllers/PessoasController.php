<?php

namespace Modules\Pessoas\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ChecksModuleEnabled;
use App\Helpers\FormatHelper;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PessoasController extends Controller
{
    use ChecksModuleEnabled;

    public function __construct()
    {
        $this->ensureModuleEnabled('Pessoas');
    }
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'localidade_id', 'beneficiaria_pbf', 'sexo']);
        $query = PessoaCad::with('localidade');

        // Busca geral
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nom_pessoa', 'like', "%{$search}%")
                  ->orWhere('num_nis_pessoa_atual', 'like', "%{$search}%")
                  ->orWhere('num_cpf_pessoa', 'like', "%{$search}%")
                  ->orWhere('cod_familiar_fam', 'like', "%{$search}%");
            });
        }

        // Filtros
        if (!empty($filters['localidade_id'])) {
            $query->where('localidade_id', $filters['localidade_id']);
        }

        if (!empty($filters['beneficiaria_pbf']) && $filters['beneficiaria_pbf'] == '1') {
            $query->beneficiariasPbf();
        }

        if (!empty($filters['sexo'])) {
            $query->where('cod_sexo_pessoa', $filters['sexo']);
        }

        $pessoas = $query->orderBy('nom_pessoa')->paginate(20);

        // Buscar localidades para filtro
        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)
                ->select('id', 'nome')
                ->orderBy('nome')
                ->get();
        }

        // Estatísticas gerais
        $estatisticas = [
            'total' => PessoaCad::where('ativo', true)->count(),
            'beneficiarias_pbf' => PessoaCad::beneficiariasPbf()->where('ativo', true)->count(),
        ];

        return view('pessoas::index', compact('pessoas', 'localidades', 'filters', 'estatisticas'));
    }

    public function create()
    {
        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)
                ->select('id', 'nome')
                ->orderBy('nome')
                ->get();
        }

        return view('pessoas::create', compact('localidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_pessoa' => 'required|string|max:255',
            'nom_apelido_pessoa' => 'nullable|string|max:255',
            'num_nis_pessoa_atual' => [
                'nullable',
                'string',
                'max:15', // Permite máscara NIS (XXX.XXXXX.XX-X)
                function ($attribute, $value, $fail) {
                    if ($value && !$this->validarNis($value)) {
                        $fail('O NIS informado não é válido.');
                    }
                },
            ],
            'num_cpf_pessoa' => [
                'required',
                'string',
                'max:14', // Permite máscara CPF (XXX.XXX.XXX-XX)
                function ($attribute, $value, $fail) {
                    if (!$this->validarCpf($value)) {
                        $fail('O CPF informado não é válido.');
                    }
                },
                Rule::unique('pessoas_cad', 'num_cpf_pessoa')->whereNull('deleted_at'),
            ],
            'cod_sexo_pessoa' => 'required|integer|in:1,2',
            'dta_nasc_pessoa' => 'required|date',
            'nom_completo_mae_pessoa' => 'nullable|string|max:255',
            'nom_completo_pai_pessoa' => 'nullable|string|max:255',
            'localidade_id' => 'required|exists:localidades,id',
            'ativo' => 'boolean',
        ]);

        $validated['ativo'] = $request->has('ativo') ? true : true; // Default sempre ativo para novos cadastros

        // Limpar máscaras de CPF e NIS se preenchidos
        if (!empty($validated['num_nis_pessoa_atual'])) {
            $validated['num_nis_pessoa_atual'] = preg_replace('/\D/', '', $validated['num_nis_pessoa_atual']);
        } else {
            $validated['num_nis_pessoa_atual'] = null;
        }

        // CPF é obrigatório, então sempre limpar máscara
        $validated['num_cpf_pessoa'] = preg_replace('/\D/', '', $validated['num_cpf_pessoa']);

        // Campos do Cadastro Único - sempre null para cadastros manuais
        // Se ref_cad, ref_pbf e cod_familiar_fam forem null, significa que foi cadastro manual
        $validated['cod_familiar_fam'] = null;
        $validated['ref_cad'] = null;
        $validated['ref_pbf'] = null;

        // Código IBGE padrão para cadastros manuais
        $validated['cd_ibge'] = 2908903;

        $pessoa = PessoaCad::create($validated);

        return redirect()->route('pessoas.show', $pessoa)
            ->with('success', 'Pessoa cadastrada com sucesso');
    }

    public function show($id)
    {
        $pessoa = PessoaCad::with('localidade')->findOrFail($id);

        // Buscar membros da mesma família
        $familia = collect([]);
        if ($pessoa->cod_familiar_fam) {
            $familia = PessoaCad::porFamilia($pessoa->cod_familiar_fam)
                ->where('id', '!=', $pessoa->id)
                ->get();
        }

        return view('pessoas::show', compact('pessoa', 'familia'));
    }

    public function edit($id)
    {
        $pessoa = PessoaCad::findOrFail($id);

        $localidades = collect([]);
        if (Schema::hasTable('localidades')) {
            $localidades = Localidade::where('ativo', true)
                ->select('id', 'nome')
                ->orderBy('nome')
                ->get();
        }

        return view('pessoas::edit', compact('pessoa', 'localidades'));
    }

    public function update(Request $request, $id)
    {
        $pessoa = PessoaCad::findOrFail($id);
        $isCadastroManual = is_null($pessoa->ref_cad);

        // Se for cadastro manual, permite editar dados básicos
        if ($isCadastroManual) {
            $validated = $request->validate([
                'nom_pessoa' => 'required|string|max:255',
                'nom_apelido_pessoa' => 'nullable|string|max:255',
                'num_nis_pessoa_atual' => [
                    'nullable',
                    'string',
                    'max:15', // Permite máscara NIS (XXX.XXXXX.XX-X)
                    function ($attribute, $value, $fail) {
                        if ($value && !$this->validarNis($value)) {
                            $fail('O NIS informado não é válido.');
                        }
                    },
                ],
                'num_cpf_pessoa' => [
                    'required',
                    'string',
                    'max:14', // Permite máscara CPF (XXX.XXX.XXX-XX)
                    function ($attribute, $value, $fail) {
                        if (!$this->validarCpf($value)) {
                            $fail('O CPF informado não é válido.');
                        }
                    },
                    Rule::unique('pessoas_cad', 'num_cpf_pessoa')->ignore($pessoa->id)->whereNull('deleted_at'),
                ],
                'cod_sexo_pessoa' => 'required|integer|in:1,2',
                'dta_nasc_pessoa' => 'required|date',
                'nom_completo_mae_pessoa' => 'nullable|string|max:255',
                'nom_completo_pai_pessoa' => 'nullable|string|max:255',
                'localidade_id' => 'nullable|exists:localidades,id',
                'ativo' => 'boolean',
            ]);

            // Limpar máscaras de CPF e NIS
            if (!empty($validated['num_nis_pessoa_atual'])) {
                $validated['num_nis_pessoa_atual'] = preg_replace('/\D/', '', $validated['num_nis_pessoa_atual']);
            } else {
                $validated['num_nis_pessoa_atual'] = null;
            }
            $validated['num_cpf_pessoa'] = preg_replace('/\D/', '', $validated['num_cpf_pessoa']);
        } else {
            // Se for do CadÚnico, só permite editar localidade e status
            $validated = $request->validate([
                'localidade_id' => 'nullable|exists:localidades,id',
                'ativo' => 'boolean',
            ]);
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $pessoa->update($validated);

        return redirect()->route('pessoas.show', $pessoa)
            ->with('success', 'Pessoa atualizada com sucesso');
    }

    public function destroy($id)
    {
        $pessoa = PessoaCad::findOrFail($id);
        $pessoa->delete();

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa deletada com sucesso');
    }

    // Métodos para estatísticas e relatórios
    public function estatisticasPorLocalidade($localidadeId)
    {
        $localidade = Localidade::findOrFail($localidadeId);

        $estatisticas = [
            'total' => PessoaCad::totalPorLocalidade($localidadeId),
            'beneficiarias_pbf' => PessoaCad::beneficiariasPbfPorLocalidade($localidadeId),
            'por_sexo' => [
                'masculino' => PessoaCad::porLocalidade($localidadeId)
                    ->where('cod_sexo_pessoa', 1)
                    ->where('ativo', true)
                    ->count(),
                'feminino' => PessoaCad::porLocalidade($localidadeId)
                    ->where('cod_sexo_pessoa', 2)
                    ->where('ativo', true)
                    ->count(),
            ],
        ];

        return response()->json($estatisticas);
    }

    public function export(Request $request, $format = 'csv')
    {
        $query = PessoaCad::with('localidade');

        if ($request->filled('localidade_id')) {
            $query->where('localidade_id', $request->localidade_id);
        }

        if ($request->filled('beneficiaria_pbf') && $request->beneficiaria_pbf == '1') {
            $query->beneficiariasPbf();
        }

        $pessoas = $query->get();

        // Implementar exportação CSV/Excel/PDF aqui
        // Por enquanto, retorna JSON
        return response()->json($pessoas);
    }

    /**
     * Valida se um CPF é válido
     *
     * @param string $cpf CPF com ou sem máscara
     * @return bool
     */
    private function validarCpf(string $cpf): bool
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // CPF deve ter 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (CPF inválido)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += (int)$cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        // Calcula segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += (int)$cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        // Verifica se os dígitos calculados conferem
        return ($digito1 == (int)$cpf[9] && $digito2 == (int)$cpf[10]);
    }

    /**
     * Valida se um NIS/PIS é válido
     *
     * @param string $nis NIS com ou sem máscara
     * @return bool
     */
    private function validarNis(string $nis): bool
    {
        // Remove caracteres não numéricos
        $nis = preg_replace('/[^0-9]/', '', $nis);

        // NIS deve ter 11 dígitos
        if (strlen($nis) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (NIS inválido)
        if (preg_match('/(\d)\1{10}/', $nis)) {
            return false;
        }

        // Algoritmo de validação do NIS
        $multiplicadores = [3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;

        for ($i = 0; $i < 10; $i++) {
            $soma += (int)$nis[$i] * $multiplicadores[$i];
        }

        $resto = $soma % 11;
        $digitoVerificador = ($resto < 2) ? 0 : 11 - $resto;

        return ($digitoVerificador == (int)$nis[10]);
    }
}
