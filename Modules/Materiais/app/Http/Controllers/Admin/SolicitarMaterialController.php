<?php

namespace Modules\Materiais\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Materiais\App\Models\Material;
use Modules\Materiais\App\Models\SolicitacaoMaterial;
use Modules\Materiais\App\Models\SolicitacaoMaterialCampo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SolicitarMaterialController extends Controller
{
    /**
     * Mostra o formulário de solicitação de materiais
     */
    public function create(Request $request)
    {
        // Buscar materiais com estoque baixo ou todos os materiais
        $query = Material::query()->where('ativo', true);

        if ($request->has('baixo_estoque') && $request->baixo_estoque == '1') {
            $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
        }

        $materiais = $query->orderBy('nome')->get();

        // Verificar se veio de uma solicitação do campo
        $solicitacaoCampo = null;
        if ($request->has('solicitacao_campo_id')) {
            $solicitacaoCampo = SolicitacaoMaterialCampo::find($request->solicitacao_campo_id);
        }

        return view('materiais::admin.solicitar.create', compact('materiais', 'solicitacaoCampo'));
    }

    /**
     * Processa e prepara os materiais selecionados para exibição no PDF
     */
    protected function processarMateriaisParaPdf(array $materiaisArray): array
    {
        $materiaisSelecionados = [];

        foreach ($materiaisArray as $item) {
            if ($item['is_customizado'] ?? false) {
                $materiaisSelecionados[] = [
                    'material' => null,
                    'nome_customizado' => $item['nome_customizado'],
                    'especificacao_customizada' => $item['especificacao_customizada'] ?? '',
                    'quantidade' => $item['quantidade'],
                    'unidade_medida_customizada' => $item['unidade_medida_customizada'],
                    'justificativa' => $item['justificativa'],
                    'is_customizado' => true,
                ];
            } else {
                $material = Material::find($item['material_id'] ?? null);
                if ($material) {
                    $materiaisSelecionados[] = [
                        'material' => $material,
                        'quantidade' => $item['quantidade'],
                        'justificativa' => $item['justificativa'],
                        'is_customizado' => false,
                    ];
                }
            }
        }

        return $materiaisSelecionados;
    }

    /**
     * Processa e prepara os materiais selecionados para salvar no banco
     */
    protected function processarMateriaisParaBanco(array $validated): array
    {
        $materiaisArray = [];

        // Buscar os materiais selecionados do sistema
        if (!empty($validated['materiais'])) {
            foreach ($validated['materiais'] as $item) {
                $materiaisArray[] = [
                    'material_id' => $item['material_id'],
                    'quantidade' => $item['quantidade'],
                    'justificativa' => $item['justificativa'],
                    'is_customizado' => false,
                ];
            }
        }

        // Adicionar materiais customizados
        if (!empty($validated['materiais_customizados'])) {
            foreach ($validated['materiais_customizados'] as $item) {
                $materiaisArray[] = [
                    'nome_customizado' => $item['nome'],
                    'especificacao_customizada' => $item['especificacao'] ?? '',
                    'quantidade' => $item['quantidade'],
                    'unidade_medida_customizada' => $item['unidade_medida'],
                    'justificativa' => $item['justificativa'],
                    'is_customizado' => true,
                ];
            }
        }

        return $materiaisArray;
    }

    /**
     * Gera o PDF da solicitação de materiais e salva no banco
     */
    public function gerarPdf(Request $request)
    {
        $validated = $request->validate([
            'cidade' => 'required|string|max:255',
            'data' => 'required|date',
            'secretario_nome' => 'required|string|max:255',
            'secretario_cargo' => 'required|string|max:255',
            'servidor_nome' => 'required|string|max:255',
            'servidor_cargo' => 'required|string|max:255',
            'servidor_telefone' => 'nullable|string|max:255',
            'servidor_email' => 'nullable|email|max:255',
            'materiais' => 'nullable|array',
            'materiais.*.material_id' => 'required_with:materiais|exists:materiais,id',
            'materiais.*.quantidade' => 'required_with:materiais|numeric|min:0.01',
            'materiais.*.justificativa' => 'required_with:materiais|string|max:500',
            'materiais_customizados' => 'nullable|array',
            'materiais_customizados.*.nome' => 'required_with:materiais_customizados|string|max:255',
            'materiais_customizados.*.especificacao' => 'nullable|string|max:500',
            'materiais_customizados.*.quantidade' => 'required_with:materiais_customizados|numeric|min:0.01',
            'materiais_customizados.*.unidade_medida' => 'required_with:materiais_customizados|string|max:50',
            'materiais_customizados.*.justificativa' => 'required_with:materiais_customizados|string|max:500',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        // Validar que pelo menos um material foi selecionado
        $temMateriais = !empty($validated['materiais']) || !empty($validated['materiais_customizados']);
        if (!$temMateriais) {
            return back()->withErrors(['materiais' => 'Selecione pelo menos um material ou adicione um material customizado.'])->withInput();
        }

        $ano = Carbon::parse($validated['data'])->format('Y');
        $dataFormatada = Carbon::parse($validated['data']);

        // Gerar número de ofício automático
        $numeroInfo = SolicitacaoMaterial::gerarProximoNumero($ano);

        // Processar materiais para salvar no banco
        $materiaisArray = $this->processarMateriaisParaBanco($validated);

        // Salvar solicitação no banco
        DB::beginTransaction();
        try {
            $solicitacao = SolicitacaoMaterial::create([
                'numero_oficio' => $numeroInfo['numero_oficio'],
                'numero_sequencial' => $numeroInfo['numero_sequencial'],
                'ano' => $numeroInfo['ano'],
                'cidade' => $validated['cidade'],
                'data' => $dataFormatada,
                'secretario_nome' => $validated['secretario_nome'],
                'secretario_cargo' => $validated['secretario_cargo'],
                'servidor_nome' => $validated['servidor_nome'],
                'servidor_cargo' => $validated['servidor_cargo'],
                'servidor_telefone' => $validated['servidor_telefone'] ?? null,
                'servidor_email' => $validated['servidor_email'] ?? null,
                'materiais' => $materiaisArray,
                'observacoes' => $validated['observacoes'] ?? null,
                'user_id' => Auth::id(),
                'hash_documento' => '', // Será preenchido após criar
            ]);

            // Gerar hash após criar o registro
            $solicitacao->hash_documento = $solicitacao->gerarHash();
            $solicitacao->save();

            // Se veio de uma solicitação do campo, marcar como processada
            if (!empty($validated['solicitacao_campo_id'])) {
                $solicitacaoCampo = SolicitacaoMaterialCampo::find($validated['solicitacao_campo_id']);
                if ($solicitacaoCampo && $solicitacaoCampo->status === 'pendente') {
                    $solicitacaoCampo->update([
                        'status' => 'processada',
                        'processado_por' => Auth::id(),
                        'solicitacao_material_id' => $solicitacao->id,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao salvar solicitação: ' . $e->getMessage()])->withInput();
        }

        // Processar materiais para exibição no PDF
        $materiaisSelecionados = $this->processarMateriaisParaPdf($materiaisArray);

        // Preparar dados para o PDF
        $data = [
            'numero_oficio' => $solicitacao->numero_oficio,
            'ano' => $solicitacao->ano,
            'cidade' => $solicitacao->cidade,
            'data' => $solicitacao->data,
            'secretario_nome' => $solicitacao->secretario_nome,
            'secretario_cargo' => $solicitacao->secretario_cargo,
            'servidor_nome' => $solicitacao->servidor_nome,
            'servidor_cargo' => $solicitacao->servidor_cargo,
            'servidor_telefone' => $solicitacao->servidor_telefone ?? '',
            'servidor_email' => $solicitacao->servidor_email ?? '',
            'materiais' => $materiaisSelecionados,
            'observacoes' => $solicitacao->observacoes ?? '',
            'usuario' => Auth::user(),
            'solicitacao_id' => $solicitacao->id,
        ];

        // Gerar PDF
        $pdf = PDF::loadView('materiais::admin.solicitar.pdf', $data);

        // Configurar para A4
        $pdf->setPaper('a4', 'portrait');

        // Nome do arquivo
        $filename = 'solicitacao_' . str_replace('/', '_', $solicitacao->numero_oficio) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Visualiza o PDF sem download (não salva no banco)
     */
    public function visualizarPdf(Request $request)
    {
        $validated = $request->validate([
            'cidade' => 'required|string|max:255',
            'data' => 'required|date',
            'secretario_nome' => 'required|string|max:255',
            'secretario_cargo' => 'required|string|max:255',
            'servidor_nome' => 'required|string|max:255',
            'servidor_cargo' => 'required|string|max:255',
            'servidor_telefone' => 'nullable|string|max:255',
            'servidor_email' => 'nullable|email|max:255',
            'materiais' => 'nullable|array',
            'materiais.*.material_id' => 'required_with:materiais|exists:materiais,id',
            'materiais.*.quantidade' => 'required_with:materiais|numeric|min:0.01',
            'materiais.*.justificativa' => 'required_with:materiais|string|max:500',
            'materiais_customizados' => 'nullable|array',
            'materiais_customizados.*.nome' => 'required_with:materiais_customizados|string|max:255',
            'materiais_customizados.*.especificacao' => 'nullable|string|max:500',
            'materiais_customizados.*.quantidade' => 'required_with:materiais_customizados|numeric|min:0.01',
            'materiais_customizados.*.unidade_medida' => 'required_with:materiais_customizados|string|max:50',
            'materiais_customizados.*.justificativa' => 'required_with:materiais_customizados|string|max:500',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        // Validar que pelo menos um material foi selecionado
        $temMateriais = !empty($validated['materiais']) || !empty($validated['materiais_customizados']);
        if (!$temMateriais) {
            return back()->withErrors(['materiais' => 'Selecione pelo menos um material ou adicione um material customizado.'])->withInput();
        }

        $ano = Carbon::parse($validated['data'])->format('Y');
        $dataFormatada = Carbon::parse($validated['data']);

        // Gerar número de ofício temporário para visualização
        $numeroInfo = SolicitacaoMaterial::gerarProximoNumero($ano);

        // Processar materiais para exibição
        $materiaisArray = $this->processarMateriaisParaBanco($validated);
        $materiaisSelecionados = $this->processarMateriaisParaPdf($materiaisArray);

        // Preparar dados para o PDF
        $data = [
            'numero_oficio' => $numeroInfo['numero_oficio'] . ' (Pré-visualização)',
            'ano' => $numeroInfo['ano'],
            'cidade' => $validated['cidade'],
            'data' => $dataFormatada,
            'secretario_nome' => $validated['secretario_nome'],
            'secretario_cargo' => $validated['secretario_cargo'],
            'servidor_nome' => $validated['servidor_nome'],
            'servidor_cargo' => $validated['servidor_cargo'],
            'servidor_telefone' => $validated['servidor_telefone'] ?? '',
            'servidor_email' => $validated['servidor_email'] ?? '',
            'materiais' => $materiaisSelecionados,
            'observacoes' => $validated['observacoes'] ?? '',
            'usuario' => Auth::user(),
            'solicitacao_id' => null, // Não salvo ainda
        ];

        // Gerar PDF
        $pdf = PDF::loadView('materiais::admin.solicitar.pdf', $data);

        // Configurar para A4
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('solicitacao_materiais_preview.pdf');
    }

    /**
     * Lista todas as solicitações de materiais
     */
    public function index(Request $request)
    {
        $query = SolicitacaoMaterial::with('usuario')->recentes();

        // Filtros
        if ($request->filled('ano')) {
            $query->where('ano', $request->ano);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_oficio', 'like', "%{$search}%")
                  ->orWhere('secretario_nome', 'like', "%{$search}%")
                  ->orWhere('servidor_nome', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        $solicitacoes = $query->paginate(20);
        $anos = SolicitacaoMaterial::select('ano')->distinct()->orderBy('ano', 'desc')->pluck('ano');

        return view('materiais::admin.solicitar.index', compact('solicitacoes', 'anos'));
    }

    /**
     * Visualiza uma solicitação específica
     */
    public function show($id)
    {
        $solicitacao = SolicitacaoMaterial::with('usuario')->findOrFail($id);

        // Processar materiais para exibição no PDF
        $materiaisSelecionados = $this->processarMateriaisParaPdf($solicitacao->materiais);

        // Preparar dados para o PDF
        $data = [
            'numero_oficio' => $solicitacao->numero_oficio,
            'ano' => $solicitacao->ano,
            'cidade' => $solicitacao->cidade,
            'data' => $solicitacao->data,
            'secretario_nome' => $solicitacao->secretario_nome,
            'secretario_cargo' => $solicitacao->secretario_cargo,
            'servidor_nome' => $solicitacao->servidor_nome,
            'servidor_cargo' => $solicitacao->servidor_cargo,
            'servidor_telefone' => $solicitacao->servidor_telefone ?? '',
            'servidor_email' => $solicitacao->servidor_email ?? '',
            'materiais' => $materiaisSelecionados,
            'observacoes' => $solicitacao->observacoes ?? '',
            'usuario' => $solicitacao->usuario,
            'solicitacao_id' => $solicitacao->id,
        ];

        // Gerar PDF
        $pdf = PDF::loadView('materiais::admin.solicitar.pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        $filename = 'solicitacao_' . str_replace('/', '_', $solicitacao->numero_oficio) . '.pdf';

        return $pdf->stream($filename);
    }
}

