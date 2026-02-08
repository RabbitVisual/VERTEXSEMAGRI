<?php

namespace Modules\Pocos\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Models\UsuarioPoco;
use Modules\Pocos\App\Models\MensalidadePoco;
use Modules\Pocos\App\Models\BoletoPoco;
use Modules\Pocos\App\Models\PagamentoPoco;
use Modules\Pocos\App\Models\SolicitacaoBaixaPoco;
use Modules\Pocos\App\Helpers\QrCodeHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MoradorPocoController extends Controller
{
    /**
     * Tela inicial de consulta (solicita código de acesso)
     */
    public function index()
    {
        return view('pocos::morador.index');
    }

    /**
     * Autenticar morador pelo código de acesso
     */
    public function autenticar(Request $request)
    {
        $validated = $request->validate([
            'codigo_acesso' => 'required|string|size:8',
        ]);

        $usuario = UsuarioPoco::porCodigoAcesso($validated['codigo_acesso'])->first();

        if (!$usuario) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Código de acesso inválido.');
        }

        if ($usuario->status !== 'ativo') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Seu cadastro está inativo. Entre em contato com o líder da comunidade.');
        }

        // Armazenar código na sessão
        session(['morador_codigo_acesso' => $validated['codigo_acesso']]);

        return redirect()->route('morador-poco.dashboard');
    }

    /**
     * Dashboard do morador
     */
    public function dashboard()
    {
        $usuario = $this->getUsuarioAutenticado();

        if (!$usuario) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        // Verificar e criar boletos faltantes para mensalidades abertas
        $this->garantirBoletosParaMensalidadesAbertas($usuario);

        // Faturas em aberto
        $faturasAbertas = BoletoPoco::where('usuario_poco_id', $usuario->id)
            ->where('status', 'aberto')
            ->with(['mensalidade', 'poco'])
            ->orderBy('data_vencimento', 'asc')
            ->get();

        // Faturas vencidas
        $faturasVencidas = BoletoPoco::where('usuario_poco_id', $usuario->id)
            ->where(function($q) {
                $q->where('status', 'vencido')
                  ->orWhere(function($q2) {
                      $q2->where('status', 'aberto')
                         ->where('data_vencimento', '<', now());
                  });
            })
            ->with(['mensalidade', 'poco'])
            ->orderBy('data_vencimento', 'asc')
            ->get();

        // Últimos pagamentos
        $ultimosPagamentos = PagamentoPoco::where('usuario_poco_id', $usuario->id)
            ->where('status', 'confirmado')
            ->with(['mensalidade', 'poco'])
            ->orderBy('data_pagamento', 'desc')
            ->limit(10)
            ->get();

        // Histórico completo de faturas
        $todasFaturas = BoletoPoco::where('usuario_poco_id', $usuario->id)
            ->with(['mensalidade', 'poco'])
            ->orderBy('data_vencimento', 'desc')
            ->limit(20)
            ->get();

        return view('pocos::morador.dashboard', compact(
            'usuario',
            'faturasAbertas',
            'faturasVencidas',
            'ultimosPagamentos',
            'todasFaturas'
        ));
    }

    /**
     * Histórico completo de faturas
     */
    public function historico()
    {
        $usuario = $this->getUsuarioAutenticado();

        if (!$usuario) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        $faturas = BoletoPoco::where('usuario_poco_id', $usuario->id)
            ->with(['mensalidade', 'poco'])
            ->orderBy('data_vencimento', 'desc')
            ->paginate(20);

        return view('pocos::morador.historico', compact('usuario', 'faturas'));
    }

    /**
     * Detalhes de uma fatura específica
     */
    public function faturaShow($id)
    {
        $usuario = $this->getUsuarioAutenticado();

        if (!$usuario) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        $boleto = BoletoPoco::with(['mensalidade', 'poco', 'usuarioPoco'])
            ->findOrFail($id);

        // Verificar se o boleto pertence ao usuário
        if ($boleto->usuario_poco_id !== $usuario->id) {
            return redirect()->route('morador-poco.dashboard')
                ->with('error', 'Acesso negado.');
        }

        // Verificar se há pagamento registrado
        $pagamento = PagamentoPoco::where('mensalidade_id', $boleto->mensalidade_id)
            ->where('usuario_poco_id', $usuario->id)
            ->where('status', 'confirmado')
            ->first();

        // Verificar se há solicitação de baixa
        $solicitacaoBaixa = SolicitacaoBaixaPoco::where('boleto_poco_id', $boleto->id)
            ->where('usuario_poco_id', $usuario->id)
            ->first();

        return view('pocos::morador.fatura.show', compact('boleto', 'pagamento', 'usuario', 'solicitacaoBaixa'));
    }

    /**
     * Emitir segunda via do boleto (PDF)
     */
    public function segundaVia($id)
    {
        $usuario = $this->getUsuarioAutenticado();

        if (!$usuario) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        $boleto = BoletoPoco::with(['mensalidade', 'poco', 'usuarioPoco'])
            ->findOrFail($id);

        // Verificar se o boleto pertence ao usuário
        if ($boleto->usuario_poco_id !== $usuario->id) {
            abort(403, 'Acesso negado.');
        }

        // Verificar se há solicitação de baixa pendente
        $solicitacaoPendente = SolicitacaoBaixaPoco::where('boleto_poco_id', $boleto->id)
            ->where('usuario_poco_id', $usuario->id)
            ->where('status', 'pendente')
            ->first();

        if ($solicitacaoPendente) {
            return redirect()->route('morador-poco.fatura.show', $boleto->id)
                ->with('error', 'A emissão da 2ª via está bloqueada enquanto sua solicitação de baixa está em análise pelo líder da comunidade.');
        }

        // Gerar QR Code se for PIX
        $qrCodeDataUrl = null;
        if ($boleto->mensalidade->forma_recebimento == 'pix' && $boleto->mensalidade->chave_pix) {
            try {
                $qrCodeDataUrl = QrCodeHelper::generateDataUrl($boleto->mensalidade->chave_pix, 150);
                // Verificar se foi gerado corretamente
                if (empty($qrCodeDataUrl) || !str_starts_with($qrCodeDataUrl, 'data:image')) {
                    \Log::warning('QR Code não gerado corretamente para boleto: ' . $boleto->id, [
                        'chave_pix' => substr($boleto->mensalidade->chave_pix, 0, 20),
                        'data_url_length' => strlen($qrCodeDataUrl ?? '')
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Erro ao gerar QR Code: ' . $e->getMessage(), [
                    'boleto_id' => $boleto->id,
                    'trace' => $e->getTraceAsString()
                ]);
                $qrCodeDataUrl = null;
            }
        }

        // Gerar PDF do boleto
        $pdf = PDF::loadView('pocos::morador.fatura.segunda-via', compact('boleto', 'usuario', 'qrCodeDataUrl'));
        $pdf->setPaper('A4', 'portrait');
        
        // Habilitar imagens remotas e HTML5 no DomPDF (necessário para data URLs)
        $pdf->setOption('enable-remote', true);
        $pdf->setOption('enable-html5-parser', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);

        $filename = 'boleto_' . $boleto->numero_boleto . '_' . $boleto->mensalidade->mes . '_' . $boleto->mensalidade->ano . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Emitir comprovante de pagamento (quando boleto está pago)
     */
    public function comprovante($id)
    {
        $usuario = $this->getUsuarioAutenticado();

        if (!$usuario) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        $boleto = BoletoPoco::with(['mensalidade', 'poco', 'usuarioPoco'])
            ->findOrFail($id);

        // Verificar se o boleto pertence ao usuário
        if ($boleto->usuario_poco_id !== $usuario->id) {
            abort(403, 'Acesso negado.');
        }

        // Buscar pagamento confirmado
        $pagamento = PagamentoPoco::where('mensalidade_id', $boleto->mensalidade_id)
            ->where('usuario_poco_id', $usuario->id)
            ->where('status', 'confirmado')
            ->with(['mensalidade', 'poco'])
            ->first();

        if (!$pagamento) {
            return redirect()->route('morador-poco.fatura.show', $boleto->id)
                ->with('error', 'Este boleto não possui pagamento confirmado.');
        }

        // Gerar PDF do comprovante
        $pdf = PDF::loadView('pocos::morador.fatura.comprovante', compact('boleto', 'usuario', 'pagamento'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption('enable-remote', true);
        $pdf->setOption('enable-html5-parser', true);

        $filename = 'comprovante_' . $pagamento->codigo . '_' . $pagamento->mensalidade->mes . '_' . $pagamento->mensalidade->ano . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Visualizar boleto em HTML
     */
    public function boletoView($id)
    {
        $usuario = $this->getUsuarioAutenticado();

        if (!$usuario) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        $boleto = BoletoPoco::with(['mensalidade', 'poco', 'usuarioPoco'])
            ->findOrFail($id);

        // Verificar se o boleto pertence ao usuário
        if ($boleto->usuario_poco_id !== $usuario->id) {
            abort(403, 'Acesso negado.');
        }

        return view('pocos::morador.fatura.segunda-via', compact('boleto', 'usuario'));
    }

    /**
     * Logout do morador
     */
    public function logout()
    {
        session()->forget('morador_codigo_acesso');

        return redirect()->route('morador-poco.index')
            ->with('success', 'Você saiu do sistema.');
    }

    /**
     * Criar solicitação de baixa do boleto
     */
    public function solicitacoesBaixaStore(Request $request)
    {
        $usuario = $this->getUsuarioAutenticado();

        if (!$usuario) {
            return redirect()->route('morador-poco.index')
                ->with('error', 'Por favor, informe seu código de acesso.');
        }

        $validated = $request->validate([
            'boleto_poco_id' => 'required|exists:boletos_poco,id',
            'data_pagamento' => 'required|date|before_or_equal:today',
            'valor_pago' => 'required|numeric|min:0.01',
            'forma_pagamento' => 'required|in:dinheiro,pix,transferencia,outro',
            'comprovante' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $boleto = BoletoPoco::with(['mensalidade', 'poco'])->findOrFail($validated['boleto_poco_id']);

        // Verificar se o boleto pertence ao usuário
        if ($boleto->usuario_poco_id !== $usuario->id) {
            return redirect()->back()->with('error', 'Acesso negado.');
        }

        // Verificar se já existe pagamento confirmado
        $pagamentoExistente = PagamentoPoco::where('mensalidade_id', $boleto->mensalidade_id)
            ->where('usuario_poco_id', $usuario->id)
            ->where('status', 'confirmado')
            ->first();

        if ($pagamentoExistente) {
            return redirect()->back()->with('error', 'Este boleto já foi pago.');
        }

        // Verificar se já existe solicitação pendente
        $solicitacaoExistente = SolicitacaoBaixaPoco::where('boleto_poco_id', $boleto->id)
            ->where('usuario_poco_id', $usuario->id)
            ->where('status', 'pendente')
            ->first();

        if ($solicitacaoExistente) {
            return redirect()->back()->with('error', 'Já existe uma solicitação pendente para este boleto.');
        }

        // Processar comprovante se fornecido
        $comprovantePath = null;
        if ($request->hasFile('comprovante')) {
            try {
                $file = $request->file('comprovante');
                $comprovantePath = $file->store('comprovantes-pagamento', 'public');
            } catch (\Exception $e) {
                \Log::error('Erro ao salvar comprovante: ' . $e->getMessage());
                // Continuar sem o comprovante
            }
        }

        // Criar solicitação
        SolicitacaoBaixaPoco::create([
            'boleto_poco_id' => $boleto->id,
            'usuario_poco_id' => $usuario->id,
            'mensalidade_id' => $boleto->mensalidade_id,
            'poco_id' => $boleto->poco_id,
            'data_pagamento' => $validated['data_pagamento'],
            'valor_pago' => $validated['valor_pago'],
            'forma_pagamento' => $validated['forma_pagamento'],
            'comprovante' => $comprovantePath,
            'observacoes' => $validated['observacoes'] ?? null,
            'status' => 'pendente',
        ]);

        return redirect()->route('morador-poco.fatura.show', $boleto->id)
            ->with('success', 'Solicitação de baixa enviada com sucesso! O líder da comunidade analisará sua solicitação.');
    }

    /**
     * Obter usuário autenticado pela sessão
     */
    protected function getUsuarioAutenticado()
    {
        $codigoAcesso = session('morador_codigo_acesso');

        if (!$codigoAcesso) {
            return null;
        }

        return UsuarioPoco::porCodigoAcesso($codigoAcesso)->first();
    }

    /**
     * Garantir que existam boletos para todas as mensalidades abertas do poço do usuário
     */
    protected function garantirBoletosParaMensalidadesAbertas(UsuarioPoco $usuario)
    {
        if ($usuario->status !== 'ativo' || !$usuario->poco_id) {
            return;
        }

        // Buscar mensalidades abertas do poço do usuário
        $mensalidadesAbertas = MensalidadePoco::where('poco_id', $usuario->poco_id)
            ->where('status', 'aberta')
            ->get();

        foreach ($mensalidadesAbertas as $mensalidade) {
            // Verificar se já existe boleto para este usuário nesta mensalidade
            $boletoExistente = BoletoPoco::where('mensalidade_id', $mensalidade->id)
                ->where('usuario_poco_id', $usuario->id)
                ->first();

            // Se não existe boleto, criar
            if (!$boletoExistente) {
                BoletoPoco::create([
                    'mensalidade_id' => $mensalidade->id,
                    'usuario_poco_id' => $usuario->id,
                    'poco_id' => $usuario->poco_id,
                    'valor' => $mensalidade->valor_mensalidade,
                    'data_vencimento' => $mensalidade->data_vencimento,
                    'status' => 'aberto',
                ]);
            }
        }
    }
}

